<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DV Tech - Quản Lý Nhân Sự</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/homePage.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-spacing.css')}}">
</head>
<body>
    @include('layoutsHomePage.partials.navbar')

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="{{asset('js/homePage.js')}}"></script>
    <script>
    function openApplicationModal(jobTitle, jobId) {
        document.getElementById('modalJobTitle').textContent = 'Ứng Tuyển: ' + jobTitle;
        document.getElementById('tin_tuyen_dung_id').value = jobId;
        document.getElementById('applicationModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('applicationModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById('applicationModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>
</body>
</html>
