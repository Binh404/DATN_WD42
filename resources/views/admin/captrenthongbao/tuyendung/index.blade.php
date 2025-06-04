@extends('layouts.master')
@section('title', 'Yêu cầu tuyển dụng')

@section('content')
    <style>
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            color: #2d3748;
            font-size: 25px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .subtitle {
            color: #718096;
            font-size: 17px;
            margin-bottom: 20px;
        }

        .notifications-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-title {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .notification-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .notification-item {
            text-decoration: none
        }

        .notification-card.important {
            border-left-color: #d69e2e;
            background: linear-gradient(135deg, #fffbeb 0%, #fef2c7 100%);
        }

        .notification-card.important::before {
            background: linear-gradient(90deg, #d69e2e, #f6e05e);
        }

        .notification-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .notification-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            flex: 1;
        }

        .notification-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #718096;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .notification-content {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }

            .notification-header {
                flex-direction: column;
                gap: 10px;
            }

            .notification-actions {
                flex-direction: column;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-bell"></i>
                Cấp Trên Thông Báo
            </h1>
            <div class="subtitle">Trung tâm thông báo và chỉ thị từ lãnh đạo công ty</div>
        </div>

        <div class="notifications-container">
            <div class="section-title">
                <i class="fas fa-list"></i>
                Thông Báo Tuyển dụng
            </div>

            <div id="notifications-list">
                @foreach ($TuyenDungs as $index => $item)
                <a class="notification-item" href="{{ route('hr.captrenthongbao.show', ['captrenthongbao' => $item->id]) }}">
                        <div class="notification-card important" data-priority="important">
                            <div class="notification-header">
                                <div class="notification-title">Tuyển dụng chức vụ {{ $item->chucVu->ten }}</div>
                            </div>
                            <div class="notification-meta">
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    Giám đốc điều hành
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $item->created_at }}
                                </div>
                            </div>
                            <div class="notification-content">
                                {{ $item->mo_ta_cong_viec }}
                            </div>

                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
@endsection
