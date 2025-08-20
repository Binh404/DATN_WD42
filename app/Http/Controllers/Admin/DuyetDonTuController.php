<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Models\YeuCauTuyenDung;
use Illuminate\Http\Request;

class DuyetDonTuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function danhSachDonTuyenDung()
    {
        $user = auth()->user();
        if ($user->coVaiTro('admin')) {
            $yeuCaus = YeuCauTuyenDung::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.duyetdontu.dontuyendung.index', compact('yeuCaus'));
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
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

        // tạo thông báo
        $truongPhong = NguoiDung::findOrFail($yeuCau->nguoi_tao_id);
        $truongPhong->notify(new \App\Notifications\DuyetDonYeuCauTuyenDung($yeuCau));

        $hrUsers = NguoiDung::whereHas('vaiTros', function ($q) {
            $q->where('ten', 'hr');
        })->get();
        foreach ($hrUsers as $hr) {
            $hr->notify(new \App\Notifications\ThongBaoTuyenDung($yeuCau));
        }
        return redirect()->route('admin.duyetdon.tuyendung.index')->with('success', 'Đã duyệt yêu cầu tuyển dụng.');
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

        // tạo thông báo
        $truongPhong = NguoiDung::findOrFail($yeuCau->nguoi_tao_id);
        $truongPhong->notify(new \App\Notifications\TuChoiYeuCauTuyenDung($yeuCau));

        return redirect()->route('admin.duyetdon.tuyendung.index')->with('success', 'Đã từ chối yêu cầu tuyển dụng.');
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
        $yeuCau = YeuCauTuyenDung::with('phongBan', 'chucVu')->findOrFail($id);
        return view('admin.duyetdontu.dontuyendung.show', compact('yeuCau'));
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
