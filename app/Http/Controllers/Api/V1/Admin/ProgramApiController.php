<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\PeriodeProgram as Program;
use App\DetailPeriodeProgram;
use App\MstGudang;
use App\Item;

class ProgramApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $program = Program::all();
        
        return response([
            'success'   => true,
            'message'   => 'List Semua program',
            'data'      => $program
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
                'start_date'    => 'required',
                'end_date'      => 'required',
                'desc'          => 'required'
            ],
            [
                'name.required'         => 'Masukkan nama program !',
                'start_date.required'   => 'Masukkan tanggal mulai program !',
                'end_date.required'     => 'Masukkan tanggal berakhir program !',
                'desc.required'         => 'Masukkan deskripsi program !',
            ]);
        
            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
                $program = Program::create([
                    'name'          => $request->input('name'),
                    'start_date'    => $request->input('start_date'),
                    'end_date'      => $request->input('end_date'),
                    'description'   => $request->input('desc'),
                    'created_by'    => Auth::user()->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);

                $i=0;
                if(isset($request->barang_id[$i])) {
                    for($count = 0;$count < count($request->barang_id); $count++) {
                        $data = array(
                            'id_periode'  => $program->id,
                            'id_barang'     => $request->input('barang_id')[$count],
                            'created_at'  => date('Y-m-d H:i:s')
                        );
                        $insert_detail[] = $data;
                    }
                    DetailPeriodeProgram::insert($insert_detail);
                }
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Program Berhasil Disimpan!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Program Gagal Disimpan!',
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
        $program = Program::find($id);
        $detail = DetailPeriodeProgram::where('id_periode', $id)
                ->get();
        
        if ($program) {
            return response()->json([
                'success'   => true,
                'message'   => ' program!',
                'program'   => $program,
                'detail'    => $datail,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Detail program Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
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
