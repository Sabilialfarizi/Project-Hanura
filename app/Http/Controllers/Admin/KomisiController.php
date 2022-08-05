<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKomisiRequest;
use App\Komisi;
use Spatie\Permission\Models\Role;

class KomisiController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('komisi-access'), 403);

        $komisi = Komisi::get();
        return view('admin.komisi.index', compact('komisi'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('komisi-create'), 403);

        $roles = Role::all();
        $komisi = new Komisi();

        return view('admin.komisi.create', compact('roles', 'komisi'));
    }

    public function store(StoreKomisiRequest $request)
    {
        abort_unless(\Gate::allows('komisi-create'), 403);

        Komisi::create($request->all());

        return redirect()->route('admin.komisi.index')->with('success', 'Komisi has been added');
    }

    public function show(Komisi $komisi)
    {
        //
    }

    public function edit(Komisi $komisi)
    {
        abort_unless(\Gate::allows('komisi-edit'), 403);

        $roles = Role::all();

        return view('admin.komisi.edit', compact('roles', 'komisi'));
    }

    public function update(StoreKomisiRequest $request, Komisi $komisi)
    {
        abort_unless(\Gate::allows('komisi-edit'), 403);

        $komisi->update($request->all());

        return redirect()->route('admin.komisi.index')->with('success', 'Komisi has been updated');
    }

    public function destroy(Komisi $komisi)
    {
        abort_unless(\Gate::allows('komisi-delete'), 403);

        $komisi->delete();

        return redirect()->route('admin.komisi.index')->with('success', 'Komisi has been deleted');
    }
}
