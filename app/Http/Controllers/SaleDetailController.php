<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleMaster;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;


class SaleDetailController extends Controller
{


    public function index(Request $request)

    {
        $customers = Customer::with('sale_details')->get();

        $products = Product::with('sale_details')->get();


        $salemasters = SaleMaster::get();


        return view('saledetails.index', compact('customers', 'products', 'salemasters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {

        $request->validate([
            'date' => 'required',
            'sale_master_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'product_id' => 'required',

        ]);

        $session_id = session()->getId();
        if ($saleDetail = SaleDetail::find($session_id)) {
            //  REMOVE table created by PHP

            // Check in the session weather sale_master_id exist or not
            // If exist grab sale_master_id from session and make insertion only into sale_details_table
            // if sale_master_id not exist in the session then insert data into both tables (sale_masters and sale_details tables)
            // store sale_master_id in session variable called sale_master_id

            $saleDetail = new SaleDetail();
            $saleDetail->quantity = $request->input('quantity');
            $saleDetail->price = $request->input('price');
            $saleDetail->product_id = $request->input('product_id');
            $saleDetail->sale_master_id = $request->input('sale_master_id');
            $saleDetail->save();

            return response()->json([
                'status' => 400,
                'message' => 'details has been added in only Sale_Details successfully!',
            ]);
        } else {

            $salemaster = new SaleMaster();
            $salemaster->date = $request->input('date');
            $salemaster->customer_id = $request->input('sale_master_id');
            $salemaster->save();
            $sale_master_id = $request->input('id');
            $request->session()->put('id', $sale_master_id);

            $saleDetail = new SaleDetail();
            $saleDetail->quantity = $request->input('quantity');
            $saleDetail->price = $request->input('price');
            $saleDetail->product_id = $request->input('product_id');
            $saleDetail->sale_master_id = $request->input('sale_master_id');
            $saleDetail->save();

            return response()->json([
                'status' => 200,
                'message' => 'data has been added in Both Tables successfully!',
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
    public function destroy(SaleDetail $saleDetail)
    {
        $saleDetail->delete();

        return redirect()->route('saledetails.index')
            ->with('success', 'Sale Details has been deleted successfully');
    }
}
