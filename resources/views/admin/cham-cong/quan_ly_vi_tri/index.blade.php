@extends('layouts.master')

@section('title', 'Quản lý địa chỉ công ty')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Danh sách địa chỉ công ty</h3>
                    {{-- <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm địa chỉ mới
                    </a> --}}
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($locations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Địa chỉ</th>
                                        <th>Tọa độ</th>
                                        <th>Bán kính (m)</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $location)
                                        <tr>
                                            <td>{{ $location->address }}</td>
                                            <td>
                                                <small>
                                                    Lat: {{ $location->latitude }}<br>
                                                    Lng: {{ $location->longitude }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ number_format($location->allowed_radius) }}m</span>
                                            </td>
                                            <td>{{ $location->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.locations.edit', $location->id) }}"
                                                       class="btn btn-warning btn-sm" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.locations.destroy', $location->id) }}"
                                                          method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này?')"
                                                                title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $locations->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có địa chỉ công ty nào được thêm.</p>
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                                Thêm địa chỉ đầu tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
