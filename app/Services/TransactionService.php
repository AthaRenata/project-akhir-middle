<?php 
namespace App\Services;

use stdClass;
use Illuminate\Support\Collection;
use App\Repositories\OrderRepository;
use App\Repositories\StockRepository;

class TransactionService{

    protected $repositoryOrder;
    protected $repositoryStock;

    public function __construct(OrderRepository $repositoryOrder, StockRepository $repositoryStock)
    {
        $this->repositoryOrder = $repositoryOrder;
        $this->repositoryStock = $repositoryStock;
    }

    public function getAll()
    {
        $transactions = [];
        $orders = $this->repositoryOrder->readAll();
        $stocks = $this->repositoryStock->readAll();
        
        $dates = [];
        foreach ($orders as $order) {
            if (!in_array($order->date, $dates)) {
                $dates[] = $order->date;
            }
        }

        foreach ($stocks as $stock) {
             if (!in_array($stock->date, $dates)) {
                $dates[] = $stock->date;
            }
        }

        foreach ($dates as $date) {
            $ordersByDate = $this->repositoryOrder->readByDate($date);
            $stock = $this->repositoryStock->readByDate($date);

            $order = 0;
            foreach ($ordersByDate as $orderByDate) {
                $order += $orderByDate->payment;
            }

            $transaction = new stdClass();
    
            $cost = ($stock->cost) ?? 0;
            $transaction->date = $date;
            $transaction->income = $order;
            $transaction->expenditure = $cost;
            $diff = $order - $cost;
            if ($diff > 0) {
                $transaction->profit = $diff;
                $transaction->loss = 0;
            }else if ($diff < 0) {
                $transaction->profit = 0;
                $transaction->loss = $diff;
            }else {
                $transaction->profit = 0;
                $transaction->loss = 0;
            }

            $transactions[] = $transaction;
        }

        $result = new Collection($transactions);
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

        $result = $this->getAll()->filter(function ($item) use ($date1, $date2) {
            $date = $item->date;
            return $date >= $date1 && $date <= $date2;
        });

        return $result;
    }
}