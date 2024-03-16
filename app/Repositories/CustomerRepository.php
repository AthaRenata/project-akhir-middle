<?php 
namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
       return $this->model::create($data);
    }

    public function update($data)
    {
        return $this->model::findOrFail($data['id'])
                    ->update($data);
    }

    public function readAll()
    {
        return $this->model::latest()->get();
    }

    public function read()
    {
        return $this->model::latest()->paginate(10)->withQueryString();
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }

    public function readByUsername($username)
    {
        return $this->model::where('username',$username)->first();
    }

    public function delete($id)
    {
        return $this->model::findOrFail($id)
                    ->delete();
    }
}