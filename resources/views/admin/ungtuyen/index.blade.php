@extends('layouts.master')
@section('title', 'Danh Sách Ứng Viên')

@section('content')

<h2 class="text-2xl font-bold mb-4">Danh sách Ứng Viên</h2>

<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-3 px-4 text-left">STT</th>
            <th class="py-3 px-4 text-left">Tên Ứng Viên</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Số Điện Thoại</th>
            <th class="py-3 px-4 text-left">Kinh Nghiệm</th>
            <th class="py-3 px-4 text-left">Kỹ Năng</th>
            <th class="py-3 px-4 text-left">Vị Trí</th>
            <th class="py-3 px-4 text-left">Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ungViens as $key => $uv)
        <tr class="border-b hover:bg-gray-100">
            <td class="py-2 px-4">{{ $key + 1 }}</td>
            <td class="py-2 px-4">{{ $uv->ten_ung_vien }}</td>
            <td class="py-2 px-4">{{ $uv->email }}</td>
            <td class="py-2 px-4">{{ $uv->so_dien_thoai }}</td>
            <td class="py-2 px-4">{{ $uv->kinh_nghiem }}</td>
            <td class="py-2 px-4">{{ $uv->ky_nang }}</td>
            <td class="py-2 px-4">{{ $uv->tinTuyenDung->tieu_de }}</td>
            <td class="py-2 px-4 flex space-x-2">
                <a href="#" class="text-blue-500 hover:underline">Xem</a>
                <form action="#" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ứng viên này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
