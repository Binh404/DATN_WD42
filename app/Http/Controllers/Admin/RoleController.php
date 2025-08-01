<?php

namespace App\Http\Controllers\Admin;
use App\Models\Quyen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\VaiTro;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function create()
    {
        return view('admin.vaitro.create');
    }


public function store(Request $request)
{
 VaiTro::create([
    'name' => 'ok', // dùng cho spatie
    'ten' => $request->name,  // gán name vào ten
    'ten_hien_thi' => $request->ten_hien_thi,
    'mo_ta' => $request->mo_ta,
    'guard_name' => 'web',
]);





    // Gán quyền bằng ID
    // if (!empty($request->permissions)) {
    //     // Lấy model Quyen theo ID
    //     $permissions = Quyen::whereIn('id', $request->permissions)->get();

    //     // Gán bằng model collection
    //     $role->syncPermissions($permissions);
    // }

    return redirect()->route('vaitro.index')->with('success', 'Tạo vai trò và quyền thành công!');
}




    public function index()
    {
        $vaiTros = VaiTro::all();
        return view('admin.vaitro.index', compact('vaiTros'));
    }
    public function edit(string $id)
    {
       $role = VaiTro::findOrFail($id);
       return view('admin.vaitro.edit', compact('role'));
    }
    public function update(Request $request, string $id)
    {
        $role = VaiTro::findOrFail($id);
        $role->update($request->only(['ten', 'ten_hien_thi', 'mo_ta']));

        // // Cập nhật quyền
        // if (!empty($request->permissions)) {
        //     $permissions = Quyen::whereIn('id', $request->permissions)->get();
        //     $role->syncPermissions($permissions);
        // }

        return redirect()->route('vaitro.index')->with('success', 'Cập nhật vai trò thành công!');
    }





public function destroy(string $id)
{
    $role = VaiTro::findOrFail($id);

    // Gỡ quyền và người dùng trước khi xóa
    // $role->permissions()->detach();
    // $role->users()->detach(); // Nếu có định nghĩa quan hệ users()

    $role->delete();

    return redirect()->route('vaitro.index')->with('success', "Đã xóa vai trò thành công!");
}

//     public function destroy(string $id)
// {
//     $role = Role::findOrFail($id);
//     $role->delete();  // Xóa vai trò đã tìm thấy

//     return redirect()->route('roles.index')->with('success', "Đã xóa vai trò thành công!");
// }

}
