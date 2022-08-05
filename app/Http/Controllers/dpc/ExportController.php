<?php

namespace App\Http\Controllers\Dpc;

use App\Export;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailUsers;
use Illuminate\Support\Facades\Auth;
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
        $id = Auth::user()->id;

        $detail = DetailUsers::where('userid', $id)->first();
        $data = Export::whereHas('Districts', function ($query) use ($detail) {
            $query->where('id_kab', '=', (int)$detail->kabupaten_domisili);
        })->orderBy('created_at', 'desc');
        $data = $data->paginate(10);
//        dd($data);
        return view('dpc.export.index', compact('data'));
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
            if($resGenKTA->getStatusCode() != 200){
                return response()->json(array('status' => false, 'message' => 'Something wrong when generate KTA'));
            }
            redirect()->route('route.name', [$param]);
            return response()->json(array('status' => true, 'message' => 'Success, silahkan ke halaman export untuk mengunduh'));
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
        try {
            $client = new Client();
            $resGenKTA = $client->request('GET', 'http://127.0.0.1:1455/'.$id);
            $data = json_decode($resGenKTA->getBody());
            if($resGenKTA->getStatusCode() != 200){
                return redirect()->back()->with('alert','Something wrong when generate KTA');
            }
            return redirect()->back()->with('alert', $data->message);
        }
		
		catch (ClientException $e){
            $data = json_decode($e->getResponse()->getBody());
            return redirect()->back()->with('alert', $data->message);
        }
		
        catch (\Exception $e){
            report($e);
            return redirect()->back()->with('alert',$e->getMessage());
//            return response()->json(array('status' => false, 'message' => $e->getMessage()));
        }
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
