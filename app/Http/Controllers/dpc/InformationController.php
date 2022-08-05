<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Information;
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('information_access'), 403);

        $info = Information::all();
        // dd($program);
        return view('dpc.informasi.index', compact('info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('information_create'), 403);
        $category = Category::where('is_active', 1)->pluck('name', 'id');
        
        return view('dpc.informasi.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $pict = $request->file('foto');
            $pict_name = time() . $pict->getClientOriginalName();
            $pict->move(public_path() . '/images/', $pict_name);
        } else {
            $pict_name = 'noimage.jpg';
        }

        $info = Information::create([
            'kategori_id'   => $request->kategori_id,
            'name'          => $request->nama,
            'content'       => $request->content,
            'gambar'        => $pict_name,
            'created_by'    => \Auth::user()->id,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('dpc.informasi.index')->with('success', 'Informasi Sudah di Create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('information_show'), 403);
        $info = Information::findOrFail($id);
        
        return view('dpc.informasi.show', compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $informasi = Information::find($id);

        $category = Category::where('is_active', 1)->pluck('name', 'id');
        return view('dpc.informasi.edit', compact('informasi','category'));
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
        $image = Information::where('id',$id)->first();
     
        $imagelama = public_path('images/' . $image->gambar);
     
        if ($request->hasFile('foto')) {
            File::delete($imagelama);
            $pict = $request->file('foto');
            $pict_name = time() . $pict->getClientOriginalName();
            $pict->move(public_path() . '/images', $pict_name);
            $attr['gambar'] = $pict_name;
        } else {
            $attr['gambar'] = $info->image;
        }
        $attr['kategori_id'] = $request->kategori_id;
        $attr['nama'] = $request->nama;
        $attr['content'] = $request->content;
        $attr['updated_by'] = \Auth::user()->id;
        $attr['update_at'] = date('Y-m-d H:i:s');

        $image->update($attr);
 

       

        return redirect()->route('dpc.informasi.index')->with('success', 'Informasi Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $informasi = DB::table('information')->where('id',$id)->delete();
       return redirect()->route('dpc.informasi.index')->with('success', 'Informasi Sudah di Delete');
    }
}