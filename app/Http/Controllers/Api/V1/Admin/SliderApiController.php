<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Slider;
use App\DetailPeriodeProgram;

class SliderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = Slider::all();
        
        return response([
            'success'   => true,
            'message'   => 'List Semua slider',
            'data'      => $slider
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'gambar'        => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'name.required'         => 'Masukkan nama program !',
                'gambar.required'       => 'Masukkan gambar'
            ]);
        
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
                if ($request->file('gambar')) {
                    $pict = $request->file('gambar');
                    $pict_name = time() . $pict->getClientOriginalName();
                    $pict->move(public_path() . '/images/slider/', $pict_name);
                } else {
                    $pict_name = 'noimage.jpg';
                }

                $slider = Slider::create([
                    'name'          => $request->input('name'),
                    'isi'           => $request->input('start_date'),
                    'gambar'        => $pict_name
                ]);
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Slider Berhasil Disimpan!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Slider Gagal Disimpan!',
            ], 400);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
