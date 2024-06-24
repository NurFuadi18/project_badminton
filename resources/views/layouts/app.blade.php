<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }

        .hamburger {
            cursor: pointer;
            z-index: 1001;
            position: fixed;
            top: 15px;
            left: 15px;
            transition: left 0.3s ease;
            background-color: #333;
            padding: 4px;
            border-radius: 4px;
        }

        .hamburger div {
            width: 30px;
            height: 3px;
            background-color: #ffffff;
            margin: 6px 0;
            transition: all 0.4s;
        }

        .hamburger.active div:first-child {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active div:last-child {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        .sidebar {
            background-color: #24292e;
            color: #fff;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            bottom: 0;
            z-index: 1000;
            transition: left 0.3s ease;
            padding-top: 20px;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-title {
            font-size: 20px;
            padding: 15px 20px;
            font-weight: 700;
            border-bottom: 1px dashed #444;
        }

        .sidebar-menu {
            padding: 0;
            list-style-type: none;
        }

        .sidebar-menu-item {
            padding: 15px 20px;
            transition: background-color 0.3s ease;
        }

        .sidebar-menu-item a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .sidebar-menu-item:hover {
            background-color: #444;
        }

        .content {
            margin: 30px 0;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        .sidebar.open ~ .content {
            margin-left: 270px;
        }

        .sidebar.open ~ .hamburger {
            left: 265px;
        }

        .dashboard-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        h1 {
            font-size: 32px;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-title {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="hamburger" onclick="toggleSidebar()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="sidebar">
        <div class="sidebar-title">Badminton Jaya</div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item"><a href="/">Home</a></li>
            <li class="sidebar-menu-item"><a href="/bookings">Booking</a></li>
            <li class="sidebar-menu-item"><a href="/databarang">Data</a></li>
            <li class="sidebar-menu-item"><a href="/cart">Cart</a></li>
            <li class="sidebar-menu-item"><a href="/register">Tambah Akun</a></li>
            <li class="sidebar-menu-item"><a href="/lapangan">Manajemen Lapangan</a></li>
            <li class="sidebar-menu-item"><a href="/pendapatan">Pendapatan</a></li>
            <li class="sidebar-menu-item"><a href="/laporan">Laporan</a></li>
            <li class="sidebar-menu-item"><a href="/gantipassword">Data Akun</a></li>
            <li class="sidebar-menu-item"><a href="/login">Log Out</a></li>

        </ul>
    </div>

    <div class="content container-fluid">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.querySelector('.sidebar');
            var hamburger = document.querySelector('.hamburger');
            sidebar.classList.toggle('open');
            hamburger.classList.toggle('active');
            if (sidebar.classList.contains('open')) {
                hamburger.style.left = '265px';
            } else {
                hamburger.style.left = '15px';
            }
        }

        document.addEventListener('mousemove', function(event) {
            var sidebar = document.querySelector('.sidebar');
            var userProfileCard = document.querySelector('.user-profile-card');
            var hamburger = document.querySelector('.hamburger');
            
            if (event.clientX < 50 && !sidebar.classList.contains('open')) {
                sidebar.classList.add('open');
                hamburger.classList.add('active');
                hamburger.style.left = '265px';
            } else if (event.clientX > 250 && sidebar.classList.contains('open') && !event.target.closest('.sidebar') && !event.target.closest('.hamburger')) {
                sidebar.classList.remove('open');
                hamburger.classList.remove('active');
                hamburger.style.left = '15px';
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
