<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePermissionRequest, UpdatePermissionRequest};
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('permission-access'), 403);

        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('admin.permission.index', compact('permissions'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('permission-create'), 403);

        $permission = new Permission();
        return view('admin.permission.create', compact('permission'));
    }

    public function store(StorePermissionRequest $request)
    {
        abort_unless(\Gate::allows('permission-create'), 403);
        $request['key'] = $request->input('name');
        $request['name'] = \Str::slug($request->input('name'));
        Permission::create($request->all());

        return back();
    }


    public function edit(Permission $permission)
    {
        abort_unless(\Gate::allows('permission-edit'), 403);

        return view('admin.permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abort_unless(\Gate::allows('permission-edit'), 403);
        $request['key'] = $request->input('name');
        $request['name'] = \Str::slug($request->input('name'));
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index')->with('success', 'Permission has been updated');
    }

    public function destroy(Permission $permission)
    {
        abort_unless(\Gate::allows('permission-delete'), 403);

        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission has been deleted');
    }
}
