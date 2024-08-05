<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index()
    {
        return view('operations');
    }

    public function getData(Request $request)
    {
        $operations = [
            ['date' => '2023-10-01', 'description' => 'Payment', 'amount' => 100],
            ['date' => '2023-10-02', 'description' => 'Refund', 'amount' => -50],
            // Add more operations here
        ];

        if ($request->has('search')) {
            $operations = array_filter($operations, function ($operation) use ($request) {
                return stripos($operation['description'], $request->search) !== false;
            });
        }

        return response()->json([
            'balance' => 1000,
            'operations' => array_slice($operations, 0, 5),
        ]);
    }
}
