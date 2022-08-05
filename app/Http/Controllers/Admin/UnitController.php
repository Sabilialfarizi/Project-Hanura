<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateWarehouseRequest;
use App\{ Perusahaan, UnitRumah};
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        // abort_unless(\Gate::allows('product-access'), 403);

        $units = UnitRumah::orderBy('id_unit_rumah','desc')->get();
        // dd($units);
        return view('admin.unit.index', compact('units'));
    }

    public function create(UnitRumah $unit)
    {
        // dd($unit);
        // abort_unless(\Gate::allows('product-create'), 403);

        $perusahaans = Perusahaan::get();

        return view('admin.unit.create', compact('unit','perusahaans'));
    }

    public function store(Request $request)
    {
        // abort_unless(\Gate::allows('product-create'), 403);

        $request['type'] = request('type');
        $request['blok'] = request('blok');
        $request['no'] = request('no');
        $request['lb'] = request('lb');
        $request['lt'] = request('lt');
        $request['nstd'] = request('nstd');
        $request['total'] = request('total');
        $request['harga_jual'] = request('jual');
        $request['status_penjualan'] = 'Available';

        UnitRumah::create($request->all());

        return redirect()->route('admin.unit.index')->with('success', 'Unit Rumah has been added');
    }

   
    public function edit(UnitRumah $unit)
    {

     

        // dd($units);
      
     

        return view('admin.unit.edit', compact('unit'));
    }

    public function update(Request $request, UnitRumah $unit)
    {
        // abort_unless(\Gate::allows('product-edit'), 403);
        $request['type'] = request('type');
        $request['blok'] = request('blok');
        $request['no'] = request('no');
        $request['lb'] = request('lb');
        $request['lt'] = request('lt');
        $request['nstd'] = request('nstd');
        $request['total'] = request('total');
        $request['harga_jual'] = request('jual');
        $request['status_penjualan'] = 'Available';
     

        $unit->update($request->all());

        return redirect()->route('admin.unit.index')->with('success', 'Unit Rumah has been updated');
    }

    public function destroy($id)
    {
        // abort_unless(\Gate::allows('product-delete'), 403);
        UnitRumah::where('id_unit_rumah', $id)->delete();

        // $unit->delete();

        return redirect()->route('admin.unit.index')->with('success', 'Unit Rumah has been deleted');
    }
}
