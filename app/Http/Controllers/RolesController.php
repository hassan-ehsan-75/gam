<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', ['roles' => $roles]);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', ['permissions' => $permissions, 'role' => $role]);
    }

    public function update(Request $request, $id)
    {

        $role = Role::findOrFail($id)->load('permissions');
        $role->syncPermissions($request->roles);
        return back()->with(['success' => 'تم تعديل الصلاحيات بنجاح']);
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'roles' => 'array|min:1'
        ]);
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->roles);
        return back()->with(['success' => 'تمت الإضافة بنجاح']);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        foreach ($role->users as $ur)
            $ur->removeRole($role->name);
        $role->delete();
        return back()->with(['success' => 'تمت الإزالة بنجاح']);
    }
}