<?php

namespace App\Http\Controllers;

use App\Models\mobile;
use App\Models\Customer;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    //
    public function show_customer($id)
    {
        $customer = mobile::find($id)->customer;
        // return $customer;
        return view('mobiles.index', ['customer' => $customer]);
    }
}
