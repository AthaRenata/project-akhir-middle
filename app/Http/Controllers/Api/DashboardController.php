<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\ApiController;


class DashboardController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalProducts = Product::all()->count();
        $orderToday = Order::where('date',today())->count();
        $orderMonth = Order::whereMonth('date',now()->month)->count();
        $incomeToday = Order::where('date',today())->sum('payment');
        $incomeMonth = Order::whereMonth('date',now()->month)->sum('payment');
        $data = [
            'totalProducts' => $totalProducts,
            'orderToday' => $orderToday,
            'orderMonth' => $orderMonth,
            'incomeToday' => $incomeToday,
            'incomeMonth' => $incomeMonth
        ];

        return $this->sendSuccess($data);
    }

}
