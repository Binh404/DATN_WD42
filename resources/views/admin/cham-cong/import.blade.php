@extends('layoutsAdmin.master')
@section('title', 'Import Chấm Công ')
@section('content')
<div class="container my-5">
    <div class="col-12 col-md-8 mx-auto">
        <!-- Header -->
        <div class="card mb-4 p-4">
            <h1 class="h4 mb-2">Import Chấm Công</h1>
            <p class="text-muted">Tải lên file Excel để import dữ liệu chấm công vào hệ thống</p>
        </div>

        <!-- Thông báo -->
        @if(session('message'))
            <div class="mb-4">
                @if(session('messageType') === 'success')
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="mdi mdi-check-circle me-2" style="font-size: 20px;"></i>
                        <div>{{ session('message') }}</div>
                    </div>
                @elseif(session('messageType') === 'warning')
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="mdi mdi-alert-circle me-2" style="font-size: 20px;"></i>
                        <div>{{ session('message') }}</div>
                    </div>
                @else
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="mdi mdi-close-circle me-2" style="font-size: 20px;"></i>
                        <div>{{ session('message') }}</div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Form Import -->
        <div class="card mb-4 p-4">
            <form action="{{ route('chamcong.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- File Upload -->
                <div class="mb-4">
                    <label for="file" class="form-label">Chọn file Excel</label>
                    <div id="dropZone" class="border border-dashed p-4 text-center">
                        <!-- Default state -->
                        <div id="defaultState">
                            <i class="mdi mdi-file-upload mx-auto mb-3 text-muted" style="font-size: 48px;"></i>
                            <div>
                                <label for="file" class="btn btn-outline-primary">
                                    <span>Chọn file</span>
                                </label>
                                <p class="mt-2">hoặc kéo thả vào đây</p>
                            </div>
                        </div>

                        <!-- Selected file state -->
                        <div id="selectedState" class="d-none">
                            <i class="mdi mdi-file-check-outline mx-auto mb-3 text-success" style="font-size: 48px;"></i>
                            <div>
                                <p id="fileName" class="fw-bold text-success"></p>
                                <p id="fileSize" class="text-muted"></p>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFile()">
                                    <i class="mdi mdi-close me-1"></i>
                                    Xóa file
                                </button>
                            </div>
                        </div>

                        <p class="text-muted mt-3">Chỉ hỗ trợ file Excel (.xlsx, .xls) hoặc CSV, tối đa 10MB</p>
                    </div>

                    <!-- Hidden file input -->
                    <input id="file" name="file" type="file" class="d-none" accept=".xlsx,.xls,.csv" required>

                    <div id="fileError" class="text-danger mt-2 d-none"></div>
                    @error('file')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hướng dẫn -->
                <div class="alert alert-info">
                    <h5 class="alert-heading">Hướng dẫn:</h5>
                    <ul class="list-unstyled mb-0">
                        <li>• File phải có định dạng Excel (.xlsx, .xls) hoặc CSV</li>
                        <li>• Dòng đầu tiên phải là tiêu đề cột</li>
                        <li>• Các cột bắt buộc: Email, Ngày chấm công, Giờ vào, Giờ ra</li>
                        <li>• Định dạng ngày: dd/mm/yyyy (VD: 01/01/2025)</li>
                        <li>• Định dạng giờ: HH:mm (VD: 08:00)</li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('chamcong.download-template') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-download me-2" style="font-size: 16px;"></i>
                        Tải template mẫu
                    </a>
                    <button id="submitBtn" type="submit" class="btn btn-primary" disabled>
                        <i class="mdi mdi-upload me-2" style="font-size: 16px;"></i>
                        Import dữ liệu
                    </button>
                </div>
            </form>
        </div>

        <!-- Kết quả Import -->
        @if(session('importResults'))
            <div class="card p-4">
                <h3 class="h5 mb-4">Kết quả Import</h3>

                <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                    <div class="col">
                        <div class="card bg-success text-white text-center p-3">
                            <i class="mdi mdi-check-circle-outline text-white" style="font-size: 48px;"></i>
                            <h5 class="card-title">{{ session('importResults.success') }}</h5>
                            <p class="card-text">Thành công</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-warning text-dark text-center p-3">
                            <i class="mdi mdi-alert-outline text-dark" style="font-size: 48px;"></i>
                            <h5 class="card-title">{{ session('importResults.skip') }}</h5>
                            <p class="card-text">Bỏ qua</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-danger text-white text-center p-3">
                            <i class="mdi mdi-close-circle-outline text-white" style="font-size: 48px;"></i>
                            <h5 class="card-title">{{ count(session('importResults.errors', [])) }}</h5>
                            <p class="card-text">Lỗi</p>
                        </div>
                    </div>
                </div>

                @if(!empty(session('importResults.errors')))
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Chi tiết lỗi:</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach(session('importResults.errors') as $error)
                                <li>
                                    <i class="mdi mdi-alert-circle me-2 text-danger" style="font-size: 20px;"></i>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
// Drag and drop functionality with validation
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const dropZone = document.getElementById('dropZone');
    const fileError = document.getElementById('fileError');
    const defaultState = document.getElementById('defaultState');
    const selectedState = document.getElementById('selectedState');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');
    const selectFileBtn = document.querySelector('label[for="file"]');

    const allowedExtensions = ['.xlsx', '.xls', '.csv'];
    const maxSizeMB = 10;
    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    // Check if critical elements exist
    if (!fileInput || !dropZone || !fileError || !defaultState || !selectedState || !submitBtn) {
        console.error('One or more required DOM elements are missing');
        return;
    }

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-primary', 'bg-light');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-primary', 'bg-light');
        }, false);
    });

    // Handle dropped files
    dropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            console.log('File dropped:', files[0].name);
            handleFileSelect(files[0]);
        }
    }, false);

    // Handle click on drop zone to trigger file input
    selectFileBtn.addEventListener('click', (e) => {
        e.preventDefault();
        fileInput.click();
    });

    // Handle file input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            console.log('File selected:', e.target.files[0].name);
            handleFileSelect(e.target.files[0]);
        }
    });

    // Handle file selection and validation
    function handleFileSelect(file) {
        resetErrors();

        // Check file extension
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            showError(`Định dạng file không hợp lệ. Chỉ chấp nhận ${allowedExtensions.join(', ')}.`);
            clearFileInput();
            return;
        }

        // Check file size
        if (file.size > maxSizeBytes) {
            showError(`File vượt quá dung lượng cho phép (${maxSizeMB}MB).`);
            clearFileInput();
            return;
        }

        // Valid file, update display
        updateFileDisplay(file);
    }

    // Update file display
    function updateFileDisplay(file) {
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';

        // Switch states
        defaultState.classList.add('d-none');
        selectedState.classList.remove('d-none');

        submitBtn.disabled = false; // Enable submit button
    }

    // Show error message
    function showError(message) {
        fileError.textContent = message;
        fileError.classList.remove('d-none');
        submitBtn.disabled = true;
    }

    // Reset errors
    function resetErrors() {
        fileError.classList.add('d-none');
        fileError.textContent = '';
    }

    // Clear file input
    function clearFileInput() {
        fileInput.value = '';
        // Switch back to default state
        selectedState.classList.add('d-none');
        defaultState.classList.remove('d-none');
        submitBtn.disabled = true;
    }

    // Global function to clear file (called from button)
    window.clearFile = function() {
        clearFileInput();
        resetErrors();
    };
});
</script>
@endsection
