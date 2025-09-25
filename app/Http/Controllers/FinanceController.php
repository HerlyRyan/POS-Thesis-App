<?php

namespace App\Http\Controllers;

use App\Models\FinanceReports;
use App\Models\Payable;
use App\Models\Receivable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FinanceReports::query();

        // Saldo berdasarkan source (cash dan bank)
        $cashIncome = FinanceReports::where('source', 'cash')->where('type', 'income')->sum('amount');
        $cashExpense = FinanceReports::where('source', 'cash')->where('type', 'expense')->sum('amount');
        $cashBalance = $cashIncome - $cashExpense;

        $bankIncome = FinanceReports::where('source', 'bank')->where('type', 'income')->sum('amount');
        $bankExpense = FinanceReports::where('source', 'bank')->where('type', 'expense')->sum('amount');
        $bankBalance = $bankIncome - $bankExpense;

        // Receivable
        $paid_receivables = Receivable::sum('paid_amount');
        $remaining_receivables = Receivable::sum('remaining_amount');
        $total_receivables = Receivable::sum('total_amount');

        // Payable
        $paid_payables = Payable::sum('installment_amount');
        $remaining_payables = Payable::sum('remaining_amount');
        $total_payables = Payable::sum('total_amount');

        // Total berdasarkan filter (semua jenis source & type)
        $filteredTotal = $cashBalance + $bankBalance;

        return view('finance.index', compact(
            'filteredTotal',
            'cashBalance',
            'bankBalance',
            'paid_receivables',
            'remaining_receivables',
            'total_receivables',
            'paid_payables',
            'remaining_payables',
            'total_payables',
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $payables = Payable::whereIn('status', ['unpaid', 'partial'])->get();
        $cashIncome = FinanceReports::where('source', 'cash')->where('type', 'income')->sum('amount');
        $cashExpense = FinanceReports::where('source', 'cash')->where('type', 'expense')->sum('amount');
        $cashBalance = $cashIncome - $cashExpense;

        $bankIncome = FinanceReports::where('source', 'bank')->where('type', 'income')->sum('amount');
        $bankExpense = FinanceReports::where('source', 'bank')->where('type', 'expense')->sum('amount');
        $bankBalance = $bankIncome - $bankExpense;

        return view('finance.create', compact('payables', 'cashBalance', 'bankBalance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
            'source' => 'required|in:cash,bank',
            'transaction_date' => 'required|date',
            'payable_id' => 'nullable|exists:payables,id'
        ]);

        DB::transaction(function () use ($request) {
            // Hitung total sebelumnya
            $lastTotal = FinanceReports::where('source', $request->source)->latest()->value('total') ?? 0;
            $total = $request->type === 'income'
                ? $lastTotal + $request->amount
                : $lastTotal - $request->amount;

            // Simpan transaksi keuangan
            FinanceReports::create([
                'type' => $request->type,
                'category' => $request->category,
                'description' => $request->description ?? ($request->category === 'payable_payment' ? 'Pembayaran Hutang' : 'Transaksi'),
                'amount' => $request->amount,
                'source' => $request->source,
                'total' => $total,
                'transaction_date' => $request->transaction_date,
            ]);

            // Jika kategori pembayaran hutang
            if ($request->category === 'payable_payment' && $request->payable_id) {
                $payable = Payable::findOrFail($request->payable_id);

                // Pastikan tidak lebih besar dari sisa
                if ($request->amount > $payable->remaining_amount) {
                    // This will trigger a rollback and redirect back with the error.
                    throw ValidationException::withMessages([
                        'amount' => 'Jumlah bayar melebihi sisa hutang.',
                    ]);
                }

                // Update payable
                $payable->remaining_amount -= $request->amount;
                $payable->installment_amount += $request->amount;
                $payable->status = $payable->remaining_amount <= 0 ? 'paid' : 'partial';
                $payable->save();
            }
        });

        return redirect()->route('admin.finance.index')->with('success', 'Transaction created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $query = FinanceReports::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                    ->orWhere('category', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $records = $query->where('source', $id)->orderBy('transaction_date', 'asc')->paginate(31);
        return view('finance.show', compact(
            'records',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $finance = FinanceReports::findOrFail($id);
        $finance->delete();

        return redirect()->route('admin.finance.index')
            ->with('success', 'Finance Record deleted successfully.');
    }
}
