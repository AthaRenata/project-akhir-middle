<?php 
namespace App\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CustomerRepository;

class CustomerService{
    protected $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'username'=>'required|unique:customers,username',
            'full_name'=>'required',
            'phone'=>'required',
            'email'=>'required',
        ]);
        
        return $this->repository->save($validatedData);
    }

    public function updateData($data, $id)
    {
        $validatedData = $data->validate([
            'username'=>['required',Rule::unique('customers')->ignore($id)],
            'full_name'=>'required',
            'phone'=>'required',
            'email'=>'required',
        ]);

        $validatedData['id'] = $id;
        return $this->repository->update($validatedData);
    }

    public function getAllNoPaginate()
    {
        return $this->repository->readAll();
    }

    public function getAll()
    {
        return $this->repository->read();
    }

    public function getByUsername($username)
    {
        return $this->repository->readByUsername($username);
    }

    public function deleteById($id)
    {
        return $this->repository->delete($id);
    }
}