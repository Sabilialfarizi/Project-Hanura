<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Request as Req;
use App\DetailRequest;
use App\MstGudang;
use App\Member;
use App\Item;

class RequestOrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ro = Req::join('periode_programs', 'requests.program_id','=', 'periode_programs.id')
            ->join('users', 'requests.created_by', '=', 'users.id')
            ->select('requests.id','requests.no_request', 'requests.created_at', 'users.name as fullname', 'periode_programs.name')
            ->get();

        return response([
            'success'   => true,
            'message'   => 'List Semua Request Order',
            'data'      => $ro
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
                'no_request'   => 'required',
                'program_id'   => 'required', 
            ],
            [
                'no_request.required'     => 'Masukkan no request!',
                'program_id.required'     => 'Masukkan program!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'silahkan isi kolom yang kosong',
                    'data'      => $validator->errors()
                ], 400);
            } else {
                $request = Req::create([
                    'no_request'    => $request->input('no_request'),
                    'program_id'    => $request->input('program_id'),
                    'created_by'    => 1,
                    'status'        => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);

                $i=0;
                if(isset($request->member[$i])) {
                    for($count = 0;$count < count($request->member); $count++) {
                        $data = array(
                            'no_req'        => $request->input('no_request'),
                            'receiver_id'   => $request->input('member')[$count],
                            'created_by'    => Auth::user()->id,
                            'created_at'    => date('Y-m-d H:i:s')
                        );
                        $insert_detail[] = $data;
                    }
                    DetailRequest::insert($insert_detail);
                }
            }
            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Request Order Berhasil Disimpan!',
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Request Order Gagal Disimpan!',
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
