<?php

namespace App\Http\Controllers\Website;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    private $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.customers.index',[
            'customers' =>  $this->service->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->service->saveData($request);

        return redirect('/admin/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('web.admin.customers.edit',[
            'customer' => $this->service->getByUsername($customer->username)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $this->service->updateData($request,$customer->id);

        return redirect('/admin/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $this->service->deleteById($customer->id);

        return redirect('/admin/customers')->with('success',"Pelanggan <b>$customer->username</b> berhasil dihapus");
    }
}
