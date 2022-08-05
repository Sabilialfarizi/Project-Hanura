<?php

namespace App\Http\Controllers\Admin;

use App\{HargaProdukCabang, Cabang, Barang};
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriceRequest;
use App\Http\Requests\UpdatePriceRequest;
use Illuminate\Http\Request;

class HargaBarangController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Cabang $cabang)
    {
        $price = new HargaProdukCabang();

        if (request()->is('admin/price-product*')) {
            $products = Barang::where('jenis', 'barang')->get();
        } else {
            $products = Barang::where('jenis', 'service')->get();
        }
        return view('admin.harga-product.create', compact('cabang', 'products', 'price'));
    }

    public function store(StorePriceRequest $request)
    {
        HargaProdukCabang::create($request->all());


        return redirect()->route('admin.cabang.show', $request->input('cabang_id'))->with('success', 'Price has been added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (request()->is('admin/price-product*')) {
            $products = Barang::where('jenis', 'barang')->get();
        } else {
            $products = Barang::where('jenis', 'service')->get();
        }

        $price = HargaProdukCabang::with('cabang', 'product')->where('id', $id)->first();

        return view('admin.harga-product.edit', compact('price', 'products'));
    }

    public function update(UpdatePriceRequest $request, $id)
    {
        $price = HargaProdukCabang::with('cabang', 'product')->where('id', $id)->first();

        $price->update($request->all());
        return redirect()->route('admin.cabang.show', $price->cabang_id)->with('success', 'Price has been updated');
    }

    public function destroy($id)
    {
        $price = HargaProdukCabang::with('cabang', 'product')->where('id', $id)->first();

        $price->delete();
        return redirect()->back()->with('success', 'Price has been deleted');
    }
}
