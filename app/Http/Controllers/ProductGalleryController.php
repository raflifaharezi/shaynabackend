<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = ProductGallery::with('product')->get();
        return view('pages.product-galleries.index')->with(['items' => $items]);
    }

    public function create()
    {
        $products = Product::all();

        return view('pages.product-galleries.create')->with(
            ['products' => $products]
        );
    }

    public function store(ProductGalleryRequest $request)
    {
        $data = $request->all();
        $data['photo'] = $request->file('photo')->store('assets/product', 'public');

        ProductGallery::create($data);
        return redirect()->route('product-galleries.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $item = ProductGallery::findorfail($id);
        $item->delete();
        return redirect()->route('product-galleries.index');
    }
    
}
