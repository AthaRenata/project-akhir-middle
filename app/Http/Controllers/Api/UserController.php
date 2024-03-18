<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends ApiController
{ 
    /**
    * Display a listing of the resource.
    */
   public function index()
   {
       $data = User::latest()
       ->get();

       return $this->sendSuccess($data);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required',
            'role'=>'required',
       ]);

       if ($validator->fails()) {
           return $this->sendBadRequest($validator->messages());
       }else{
           User::create([
               'name'=>$request->name,
               'email'=>$request->email,
               'password'=>Hash::make($request->password),
               'role'=>$request->role,
           ]);

           return $this->sendMessage("Pengguna $request->name berhasil ditambahkan");
       }
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
       $data = User::find($id);
       return $this->sendSuccess($data);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>['required',Rule::unique('users')->ignore($id)],
            'password'=>'nullable',
            'role'=>'required',
       ]);

       if ($validator->fails()) {
           return $this->sendBadRequest($validator->messages());
       }else{
        if ($request->password == null) {
            User::findOrFail($id)
            ->update([
                 'name'=>$request->name,
                 'email'=>$request->email,
                 'role'=>$request->role,
            ]);
            
        }else{
            User::findOrFail($id)
            ->update([
                 'name'=>$request->name,
                 'email'=>$request->email,
                 'password'=>Hash::make($request->password),
                 'role'=>$request->role,
            ]);

        }

           return $this->sendMessage("Pengguna $request->name berhasil diubah");
       }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
       User::findOrFail($id)
       ->delete();

        return $this->sendMessage('Data berhasil dihapus');
   }
}
