<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhongBan;
use Illuminate\Http\Request;

class PhongBanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phongBans = PhongBan::orderBy("id", "desc")->get();
        return view("admin.phongban.index", compact('phongBans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.phongban.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_phong_ban' => 'required|string|max:255',
            'ma_phong_ban' => 'required|string|max:50|unique:phong_ban,ma_phong_ban',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:0,1',
        ]);

        PhongBan::create($validated);

        return redirect("/phongban")->with('success', 'Thêm phòng ban thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phongBan = PhongBan::findOrFail($id);
        return view('admin.phongban.edit', compact('phongBan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $phongban = PhongBan::findOrFail($id);

        $validated = $request->validate([
            'ten_phong_ban' => 'required|string|max:255',
            'ma_phong_ban' => 'required|string|max:50|unique:phong_ban,ma_phong_ban,' . $phongban->id,
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:0,1',
        ]);

        $phongban->update($validated);

        return redirect("/phongban")->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phongBan = PhongBan::findOrFail($id)->delete();
        return redirect('/phongban')->with('success', "Đã xóa phòng ban thành công!");
    }
}
