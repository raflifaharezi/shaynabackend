<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Product::all();
        return view('pages.products.index')->with(['items' => $items]);
    }

    public function create()
    {
        return view('pages.products.create');
    }

    
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findorfail($id);
        return view('pages.products.edit')->with([
            'item' => $item
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug('$request->name');

        $item = Product::findorfail($id);
        $item->update($data);
        return redirect()->route('products.index');

    }

    public function destroy($id)
    {
        $item = Product::findorfail($id);
        $item->delete();

        ProductGallery::where('products_id', $id)->delete();

        return redirect()->route('products.index');
    }

    public function gallery(Request $request, $id)
    {
        $product = Product::findorfail($id);
        $items = ProductGallery::with('product')
        ->where('products_id', $id)->get();

        return view('pages.products.gallery')->with([
            'product' => $product,
            'items' => $items
        ]);
    }
}
