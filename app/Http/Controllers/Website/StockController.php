<?php

namespace App\Http\Controllers\Website;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Services\ProductService;
use App\Http\Controllers\Controller;


class StockController extends Controller
{
    private $serviceStock;
    private $serviceProduct;

    public function __construct(StockService $serviceStock, ProductService $serviceProduct)
    {
        $this->serviceStock = $serviceStock;
        $this->serviceProduct = $serviceProduct;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.stocks.index',[
            'stocks'=>$this->serviceStock->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.admin.stocks.create',[
            'products'=>$this->serviceProduct->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->serviceStock->saveData($request);

        return redirect('/admin/stocks')->with('success',"Stok Tanggal <b>".now()."</b> berhasil ditambahkan");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return view('web.admin.stocks.edit',[
            'products'=>$this->serviceProduct->getAll(),
            'stock'=>$this->serviceStock->getByDate($stock->date)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $this->serviceStock->updateData($request,$stock->id);

        return redirect('/admin/stocks')->with('success',"Stok tanggal <b>$stock->date</b> berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $this->serviceStock->deleteById($stock->id);

        return redirect('/admin/stocks')->with('success',"Stok tanggal <b>$stock->date</b> berhasil dihapus");
    }
}
