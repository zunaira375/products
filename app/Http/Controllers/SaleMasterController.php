<?php

namespace App\Http\Controllers;

use App\Models\SaleMaster;
use Illuminate\Http\Request;

use App\Models\Customer;
use Yajra\DataTables\Facades\DataTables;

class SaleMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {


        if ($request->ajax()) {
            $data = SaleMaster::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/salemasters/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteSalesMaster"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                // ->editColumn('customer_id', function ($row) {
                //     return $row->customer()->first()->name;
                // })
                ->rawColumns(['action'])->make(true);
        }


        $customers = Customer::with('sale_masters')->get();

        return view('saleMasters.index', compact('customers'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('saleMasters.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('id') != '') {
            //perform Edit
            $id = $request->get('id');
            $saleMaster = SaleMaster::find($id);


            $saleMaster->date = $request->date;

            $saleMaster->customer_id = $request->customer_id;

            $saleMaster->save();

            // $product->categories()->attach($request->category);


            return redirect()->route('salemasters.index')
                ->with('success', 'SaleMaster updated successfully.');
        } else {


            //Perform Create
            $request->validate([
                'date' => 'date',
                // 'customer_id' => 'required',




            ]);
            SaleMaster::create($request->all());
        }

        return redirect()->route('salemasters.index')
            ->with('success', 'saleMaster created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleMaster  $saleMaster
     * @return \Illuminate\Http\Response
     */
    public function show(SaleMaster $saleMaster)
    {
        //
        return view('saleMasters.show', compact('saleMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleMaster  $saleMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $saleMaster = SaleMaster::find($id);
        $saleMasters = SaleMaster::latest()->paginate(5);
        $customers = Customer::with('sale_masters')->get();

        // $categories = Category::latest()->paginate(5);

        return view('saleMasters.index', compact('saleMaster', 'saleMasters', 'customers'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleMaster  $saleMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleMaster $saleMaster)
    {
        $request->validate([
            'date' => 'required',
            'customer_id' => 'required',

        ]);

        $saleMaster->update($request->all());

        return redirect()->route('salemasters.index')
            ->with('success', 'SaleMaster updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleMaster  $saleMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleMaster $saleMaster)
    {
        $saleMaster->delete();

        return redirect()->route('salemasters.index')
            ->with('success', 'saleMaster deleted successfully');
    }
}
