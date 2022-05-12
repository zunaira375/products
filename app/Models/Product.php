<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = ['id', 'name', 'cat_id', 'detail'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function items()
    {

        return $this->hasMany(Item::class, 'product_id');
    }

    public function sale_details()
    {

        return $this->hasMany(SaleDetail::class, 'product_id');
    }
}
