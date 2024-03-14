<?php 
namespace App\Services;

use Illuminate\Validation\Rule;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required',
            'role'=>'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        return $this->repository->save($validatedData);
    }

    public function updateData($data, $id)
    { 
        $validatedData = $data->validate([
            'name'=>'required',
            'email'=>['required',Rule::unique('users')->ignore($id)],
            'password'=>'nullable',
            'role'=>'required',
        ]);

        $validatedData['id'] = $id;
        return $this->repository->update($validatedData);
    }

    public function getAll()
    {
        return $this->repository->read();
    }

    public function getById($id)
    {
        return $this->repository->readById($id);
    }

    public function deleteById($id)
    {
        return $this->repository->delete($id);
    }
}