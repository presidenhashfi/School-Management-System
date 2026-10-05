<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem manajemen sekolah: kelola siswa, guru, kelas, dan mata pelajaran dengan mudah.">
    <title>@yield('title', 'School Management System')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/ui.css') }}?v={{ @filemtime(public_path('css/ui.css')) }}" rel="stylesheet">
</head>
<body>
@php
    $authUser = auth()->user();
    $navItems = [
        ['route' => 'dashboard',      'match' => 'dashboard',  'icon' => 'bi-grid-1x2',   'label' => 'Dashboard'],
        ['route' => 'students.index', 'match' => 'students.*', 'icon' => 'bi-people',     'label' => 'Siswa'],
        ['route' => 'classes.index',  'match' => 'classes.*',  'icon' => 'bi-building',   'label' => 'Kelas'],
        ['route' => 'subjects.index', 'match' => 'subjects.*', 'icon' => 'bi-journal-text', 'label' => 'Mapel'],
    ];
    if ($authUser->role === 'admin') {
        $navItems[] = ['route' => 'teachers.index', 'match' => 'teachers.*', 'icon' => 'bi-person-workspace', 'label' => 'Guru'];
    }
    $initials = strtoupper(substr($authUser->username, 0, 2));
@endphp

<header class="nav-ui">
    <div class="nav-inner">
        <a href="{{ route('dashboard') }}" class="brand" aria-label="School Management System">
            <span class="brand-mark"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
            <span class="brand-name">SchoolMS</span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="nav-link-ui {{ request()->routeIs($item['match']) ? 'active' : '' }}"
                   @if(request()->routeIs($item['match'])) aria-current="page" @endif>
                    <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>{{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="nav-user">
            <div class="avatar" aria-hidden="true">{{ $initials }}</div>
            <div class="nav-user-meta">
                <div class="nav-user-name">{{ $authUser->username }}</div>
                <div class="nav-user-role">{{ $authUser->role }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="icon-btn logout" aria-label="Keluar" title="Keluar">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                </button>
            </form>
        </div>

        <button class="icon-btn nav-toggle" id="navToggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="navPanel">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>
    </div>
</header>

{{-- Mobile menu --}}
<div class="nav-scrim" id="navScrim"></div>
<div class="nav-panel" id="navPanel">
    @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}" class="nav-link-ui {{ request()->routeIs($item['match']) ? 'active' : '' }}">
            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>{{ $item['label'] }}
        </a>
    @endforeach
    <div class="nav-panel-user">
        <div class="avatar" aria-hidden="true">{{ $initials }}</div>
        <div class="nav-user-meta">
            <div class="nav-user-name">{{ $authUser->username }}</div>
            <div class="nav-user-role">{{ $authUser->role }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn-ui btn-ui-ghost"><i class="bi bi-box-arrow-right" aria-hidden="true"></i> Keluar</button>
        </form>
    </div>
</div>

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
    var toggle = document.getElementById('navToggle');
    var panel = document.getElementById('navPanel');
    var scrim = document.getElementById('navScrim');
    function setOpen(open) {
        panel.classList.toggle('open', open);
        scrim.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', open);
        toggle.querySelector('i').className = 'bi ' + (open ? 'bi-x-lg' : 'bi-list');
    }
    toggle.addEventListener('click', function () { setOpen(!panel.classList.contains('open')); });
    scrim.addEventListener('click', function () { setOpen(false); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
    window.addEventListener('resize', function () { if (window.innerWidth > 860) setOpen(false); });
})();
</script>
@stack('scripts')
</body>
</html>