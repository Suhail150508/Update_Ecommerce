<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = ['name','discount_type','price','product_ids'];

    public function products(){
        return $this->belongsToMany(Product::class, 'bundled_product_product');
    }
}
