
@extends('layoutsEmploye.master')

@section('content-employee')
<section class="content-section" id="tasks">
    <h2 style="margin-bottom: 30px;">Công việc phòng ban</h2>

    <div style="display: grid; gap: 20px;">
        <div
            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="color: #333; margin: 0;">Cập nhật hệ thống ERP</h4>
                <span class="status-badge status-pending">Đang thực hiện</span>
            </div>
            <p style="color: #666; margin-bottom: 15px;">Cập nhật module nhân sự trong hệ thống ERP của
                công ty</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <small style="color: #999;">Hạn: 30/05/2025</small>
                    <div style="margin-top: 5px;">
                        <div
                            style="background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div
                                style="background: #28a745; width: 65%; height: 100%; border-radius: 4px;">
                            </div>
                        </div>
                        <small style="color: #666;">Tiến độ: 65%</small>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="updateTaskProgress()">
                    <i class="fas fa-edit"></i>
                    Cập nhật
                </button>
            </div>
        </div>

        <div
            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-left: 4px solid #ffc107;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="color: #333; margin: 0;">Bảo trì server</h4>
                <span class="status-badge status-pending">Chờ bắt đầu</span>
            </div>
            <p style="color: #666; margin-bottom: 15px;">Thực hiện bảo trì định kỳ hệ thống server</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <small style="color: #999;">Hạn: 05/06/2025</small>
                    <div style="margin-top: 5px;">
                        <div
                            style="background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div style="background: #ffc107; width: 0%; height: 100%; border-radius: 4px;">
                            </div>
                        </div>
                        <small style="color: #666;">Tiến độ: 0%</small>
                    </div>
                </div>
                <button class="btn btn-warning" onclick="startTask()">
                    <i class="fas fa-play"></i>
                    Bắt đầu
                </button>
            </div>
        </div>

        <div
            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="color: #333; margin: 0;">Đào tạo nhân viên mới</h4>
                <span class="status-badge status-approved">Hoàn thành</span>
            </div>
            <p style="color: #666; margin-bottom: 15px;">Đào tạo sử dụng phần mềm cho nhân viên mới</p>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <small style="color: #999;">Hoàn thành: 20/05/2025</small>
                    <div style="margin-top: 5px;">
                        <div
                            style="background: #e9ecef; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div
                                style="background: #28a745; width: 100%; height: 100%; border-radius: 4px;">
                            </div>
                        </div>
                        <small style="color: #666;">Tiến độ: 100%</small>
                    </div>
                </div>
                <button class="btn btn-success" disabled>
                    <i class="fas fa-check"></i>
                    Hoàn thành
                </button>
            </div>
        </div>
    </div>
</section>
@endsection
