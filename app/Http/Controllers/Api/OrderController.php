<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Order::latest()
        ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required',
            'payment' => 'required',
            'products.*.id' => 'required',
            'products.*.quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($request) {
                $segments = explode('.', $attribute);
                $productIndex = $segments[1]; 
                $productId = $request['products'][$productIndex]['id']; 
                $product = Product::find($productId);
                if ($value > $product->stock) {
                    return $fail('Jumlah melebihi stok');
                }
            }],
            'products.*.price' => 'required',
            'products.*.product_name' => 'required',
            'products.*.category_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            
            $customer = Customer::find($request->customer_id);
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'username' => $customer->username,
                'full_name' =>  $customer->full_name,
                'payment' => $request->payment,
                'date' => today()
            ]);

            foreach ($request->products as $productData) {
                $productId = $productData['id'];
                $quantity = $productData['quantity'];
                $price = $productData['price'];
                $product_name = $productData['product_name'];
                $category_name = $productData['category_name'];
                $order->products()->attach($productId, [
                    'quantity' => $quantity,
                    'price' => $price,
                    'product_name' => $product_name,
                    'category_name' => $category_name
                 ]);
                Product::findOrFail($productId)->decrement('stock',$quantity);
            }
            
            return $this->sendMessage("Order ".now()." berhasil ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Order::find($id);
        return $this->sendSuccess($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $idproducts = $order->products()->pluck('id')->toArray();
        foreach ($idproducts as $idproduct) {
        $quantities[$idproduct] = $order->products()->wherePivot('product', $idproduct)->first()->pivot->quantity;
        }
        
        $order->products()->wherePivot('order', $id)->detach();
        $order->delete();

        foreach ($quantities as $idproduct => $quantity) {
            $product = Product::find($idproduct);
            $product->increment('stock',$quantity);
        }

         return $this->sendMessage('Data berhasil dihapus');
    }
}
