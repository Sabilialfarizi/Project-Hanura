<?php

namespace App\Http\Controllers\Dpp;

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
        return view('dpp.informasi.index', compact('info'));
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
        
        return view('dpp.informasi.create', compact('category'));
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
           $pict->move('uploads/img/Information/', $pict_name);
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

        return redirect()->route('dpp.informasi.index')->with('success', 'Informasi Sudah di Create');
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
        $informasi = Information::find($id);

        $category = Category::where('is_active', 1)->pluck('name', 'id');
        return view('dpp.informasi.edit', compact('informasi','category'));
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
     
        $imagelama = asset('uploads/img/Information/' . $image->gambar);
      
      $files = ['foto'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                if ($file == 'foto') {
                        File::delete($imagelama);
                    $uploadedFile->move('uploads/img/Information/', $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $oldFile = $file . '_lama';
              
             
                if($request->input($oldFile) !== 'noname' && $request->input($oldFile) !== ''){
                    $files[$file] = $request->input($oldFile);
                }else{
                    $files[$file] = 'noname';
                }
            }
        }
        
       $data = array(
        'kategori_id' => $request->kategori_id,
        'name' => $request->nama,
        'content' => $request->content,
        'updated_by' => \Auth::user()->id,
        'updated_at' => date('Y-m-d H:i:s'),
        'gambar'    => $files['foto']
           );
    
        

        $foto = Information::where('id',$id)->update($data);
     
 

       

        return redirect()->route('dpp.informasi.index')->with('success', 'Informasi Sudah di Update');
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
       return redirect()->route('dpp.informasi.index')->with('success', 'Informasi Sudah di Delete');
    }
}
