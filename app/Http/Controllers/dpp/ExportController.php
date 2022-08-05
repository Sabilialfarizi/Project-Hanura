<?php

namespace App\Http\Controllers\Dpp;

use App\Export;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('information_access'), 403);

        $data = Export::with(['Districts','Districts.Kabupaten','Districts.Kabupaten.Provins'])->orderBy('created_at', 'desc');
        $data = $data->paginate(10);
//        dd($data);
        return view('dpp.export.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('information_create'), 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $client = new Client();
            $resGenKTA = $client->request('GET', 'http://127.0.0.1:1455/'.$request->district_id);
            $data = json_decode($resGenKTA->getBody());
            if($resGenKTA->getStatusCode() != 200){
                return response()->json(array('status' => false, 'message' => 'Something wrong when generate KTA'));
            }
            return response()->json(array('status' => true, 'message' => $data->message));
        }
		
		catch (ClientException $e){
            $data = json_decode($e->getResponse()->getBody());
            return response()->json(array('status' => false, 'message' => $data->message));
        }
		
        catch (\Exception $e){
            report($e);
            return response()->json(array('status' => false, 'message' => $e->getMessage()));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function export($id)
    {
        $export = Export::find($id);
        $file = $export->file_path;
        return response()->download($file);
    }
}
