<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thông tin nhân viên</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>

<body>
    <div class="container">
        @include('layoutsEmploye.partials.aside')

        <main class="main-content">
            @include('layoutsEmploye.partials.header')
            @yield('content-employee')
        </main>
    </div>

    <!-- Modals -->
    @include('employe.modals')
    @yield('javascript')
    <script src="{{asset('js/employee.js')}}"></script>

</body>
