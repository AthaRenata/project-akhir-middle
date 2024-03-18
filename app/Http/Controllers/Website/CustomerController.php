<?php

namespace App\Http\Controllers\Website;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

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
        if(Gate::allows('admin')){
        return view('web.admin.customers.index',[
            'customers' =>  $this->service->getAll()
        ]);
    }else if(Gate::allows('staff')){
        return view('web.staff.customers.index',[
            'customers' =>  $this->service->getAll()
        ]);
            }else{
                abort(403);
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin')){
        return view('web.admin.customers.create');
        }else if(Gate::allows('staff')){
        return view('web.staff.customers.create');
            }else{
                abort(403);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->service->saveData($request);
        if(Gate::allows('admin')){
            return redirect('/admin/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil ditambahkan");
         }else if(Gate::allows('staff')){
            return redirect('/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil ditambahkan");
        }else{
            abort(403);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
    if(Gate::allows('admin')){
        return view('web.admin.customers.edit',[
            'customer' => $this->service->getByUsername($customer->username)
        ]);
         }else if(Gate::allows('staff')){
       return view('web.staff.customers.edit',[
            'customer' => $this->service->getByUsername($customer->username)
        ]);
            }else{
                abort(403);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $this->service->updateData($request,$customer->id);

if(Gate::allows('admin')){
        return redirect('/admin/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil diubah");
         }else if(Gate::allows('staff')){
         return redirect('/customers')->with('success',"Pelanggan <b>$request->username</b> berhasil diubah");
            }else{
                abort(403);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $this->service->deleteById($customer->id);

if(Gate::allows('admin')){
        return redirect('/admin/customers')->with('success',"Pelanggan <b>$customer->username</b> berhasil dihapus");
         }else if(Gate::allows('staff')){
        return redirect('/customers')->with('success',"Pelanggan <b>$customer->username</b> berhasil dihapus");
            }else{
                abort(403);
            }
    }
}
