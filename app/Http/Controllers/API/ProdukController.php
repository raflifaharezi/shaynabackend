<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;


class ProdukController extends Controller
{
    public function all(Request $request) {
        // mencari berdasarkan id, nama, slug
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $slug  = $request->input('slug');
        $type  = $request->input('type');
        //untuk mencari berdasarkan dari yang terendah ke tertinggi
        $price_from  = $request->input('price_from');
        $price_to  = $request->input('price_to');

        //mengecek apakah ada data id
        if($id)
        {
            //jika ada tampilkan  variabel product dari model Product dengan relasi galleries
            $product = Product::with('galleries')->find($id);
            
            //jika produk ada maka keluarkan success
            if($product)     
                return ResponseFormatter::success($product, 'Data Produk Berhasil diambil');
            else 
                return ResponseFormatter::error(null, 'Data Produk tidak ada', 404);
        }

        //mengecek apakah ada data slug
        if($slug)
        {
            //jika ada tampilkan  variabel product dari model Product dengan relasi galleries
            
            $product = Product::with('galleries')
                ->where('slug',$slug)
                ->first();
        
            //jika produk ada maka keluarkan success
            if($product)     
                return ResponseFormatter::success($product, 'Data Produk Berhasil diambil');
            else 
                return ResponseFormatter::error(null, 'Data Produk tidak ada', 404);
        }

        $product = Product::with('galleries');

        if($name)
            $product->where('name', 'like', '%' . $name . '%');

        if($type)
            $product->where('type', 'like', '%' . $type . '%');

        if($price_from)
            $product->where('price', '>=' . $price_from);

        // menampilkan harga dari yang terendah
        if($price_to)
            $product->where('price', '<=' . $price_to);

        // menampilkan harga dari yang terendah
        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data list produk berhasil diambil'
        );
    }

}
