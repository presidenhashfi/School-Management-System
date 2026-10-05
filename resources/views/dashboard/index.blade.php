@extends('layouts.app')

@section('title', 'Dashboard — School Management System')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
@php
    $user  = auth()->user();
    $role  = $user->role;
    $hour  = now()->setTimezone('Asia/Jakarta')->hour;
    $greet = $hour >= 5 && $hour < 11 ? 'Selamat pagi' : ($hour < 15 && $hour >= 11 ? 'Selamat siang' : ($hour >= 15 && $hour < 18 ? 'Selamat sore' : 'Selamat malam'));
    $maxVal = max($studentsCount, $teachersCount, $classesCount, $subjectsCount, 1);

    $stats = [
        ['label' => 'Siswa',  'value' => $studentsCount, 'icon' => 'bi-people',         'route' => $role !== 'student' ? 'students.index' : null, 'desc' => $role === 'admin' ? 'Kelola data siswa' : 'Lihat data siswa'],
        ['label' => 'Guru',   'value' => $teachersCount, 'icon' => 'bi-person-workspace', 'route' => 'teachers.index', 'desc' => 'Kelola data guru', 'admin' => true],
        ['label' => 'Kelas',  'value' => $classesCount,  'icon' => 'bi-building',       'route' => 'classes.index',  'desc' => $role === 'admin' ? 'Kelola data kelas' : 'Lihat data kelas'],
        ['label' => 'Mata Pelajaran', 'value' => $subjectsCount, 'icon' => 'bi-journal-text', 'route' => $role !== 'student' ? 'subjects.index' : null, 'desc' => $role === 'admin' ? 'Kelola mata pelajaran' : 'Lihat mata pelajaran'],
    ];
    $stats = array_values(array_filter($stats, fn($s) => empty($s['admin']) || $role === 'admin'));
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">{{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}</div>
        <h1 class="ph-title">{{ $greet }}, {{ $user->username }}</h1>
        <p class="ph-sub">Ringkasan data akademik sekolah Anda hari ini.</p>
    </div>
    <span class="tag tag-accent tag-dot">{{ ucfirst($role) }}</span>
</div>

{{-- Stats --}}
<section class="stat-grid" aria-label="Statistik">
    @foreach($stats as $s)
        @if($s['route'])
            <a href="{{ route($s['route']) }}" class="stat">
        @else
            <div class="stat">
        @endif
            <div class="stat-top">
                <span class="stat-icon"><i class="bi {{ $s['icon'] }}" aria-hidden="true"></i></span>
                @if($s['route'])<i class="bi bi-arrow-up-right stat-arrow" aria-hidden="true"></i>@endif
            </div>
            <div>
                <div class="stat-num count-up" data-target="{{ $s['value'] }}">{{ $s['value'] }}</div>
                <div class="stat-label">Total {{ $s['label'] }}</div>
            </div>
        @if($s['route']) </a> @else </div> @endif
    @endforeach
</section>

<div class="dash-grid">
    <div class="d-flex flex-column" style="gap:var(--s5);min-width:0">
        {{-- Quick access --}}
        <section class="card-ui">
            <div class="card-ui-head"><h2 class="card-ui-title">Akses cepat</h2></div>
            <div class="link-list">
                @foreach($stats as $s)
                    @if($s['route'])
                        <a href="{{ route($s['route']) }}" class="link-row">
                            <span class="stat-icon"><i class="bi {{ $s['icon'] }}" aria-hidden="true"></i></span>
                            <div>
                                <div class="link-row-title">{{ $s['label'] }}</div>
                                <div class="link-row-desc">{{ $s['desc'] }}</div>
                            </div>
                            <i class="bi bi-arrow-right link-row-go" aria-hidden="true"></i>
                        </a>
                    @else
                        <div class="link-row">
                            <span class="stat-icon"><i class="bi {{ $s['icon'] }}" aria-hidden="true"></i></span>
                            <div>
                                <div class="link-row-title">{{ $s['label'] }}</div>
                                <div class="link-row-desc">{{ $s['value'] }} tercatat</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Overview --}}
        <section class="card-ui">
            <div class="card-ui-head"><h2 class="card-ui-title">Perbandingan data</h2></div>
            <div class="card-ui-body">
                @foreach($stats as $s)
                    <div class="bar-row">
                        <div class="bar-top"><span>{{ $s['label'] }}</span><span>{{ $s['value'] }}</span></div>
                        <div class="bar-track"><div class="bar-fill" data-pct="{{ round($s['value'] / $maxVal * 100) }}"></div></div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- Account --}}
    <aside class="card-ui">
        <div class="card-ui-head"><h2 class="card-ui-title">Akun saya</h2></div>
        <div class="card-ui-body" style="padding-top:var(--s3);padding-bottom:var(--s3)">
            <div class="kv"><span class="kv-k">Username</span><span class="kv-v">{{ $user->username }}</span></div>
            <div class="kv"><span class="kv-k">Email</span><span class="kv-v">{{ $user->email }}</span></div>
            <div class="kv"><span class="kv-k">Peran</span><span class="kv-v"><span class="tag">{{ ucfirst($role) }}</span></span></div>
            <div class="kv"><span class="kv-k">Bergabung</span><span class="kv-v">{{ $user->created_at->translatedFormat('d M Y') }}</span></div>
            <div class="kv"><span class="kv-k">Status</span><span class="kv-v"><span class="tag tag-accent tag-dot">Aktif</span></span></div>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    document.querySelectorAll('.count-up').forEach(function (el) {
        var target = parseInt(el.dataset.target, 10) || 0;
        if (reduce || target === 0) { el.textContent = target; return; }
        var start = null, dur = 900;
        function tick(t) {
            if (start === null) start = t;
            var p = Math.min((t - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        }
        el.textContent = 0;
        requestAnimationFrame(tick);
    });
    setTimeout(function () {
        document.querySelectorAll('.bar-fill').forEach(function (b) { b.style.width = b.dataset.pct + '%'; });
    }, 150);
})();
</script>
@endpush
