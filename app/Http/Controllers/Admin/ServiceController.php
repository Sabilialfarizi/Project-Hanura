<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('service-access'), 403);

        $services = Barang::where('jenis', 'service')->get();

        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('service-create'), 403);

        $service = new Barang();
        return view('admin.service.create', compact('service'));
    }

    public function store(StoreServiceRequest $request)
    {
        abort_unless(\Gate::allows('service-create'), 403);

        $request['jenis'] = 'service';
        Barang::create($request->all());

        return redirect()->route('admin.service.index')->with('success', 'Service has been added');
    }

    public function show(Barang $barang)
    {
        //
    }

    public function edit(Barang $service)
    {
        abort_unless(\Gate::allows('service-edit'), 403);

        return view('admin.service.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Barang $service)
    {
        abort_unless(\Gate::allows('service-edit'), 403);

        $service->update($request->all());

        return redirect()->route('admin.service.index')->with('success', 'Service has been updated');
    }

    public function destroy(Barang $service)
    {
        abort_unless(\Gate::allows('service-delete'), 403);

        $service->delete();
        return redirect()->route('admin.service.index')->with('success', 'Service has been deleted');
    }
}
