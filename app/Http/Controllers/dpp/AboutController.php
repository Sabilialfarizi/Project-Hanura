<?php namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use PDF;
class AboutController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // abort_unless(\Gate::allows('information_access'), 403);

        $settings= DB::table('settings')->get();

        return view('dpp.about.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // abort_unless(\Gate::allows('information_create'), 403);


        return view('dpp.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         $files = ['pic_login', 'pic_after_login','pic_kta_depan','pic_tentang_kami'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                if ($file == 'pic_login') {
                    $uploadedFile->move('uploads/img/pic_login/', $filename);
                }elseif($file == 'pic_after_login'){
                    $uploadedFile->move('uploads/img/pic_login/', $filename);
                }elseif($file == 'pic_tentang_kami'){
                    $uploadedFile->move('uploads/img/pic_tentang_kami/', $filename);
                }else{
                     $uploadedFile->move('uploads/img/pic_kta/', $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $files[$file] = 'noimage.jpg';
            }
        }
       
        $anggota=DB::table('settings')->insert([ 
            'about_us'=> $request->about_as,
            'pic_login'=> $files['pic_login'],
            'pic_after_login'=> $files['pic_after_login'],
            'pic_tentang_kami'=> $files['pic_tentang_kami'],
            'pic_kta_depan' => $files['pic_kta_depan']
            ]);

        return redirect()->route('dpp.about.index')->with('success', 'Settings Sudah di Create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
      $settings = DB::table('settings')->where('id',$id)->select('pic_kta_depan')->first();


       $customPaper = array(10,0,290,210);;
        $pdf = PDF::loadview('dpc.member.kta_depan',['settings'=>$settings])->setPaper($customPaper,'portrait') ;
          return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $settings= DB::table('settings')->find($id);

        return view('dpp.about.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $image = DB::table('settings')->where('id',$id)->first();

        $imagelogin =  '/www/wwwroot/hanura.net/uploads/img/pic_login/' . $image->pic_login;
        $imageafter =  '/www/wwwroot/hanura.net/uploads/img/pic_login/' . $image->pic_after_login;
        $imagekami =  '/www/wwwroot/hanura.net/uploads/img/pic_tentang_kami/' . $image->pic_tentang_kami;
        $imagekta =  '/www/wwwroot/hanura.net/uploads/img/pic_kta/' . $image->pic_kta_depan;
        $files = ['pic_login', 'pic_after_login','pic_kta_depan','pic_tentang_kami'];

        foreach($files as $file){
            if($request->file($file)){
                $uploadedFile = $request->file($file);
                $filename = time() . '.' . $uploadedFile->getClientOriginalName();
                
                if ($file == 'pic_login') {
                     File::delete($imagelogin);
                    $uploadedFile->move('uploads/img/pic_login/', $filename);
                }elseif($file == 'pic_after_login'){
                     File::delete($imageafter);
                    $uploadedFile->move('uploads/img/pic_login/', $filename);
                }elseif($file == 'pic_tentang_kami'){
                     File::delete($imagekami);
                    $uploadedFile->move('uploads/img/pic_tentang_kami/', $filename);
                }else{
                     File::delete($imagekta);
                     $uploadedFile->move('uploads/img/pic_kta/', $filename);
                }
                
                $files[$file] = $filename;
            }else{
                $oldFile = $file . '_lama';
                if($request->input($oldFile) !== 'noimage.jpg' && $request->input($oldFile) !== ''){
                    $files[$file] = $request->input($oldFile);
                }else{
                    $files[$file] = 'noimage.jpg';
                }
            }
        }
    

         $detail = DB::table('settings')->where('id',$id)->update([
            'pic_login'   => $files['pic_login'],
            'pic_after_login'          => $files['pic_after_login'],
            'pic_tentang_kami'       => $files['pic_tentang_kami'],
            'pic_kta_depan' => $files['pic_kta_depan'],
            'about_us'        => $request->about_us,
             
             ]);


        return redirect()->route('dpp.about.index')->with('success', 'Settings Sudah di Update');
    }


}
