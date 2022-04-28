<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'id', 'name', 'size', 'product_id'
    // ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
