<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\Helpers\Colors;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::allows('admin')) {
        return view('web.admin.orders.index',[
            'orders' =>  $this->serviceOrder->getAll()
        ]);
        }else if(Gate::allows('staff')){
        return view('web.staff.orders.index',[
            'orders' =>  $this->serviceOrder->getAll()
        ]);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        $orders = $request->session()->get('orders', []);

        if (Gate::allows('admin')) {
        return view('web.admin.orders.create',[
            'customers' => $this->serviceCustomer->getAllNoPaginate(),
            'categories' => $this->serviceCategory->getAllNoPaginate(),
            'colorArray'=> Colors::getColors(),
            'products'=> $this->serviceProduct->getAll(request(['category','search'])),
            'orders'=> $this->serviceProduct->getAll($orders,'order')
        ]);
        }else if(Gate::allows('staff')){
            return view('web.staff.orders.create',[
                'customers' => $this->serviceCustomer->getAllNoPaginate(),
                'categories' => $this->serviceCategory->getAllNoPaginate(),
                'colorArray'=> Colors::getColors(),
                'products'=> $this->serviceProduct->getAll(request(['category','search'])),
                'orders'=> $this->serviceProduct->getAll($orders,'order')
            ]);
        }else{
            abort(403);
        }
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

        if (Gate::allows('admin')) {
        return redirect('/admin/orders')->with('success',"Order baru tanggal <b>".now()."</b> berhasil ditambahkan");
        }else if(Gate::allows('staff')){
            return redirect('/orders')->with('success',"Order baru tanggal <b>".now()."</b> berhasil ditambahkan");
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if(Gate::allows('admin')){
        return view('web.admin.orders.show',[
                'order' =>  $this->serviceOrder->getById($order->id)
        ]);
    }else if(Gate::allows('staff')){
        return view('web.staff.orders.show',[
            'order' =>  $this->serviceOrder->getById($order->id)
    ]);
    }else{
        abort(403);
    }
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

        if(Gate::allows('admin')){
        return redirect('/admin/orders')->with('success',"Order pada <b>$order->created_at</b> berhasil dibatalkan");
        }else if(Gate::allows('staff')){
            return redirect('/orders')->with('success',"Order pada <b>$order->created_at</b> berhasil dibatalkan");
        }else{
            abort(403);
        }
    }
}
