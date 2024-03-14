<?php 
namespace App\Repositories;

use App\Models\Order;

class OrderRepository{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
       return $this->model::create([
           'customer_id' => $data['customer_id'],
           'payment' => $data['payment'],
           'date' => today()
       ]);
    }

    public function update($data)
    {
        return $this->model::findOrFail($data['id'])
                    ->update($data);
    }

    public function read()
    {
        return $this->model::latest()->paginate(10)->withQueryString();
    }

    public function countOrderToday()
    {
        return $this->model::where('date',today())->count();
    }

    public function countOrderMonth()
    {
        return $this->model::whereMonth('date',now()->month)->count();
    }

    public function sumIncomeToday()
    {
        return $this->model::where('date',today())->sum('payment');
    }

    public function sumIncomeMonth()
    {
        return $this->model::whereMonth('date',now()->month)->sum('payment');
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }

    public function delete($id)
    {
        $order = $this->model::findOrFail($id);

        $idproducts = $order->products()->pluck('id')->toArray();
        foreach ($idproducts as $idproduct) {
        $quantities[$idproduct] = $order->products()->wherePivot('product', $idproduct)->first()->pivot->quantity;
        }
        
        $order->products()->wherePivot('order', $id)->detach();
        $order->delete();
        return $quantities;
    }
}