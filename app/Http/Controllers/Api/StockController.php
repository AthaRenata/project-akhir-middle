<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;


class StockController extends ApiController
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Stock::latest()
        ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'date'=>'required|unique:stocks,date',
            'cost'=>'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            $stock = Stock::create([
                'date' => $request->date,
                'cost' => $request->cost
            ]);

            foreach ($request->products as $productData) {
                $productId = $productData['id'];
                $quantity = $productData['quantity'];
                $stock->products()->attach($productId, ['quantity' => $quantity]);
                
                Product::findOrFail($productId)->increment('stock',$quantity);
            }

            return $this->sendMessage("Stok ".now()." berhasil ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Stock::find($id);
        return $this->sendSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'cost'=>'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
               $stock =  Stock::findOrFail($id)
                ->update([
                    'cost'=>$request->cost,
                ]);

                foreach ($stock->products as $productData) {
                    $productId = $productData['id'];
                    $quantity = $productData['quantity'];
                    $syncData[$productId] = ['quantity' => $quantity];
                }
                
                foreach ($syncData as $productId => $quantity) {
                    $product = Product::findOrFail($productId);

                    $quantity = $product->stocks()->wherePivot('stock', $id)->first()->pivot->quantity;
        
                    if ($quantity > $quantity['quantity']) {
                        $diffQty = intval($quantity) - intval($quantity['quantity']);
                        return $product->decrement('stock',$diffQty);
                    }else{
                        $diffQty = intval($quantity['quantity']) - intval($quantity);
                        return $product->increment('stock',$diffQty);
                    }
                }
        
                $stock->products()->sync($syncData);

            return $this->sendMessage("Stok ".now()." berhasil diubah");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::findOrFail($id);

        $idproducts = $stock->products()->pluck('id')->toArray();
        foreach ($idproducts as $idproduct) {
        $quantities[$idproduct] = $stock->products()->wherePivot('product', $idproduct)->first()->pivot->quantity;
        }
        
        $stock->products()->wherePivot('stock', $id)->detach();
        $stock->delete();

        foreach ($quantities as $idproduct => $quantity) {
            $product = Product::find($idproduct);
            $product->decrement('stock',$quantity);
        }

         return $this->sendMessage('Data berhasil dihapus');
    }
}
