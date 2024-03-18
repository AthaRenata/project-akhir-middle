<?php 
namespace App\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;

class CategoryService{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'icon'=>'required|image',
            'name'=>'required|unique:categories,name'
        ]);

        $upload = Storage::put('image',$validatedData['icon']);
        $validatedData['icon'] = "storage/{$upload}";
        
        return $this->repository->save($validatedData);
    }

    public function updateData($data, $id)
    {
        $validatedData = $data->validate([
            'name'=>['required',Rule::unique('categories')->ignore($id)],
        ]);

        if (!empty($data['icon'])) {
            $dataunlink = $this->repository->readById($id);
            $unlinkimg = substr($dataunlink['icon'],strpos($dataunlink['icon'],'/')+1);
            Storage::delete($unlinkimg);
            $upload = Storage::put('image',$data['icon']);
            $validatedData['icon'] = "storage/{$upload}";
        }
        
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

    public function getByName($name)
    {
        return $this->repository->readByName($name);
    }

    public function deleteById($id)
    {
        $data = $this->repository->readById($id);
        $unlinkimg = substr($data['icon'],strpos($data['icon'],'/')+1);
        Storage::delete($unlinkimg);
        return $this->repository->delete($id);
    }
}