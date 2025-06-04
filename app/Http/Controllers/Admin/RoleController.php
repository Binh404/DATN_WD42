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
        // $permissions = Permission::all()->groupBy('group_id');
        $permissions = Permission::join('nhom_quyen', 'quyen.nhom_quyen_id', '=', 'nhom_quyen.id')
            ->select('quyen.*', 'nhom_quyen.ten as ten_nhom')
            ->get()
            ->groupBy('ten_nhom');
        return view('admin.vaitro.roles_create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'ten' => $request->name,
            'ten_hien_thi' => $request->display_name,
            'mo_ta' => $request->description,
            'la_vai_tro_he_thong' => $request->level ?? 0,
            'trang_thai' => $request->is_system ?? false,
            'ten_nhom' => 'web',
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
