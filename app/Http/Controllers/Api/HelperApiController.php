<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Item;
use App\Provinsi;
use App\Kelurahan;
use App\Kecamatan;
use App\Kabupaten;
use App\MaritalStatus;
use App\Job;

class HelperApiController extends Controller
{
    public function job()
    {
        $job = Job::all();

        return response([
            'success'   => true,
            'message'   => 'List Semua Pekerjaan',
            'data'      => $job
        ], 200);
    }

    public function item()
    {
        $item = Item::all();

        return response([
            'success'   => true,
            'message'   => 'List Semua Barang',
            'data'      => $item
        ], 200);
    }
    public function nikah()
    {
        
        $nikah = MaritalStatus::all();

        return response([
            'success'   => true,
            'message'   => 'List Status Pernikahan',
            'data'      => $nikah
        ], 200);
    }

    public function getPOB(Request $request)
    {
        $data = Kabupaten::all();
        
        return response([
            'success'   => true,
            'message'   => 'List Semua Kota',
            'data'      => $data
        ], 200);
    }

    public function prov()
    {
        
        $prov = Provinsi::all();

        return response([
            'success'   => true,
            'message'   => 'List Semua Provinsi',
            'data'      => $prov
        ], 200);
    }

    public function kel(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'id_kec'  => 'required'
        ],
        [
            'id_kec.required'         => 'Masukkan kecamatan !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kelurahan::where('id_kec', $request->input('id_kec'))
                ->get();
            
            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }
            
            return response([
                'success'   => true,
                'message'   => 'List Semua Kelurahan',
                'data'      => $data
            ], 200);
        }
    }

    public function kec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kab'  => 'required'
        ],
        [
            'id_kab.required'         => 'Masukkan Kabupaten !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kecamatan::where('id_kab', $request->input('id_kab'))
                ->get();
            
            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }

            return response([
                'success'   => true,
                'message'   => 'List Semua Kecamatan',
                'data'      => $data
            ], 200);
        }
        

        return \Response::json($data);
    }

    public function kab(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_prov'  => 'required'
        ],
        [
            'id_prov.required'         => 'Masukkan Provinsi !',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'silahkan isi kolom yang kosong',
                'data'      => $validator->errors()
            ], 400);
        } else {
            $data = Kabupaten::where('id_prov', $request->input('id_prov'))
            ->get();

            if(is_null($data)){
                return Response([
                    'success'   => true,
                    'messages'  => 'Data Not Found',
                ], 404);
            }

            return response([
                'success'   => true,
                'message'   => 'List Semua Kabupaten',
                'data'      => $data
            ], 200);
        }
    }
}
