<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Services\OrderService;

class DashboardController extends Controller
{
    private $serviceProduct;
    private $serviceOrder;

    public function __construct(ProductService $serviceProduct, OrderService $serviceOrder)
    {
        $this->serviceProduct = $serviceProduct;
        $this->serviceOrder = $serviceOrder;
    }

    public function index()
    {
        return view('web.admin.dashboard.index',[
            'totalProducts' => $this->serviceProduct->getAll()->total(),
            'orderToday' => $this->serviceOrder->getOrderToday(),
            'orderMonth' => $this->serviceOrder->getOrderMonth(),
            'incomeToday' => $this->serviceOrder->getIncomeToday(),
            'incomeMonth' => $this->serviceOrder->getIncomeMonth(),
        ]);
    }
}
