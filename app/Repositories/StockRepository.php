<?php 
namespace App\Repositories;

use App\Models\Stock;

class StockRepository{
    protected $model;

    public function __construct(Stock $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
        return $this->model::create([
            'date' => $data['date'],
            'cost' => $data['cost']
        ]);
    }

    public function update($data)
    {
     $stock = $this->model::find($data['id']);
     $stock->update([
             'cost' => $data['cost']
            ]);
                return $stock;
    }

    public function read()
    {
        return $this->model::latest()->paginate(7)->withQueryString();
    }

    public function readAll()
    {
        return $this->model::latest()->get();
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }


    public function readByDate($date)
    {
        return $this->model::where('date', $date)->first();
    }

    public function delete($id)
    {
        $stock = $this->model::findOrFail($id);

        $idproducts = $stock->products()->pluck('id')->toArray();
        foreach ($idproducts as $idproduct) {
        $quantities[$idproduct] = $stock->products()->wherePivot('product', $idproduct)->first()->pivot->quantity;
        }
        
        $stock->products()->wherePivot('stock', $id)->detach();
        $stock->delete();
        return $quantities;
    }
}