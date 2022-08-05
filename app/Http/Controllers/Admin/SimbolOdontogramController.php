<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimbolRequest;
use App\SimbolOdontogram;
use Illuminate\Http\Request;

class SimbolOdontogramController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('simbol-access'), 403);

        $simbol = SimbolOdontogram::get();
        return view('admin.simbol.index', compact('simbol'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('simbol-create'), 403);

        $simbol = new SimbolOdontogram();

        return view('admin.simbol.create', compact('simbol'));
    }

    public function store(SimbolRequest $request)
    {
        abort_unless(\Gate::allows('simbol-create'), 403);

        SimbolOdontogram::create($request->all());

        return redirect()->route('admin.simbol.index')->with('Simbol has been added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_unless(\Gate::allows('simbol-edit'), 403);

        $simbol = SimbolOdontogram::find($id);
        return view('admin.simbol.edit', compact('simbol'));
    }

    public function update(SimbolRequest $request, $id)
    {
        abort_unless(\Gate::allows('simbol-edit'), 403);

        $simbol = SimbolOdontogram::find($id);
        $simbol->update($request->all());

        return redirect()->route('admin.simbol.index')->with('Simbol has been updated');
    }

    public function destroy($id)
    {
        //
    }
}
