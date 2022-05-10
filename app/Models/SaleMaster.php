<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }


    public function sale_details()
    {

        return $this->hasMany(SaleDetail::class, 'sale_master_id');
    }
}
