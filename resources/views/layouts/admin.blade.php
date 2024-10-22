<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .sidebar {
            width: 64px;
            transition: width 0.3s;
            overflow-x: hidden;
            background-color: #2F855A; /* Warna hijau gelap */
        }
        .sidebar:hover {
            width: 256px;
        }
        .sidebar-logo {
            width: 48px;
            transition: width 0.3s;
            border: 2px solid #F6E05E; /* Pinggiran kuning */
            border-radius: 8px;
            padding: 4px;
            background-color: #ffffff; /* Latar belakang putih untuk logo */
        }
        .sidebar:hover .sidebar-logo {
            width: 128px;
        }
        .sidebar a, .sidebar button {
            white-space: nowrap;
            display: flex;
            align-items: center;
        }
        .sidebar a span, .sidebar button span {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s, transform 0.3s;
        }
        .sidebar:hover a span, .sidebar:hover button span {
            opacity: 1;
            transform: translateX(0);
        }
        .submenu {
            display: none;
            transition: max-height 0.3s ease-out;
            max-height: 0;
            overflow: hidden;
            background-color: #2C7A7B; /* Warna hijau mint */
        }
        .submenu.open {
            display: block;
            max-height: 1000px;
        }
        .submenu a {
            color: white;
        }
        .submenu a:hover {
            background-color: #2A9D8F; /* Warna hijau mint lebih gelap untuk hover */
        }
        .logout-button span {
            display: none;
        }
        .sidebar:hover .logout-button span {
            display: inline;
        }
        .sidebar a {
            color: white;
        }
        .sidebar a:hover {
            background-color: #22543D; /* Warna hijau yang lebih gelap untuk hover */
        }
        .logout-button {
            background-color: #C53030; /* Warna merah untuk tombol logout */
        }
        .logout-button:hover {
            background-color: #9B2C2C; /* Warna merah gelap untuk hover */
        }
    </style>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="sidebar text-white h-full flex flex-col items-center space-y-6 py-7 absolute inset-y-0 left-0 transform transition duration-300 ease-in-out md:relative md:translate-x-0">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-6">
            <img src="{{ asset('images/MA.png') }}" alt="Logo" class="sidebar-logo">
        </div>
        <!-- Navigation -->
        <nav class="w-full">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>

            <!-- User Section with Submenu -->
            <div class="relative">
                <button id="user-button" class="flex items-center py-2.5 px-4 rounded w-full text-left transition duration-200 hover:bg-gray-800">
                    <i class="fas fa-users mr-3"></i>
                    <span class="sidebar-text">User</span>
                    <i id="user-chevron" class="fas fa-chevron-down ml-auto"></i>
                </button>
                <div id="user-submenu" class="submenu bg-gray-700 mt-2 rounded">
                    <a href="{{ route('admin.santri') }}" class="block py-2.5 px-6 rounded hover:bg-gray-600">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Kelola Santri</span>
                    </a>
                    <a href="{{ route('admin.guru') }}" class="block py-2.5 px-6 rounded hover:bg-gray-600">
                        <i class="fas fa-chalkboard-teacher mr-3"></i>
                        <span>Kelola Guru</span>
                    </a>
                    <a href="{{ route('admin.orangtua') }}" class="block py-2.5 px-6 rounded hover:bg-gray-600">
                        <i class="fas fa-user-friends mr-3"></i>
                        <span>Kelola Orang Tua</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.kelas') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                <i class="fas fa-school mr-3"></i>
                <span>Kelola Kelas</span>
            </a>
        </nav>
        <!-- Logout button -->
        <form method="POST" action="{{ route('logout') }}" class="absolute bottom-6 w-full px-4">
            @csrf
            <button type="submit" class="flex items-center justify-center py-2.5 px-4 rounded logout-button font-bold transition duration-200 w-full">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span>Logout</span>
            </button>
        </form>
    </aside>

    <!-- Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">@yield('header', 'Admin Dashboard')</h1>
                <button id="menu-button" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            @yield('content')
        </main>
    </div>

    <script>
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');
        const userButton = document.getElementById('user-button');
        const userSubmenu = document.getElementById('user-submenu');
        const userChevron = document.getElementById('user-chevron');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        userButton.addEventListener('click', () => {
            userSubmenu.classList.toggle('open');
            userChevron.classList.toggle('fa-chevron-down');
            userChevron.classList.toggle('fa-chevron-up');
        });
    </script>
</body>
</html>
