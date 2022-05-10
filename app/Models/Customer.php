<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone_number', 'address'
    ];

    public function mobile()
    {
        return $this->hasOne(Mobile::class);
    }

    public function sale_masters()
    {

        return $this->hasMany(SaleMaster::class, 'customer_id');
    }
}
