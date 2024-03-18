<?php 
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveData($data)
    {
        $validatedData = $data->validate([
            'category_id'=>'nullable',
            'photo'=>'required|image',
            'name'=>'required|unique:products,name',
            'description'=>'required',
            'price'=>'required'
        ]);
        $validatedData['stock'] = 0;
        $upload = Storage::put('image',$validatedData['photo']);
        $validatedData['photo'] = "storage/{$upload}";
        
        return $this->repository->save($validatedData);
    }

    public function updateData($data, $id)
    {
        $validatedData = $data->validate([
            'category_id'=>'nullable',
            'name'=>['required',Rule::unique('products')->ignore($id)],
            'description'=>'required',
            'price'=>'required'
        ]);

        if (empty($data['photo'])) {
            $validatedData = $data->except(['photo']);
        }else{
            $dataunlink = $this->repository->readById($id);
            $unlinkimg = substr($dataunlink['photo'],strpos($dataunlink['photo'],'/')+1);
            Storage::delete($unlinkimg);
            $upload = Storage::put('image',$data['photo']);
            $validatedData['photo'] = "storage/{$upload}";
        }
        
        $validatedData['id'] = $id;
        return $this->repository->update($validatedData);
    }

    public function getAll($request=null, $isorder = null)
    {
        if($isorder=="order"){
            $products =  $this->repository->read($request,$isorder); 
        }else{
         $products =  $this->repository->read($request); 
         if (!empty($products)) {
         foreach ($products as $product) {
            $product->full_description = $product->description; 
            $product->description = Str::words($product->description, 10, '...'); 
         }
        }
    }   
         return $products;
    }

    public function getByName($name)
    {
        return $this->repository->readByName($name);
    }

    public function deleteById($id)
    {
        $data = $this->repository->readById($id);
        $unlinkimg = substr($data['photo'],strpos($data['photo'],'/')+1);
        Storage::delete($unlinkimg);
        return $this->repository->delete($id);
    }
}