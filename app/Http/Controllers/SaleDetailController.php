<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SaleDetailController extends Controller
{


    public function index(Request $request)

    {

        $customers = Customer::with('sale_details')->get();

        $products = Product::with('sale_details')->get();

        return view('saledetails.index', compact('customers', 'products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|max:191',
            'sale_master_id' => 'required|max:2',
            'product_id' => 'required|max:10',
            'quantity' => 'required|max:700',
            'price' => 'required|max:400',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages,
            ]);
        } else {

            $saleDetail = new SaleDetail();
            $saleDetail->date = $request->input('date');
            $saleDetail->sale_master_id = $request->input('sale_master_id');
            $saleDetail->product_id = $request->input('product_id');
            $saleDetail->quantity = $request->input('quantity');
            $saleDetail->price = $request->input('price');
            $saleDetail->save();
            return response()->json([
                'status' => 200,
                'message' => 'details has been added successfully!',
            ]);
        }
    }


    public function create()
    {
        return view('saledetails.index');
    }





    public function show(SaleDetail $saleDetail)
    {
        $customers = Customer::with('sale_details')->get();

        $products = Product::with('sale_details')->get();

        return view('saledetails.jquery_index', compact('saleDetail', 'customers', 'products'));
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
