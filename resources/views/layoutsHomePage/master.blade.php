<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DV Tech - Quản Lý Nhân Sự</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/homePage.css')}}">
</head>
<body>
    @include('layoutsHomePage.partials.navbar')

    <main>
        @yield('content')
    </main>

    <!-- Application Modal -->
    @include('layoutsHomePage.partials.applicationModal')

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="{{asset('js/homePage.js')}}"></script>
</body>
</html>
