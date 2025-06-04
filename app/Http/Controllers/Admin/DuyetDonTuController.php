<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YeuCauTuyenDung;
use Illuminate\Http\Request;

class DuyetDonTuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function danhSachDonTuyenDung()
    {
        $yeuCaus = YeuCauTuyenDung::where('trang_thai', 'cho_duyet')->get();
        return view('admin.duyetdontu.dontuyendung.index', compact('yeuCaus'));
    }

    public function duyetDonTuyenDung($id)
    {
        $user = auth()->user();
        $yeuCau = YeuCauTuyenDung::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return back()->with('error', 'Yêu cầu này không còn ở trạng thái chờ duyệt.');
        }

        $yeuCau->update([
            'trang_thai' => 'da_duyet',
            'nguoi_duyet_id' => $user->id,
            'thoi_gian_duyet' => now()
        ]);

        return back()->with('success', 'Đã duyệt yêu cầu tuyển dụng.');
    }

    public function tuChoiDonTuyenDung($id)
    {
        $user = auth()->user();
        $yeuCau = YeuCauTuyenDung::findOrFail($id);
        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return back()->with('error', 'Yêu cầu này không còn ở trạng thái chờ duyệt.');
        }

        $yeuCau->update([
            'trang_thai' => 'bi_tu_choi',
            'nguoi_duyet_id' => $user->id,
            'thoi_gian_duyet' => now()
        ]);

        return back()->with('success', 'Đã từ chối yêu cầu tuyển dụng.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
