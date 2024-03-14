<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products(){
        return $this->belongsToMany(Product::class,'stock_details','stock','product')
                    ->withTimestamps()
                    ->withPivot('quantity');
    }

    public function getRouteKeyName()
    {
        return 'date';
    }

}
