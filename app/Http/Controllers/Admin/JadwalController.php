<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jadwal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current = Carbon::now()->format('Y-m-d');

        //SET OF DATE
        $month = Carbon::parse($current)->format('m');
        $year = Carbon::parse($current)->format('Y');
        $last_day_of_month  = Carbon::parse($current)->endOfMonth()->format('d');

        $date = [
            'month' => $month,
            'year' => $year
        ];
        // QUERY

        $jadwal = Jadwal::with('user')->whereYear('tanggal', $year)->whereMonth('tanggal', $month)->get();

        $user = User::has('jadwal')->get();
        return view('admin.jadwal.index',[
            'jadwal' => $jadwal,
            'user' => $user,
            'last_day_of_month' => $last_day_of_month,
            'date' => $date
        ]); 
    }

    public function filter(Request $request)
    {
        $this->validate($request,[
            'start' => 'required',
            'end' => 'required'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
