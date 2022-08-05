<?php

namespace App\Http\Controllers\Admin;

use App\Holidays;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidaysRequest;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Yajra\DataTables\Contracts\DataTable;

class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holiday = Holidays::all();
        if (request()->ajax()) {
            return datatables()->of($holiday)
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.holidays.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidaysRequest $request)
    {
        $form = $request->all();
        $id = $request->id;
        $input  = $request->holiday_date;
        $format = 'd/m/Y';
        $date = Carbon::createFromFormat($format, $input);
        $form['day'] = $date->format('l');
        $form['holiday_date'] = $date->format('Y-m-d');
        // $distinct = Holidays::select('holiday_date')->distinct()->get()->toArray();
        $response = Holidays::updateOrCreate(['id' => $id], $form);
        return response()->json($response);
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
        $post  = Holidays::findOrFail($id);
        $array = $post;
        $array['holiday_date'] = Carbon::parse($post->holiday_date)->format('d/m/Y');
        return response()->json($array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HolidaysRequest $request, $id)
    {
        $form = $request->except(['_token', '_method']);
        $input  = $request->holiday_date;
        $format = 'd/m/Y';
        $date = Carbon::createFromFormat($format, $input);
        $form['day'] = $date->format('l');
        $form['holiday_date'] = $date->format('Y-m-d');
        Holidays::where('id', $id)->update($form);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Holidays::findOrFail($id)->delete();
        return response()->json($response);
    }
}
