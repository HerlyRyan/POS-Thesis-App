<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\FinanceReports;
use App\Models\OrderPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderPaymentController extends Controller
{
    public function index(string $id)
    {
        $payments = OrderPayments::with(['order', 'employee'])->where('order_id', $id)->paginate(10);
        return view('admin.orders.history-payment-employee', compact('payments'));
    }

    public function create(Order $order)
    {
        // Saldo berdasarkan source (cash dan bank)
        $cashIncome = FinanceReports::where('source', 'cash')->where('type', 'income')->sum('amount');
        $cashExpense = FinanceReports::where('source', 'cash')->where('type', 'expense')->sum('amount');
        $cashBalance = $cashIncome - $cashExpense;

        $bankIncome = FinanceReports::where('source', 'bank')->where('type', 'income')->sum('amount');
        $bankExpense = FinanceReports::where('source', 'bank')->where('type', 'expense')->sum('amount');
        $bankBalance = $bankIncome - $bankExpense;

        $order->load(['driver', 'workers']); // pastikan relasi ini ada di model Order
        return view('admin.orders.payment-employee', compact(
            'order',
            'cashBalance',
            'bankBalance'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'source' => 'required|string',
            'payments' => 'required|array',
            'payments.*.employee_id' => 'required|exists:employees,id',
            'payments.*.role' => 'required|in:sopir,buruh',
            'payments.*.amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Ambil saldo awal hanya sekali
            $currentBalance = FinanceReports::where('source', $request->source)->latest()->value('total') ?? 0;

            foreach ($request->payments as $paymentData) {
                $payment = OrderPayments::create([
                    'order_id'    => $request->order_id,
                    'employee_id' => $paymentData['employee_id'],
                    'role'        => $paymentData['role'],
                    'amount'      => $paymentData['amount'],
                    'paid_at'     => now(),
                ]);

                // Kurangi saldo di memori (bukan ambil ulang dari DB)
                $currentBalance -= $payment->amount;

                FinanceReports::create([
                    'type'             => 'expense',
                    'category'         => 'Pengupahan',
                    'source'           => $request->source,
                    'amount'           => $payment->amount,
                    'transaction_date' => now(),
                    'description'      => "Pembayaran {$payment->role} - {$payment->employee->name} untuk Order #{$payment->order->sale->invoice_number}",
                    'total'            => $currentBalance,
                ]);
            }
        });


        return redirect()->route('admin.orders.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function print_evidence(string $id)
    {
        $payment = OrderPayments::with(['order.sale', 'employee'])->findOrFail($id);
        return view('admin.orders.evidence-payment-employee', compact('payment'));
    }
}
