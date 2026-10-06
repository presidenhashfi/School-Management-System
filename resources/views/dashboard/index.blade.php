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
    $greet = $hour >= 5 && $hour < 11 ? 'Selamat Pagi' : ($hour < 15 && $hour >= 11 ? 'Selamat Siang' : ($hour >= 15 && $hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    $maxVal = max($studentsCount, $teachersCount, $classesCount, $subjectsCount, 1);

    $roleWelcome = [
        'admin'   => 'Selamat datang kembali, Administrator. Semua data akademik sekolah siap dikelola hari ini.',
        'teacher' => 'Semangat mengajar hari ini! Pantau tugas siswa dan materi pelajaran Anda dengan mudah.',
        'student' => 'Semangat belajar! Cek materi dan tugas kelas yang aktif untuk segera dikerjakan.',
    ];

    $stats = [
        ['label' => 'Siswa Terdaftar',  'value' => $studentsCount, 'icon' => 'bi-people-fill',         'route' => $role !== 'student' ? 'students.index' : null, 'desc' => $role === 'admin' ? 'Kelola data siswa sekolah' : 'Data siswa aktif', 'color' => '#0284c7', 'soft' => '#f0f9ff'],
        ['label' => 'Tenaga Pendidik',  'value' => $teachersCount, 'icon' => 'bi-mortarboard-fill',    'route' => 'teachers.index', 'desc' => 'Daftar guru & pengampu mapel', 'admin' => true, 'color' => '#059669', 'soft' => '#ecfdf5'],
        ['label' => 'Ruang & Rombel',   'value' => $classesCount,  'icon' => 'bi-building-fill',       'route' => 'classes.index',  'desc' => 'Tingkat X, XI, XII & Soal', 'color' => '#4f46e5', 'soft' => '#eef2ff'],
        ['label' => 'Mata Pelajaran',   'value' => $subjectsCount, 'icon' => 'bi-journal-bookmark-fill', 'route' => $role !== 'student' ? 'subjects.index' : null, 'desc' => 'Kurikulum & silabus aktif', 'color' => '#d97706', 'soft' => '#fffbeb'],
    ];
    $stats = array_values(array_filter($stats, fn($s) => empty($s['admin']) || $role === 'admin'));
@endphp

{{-- Welcome Hero --}}
<div class="ph">
    <div>
        <div class="ph-eyebrow">
            <i class="bi bi-calendar2-week-fill me-1"></i> {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
        </div>
        <h1 class="ph-title">{{ $greet }}, {{ $user->username }}!</h1>
        <p class="ph-sub">{{ $roleWelcome[$role] ?? 'Ringkasan data akademik sekolah Anda hari ini.' }}</p>
    </div>
    <div>
        @if($role === 'admin')
            <span class="role-pill role-pill-admin" style="font-size:.8rem;padding:.3rem .8rem">
                <i class="bi bi-shield-check" aria-hidden="true"></i> Administrator Sekolah
            </span>
        @elseif($role === 'teacher')
            <span class="role-pill role-pill-teacher" style="font-size:.8rem;padding:.3rem .8rem">
                <i class="bi bi-mortarboard-fill" aria-hidden="true"></i> Guru Mata Pelajaran
            </span>
        @else
            <span class="role-pill role-pill-student" style="font-size:.8rem;padding:.3rem .8rem">
                <i class="bi bi-backpack2-fill" aria-hidden="true"></i> Siswa Aktif
            </span>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<section class="stat-grid" aria-label="Statistik">
    @foreach($stats as $s)
        @if($s['route'])
            <a href="{{ route($s['route']) }}" class="stat">
        @else
            <div class="stat">
        @endif
            <div class="stat-top">
                <span class="stat-icon" style="background:{{ $s['soft'] }};color:{{ $s['color'] }}">
                    <i class="bi {{ $s['icon'] }}" aria-hidden="true"></i>
                </span>
                @if($s['route'])
                    <i class="bi bi-arrow-up-right stat-arrow" aria-hidden="true"></i>
                @endif
            </div>
            <div>
                <div class="stat-num count-up" data-target="{{ $s['value'] }}">{{ $s['value'] }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        @if($s['route']) </a> @else </div> @endif
    @endforeach
</section>

<div class="dash-grid">
    <div class="d-flex flex-column" style="gap:var(--s5);min-width:0">
        {{-- Quick Access --}}
        <section class="card-ui">
            <div class="card-ui-head">
                <h2 class="card-ui-title"><i class="bi bi-lightning-charge-fill text-warning"></i> Menu Pintas</h2>
            </div>
            <div class="link-list">
                @foreach($stats as $s)
                    @if($s['route'])
                        <a href="{{ route($s['route']) }}" class="link-row">
                            <span class="stat-icon" style="background:{{ $s['soft'] }};color:{{ $s['color'] }}">
                                <i class="bi {{ $s['icon'] }}" aria-hidden="true"></i>
                            </span>
                            <div>
                                <div class="link-row-title">{{ $s['label'] }}</div>
                                <div class="link-row-desc">{{ $s['desc'] }}</div>
                            </div>
                            <i class="bi bi-arrow-right link-row-go" aria-hidden="true"></i>
                        </a>
                    @else
                        <div class="link-row">
                            <span class="stat-icon" style="background:{{ $s['soft'] }};color:{{ $s['color'] }}">
                                <i class="bi {{ $s['icon'] }}" aria-hidden="true"></i>
                            </span>
                            <div>
                                <div class="link-row-title">{{ $s['label'] }}</div>
                                <div class="link-row-desc">{{ $s['value'] }} data terdata</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Overview Bars --}}
        <section class="card-ui">
            <div class="card-ui-head">
                <h2 class="card-ui-title"><i class="bi bi-bar-chart-fill text-primary"></i> Distribusi Data Akademik</h2>
            </div>
            <div class="card-ui-body">
                @foreach($stats as $s)
                    <div class="bar-row">
                        <div class="bar-top"><span>{{ $s['label'] }}</span><span>{{ $s['value'] }}</span></div>
                        <div class="bar-track">
                            <div class="bar-fill" data-pct="{{ round($s['value'] / $maxVal * 100) }}" style="background:{{ $s['color'] }}"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- Account Info Widget --}}
    <aside class="card-ui">
        <div class="card-ui-head">
            <h2 class="card-ui-title"><i class="bi bi-person-circle text-primary"></i> Profil Anda</h2>
        </div>
        <div class="card-ui-body" style="padding-top:var(--s3);padding-bottom:var(--s3)">
            <div class="text-center py-3">
                <div class="avatar" style="width:58px;height:58px;font-size:1.3rem;margin:0 auto var(--s3);box-shadow:0 4px 12px rgba(79,70,229,.18)">
                    {{ strtoupper(substr($user->username, 0, 2)) }}
                </div>
                <div style="font-weight:900;font-size:1.05rem;color:var(--ink)">{{ $user->username }}</div>
                <div style="font-size:.82rem;color:var(--muted)">{{ $user->email }}</div>
            </div>
            <div class="kv"><span class="kv-k">Peran Akun</span><span class="kv-v"><span class="tag">{{ ucfirst($role) }}</span></span></div>
            <div class="kv"><span class="kv-k">Terdaftar Sejak</span><span class="kv-v">{{ $user->created_at->translatedFormat('d M Y') }}</span></div>
            <div class="kv"><span class="kv-k">Status Akses</span><span class="kv-v"><span class="tag tag-accent tag-dot">Aktif</span></span></div>
            <div class="pt-3">
                <a href="{{ route('password.edit') }}" class="btn-ui btn-ui-ghost w-100" style="font-size:.84rem;min-height:36px">
                    <i class="bi bi-key-fill"></i> Perbarui Kata Sandi
                </a>
            </div>
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
        var start = null, dur = 850;
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
