<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem manajemen sekolah: kelola siswa, guru, kelas, dan mata pelajaran dengan mudah.">
    <title>@yield('title', 'School Management System')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/ui.css') }}?v={{ @filemtime(public_path('css/ui.css')) }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@php
    $authUser = auth()->user();
    $navItems = [
        ['route' => 'dashboard',      'match' => 'dashboard',  'icon' => 'bi-grid-1x2-fill',   'label' => 'Dashboard'],
        ['route' => 'students.index', 'match' => 'students.*', 'icon' => 'bi-people-fill',     'label' => 'Siswa'],
        ['route' => 'classes.index',  'match' => ['classes.*', 'assignments.*', 'promotion.*'],  'icon' => 'bi-building-fill',   'label' => 'Kelas & Soal'],
        ['route' => 'subjects.index', 'match' => 'subjects.*', 'icon' => 'bi-journal-bookmark-fill', 'label' => 'Mapel'],
    ];
    if ($authUser->role === 'admin') {
        $navItems[] = ['route' => 'teachers.index', 'match' => 'teachers.*', 'icon' => 'bi-person-badge-fill', 'label' => 'Guru'];
        $navItems[] = ['route' => 'users.index', 'match' => 'users.*', 'icon' => 'bi-person-gear', 'label' => 'Akun'];
        $navItems[] = ['route' => 'activity-logs.index', 'match' => 'activity-logs.*', 'icon' => 'bi-clock-history', 'label' => 'Log'];
    }
    $initials = strtoupper(substr($authUser->username, 0, 2));
    $roleLabels = [
        'admin'   => ['label' => 'Admin Sekolah', 'class' => 'role-pill-admin',   'icon' => 'bi-shield-check'],
        'teacher' => ['label' => 'Guru',          'class' => 'role-pill-teacher', 'icon' => 'bi-mortarboard-fill'],
        'student' => ['label' => 'Siswa',         'class' => 'role-pill-student', 'icon' => 'bi-backpack2-fill'],
    ];
    $roleMeta = $roleLabels[$authUser->role] ?? ['label' => ucfirst($authUser->role), 'class' => 'role-pill-default', 'icon' => 'bi-person-fill'];
@endphp

<header class="nav-ui">
    <div class="nav-inner">
        {{-- Brand / School Identity --}}
        <a href="{{ route('dashboard') }}" class="brand" aria-label="School Management System">
            <span class="brand-mark"><i class="bi bi-mortarboard-fill" aria-hidden="true"></i></span>
            <span class="brand-text">
                <span class="brand-name">SchoolMS</span>
                <span class="brand-sub">Portal Akademik</span>
            </span>
        </a>

        {{-- Desktop Segmented Capsule Track --}}
        <nav class="nav-track" aria-label="Navigasi utama">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="nav-link-ui {{ request()->routeIs($item['match']) ? 'active' : '' }}"
                   @if(request()->routeIs($item['match'])) aria-current="page" @endif>
                    <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Right Section: Profile Card & Mobile Toggle --}}
        <div class="nav-actions">
            <div class="user-dropdown" id="userDropdown">
                <button type="button" class="user-dropdown-btn" id="userDropdownBtn" aria-expanded="false" aria-haspopup="true" aria-controls="userDropdownMenu" aria-label="Menu profil pengguna">
                    <div class="avatar" aria-hidden="true">{{ $initials }}</div>
                    <div class="user-dropdown-meta">
                        <span class="user-dropdown-name">{{ $authUser->username }}</span>
                        <span class="role-pill {{ $roleMeta['class'] }}">
                            <i class="bi {{ $roleMeta['icon'] }}" aria-hidden="true"></i> {{ $roleMeta['label'] }}
                        </span>
                    </div>
                    <i class="bi bi-chevron-down user-dropdown-caret" aria-hidden="true"></i>
                </button>

                <div class="user-dropdown-menu" id="userDropdownMenu" role="menu" aria-labelledby="userDropdownBtn">
                    <div class="user-dropdown-header">
                        <div class="avatar avatar-lg" aria-hidden="true">{{ $initials }}</div>
                        <div class="user-dropdown-header-info">
                            <span class="dropdown-user-title">{{ $authUser->username }}</span>
                            <span class="dropdown-user-subtitle">{{ $authUser->email ?? 'Sesi Aktif' }}</span>
                            <span class="role-pill {{ $roleMeta['class'] }} mt-1">
                                <i class="bi {{ $roleMeta['icon'] }}" aria-hidden="true"></i> {{ $roleMeta['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="user-dropdown-divider"></div>
                    <a href="{{ route('password.edit') }}" class="user-dropdown-item" role="menuitem">
                        <span class="dropdown-item-icon"><i class="bi bi-shield-lock"></i></span>
                        <div class="dropdown-item-text">
                            <span class="dropdown-item-title">Ubah Password</span>
                            <span class="dropdown-item-desc">Keamanan kata sandi akun</span>
                        </div>
                    </a>
                    @if($authUser->role === 'admin')
                    <a href="{{ route('activity-logs.index') }}" class="user-dropdown-item" role="menuitem">
                        <span class="dropdown-item-icon"><i class="bi bi-clock-history"></i></span>
                        <div class="dropdown-item-text">
                            <span class="dropdown-item-title">Log Aktivitas</span>
                            <span class="dropdown-item-desc">Riwayat tindakan sistem</span>
                        </div>
                    </a>
                    @endif
                    <div class="user-dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="user-dropdown-item user-dropdown-logout" role="menuitem">
                            <span class="dropdown-item-icon"><i class="bi bi-box-arrow-right"></i></span>
                            <div class="dropdown-item-text">
                                <span class="dropdown-item-title">Keluar dari Akun</span>
                                <span class="dropdown-item-desc">Akhiri sesi di perangkat ini</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <button class="nav-toggle-btn" id="navToggle" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="navPanel">
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

{{-- Mobile Drawer Navigation --}}
<div class="nav-scrim" id="navScrim"></div>
<aside class="nav-drawer" id="navPanel" aria-label="Menu navigasi mobile">
    <div class="nav-drawer-header">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-mortarboard-fill" aria-hidden="true"></i></span>
            <span class="brand-text">
                <span class="brand-name">SchoolMS</span>
                <span class="brand-sub">Portal Akademik</span>
            </span>
        </div>
        <button type="button" class="icon-btn" id="navDrawerClose" aria-label="Tutup menu">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>
    </div>

    <div class="nav-drawer-user">
        <div class="avatar avatar-md" aria-hidden="true">{{ $initials }}</div>
        <div class="nav-drawer-user-info">
            <div class="nav-drawer-user-name">{{ $authUser->username }}</div>
            <span class="role-pill {{ $roleMeta['class'] }}">
                <i class="bi {{ $roleMeta['icon'] }}" aria-hidden="true"></i> {{ $roleMeta['label'] }}
            </span>
        </div>
    </div>

    <nav class="nav-drawer-links" aria-label="Navigasi mobile">
        <div class="nav-drawer-group-label">Menu Akademik</div>
        @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="nav-drawer-link {{ request()->routeIs($item['match']) ? 'active' : '' }}">
                <span class="nav-drawer-link-icon"><i class="bi {{ $item['icon'] }}" aria-hidden="true"></i></span>
                <span class="nav-drawer-link-text">{{ $item['label'] }}</span>
                @if(request()->routeIs($item['match']))
                    <i class="bi bi-check2 nav-drawer-link-indicator" aria-hidden="true"></i>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="nav-drawer-footer">
        <div class="nav-drawer-group-label">Akun & Sesi</div>
        <a href="{{ route('password.edit') }}" class="nav-drawer-link">
            <span class="nav-drawer-link-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
            <span class="nav-drawer-link-text">Ubah Password</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0 mt-2">
            @csrf
            <button type="submit" class="nav-drawer-logout-btn">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>
</aside>

@hasSection('breadcrumbs')
<div class="crumbs">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">@yield('breadcrumbs')</ol>
    </nav>
</div>
@endif

<main class="shell">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2" aria-hidden="true"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2" aria-hidden="true"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    // Mobile Drawer
    var toggle = document.getElementById('navToggle');
    var drawer = document.getElementById('navPanel');
    var scrim = document.getElementById('navScrim');
    var drawerClose = document.getElementById('navDrawerClose');

    function setDrawerOpen(open) {
        if (!drawer || !scrim) return;
        drawer.classList.toggle('open', open);
        scrim.classList.toggle('open', open);
        document.body.style.overflow = open ? 'hidden' : '';
        if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    if (toggle) toggle.addEventListener('click', function () { setDrawerOpen(!drawer.classList.contains('open')); });
    if (drawerClose) drawerClose.addEventListener('click', function () { setDrawerOpen(false); });
    if (scrim) scrim.addEventListener('click', function () { setDrawerOpen(false); });

    // User Dropdown
    var userDropdown = document.getElementById('userDropdown');
    var userDropdownBtn = document.getElementById('userDropdownBtn');

    function toggleUserDropdown(show) {
        if (!userDropdown || !userDropdownBtn) return;
        var isOpen = typeof show === 'boolean' ? show : !userDropdown.classList.contains('open');
        userDropdown.classList.toggle('open', isOpen);
        userDropdownBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    if (userDropdownBtn) {
        userDropdownBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleUserDropdown();
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (userDropdown && !userDropdown.contains(e.target)) {
            toggleUserDropdown(false);
        }
    });

    // Keyboard navigation (ESC closes both)
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            setDrawerOpen(false);
            toggleUserDropdown(false);
        }
    });

    // Reset when resizing to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            setDrawerOpen(false);
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>