<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\Request;
use App\StatusPasien;


class StatusPasienController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('status-access'), 403);

        $status = StatusPasien::get();

        return view('admin.status.index', compact('status'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('status-create'), 403);

        $status = new StatusPasien();
        return view('admin.status.create', compact('status'));
    }

    public function store(StoreStatusRequest $request)
    {
        abort_unless(\Gate::allows('status-create'), 403);

        StatusPasien::create($request->all());

        return redirect()->route('admin.status.index')->with('success', 'Status has been added');
    }

    public function edit(StatusPasien $status)
    {
        abort_unless(\Gate::allows('status-edit'), 403);

        return view('admin.status.edit', compact('status'));
    }

    public function update(UpdateStatusRequest $request, StatusPasien $status)
    {
        abort_unless(\Gate::allows('status-edit'), 403);

        $status->update($request->all());

        return redirect()->route('admin.status.index')->with('success', 'Status has been updated');
    }

    public function destroy(StatusPasien $status)
    {
        abort_unless(\Gate::allows('status-delete'), 403);

        $status->delete();

        return redirect()->route('admin.status.index')->with('success', 'Status has been deleted');
    }
}
