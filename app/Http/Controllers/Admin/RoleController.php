<?php

namespace App\Http\Controllers\Admin;
use App\Models\Quyen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
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
        'ten' => $request->ten,
        'ten_hien_thi' => $request->ten_hien_thi,
        'mo_ta' => $request->mo_ta,
        'la_vai_tro_he_thong' => $request->la_vai_tro_he_thong ?? 0,
        'trang_thai' => $request->trang_thai ?? false,
    ]);

    // ✅ Gán quyền bằng ID
    if (!empty($request->permissions)) {
        // Lấy model Quyen theo ID
        $permissions = Quyen::whereIn('id', $request->permissions)->get();

        // Gán bằng model collection
        $role->syncPermissions($permissions);
    }

    return redirect()->route('roles.index')->with('success', 'Tạo vai trò và quyền thành công!');
}




    public function index()
    {
        $roles = Role::all();
        return view('admin.vaitro.roles_index', compact('roles'));
    }
    public function edit(string $id)
    {
       $role = Role::findOrFail($id);
       return view('admin.vaitro.roles_edit', compact('role'));
    }






public function destroy(string $id)
{
    $role = Role::findOrFail($id);

    // Gỡ quyền và người dùng trước khi xóa
    $role->permissions()->detach();
    $role->users()->detach(); // Nếu có định nghĩa quan hệ users()

    $role->delete();

    return redirect()->route('roles.index')->with('success', "Đã xóa vai trò thành công!");
}

//     public function destroy(string $id)
// {
//     $role = Role::findOrFail($id);
//     $role->delete();  // Xóa vai trò đã tìm thấy

//     return redirect()->route('roles.index')->with('success', "Đã xóa vai trò thành công!");
// }

}