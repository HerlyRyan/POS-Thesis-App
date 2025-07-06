<?php

namespace App\Http\Controllers;

use App\Models\FinanceReports;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

use function PHPSTORM_META\type;

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

        // Total berdasarkan filter (semua jenis source & type)
        $filteredTotal = $cashBalance + $bankBalance;

        return view('finance.index', compact(
            'filteredTotal',
            'cashBalance',
            'bankBalance'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'source' => 'required|in:cash,bank',
            'transaction_date' => 'required|date'
        ]);

        // Ambil total terakhir, default ke 0 jika belum ada transaksi
        $lastCashTotal = FinanceReports::where('source', 'cash')->latest()->value('total') ?? 0;
        $lastBankTotal = FinanceReports::where('source', 'bank')->latest()->value('total') ?? 0;

        // Hitung total berdasarkan jenis transaksi dan sumber
        $total = 0;
        if ($request->type == "income") {
            $total = $request->source === "cash"
                ? $lastCashTotal + $request->amount
                : $lastBankTotal + $request->amount;
        } else {
            $total = $request->source === "cash"
                ? $lastCashTotal - $request->amount
                : $lastBankTotal - $request->amount;
        }

        // Simpan transaksi
        FinanceReports::create([
            'type' => $request->type,
            'category' => $request->category,
            'description' => $request->description,
            'amount' => $request->amount,
            'source' => $request->source,
            'total' => $total,
            'transaction_date' => $request->transaction_date,
        ]);

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
