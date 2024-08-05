<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GlobalMoneyTrait;

class HomeController extends Controller
{
    use GlobalMoneyTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function getOperations(Request $request)
    {
        $user = $request->user();
        $lastFiveOperations = $user->getLastFiveOperations();
        return response()->json([
            'operations' => $lastFiveOperations
        ]);
    }

    public function getTransactions(Request $request)
    {
        $user = $request->user();
        $lastFiveOperations = $user->operations;
        return response()->json([
            'operations' => $lastFiveOperations
        ]);
    }


    public function getBalance(Request $request)
    {
        $user = $request->user();
        $balance = $user->balance;
        $balanceAmount = $balance->amount_format;
        return response()->json([
            'balance_format' => $balanceAmount,
        ]);
    }

}
