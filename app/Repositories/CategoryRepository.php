<?php 
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository{
    protected $model;

    public function __construct(Category $model)
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
        return $this->model::latest()->paginate(8)->withQueryString();
    }

    public function readById($id)
    {
        return $this->model::find($id);
    }

    public function readByName($name)
    {
        return $this->model::where('name',$name)->first();
    }

    public function delete($id)
    {
        return $this->model::findOrFail($id)
                    ->delete();
    }
}