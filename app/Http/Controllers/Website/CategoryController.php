<?php

namespace App\Http\Controllers\Website;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.categories.index',[
            'categories' =>  $this->service->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->service->saveData($request);

        return redirect('/admin/categories')->with('success',"Kategori <b>$request->name</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($name)
    {
        return view('web.admin.categories.edit',[
            'category' => $this->service->getByName($name)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->service->updateData($request,$category->id);

        return redirect('/admin/categories')->with('success',"Kategori <b>$request->name</b> berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->service->deleteById($category->id);

        return redirect('/admin/categories')->with('success',"Kategori <b>$category->name</b> berhasil dihapus");
    }
}
