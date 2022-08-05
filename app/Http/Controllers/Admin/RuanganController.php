<?php

namespace App\Http\Controllers\Admin;

use App\Cabang;
use App\Http\Controllers\Controller;
use App\Http\Requests\RuanganRequest;
use App\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function create(Cabang $cabang)
    {
        $ruangan = new Ruangan();

        return view('admin.ruangan.create', compact('cabang', 'ruangan'));
    }

    public function store(RuanganRequest $request)
    {
        Ruangan::create($request->all());

        return redirect('/admin/cabang/' . $request->input('cabang_id') . '/ruangan')->with('success', 'Ruangan has been added');
    }

    public function show($id)
    {
        //
    }

    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(RuanganRequest $request, Ruangan $ruangan)
    {
        $ruangan->update($request->all());

        return redirect('/admin/cabang/' . $request->input('cabang_id') . '/ruangan')->with('success', 'Ruangan has been updated');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return back()->with('success', 'Ruangan has been deleted');
    }
}
