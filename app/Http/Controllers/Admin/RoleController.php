<?php

namespace App\Http\Controllers\Admin;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function create()
    {
        // Lấy permission và group theo group_id (hoặc group_name nếu có)
        $permissions = Permission::all()->groupBy('group_id');
        return view('admin.vaitro.roles_create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'level' => $request->level ?? 0,
            'is_system' => $request->is_system ?? false,
            'guard_name' => 'web',
        ]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.create')->with('success', 'Tạo vai trò thành công!');
    }

    public function index()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.vaitro.roles_index', compact('roles'));
    }
}