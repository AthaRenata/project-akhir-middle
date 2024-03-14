<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['category'];

    public function scopeFilter($query,array $filters = null)
    {
        $query->when($filters['category'] ?? false, function($query,$category){
            return $query->whereHas('category',function($query) use ($category){
                $query->where('name',$category);
            });
        });

        $query->when($filters['search'] ?? false, fn($query,$search)=>
                $query->where('name','like','%'.$search.'%')
        );

        $query->when($filters['order'] ?? false, fn($query,$order)=> 
            $query->whereIn('name',$order)
        );
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stocks(){
        return $this->belongsToMany(Product::class,'stock_details','product','stock')
                    ->withTimestamps()
                    ->withPivot('quantity');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
