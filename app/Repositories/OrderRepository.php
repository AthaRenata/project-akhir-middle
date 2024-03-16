<?php 
namespace App\Repositories;

use App\Models\Order;

class OrderRepository{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function save($data,$customer)
    {
        return $this->model::create([
            'customer_id' => $data['customer_id'],
            'username' => $customer->username,
            'full_name' =>  $customer->full_name,
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

    public function readAll()
    {
        return $this->model::latest()->get();
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

    public function readByDate($date)
    {
        return $this->model::where('date',$date)->get();
    }

    public function readByIdAndDate($id,$date)
    {
        return $this->model::where('id', $id)->where('date', $date)->get();
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