<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

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
        return view('web.admin.users.index',[
            'users' =>$this->service->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->service->saveData($request);

        return redirect('/admin/users')->with('success',"Pengguna $request->name berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('web.admin.users.edit',[
            'user' => $this->service->getById($user->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->merge(['role' => $user->role]);
        $this->service->updateData($request,$user->id);

        return redirect('/admin/users')->with('success',"Pengguna $request->name berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->service->deleteById($user->id);

        return redirect('/admin/users')->with('success',"Pengguna $user->email berhasil dihapus");
    }
}
