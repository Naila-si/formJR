<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Layout')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin1/dashboard.css') }}">
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="logo mb-6">
            <div class="logo-bg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" />
            </div>
        </div>
        <nav>
            <a href="{{ route('admin1.dashboard') }}"
                class="{{ request()->routeIs('admin1.dashboard') ? 'active' : '' }}">
                <span class="material-icons">dashboard</span> Dashboard
            </a>

            <!-- Section Judul -->
            <p class="sidebar-section">DATA & INFORMASI</p>

            <!-- Parent menu -->
            <div class="menu-item has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">
                    <span class="material-icons">grid_view</span> Data
                    <span class="material-icons expand-icon">expand_more</span>
                </a>
                <div class="submenu">
                    <li>
                        <a href="{{ route('admin1.iwkbu.index') }}">
                            <span class="material-icons">folder</span> Data IWKBU
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.iwkl.index') }}">
                            <span class="material-icons">folder</span> Data IWKL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.rkcrm.index') }}">
                            <span class="material-icons">folder</span> Data RK CRM
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.formulir.index') }}">
                            <span class="material-icons">folder</span> Data Form CRM
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.manifest.index') }}">
                            <span class="material-icons">folder</span> Data Manifest
                        </a>
                    </li>
                </div>
            </div>

            <p class="sidebar-section">PERENCANAAN EVALUASI</p>
            <a href="{{ route('admin1.rk.jadwal') }}"
                class="{{ request()->routeIs('admin1.rk.jadwal') ? 'active' : '' }}">
                <span class="material-icons">event_note</span> RK Jadwal dan Target
            </a>

            <p class="sidebar-section">SETTINGS</p>
            <!-- Parent menu Access Control -->
            <div class="menu-item has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">
                    <span class="material-icons">security</span> Access Control
                    <span class="material-icons expand-icon">expand_more</span>
                </a>
                <div class="submenu">
                    <a href="#"><span class="material-icons">account_balance</span> Admin Pusat</a>
                    <a href="#"><span class="material-icons">person</span> Admin Cabang</a>
                </div>
            </div>
            <a href="#"><span class="material-icons">settings</span> Settings</a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="main">
        <!-- Header -->
        <header class="header">
            <div class="flex items-center gap-4">
                <span id="hamburger" class="hamburger material-icons" aria-expanded="false">menu</span>
                <h1>@yield('title', 'Dashboard')</h1>

                <!-- Search -->
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cari menu..." />
                    <span class="material-icons search-icon">search</span>
                    <div id="searchResults" class="search-results"></div>
                </div>

                <div class="user">
                    <span>Hi, Admin</span>
                    <img src="{{ asset('images/User Profile.jpeg') }}" alt="User">
                    <button id="logoutBtn" class="logout-btn">Logout</button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('hamburger');

            if (!sidebar || !hamburger) return;

            // atur initial state sesuai lebar layar
            function resetSidebar() {
                if (window.innerWidth <= 768) {
                sidebar.classList.add('hidden');
                hamburger.setAttribute('aria-expanded', 'false');
                } else {
                sidebar.classList.remove('hidden');
                hamburger.setAttribute('aria-expanded', 'true');
                }
            }

            resetSidebar();
            window.addEventListener('resize', resetSidebar);

            // toggle saat klik hamburger
            hamburger.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar.classList.toggle('hidden');
                const expanded = sidebar.classList.contains('hidden') ? 'false' : 'true';
                hamburger.setAttribute('aria-expanded', expanded);
            });

            // tutup kalau klik di luar (hanya di mobile)
            document.addEventListener('click', function (e) {
                if (window.innerWidth <= 768 && !sidebar.classList.contains('hidden')) {
                if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                    sidebar.classList.add('hidden');
                    hamburger.setAttribute('aria-expanded', 'false');
                }
                }
            });

            // tutup pake Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && window.innerWidth <= 768 && !sidebar.classList.contains('hidden')) {
                sidebar.classList.add('hidden');
                hamburger.setAttribute('aria-expanded', 'false');
                }
            });
        });

        // Dropdown submenu sidebar
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const parent = this.closest('.menu-item');
                parent.classList.toggle('open');
                const submenu = parent.querySelector('.submenu');
                submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
            });
        });
        document.getElementById('logoutBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Kamu akan keluar dari akunmu!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, logout!',
                cancelButtonText: 'Tidak, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        });
    </script>
</body>

</html>
