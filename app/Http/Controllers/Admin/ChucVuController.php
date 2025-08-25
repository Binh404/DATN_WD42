<?php
// app/Http/Controllers/Admin/ChucVuController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use App\Models\PhongBan;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function index()
    {
        $phongBan = PhongBan::all();
        $chucvus = ChucVu::orderBy('created_at', 'desc')->paginate(7); // 7 bản ghi mỗi trang
        // $chucvus = ChucVu::with('phongBan')->get();
        return view('admin.chucvu.index', compact('chucvus', 'phongBan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required',
            'ma' => 'required|unique:chuc_vu,ma',
            'luong_co_ban' => 'required|numeric',
            'phong_ban_id' => 'required',
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
        $chucVus = \App\Models\ChucVu::where('phong_ban_id', $phongBanId)
            ->where('trang_thai', true)
            ->get();

        return response()->json($chucVus);
    }

    public function hide($id)
    {
        $chucvu = ChucVu::findOrFail($id);
        $chucvu->update(['trang_thai' => false]);
        return redirect()->route('chucvu.index')->with('success', 'Đã ẩn chức vụ thành công');
    }

    public function showAgain($id)
    {
        $chucvu = ChucVu::findOrFail($id);
        $chucvu->update(['trang_thai' => true]);
        return redirect()->route('chucvu.index')->with('success', 'Đã hiện chức vụ thành công');
    }
}
