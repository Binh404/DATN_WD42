<?php

namespace App\Http\Controllers;

use App\Models\CompanyLocation;
use Illuminate\Http\Request;

class CompanyLocationController extends Controller
{
    public function getLocation()
    {
        // Giả sử chỉ có 1 vị trí công ty, bạn có thể lấy bản ghi đầu tiên
        $location = CompanyLocation::first();

        if (!$location) {
            return response()->json(['error' => 'Không tìm thấy vị trí công ty'], 404);
        }

        return response()->json([
            'address' => $location->address,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'allowedRadius' => $location->allowed_radius
        ]);
    }
    public function index()
    {
        $locations = CompanyLocation::latest()->paginate(10);
        return view('admin.cham-cong.quan_ly_vi_tri.index', compact('locations'));
    }
    public function create()
    {
        return view('admin.cham-cong.quan_ly_vi_tri.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'allowed_radius' => 'required|integer|min:1|max:10000'
        ]);

        CompanyLocation::create($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Địa chỉ công ty đã được thêm thành công!');
    }
    public function edit($id)
    {
        $location = CompanyLocation::findOrFail($id);
        // dd($location);
        return view('admin.cham-cong.quan_ly_vi_tri.edit', compact('location'));
    }
    public function update(Request $request, $id)
    {
        $location = CompanyLocation::findOrFail($id);
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'allowed_radius' => 'required|integer|min:1|max:10000'
        ]);

        $location->update($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Địa chỉ công ty đã được cập nhật!');
    }

    public function destroy($id)
    {
        $location = CompanyLocation::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Địa chỉ công ty đã được xóa!');
    }

}
