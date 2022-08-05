<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\{Unit};
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function index()
    {
        // abort_unless(\Gate::allows('product-access'), 403);

        $satuan = Unit::get();
        return view('admin.satuan.index', compact('satuan'));
    }

    public function create(Unit $satuan)
    {
        // abort_unless(\Gate::allows('product-create'), 403);



        return view('admin.satuan.create', compact('satuan'));
    }

    public function store(Request $request)
    {
        // abort_unless(\Gate::allows('product-create'), 403);

        $request['nama'] = request('nama');
      

        Unit::create($request->all());

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan Barang has been added');
    }

    public function edit(Unit $satuan)
    {
        // abort_unless(\Gate::allows('cabang-edit'), 403);
     

        return view('admin.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Unit $satuan)
    {
        // abort_unless(\Gate::allows('product-edit'), 403);
        $request['nama'] = request('nama');
    
        $satuan->update($request->all());

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan Barang has been updated');
    }

    public function destroy($id)
    {
        // abort_unless(\Gate::allows('product-delete'), 403);
        $satuan = Unit::where('id',$id)->delete();
      

        return redirect()->route('admin.satuan.index')->with('success', 'Satuan Barang has been deleted');
    }
}
