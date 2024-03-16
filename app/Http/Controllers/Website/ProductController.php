<?php

namespace App\Http\Controllers\Website;

use App\Helpers\Colors;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductController extends Controller
{
    private $serviceProduct;
    private $serviceCategory;

    public function __construct(ProductService $serviceProduct, CategoryService $serviceCategory)
    {
        $this->serviceProduct = $serviceProduct;
        $this->serviceCategory = $serviceCategory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.products.index',[
            'categories'=> $this->serviceCategory->getAllNoPaginate(),
            'products'=> $this->serviceProduct->getAll(request(['category','search'])),
            'colorArray'=>Colors::getColors()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.admin.products.create',[
            'categories'=>$this->serviceCategory->getAllNoPaginate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->serviceProduct->saveData($request);

        return redirect('/admin/products')->with('success',"Produk <b>$request->name</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('web.admin.products.edit',[
            'product' => $this->serviceProduct->getByName($product->name),
            'categories'=>$this->serviceCategory->getAllNoPaginate()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->serviceProduct->updateData($request,$product->id);

        return redirect('/admin/products')->with('success',"Produk <b>$request->name</b> berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->serviceProduct->deleteById($product->id);

        return redirect('/admin/products')->with('success',"Produk <b>$product->name</b> berhasil dihapus");
    }
}
