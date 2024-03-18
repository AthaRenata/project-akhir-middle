<?php

namespace App\Http\Controllers\Api;

use stdClass;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;


class TransactionController extends ApiController
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fromDate' => 'required',
            'toDate' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{

        $date1 = $request['fromDate'];
        $date2 = $request['toDate'];

        $transactions = [];
        $orders = Order::all();
        $stocks = Stock::all();
        
        $dates = [];
        foreach ($orders as $order) {
            if (!in_array($order->date, $dates)) {
                $dates[] = $order->date;
            }
        }

        foreach ($stocks as $stock) {
             if (!in_array($stock->date, $dates)) {
                $dates[] = $stock->date;
            }
        }

        foreach ($dates as $date) {
            $ordersByDate = Order::where('date',$date)->get();
            $stock =  Stock::where('date',$date)->first();

            $order = 0;
            foreach ($ordersByDate as $orderByDate) {
                $order += $orderByDate->payment;
            }

            $transaction = new stdClass();
    
            $cost = ($stock->cost) ?? 0;
            $transaction->date = $date;
            $transaction->income = $order;
            $transaction->expenditure = $cost;
            $diff = $order - $cost;
            if ($diff > 0) {
                $transaction->profit = $diff;
                $transaction->loss = 0;
            }else if ($diff < 0) {
                $transaction->profit = 0;
                $transaction->loss = $diff;
            }else {
                $transaction->profit = 0;
                $transaction->loss = 0;
            }

            $transactions[] = $transaction;
        }

        $collection = new Collection($transactions);
        $sorted = $collection->sortBy('date');
        
        $result = $sorted->filter(function ($item) use ($date1, $date2) {
            $date = $item->date;
            return $date >= $date1 && $date <= $date2;
        });

        return $this->sendSuccess($result);
     }
    }

}
