<?php
// app/Http/Controllers/Admin/ChucVuController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
 public function index()
{
 $chucvus = ChucVu::orderBy('created_at', 'desc')->paginate(7); // 5 bản ghi mỗi trang
    return view('admin.chucvu.index', compact('chucvus'));
}

public function store(Request $request)
{
    $request->validate([
        'ten' => 'required',
        'ma' => 'required|unique:chuc_vu,ma',
        'luong_co_ban' => 'required|numeric',
    ]);

    ChucVu::create($request->all());
    return redirect()->route('chucvu.index')->with('success', 'Thêm chức vụ thành công');
}

public function update(Request $request, $id)
{
    $chucvu = ChucVu::findOrFail($id);
    $chucvu->update($request->all());
    return redirect()->route('chucvu.index')->with('success', 'Cập nhật chức vụ thành công');
}

public function destroy($id)
{
    $chucvu = ChucVu::findOrFail($id);
    $chucvu->delete();
    return redirect()->route('chucvu.index')->with('success', 'Xóa chức vụ thành công');
}
public function getByPhongBan($phongBanId)
    {
        $chucVus = \App\Models\ChucVu::where('phong_ban_id', $phongBanId)->get();

        return response()->json($chucVus);
    }

}