<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\Helpers\Colors;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $serviceOrder;
    private $serviceCustomer; 
    private $serviceProduct; 
    private $serviceCategory; 

    public function __construct(OrderService $serviceOrder, CustomerService $serviceCustomer, ProductService $serviceProduct, CategoryService $serviceCategory)
    {
        $this->serviceOrder = $serviceOrder;
        $this->serviceCustomer = $serviceCustomer;
        $this->serviceProduct = $serviceProduct;
        $this->serviceCategory = $serviceCategory;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.orders.index',[
            'orders' =>  $this->serviceOrder->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        $orders = $request->session()->get('orders', []);

        return view('web.admin.orders.create',[
            'customers' => $this->serviceCustomer->getAll(),
            'categories' => $this->serviceCategory->getAll(),
            'colorArray'=> Colors::getColors(),
            'products'=> $this->serviceProduct->getAll(request(['category','search'])),
            'orders'=> $this->serviceProduct->getAll($orders,'order')
        ]);
    }

    public function sessionControl(Request $request)
    {
        if ($request->input('type')=="create") {
            $order = $request->input('name'); 
            $orders = $request->session()->get('orders', []);
                
            if (!in_array($order, $orders)) {
                $orders[] = $order;
                $request->session()->put('orders', $orders);
            }

        }else if($request->input('type')=="delete"){
            
            $orders = $request->session()->get('orders', []);
            $index = array_search($request->input('name'), $orders);

            if ($index !== false) {
                $request->session()->forget("orders.$index");
            }

        }else if($request->input('type')=="deleteAll"){
            
                $request->session()->forget("orders",[]);

        }
        return response()->json(['message' => "berhasil"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->serviceOrder->saveData($request);

        return redirect('/admin/orders')->with('success',"Order baru tanggal <b>".now()."</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('web.admin.orders.show',[
                'order' =>  $this->serviceOrder->getById($order->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Order $order)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Order $order)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->serviceOrder->deleteById($order->id);

        return redirect('/admin/orders')->with('success',"Order pada <b>$order->created_at</b> berhasil dibatalkan");

    }
}
