<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() 
    {
        $income = Transaction::where('transaction_status', 'SUCCESS')->sum('transaction_total');
        $sales  = Transaction::count();
        // untuk mengambil 5 item/data terakhir yang masuk ke sistem
        $items = Transaction::orderBy('id', 'DESC')->take(5)->get();
        // fungsi untuk grafik pending,failed dan success
        $pie   = [
            'pending' => Transaction::where('transaction_status', 'PENDING')->count(),
            'failed' => Transaction::where('transaction_status', 'FAILED')->count(),
            'success' => Transaction::where('transaction_status', 'SUCCESS')->count()
        ];

        return view('pages.dashboard')->with([
            'income' => $income,
            'sales' => $sales,
            'items' => $items,
            'pie' => $pie
        ]);
    }
    
}
