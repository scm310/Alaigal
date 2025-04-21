<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function managePermissions()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.user.manage-permissions', compact('roles'));
    }

    public function showPermissionsForm()
    {
        $roles = Role::pluck('role', 'id');
        $permissions = Permission::all();
        return view('admin.user.permissions', compact('roles', 'permissions'));
    }

    public function assignPermissions(Request $request)
    {
        $role = Role::find($request->role);

        if ($role) {
            $role->permissions()->sync($request->permissions ?? []);
            return redirect()->route('permissions.manage')->with('success', 'Permissions assigned successfully.');
        }

        return redirect()->route('permissions.manage')->with('error', 'Role not found.');
    }

    // app/Http/Controllers/PermissionController.php
public function getPermissionsByRole($roleId)
{
    $permissions = Role::find($roleId)->permissions; // Adjust as needed based on your relationships
    return response()->json($permissions);
}

}
