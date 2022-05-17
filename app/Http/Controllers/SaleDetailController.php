<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    //
    public function index(Request $request)

    {


        // if ($request->ajax()) {
        // $data = SaleDetail::latest()->get();
        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($data) {

        //             //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
        //             $btn = ' <a href="/saledetails/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
        //             $btn = $btn . ' <a href="/saledetails/" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteDetails"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

        //             return $btn;
        //         })
        //         // ->editColumn('sale_master_id', function ($row) {
        //         //     return $row->customer()->first()->name;
        //         // })
        //         ->rawColumns(['action'])->make(true);
        // }


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

        // SaleDetail::create($request->all());

        return redirect()->route('saledetails.index')
            ->with('success', 'Sale Details has been added successfully!');
    }

    // public function show(SaleDetail $saleDetail)
    // {
    //     return view('saledetails.index', compact('saleDetail'));
    // }

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
