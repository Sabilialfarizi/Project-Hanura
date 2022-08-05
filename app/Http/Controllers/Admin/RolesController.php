<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreRoleRequest, UpdateRoleRequest};
use phpDocumentor\Reflection\Types\Null_;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('roles-access'), 403);

        $roles = Role::get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('roles-create'), 403);

        $role = new Role();
        $rolePermissions = null;

        $permissions = Permission::orderBy('Name', 'ASC')->get();

        return view('admin.roles.create', compact('permissions', 'role', 'rolePermissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        abort_unless(\Gate::allows('roles-create'), 403);

        $request['key'] = $request->input('name');
        $request['name'] = \Str::slug($request->input('name'));

        $role = Role::create($request->all());
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles.index')->with('success', 'Role has been added');
    }

    public function show(Role $role)
    {
        abort_unless(\Gate::allows('roles-show'), 403);

        $permissions = \DB::table("role_has_permissions")->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    public function edit(Role $role)
    {
        abort_unless(\Gate::allows('roles-edit'), 403);

        $permissions = Permission::orderBy('Name', 'ASC')->get();
        $rolePermissions = \DB::table("role_has_permissions")->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        abort_unless(\Gate::allows('roles-edit'), 403);

        $request['key'] = $request->input('name');
        $request['name'] = \Str::slug($request->input('name'));
        $role->update($request->all());
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles.index')->with('success', 'Role has been updated');
    }

    public function destroy(Role $role)
    {
        abort_unless(\Gate::allows('roles-delete'), 403);

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role has been deleted');
    }
}
