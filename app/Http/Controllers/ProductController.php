<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;




use Yajra\DataTables\DataTables as DataTablesDataTables;

class ProductController extends Controller
{
    public function add_product($id)
    {
        $category = Category::find($id);

        $product = new Product();
        $product->name = 'herbal shampoo';
        $product->detail = 'for smooth and long hairs..';
        $product->cat = 'cat 3';
        $category->product()->save($product);
    }

    public function index(Request $request)

    {

        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/products/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteProduct"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])->make(true);
        }

        $products = Product::latest()->get();
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    // $products = Product::latest()->paginate(5);
    // return view('products.index', compact('products'))
    //     ->with('i', (request()->input('page', 1) - 1) * 5);


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.index');
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
            $product = Product::find($id);

            $product->name = $request->name;

            $product->detail = $request->detail;

            $product->save();

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');
        } else {
            //Perform Create
            $request->validate([
                'name' => 'required',
                'detail' => 'required',
            ]);
            Product::create($request->all());
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $product = Product::find($id);
        $products = Product::latest()->paginate(5);

        return view('products.index', compact('product', 'products'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response


     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
