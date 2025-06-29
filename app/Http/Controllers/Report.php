<?php

namespace App\Http\Controllers;

use App\Models\FinanceReports;

use Illuminate\Http\Request;

class Report extends Controller
{
    public function indexFinance(Request $request)
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

        return view('report.finance.index', compact(
            'filteredTotal',
            'cashBalance',
            'bankBalance'
        ));
    }

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
        $records = $query->where('source', $id)->orderBy('transaction_date', 'desc')->paginate(10);
        return view('report.finance.show', compact(
            'records',
        ));
    }
}
