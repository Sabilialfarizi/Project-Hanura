<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Project;
use App\HargaProdukCabang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Http\Requests\UpdateKategoriBarangRequest;
use App\KategoriBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
      
        $kategoris = KategoriBarang::select('id','nama_kategori','is_active')
        ->OrderBy('id','desc')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create(KategoriBarang $kategori)
    {
        abort_unless(\Gate::allows('product-create'), 403);
        return view('admin.kategori.create', compact('kategori'));
    }

    public function store(StoreKategoriBarangRequest $request)
    {

        $request['is_active'] = 1 ;

        KategoriBarang::create($request->all());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Barang has been added');
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }
    public function update(StoreKategoriBarangRequest $request, KategoriBarang $kategori)
    {
     
        $kategori->update($request->all());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Barang has been updated');
    }

    public function destroy($id)
    {
    
        abort_unless(\Gate::allows('product-delete'), 403);

        KategoriBarang::where('id',$id)->delete();
  
     
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori Barang has been deleted');
    }
}
