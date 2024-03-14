<?php 
namespace App\Services;

use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderService{
    protected $repositoryOrder;
    protected $repositoryProduct;

    public function __construct(OrderRepository $repositoryOrder, ProductRepository $repositoryProduct)
    {
        $this->repositoryOrder = $repositoryOrder;
        $this->repositoryProduct = $repositoryProduct;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'customer_id' => 'required',
            'payment' => 'required',
            'products.*.id' => 'required',
            'products.*.quantity' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($data) {
                $segments = explode('.', $attribute);
                $productIndex = $segments[1]; 
                $productId = $data['products'][$productIndex]['id']; 
                $product = $this->repositoryProduct->readById($productId);
                if ($value > $product->stock) {
                    return $fail('Jumlah melebihi stok');
                }
            }],
            'products.*.price' => 'required',
            'products.*.product_name' => 'required',
            'products.*.category_name' => 'required',
        ]);
        

        foreach ($data['products'] as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $product = $this->repositoryProduct->readById($productId);
            if ($quantity > $product->stock) {
                return false;
            }
        }
        $order = $this->repositoryOrder->save($validatedData);

        foreach ($data['products'] as $productData) {
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
            $this->repositoryProduct->updateStock($productId,$quantity,"sold");
        }
        
        return $order;
    }

    public function getAll()
    {
        return $this->repositoryOrder->read();
    }

    public function getOrderToday()
    {
        return $this->repositoryOrder->countOrderToday();
    }

    public function getOrderMonth()
    {
        return $this->repositoryOrder->countOrderMonth();
    }

    public function getIncomeToday()
    {
        return $this->repositoryOrder->sumIncomeToday();
    }

    public function getIncomeMonth()
    {
        return $this->repositoryOrder->sumIncomeMonth();
    }

    public function getById($id)
    {
        return $this->repositoryOrder->readById($id);
    }

    public function deleteById($id)
    {
        $quantities = $this->repositoryOrder->delete($id);
        foreach ($quantities as $idproduct => $quantity) {
            $product = $this->repositoryProduct->readById($idproduct);
            $product->increment('stock',$quantity);
        }
    }
}