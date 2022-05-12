<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'price', 'sale_master_id', 'product_id'
    ];

    public function customer()
    {
        return $this->belongsTo(SaleMaster::class, 'sale_master_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
