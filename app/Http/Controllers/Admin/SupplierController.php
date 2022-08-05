<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::get();
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        $supplier = new Supplier();
        return view('admin.supplier.create', compact('supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telpon' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'telpon.required' => 'Telpon tidak boleh kosong.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        //
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required',
            'telpon' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'telpon.required' => 'Telpon tidak boleh kosong.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier berhasil didelete');
    }
}
