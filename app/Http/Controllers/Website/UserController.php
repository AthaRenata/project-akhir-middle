<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('admin')){
        return view('web.admin.users.index',[
            'users' =>$this->service->getAll()
        ]);
    }else if(Gate::allows('staff')){
        return view('web.staff.users.index',[
            'users' =>$this->service->getAll()
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
            return view('web.admin.users.create');
        }else if(Gate::allows('staff')){
             return view('web.staff.users.create');
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
        return redirect('/admin/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil ditambahkan");
    }else if(Gate::allows('staff')){
        return redirect('/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil ditambahkan");
              }else{
                abort(403);
            }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if(Gate::allows('admin')){
        return view('web.admin.users.edit',[
            'user' => $this->service->getById($user->id)
        ]);
    }else if(Gate::allows('staff')){
        return view('web.staff.users.edit',[
            'user' => $this->service->getById($user->id)
        ]);
    }else{
                abort(403);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->merge(['role' => $user->role]);
        $this->service->updateData($request,$user->id);

        if(Gate::allows('admin')){
        return redirect('/admin/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil diubah");
    }else if(Gate::allows('staff')){
        return redirect('/users')->with('success',"Pengguna <strong>$request->name</strong> berhasil diubah");
    }else{
                abort(403);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->service->deleteById($user->id);

        if(Gate::allows('admin')){
        return redirect('/admin/users')->with('success',"Pengguna <strong>$user->email</strong> berhasil dihapus");
    }else if(Gate::allows('staff')){
        return redirect('/users')->with('success',"Pengguna <strong>$user->email</strong> berhasil dihapus");
    }else{
                abort(403);
            }
    }
}
