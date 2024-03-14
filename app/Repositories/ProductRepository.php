<?php 
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class ProductRepository{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
       return $this->model::create($data);
    }

    public function update($data)
    {
        return $this->model::findOrFail($data['id'])
                    ->update($data);
    }

    public function updateStock($id,$qty,$type="add")
    {
        $product = $this->model::findOrFail($id);

        if ($type=="sold") {
            return $product->decrement('stock',$qty);
        }

        if($type=="add"){
            return $product->increment('stock',$qty);
        }else{
        $quantity = $product->stocks()->wherePivot('stock', $type)->first()->pivot->quantity;
        
        if ($quantity > $qty) {
            $diffQty = intval($quantity) - intval($qty);
            return $product->decrement('stock',$diffQty);
        }else{
            $diffQty = intval($qty) - intval($quantity);
            return $product->increment('stock',$diffQty);
        }
        } 
    }

    public function read($request,$isorder=null)
    {
        if ($isorder=="order") {
            if (!empty($request)) {
            
            $data = collect(); 
            foreach ($request as $order) {
                $orderDetails = $this->model::where('name', $order)->latest()->get();
                $data = $data->merge($orderDetails);
            }
            return $data;
        }else{
            return null;
        }
        }
        return $this->model::latest()->filter($request)->paginate(8)->withQueryString();
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }

    public function readByName($name)
    {
        return $this->model::where('name',$name)->first();
    }

    public function delete($id)
    {
        return $this->model::findOrFail($id)
                    ->delete();
    }
}