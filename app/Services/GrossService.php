<?php 
namespace App\Services;

use stdClass;
use Illuminate\Support\Collection;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class GrossService{

    protected $repositoryOrder;
    protected $repositoryProduct;

    public function __construct(OrderRepository $repositoryOrder, ProductRepository $repositoryProduct)
    {
        $this->repositoryOrder = $repositoryOrder;
        $this->repositoryProduct = $repositoryProduct;
    }

    public function getAll()
    {
        $grosses = [];
        $orders = $this->repositoryOrder->readAll();

        foreach ($orders as $order) {
            $date = $order->date;
            $productData = [];
            foreach ($order->products as $product) {
                if (array_key_exists($product->pivot->product,$productData)) {
                    $productData[$product->pivot->product]['quantity'] += $product->pivot->quantity;
                }else{
                    $productData[$product->pivot->product]['quantity'] = $product->pivot->quantity;
                    $productData[$product->pivot->product]['product_name'] = $product->pivot->product_name;
                    $productData[$product->pivot->product]['category_name'] = $product->pivot->category_name;
                    $productData[$product->pivot->product]['price'] = $product->pivot->price;
                }
            }

            foreach ($productData as $data) {
                $gross = new stdClass();
        
                $gross->date = $date;
                $gross->name = $data['product_name'];
                $gross->category = $data['category_name'];
                $gross->price =  $data['price'];
                $gross->qty =  $data['quantity'];
                
                $grosses[] = $gross;
            }

        }

        $result = new Collection($grosses);
        $result = $result->sortBy('date');
        return $result;
    }

    public function getByDates($data){
        $validatedData = $data->validate([
            'fromDate' => 'required',
            'toDate' => 'required'
        ]);

        $date1 = $validatedData['fromDate'];
        $date2 = $validatedData['toDate'];

        $filteredData = $this->getAll()->filter(function ($item) use ($date1, $date2) {
            $date = $item->date;
            return $date >= $date1 && $date <= $date2;
        });


        $arrayData = $filteredData->groupBy(['name'])
            ->map(function ($group) {
                $totalQty = $group->sum('qty');
                $firstProduct = $group->first();
                $firstProduct->qty = $totalQty;
                return $firstProduct;
            })
            ->sortByDesc('qty')
            ->map(function ($filteredData) {
                return [
                    'name' => $filteredData->name,
                    'category' => $filteredData->category,
                    'price' => $filteredData->price,
                    'total_qty' => $filteredData->qty,
                ];
            });

            $arrayData = $arrayData->values()->all();
            $result = collect($arrayData)->map(function ($item) {
                return (object) $item;
            });
        return  $result;
    }
}