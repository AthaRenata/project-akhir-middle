<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['customer'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_details','order','product')
                    ->withTimestamps()
                    ->withPivot('quantity')
                    ->withPivot('price')
                    ->withPivot('product_name')
                    ->withPivot('category_name');
    }
}
