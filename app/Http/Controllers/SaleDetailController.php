<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{

    public function index(Request $request)

    {

        $customers = Customer::with('sale_details')->get();

        $products = Product::with('sale_details')->get();

        return view('saledetails.index', compact('customers', 'products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('saledetails.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'price' => 'required',
            'date' => 'required',
            'quantity' => 'required',
            'sale_master_id' => 'required',

        ]);

        return redirect()->route('saledetails.index')
            ->with('success', 'Sale Details has been added successfully!');
    }

    public function show(SaleDetail $saleDetail)
    {
        $customers = Customer::with('sale_details')->get();

        $products = Product::with('sale_details')->get();

        return view('saledetails.jqueryIndex', compact('saleDetail', 'customers', 'products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id->delete();

        return redirect()->route('saledetails.index')
            ->with('success', 'Sale Details has been deleted successfully');
    }
}
