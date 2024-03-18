<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;


class CustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Customer::latest()
        ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username'=>'required|unique:customers,username',
            'full_name'=>'required',
            'phone'=>'required',
            'email'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            Customer::create([
                'username'=>$request->username,
                'full_name'=>$request->full_name,
                'phone'=>$request->phone,
                'email'=>$request->email,
            ]);

            return $this->sendMessage("Pelanggan $request->full_name berhasil ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Customer::find($id);
        return $this->sendSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'username'=>['required',Rule::unique('customers')->ignore($id)],
            'full_name'=>'required',
            'phone'=>'required',
            'email'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
                Customer::findOrFail($id)
                ->update([
                    'username'=>$request->username,
                    'full_name'=>$request->full_name,
                    'phone'=>$request->phone,
                    'email'=>$request->email,
                ]);

            return $this->sendMessage("Pelanggan $request->full_name berhasil diubah");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::findOrFail($id)
        ->delete();

         return $this->sendMessage('Data berhasil dihapus');
    }
}
