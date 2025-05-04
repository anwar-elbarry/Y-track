<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Client;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class StatisticsService {
    public function getStatistics() {
        $user = Auth::user();
        $incomes = Transaction::where('user_id', $user->id)
                                ->where('type','income')
                                ->get();
        $bills = Transaction::where('user_id', $user->id)
                                ->where('type','bill')
                                ->get();
        $expenses = Expense::where('user_id', $user->id)->get();
        $clients = Client::where('user_id', $user->id)->get();
        
        $totalIncomes = round($incomes->sum('amount'), 2);
        $totalBills = round($bills->sum('amount'), 2);
        $totalExpenses = round($expenses->sum('amount'), 2);
        $totalClients = $clients->count();
        
        return [
            'totalIncomes' => $totalIncomes,
            'totalBills' => $totalBills,
            'totalExpenses' => $totalExpenses,
            'totalClients' => $totalClients,
        ];
    }
}
