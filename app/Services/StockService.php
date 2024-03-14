<?php 
namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\StockRepository;

class StockService{
    protected $repositoryStock;
    protected $repositoryProduct;

    public function __construct(StockRepository $repositoryStock, ProductRepository $repositoryProduct)
    {
        $this->repositoryStock = $repositoryStock;
        $this->repositoryProduct = $repositoryProduct;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'date'=>'required|unique:stocks,date',
            'cost'=>'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $stock = $this->repositoryStock->save($validatedData);

        foreach ($data['products'] as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $stock->products()->attach($productId, ['quantity' => $quantity]);
            $this->repositoryProduct->updateStock($productId,$quantity);
        }
        
        return $stock;
    }

    public function updateData($data, $id)
    {
        $validatedData = $data->validate([
            'cost'=>'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        $validatedData['id'] = $id;

        $stock = $this->repositoryStock->update($validatedData);
        
        foreach ($validatedData['products'] as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $syncData[$productId] = ['quantity' => $quantity];
        }
        
        foreach ($syncData as $productId => $quantity) {
            $this->repositoryProduct->updateStock($productId, $quantity['quantity'],$id);
        }

        $stock->products()->sync($syncData);
        
        return $stock;
    }

    public function getAll()
    {
        return $this->repositoryStock->read();
    }

    public function getByDate($date)
    {
        return $this->repositoryStock->readByDate($date);
    }

    public function deleteById($id)
    {
        $quantities = $this->repositoryStock->delete($id);
        foreach ($quantities as $idproduct => $quantity) {
            $product = $this->repositoryProduct->readById($idproduct);
            $product->decrement('stock',$quantity);
        }
    }
}