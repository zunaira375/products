<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {


        if ($request->ajax()) {
            $data = Item::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/items/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteItem"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                ->editColumn('product_id', function ($row) {
                    return $row->product()->first()->name;
                })
                ->rawColumns(['action'])->make(true);
        }


        $products = Product::with('items')->get();


        return view('items.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function add(Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'required'],
            'size' => ['text', 'required'],
            'product_id' => ['required', 'numeric'],


        ]);
        $product = Product::findOrFail($data['id']);
        $item = new Item();
        $item->name = $data['name'];
        $item->product_id = $data['product_id'];
        $item->size = $data['size'];


        $product->items()->saveMany([
            new Item(['item' => 'name']),
            new Item(['product' => 'name']),
            new Item(['item' => 'size']),
            new Item(['item' => 'product_id']),
        ]);
        session()->flash("status", "success");
        session()->flash("title", "Success!");
        session()->flash('message', "The product was created successfully!");
        return redirect()->route('products');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->get('id') != '') {
            //perform Edit
            $id = $request->get('id');
            $item = Item::find($id);


            $item->name = $request->name;

            $item->product_id = $request->product_id;

            $item->size = $request->size;

            $item->save();

            // $product->categories()->attach($request->category);


            return redirect()->route('items.index')
                ->with('success', 'Item updated successfully.');
        } else {


            //Perform Create
            $request->validate([
                'name' => 'required',
                'size' => 'required',
                // 'product_id' => 'required',




            ]);
            Item::create($request->all());
        }

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $item = Item::find($id);
        $items = Item::latest()->paginate(5);
        $products = Product::with('items')->get();

        // $categories = Category::latest()->paginate(5);

        return view('items.index', compact('item', 'items', 'products'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'size' => 'required',
            'product_id' => 'required',



        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'item deleted successfully');
    }
}
