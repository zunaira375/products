<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'price', 'sale_master_id'
    ];

    public function saleMaster()
    {
        return $this->belongsTo(SaleMaster::class, 'sale_master_id', 'id');
    }
}
