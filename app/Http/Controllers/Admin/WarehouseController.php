<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Project;
use App\HargaProdukCabang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Http\Requests\UpdateKategoriBarangRequest;
use App\Perusahaan;
use App\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
      
        $warehouses = Warehouse::OrderBy('id','desc')->get();
        return view('admin.warehouse.index', compact('warehouses'));
    }

    public function create(Warehouse $warehouse)
    {
        // abort_unless(\Gate::allows('product-create'), 403);
        $perusahaans = Perusahaan::get();
        return view('admin.warehouse.create', compact('warehouse','perusahaans'));
    }

    public function store(Request $request)
    {

        $request['is_active'] = 1 ;

        warehouse::create($request->all());

        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse has been added');
    }

    public function edit(Warehouse $warehouse)
    {
        $perusahaans = Perusahaan::get();
        return view('admin.warehouse.edit', compact('warehouse','perusahaans'));
    }
    public function update(Request $request, Warehouse $warehouse)
    {
     
        $warehouse->update($request->all());

        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse has been updated');
    }

    public function destroy($id)
    {
    
        // abort_unless(\Gate::allows('product-delete'), 403);

        Warehouse::where('id',$id)->delete();
  
     
        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse has been deleted');
    }
}
