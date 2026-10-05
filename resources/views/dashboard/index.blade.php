@extends('layouts.app')

@section('title', 'Dashboard — School Management System')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<style>
/* ============================================================
   DASHBOARD — ULTRA PREMIUM REDESIGN
   ============================================================ */

/* ----- Greeting Hero ----- */
.db-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 40%, #a855f7 75%, #c084fc 100%);
    border-radius: 28px;
    padding: 2.5rem 3rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 50px rgba(99,102,241,.4);
    color: white;
}

.db-hero-noise {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.7' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
}

.db-hero-orb1 { position:absolute; width:350px; height:350px; background:rgba(255,255,255,.07); border-radius:50%; top:-140px; right:-80px; pointer-events:none; }
.db-hero-orb2 { position:absolute; width:200px; height:200px; background:rgba(255,255,255,.05); border-radius:50%; bottom:-80px; right:220px; pointer-events:none; }
.db-hero-orb3 { position:absolute; width:100px; height:100px; background:rgba(255,255,255,.06); border-radius:50%; top:30px; left:45%; pointer-events:none; }

.db-hero-content { position:relative; z-index:2; display:flex; align-items:center; justify-content:space-between; gap:2rem; flex-wrap:wrap; }

.db-hero-left {}

.db-hero-greeting {
    font-size: .8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    opacity: .7;
    margin-bottom: .5rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.db-hero-greeting .dot {
    width: 6px; height: 6px;
    background: #a3e635;
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(163,230,53,.3);
    animation: pulse-dot 2s ease-in-out infinite;
}

@keyframes pulse-dot {
    0%, 100% { box-shadow: 0 0 0 3px rgba(163,230,53,.3); }
    50% { box-shadow: 0 0 0 6px rgba(163,230,53,.15); }
}

.db-hero-name {
    font-size: 2rem;
    font-weight: 900;
    margin: 0 0 .4rem;
    letter-spacing: -.5px;
    line-height: 1.1;
}

.db-hero-sub {
    font-size: .9rem;
    opacity: .75;
    margin: 0 0 1.75rem;
    font-weight: 400;
}

.db-hero-badges {
    display: flex;
    gap: .75rem;
    flex-wrap: wrap;
}

.db-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.25);
    padding: .4rem 1rem;
    border-radius: 20px;
    font-size: .78rem;
    font-weight: 700;
    backdrop-filter: blur(6px);
    letter-spacing: .2px;
}

.db-hero-right {
    flex-shrink: 0;
    text-align: center;
}

.db-hero-avatar {
    width: 100px; height: 100px;
    background: rgba(255,255,255,.2);
    border: 3px solid rgba(255,255,255,.4);
    border-radius: 28px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem;
    font-weight: 900;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 30px rgba(0,0,0,.2);
    margin: 0 auto .75rem;
    letter-spacing: 1px;
}

.db-hero-role-badge {
    background: rgba(255,255,255,.2);
    border: 1px solid rgba(255,255,255,.3);
    padding: .3rem .9rem;
    border-radius: 20px;
    font-size: .72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
}

/* ----- Stat Cards ----- */
.db-stat-card {
    border-radius: 22px;
    padding: 1.6rem 1.75rem;
    position: relative;
    overflow: hidden;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s;
    cursor: default;
    color: white;
    text-decoration: none;
    display: block;
}

.db-stat-card:hover {
    transform: translateY(-6px) scale(1.02);
    color: white;
}

.db-stat-card .sc-orb {
    position: absolute;
    right: -20px; bottom: -20px;
    width: 110px; height: 110px;
    background: rgba(255,255,255,.1);
    border-radius: 50%;
    pointer-events: none;
}

.db-stat-card .sc-orb2 {
    position: absolute;
    right: 20px; top: -30px;
    width: 70px; height: 70px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    pointer-events: none;
}

.sc-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,.2);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.1rem;
    border: 1.5px solid rgba(255,255,255,.25);
}

.sc-number {
    font-size: 2.5rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: .2rem;
    letter-spacing: -1px;
}

.sc-label {
    font-size: .73rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: .8;
}

.sc-trend {
    position: absolute;
    top: 1.4rem; right: 1.4rem;
    background: rgba(255,255,255,.2);
    border-radius: 20px;
    padding: .2rem .65rem;
    font-size: .68rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: .25rem;
}

/* ----- Section headers ----- */
.db-section-hdr {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
}

.db-section-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: .6rem;
}

.db-section-title i {
    width: 32px; height: 32px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem;
}

.db-section-link {
    font-size: .8rem;
    font-weight: 700;
    color: #6366f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: .3rem;
    transition: gap .2s;
}

.db-section-link:hover { gap: .6rem; color: #4f46e5; }

/* ----- Quick Action Cards ----- */
.db-quick-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media(max-width:576px) { .db-quick-grid { grid-template-columns: 1fr; } }

.db-quick-card {
    border-radius: 18px;
    padding: 1.4rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    border: 1.5px solid transparent;
    position: relative;
    overflow: hidden;
}

.db-quick-card::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity .2s;
    border-radius: inherit;
}

.db-quick-card:hover {
    transform: translateY(-4px) scale(1.015);
}

.db-quick-card:hover::before { opacity: 1; }

.db-quick-icon {
    width: 50px; height: 50px;
    border-radius: 15px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}

.db-quick-card:hover .db-quick-icon {
    transform: scale(1.12) rotate(-5deg);
}

.db-quick-label {
    font-size: .88rem;
    font-weight: 800;
    margin-bottom: .15rem;
}

.db-quick-desc {
    font-size: .72rem;
    font-weight: 500;
    opacity: .65;
}

.db-quick-arrow {
    margin-left: auto;
    font-size: .8rem;
    opacity: .4;
    transition: all .2s;
    flex-shrink: 0;
}

.db-quick-card:hover .db-quick-arrow { opacity: 1; transform: translateX(4px); }

/* ----- Info / Activity Panel ----- */
.db-info-card {
    background: white;
    border-radius: 22px;
    box-shadow: 0 2px 12px rgba(0,0,0,.05), 0 8px 30px rgba(0,0,0,.04);
    border: 1px solid #eef2f7;
    overflow: hidden;
}

.db-info-header {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid #f0f0fa;
    background: #fafaff;
}

.db-info-body { padding: 1.25rem 1.75rem; }

/* Progress stats */
.db-progress-row {
    margin-bottom: 1.1rem;
}

.db-progress-row:last-child { margin-bottom: 0; }

.db-progress-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .45rem;
}

.db-progress-label {
    font-size: .82rem;
    font-weight: 700;
    color: #374151;
    display: flex;
    align-items: center;
    gap: .4rem;
}

.db-progress-label i {
    font-size: .75rem;
}

.db-progress-val {
    font-size: .8rem;
    font-weight: 800;
    color: #0f172a;
}

.db-progress-bar {
    height: 8px;
    background: #f1f5f9;
    border-radius: 10px;
    overflow: hidden;
}

.db-progress-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 1.2s cubic-bezier(.25,.46,.45,.94);
}

/* System info items */
.db-info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .85rem 0;
    border-bottom: 1px solid #f8f9ff;
}

.db-info-item:last-child { border-bottom: none; }

.db-info-icon {
    width: 38px; height: 38px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    flex-shrink: 0;
}

.db-info-text { flex: 1; }
.db-info-text .it-label { font-size: .75rem; color: #94a3b8; font-weight: 600; margin-bottom: 2px; }
.db-info-text .it-val { font-size: .875rem; font-weight: 700; color: #1e293b; }

.db-info-badge {
    font-size: .68rem;
    font-weight: 800;
    padding: .2rem .65rem;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* ----- Layout grid ----- */
.db-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.75rem;
    align-items: start;
}

@media(max-width:900px) { .db-grid { grid-template-columns: 1fr; } }

/* Animations */
@keyframes dbFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.db-hero        { animation: dbFadeUp .5s ease both; }
.db-stat-row    { animation: dbFadeUp .5s .1s ease both; }
.db-main-col    { animation: dbFadeUp .5s .2s ease both; }
.db-side-col    { animation: dbFadeUp .5s .3s ease both; }

/* Counter animation */
.count-up { display: inline-block; }

/* DateTime */
.db-datetime {
    font-size: .78rem;
    color: rgba(255,255,255,.65);
    font-weight: 500;
    margin-top: .5rem;
}
</style>

{{-- ════════════════════════════════════════════
     GREETING HERO
     ════════════════════════════════════════════ --}}
<div class="db-hero">
    <div class="db-hero-noise"></div>
    <div class="db-hero-orb1"></div>
    <div class="db-hero-orb2"></div>
    <div class="db-hero-orb3"></div>

    <div class="db-hero-content">
        <div class="db-hero-left">
            <div class="db-hero-greeting">
                <span class="dot"></span>
                @php
                    $hour = now()->setTimezone('Asia/Jakarta')->hour;
                    if ($hour >= 5 && $hour < 12)       $greet = 'Selamat Pagi';
                    elseif ($hour >= 12 && $hour < 15)  $greet = 'Selamat Siang';
                    elseif ($hour >= 15 && $hour < 18)  $greet = 'Selamat Sore';
                    else                                 $greet = 'Selamat Malam';
                @endphp
                {{ $greet }}, Selamat Datang!
            </div>
            <h1 class="db-hero-name">{{ auth()->user()->username }} 👋</h1>
            <p class="db-hero-sub">Pantau dan kelola seluruh data akademik sekolah dari satu tempat.</p>
            <div class="db-hero-badges">
                <span class="db-badge">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                </span>
                <span class="db-badge">
                    <i class="bi bi-clock"></i>
                    <span id="liveClock">{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }}</span>
                </span>
                <span class="db-badge">
                    <i class="bi bi-mortarboard-fill"></i>
                    School Management System
                </span>
            </div>
        </div>

        <div class="db-hero-right">
            <div class="db-hero-avatar">
                {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
            </div>
            <div class="db-hero-role-badge">
                <i class="bi bi-shield-check me-1"></i>{{ ucfirst(auth()->user()->role) }}
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     STAT CARDS
     ════════════════════════════════════════════ --}}
<div class="row g-3 mb-4 db-stat-row">
    {{-- Students --}}
    <div class="col-sm-6 col-xl-3">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('students.index') }}" class="db-stat-card" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);box-shadow:0 8px 30px rgba(99,102,241,.45);">
        @else
        <div class="db-stat-card" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);box-shadow:0 8px 30px rgba(99,102,241,.45);">
        @endif
            <div class="sc-orb"></div>
            <div class="sc-orb2"></div>
            <div class="sc-trend"><i class="bi bi-people"></i> Active</div>
            <div class="sc-icon"><i class="bi bi-people-fill"></i></div>
            <div class="sc-number count-up" data-target="{{ $studentsCount }}">0</div>
            <div class="sc-label">Total Siswa</div>
        @if(auth()->user()->role === 'admin') </a> @else </div> @endif
    </div>

    {{-- Teachers --}}
    @if(auth()->user()->role === 'admin')
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('teachers.index') }}" class="db-stat-card" style="background:linear-gradient(135deg,#059669,#10b981);box-shadow:0 8px 30px rgba(5,150,105,.4);">
            <div class="sc-orb"></div>
            <div class="sc-orb2"></div>
            <div class="sc-trend"><i class="bi bi-person-workspace"></i> Staff</div>
            <div class="sc-icon"><i class="bi bi-person-workspace"></i></div>
            <div class="sc-number count-up" data-target="{{ $teachersCount }}">0</div>
            <div class="sc-label">Total Guru</div>
        </a>
    </div>
    @endif

    {{-- Classes --}}
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('classes.index') }}" class="db-stat-card" style="background:linear-gradient(135deg,#2563eb,#4f46e5);box-shadow:0 8px 30px rgba(37,99,235,.4);">
            <div class="sc-orb"></div>
            <div class="sc-orb2"></div>
            <div class="sc-trend"><i class="bi bi-building"></i> Active</div>
            <div class="sc-icon"><i class="bi bi-building-fill"></i></div>
            <div class="sc-number count-up" data-target="{{ $classesCount }}">0</div>
            <div class="sc-label">Total Kelas</div>
        </a>
    </div>

    {{-- Subjects --}}
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('subjects.index') }}" class="db-stat-card" style="background:linear-gradient(135deg,#dc2626,#ea580c);box-shadow:0 8px 30px rgba(220,38,38,.4);">
            <div class="sc-orb"></div>
            <div class="sc-orb2"></div>
            <div class="sc-trend"><i class="bi bi-book"></i> Active</div>
            <div class="sc-icon"><i class="bi bi-book-fill"></i></div>
            <div class="sc-number count-up" data-target="{{ $subjectsCount }}">0</div>
            <div class="sc-label">Mata Pelajaran</div>
        </a>
    </div>
</div>

{{-- ════════════════════════════════════════════
     MAIN GRID
     ════════════════════════════════════════════ --}}
<div class="db-grid">

    {{-- LEFT: Quick Actions --}}
    <div class="db-main-col">

        {{-- Quick Access --}}
        <div class="db-section-hdr">
            <h2 class="db-section-title">
                <span style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);color:#6366f1;" class="d-flex align-items-center justify-content-center" style="border-radius:9px;width:32px;height:32px;">
                    <i class="bi bi-grid-3x3-gap-fill" style="font-size:.9rem;"></i>
                </span>
                Akses Cepat
            </h2>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="db-quick-grid mb-4">
            {{-- Students --}}
            <a href="{{ route('students.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-color:#ddd6fe;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;box-shadow:0 4px 15px rgba(99,102,241,.4);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="db-quick-label" style="color:#4f46e5;">Students</div>
                    <div class="db-quick-desc">Kelola data siswa</div>
                </div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#6366f1;"></i>
            </a>

            {{-- Teachers --}}
            <a href="{{ route('teachers.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-color:#bbf7d0;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#059669,#10b981);color:white;box-shadow:0 4px 15px rgba(5,150,105,.4);">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div>
                    <div class="db-quick-label" style="color:#059669;">Teachers</div>
                    <div class="db-quick-desc">Kelola data guru</div>
                </div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#059669;"></i>
            </a>

            {{-- Classes --}}
            <a href="{{ route('classes.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border-color:#bfdbfe;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#2563eb,#4f46e5);color:white;box-shadow:0 4px 15px rgba(37,99,235,.4);">
                    <i class="bi bi-building-fill"></i>
                </div>
                <div>
                    <div class="db-quick-label" style="color:#2563eb;">Classes</div>
                    <div class="db-quick-desc">Kelola data kelas</div>
                </div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#2563eb;"></i>
            </a>

            {{-- Subjects --}}
            <a href="{{ route('subjects.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-color:#fecdd3;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#dc2626,#ea580c);color:white;box-shadow:0 4px 15px rgba(220,38,38,.4);">
                    <i class="bi bi-book-fill"></i>
                </div>
                <div>
                    <div class="db-quick-label" style="color:#dc2626;">Subjects</div>
                    <div class="db-quick-desc">Kelola mata pelajaran</div>
                </div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#dc2626;"></i>
            </a>
        </div>

        @elseif(auth()->user()->role === 'teacher')
        <div class="db-quick-grid mb-4">
            <a href="{{ route('students.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-color:#ddd6fe;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;box-shadow:0 4px 15px rgba(99,102,241,.4);"><i class="bi bi-people-fill"></i></div>
                <div><div class="db-quick-label" style="color:#4f46e5;">Students</div><div class="db-quick-desc">Lihat data siswa</div></div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#6366f1;"></i>
            </a>
            <a href="{{ route('classes.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border-color:#bfdbfe;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#2563eb,#4f46e5);color:white;box-shadow:0 4px 15px rgba(37,99,235,.4);"><i class="bi bi-building-fill"></i></div>
                <div><div class="db-quick-label" style="color:#2563eb;">Classes</div><div class="db-quick-desc">Lihat data kelas</div></div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#2563eb;"></i>
            </a>
            <a href="{{ route('subjects.index') }}" class="db-quick-card" style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-color:#fecdd3;color:#1e293b;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#dc2626,#ea580c);color:white;box-shadow:0 4px 15px rgba(220,38,38,.4);"><i class="bi bi-book-fill"></i></div>
                <div><div class="db-quick-label" style="color:#dc2626;">Subjects</div><div class="db-quick-desc">Lihat mata pelajaran</div></div>
                <i class="bi bi-arrow-right db-quick-arrow" style="color:#dc2626;"></i>
            </a>
        </div>
        @else
        <div class="db-quick-grid mb-4">
            <div class="db-quick-card" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-color:#ddd6fe;color:#1e293b;cursor:default;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:white;"><i class="bi bi-person-circle"></i></div>
                <div><div class="db-quick-label" style="color:#4f46e5;">My Profile</div><div class="db-quick-desc">Data profil saya</div></div>
            </div>
            <div class="db-quick-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-color:#bbf7d0;color:#1e293b;cursor:default;">
                <div class="db-quick-icon" style="background:linear-gradient(135deg,#059669,#10b981);color:white;"><i class="bi bi-building"></i></div>
                <div><div class="db-quick-label" style="color:#059669;">My Class</div><div class="db-quick-desc">Kelas saya</div></div>
            </div>
        </div>
        @endif

        {{-- Data Overview Progress --}}
        <div class="db-section-hdr">
            <h2 class="db-section-title">
                <span style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#2563eb;border-radius:9px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-bar-chart-fill" style="font-size:.85rem;"></i>
                </span>
                Overview Data
            </h2>
        </div>

        <div class="db-info-card">
            <div class="db-info-body">
                @php
                    $maxVal = max($studentsCount, $teachersCount, $classesCount, $subjectsCount, 1);
                @endphp

                <div class="db-progress-row">
                    <div class="db-progress-top">
                        <div class="db-progress-label"><i class="bi bi-people-fill" style="color:#6366f1;"></i> Siswa Terdaftar</div>
                        <div class="db-progress-val">{{ $studentsCount }}</div>
                    </div>
                    <div class="db-progress-bar">
                        <div class="db-progress-fill" style="width:0%;background:linear-gradient(90deg,#6366f1,#8b5cf6);" data-pct="{{ $maxVal > 0 ? round($studentsCount/$maxVal*100) : 0 }}"></div>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="db-progress-row">
                    <div class="db-progress-top">
                        <div class="db-progress-label"><i class="bi bi-person-workspace" style="color:#059669;"></i> Guru Terdaftar</div>
                        <div class="db-progress-val">{{ $teachersCount }}</div>
                    </div>
                    <div class="db-progress-bar">
                        <div class="db-progress-fill" style="width:0%;background:linear-gradient(90deg,#059669,#34d399);" data-pct="{{ $maxVal > 0 ? round($teachersCount/$maxVal*100) : 0 }}"></div>
                    </div>
                </div>
                @endif

                <div class="db-progress-row">
                    <div class="db-progress-top">
                        <div class="db-progress-label"><i class="bi bi-building-fill" style="color:#2563eb;"></i> Kelas Aktif</div>
                        <div class="db-progress-val">{{ $classesCount }}</div>
                    </div>
                    <div class="db-progress-bar">
                        <div class="db-progress-fill" style="width:0%;background:linear-gradient(90deg,#2563eb,#6366f1);" data-pct="{{ $maxVal > 0 ? round($classesCount/$maxVal*100) : 0 }}"></div>
                    </div>
                </div>

                <div class="db-progress-row">
                    <div class="db-progress-top">
                        <div class="db-progress-label"><i class="bi bi-book-fill" style="color:#dc2626;"></i> Mata Pelajaran</div>
                        <div class="db-progress-val">{{ $subjectsCount }}</div>
                    </div>
                    <div class="db-progress-bar">
                        <div class="db-progress-fill" style="width:0%;background:linear-gradient(90deg,#dc2626,#f97316);" data-pct="{{ $maxVal > 0 ? round($subjectsCount/$maxVal*100) : 0 }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: System Info --}}
    <div class="db-side-col">

        <div class="db-section-hdr">
            <h2 class="db-section-title">
                <span style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;border-radius:9px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-info-circle-fill" style="font-size:.85rem;"></i>
                </span>
                Informasi Sistem
            </h2>
        </div>

        <div class="db-info-card mb-3">
            <div class="db-info-body" style="padding-top:1rem;padding-bottom:1rem;">

                <div class="db-info-item">
                    <div class="db-info-icon" style="background:#ede9fe;color:#6366f1;"><i class="bi bi-person-fill"></i></div>
                    <div class="db-info-text">
                        <div class="it-label">Username</div>
                        <div class="it-val">{{ auth()->user()->username }}</div>
                    </div>
                </div>

                <div class="db-info-item">
                    <div class="db-info-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-envelope-fill"></i></div>
                    <div class="db-info-text">
                        <div class="it-label">Email</div>
                        <div class="it-val" style="font-size:.8rem;">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="db-info-item">
                    <div class="db-info-icon" style="background:#d1fae5;color:#059669;"><i class="bi bi-shield-check-fill"></i></div>
                    <div class="db-info-text">
                        <div class="it-label">Role Akses</div>
                        <div class="it-val">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                    @php
                        $roleColors = ['admin' => '#5b21b6:#ede9fe', 'teacher' => '#065f46:#d1fae5', 'student' => '#1e40af:#dbeafe'];
                        $rc = explode(':', $roleColors[auth()->user()->role] ?? '#374151:#f1f5f9');
                    @endphp
                    <span class="db-info-badge" style="color:{{ $rc[0] }};background:{{ $rc[1] }};">
                        {{ auth()->user()->role }}
                    </span>
                </div>

                <div class="db-info-item">
                    <div class="db-info-icon" style="background:#fff7ed;color:#ea580c;"><i class="bi bi-calendar-check-fill"></i></div>
                    <div class="db-info-text">
                        <div class="it-label">Bergabung Sejak</div>
                        <div class="it-val">{{ auth()->user()->created_at->translatedFormat('d M Y') }}</div>
                    </div>
                </div>

                <div class="db-info-item" style="border-bottom:none;">
                    <div class="db-info-icon" style="background:#f0fdf4;color:#15803d;"><i class="bi bi-circle-fill" style="font-size:.6rem;"></i></div>
                    <div class="db-info-text">
                        <div class="it-label">Status</div>
                        <div class="it-val">Online</div>
                    </div>
                    <span class="db-info-badge" style="color:#065f46;background:#d1fae5;">● Aktif</span>
                </div>
            </div>
        </div>

        {{-- System Summary Card --}}
        <div class="db-info-card">
            <div class="db-info-header">
                <div style="font-size:.82rem;font-weight:800;color:#1e293b;display:flex;align-items:center;gap:.5rem;">
                    <i class="bi bi-mortarboard-fill" style="color:#6366f1;"></i>
                    Ringkasan Akademik
                </div>
            </div>
            <div class="db-info-body" style="padding-top:1rem;padding-bottom:1rem;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    @php
                        $summary = [
                            ['val'=>$studentsCount, 'lbl'=>'Siswa',   'icon'=>'bi-people-fill',    'clr'=>'#6366f1', 'bg'=>'#ede9fe'],
                            ['val'=>$classesCount,  'lbl'=>'Kelas',   'icon'=>'bi-building-fill',  'clr'=>'#2563eb', 'bg'=>'#dbeafe'],
                            ['val'=>$subjectsCount, 'lbl'=>'Mapel',   'icon'=>'bi-book-fill',      'clr'=>'#dc2626', 'bg'=>'#fee2e2'],
                            ['val'=>auth()->user()->role==='admin' ? $teachersCount : '—', 'lbl'=>'Guru', 'icon'=>'bi-person-workspace', 'clr'=>'#059669', 'bg'=>'#d1fae5'],
                        ];
                    @endphp
                    @foreach($summary as $s)
                    <div style="background:{{ $s['bg'] }};border-radius:14px;padding:.9rem;text-align:center;">
                        <div style="color:{{ $s['clr'] }};font-size:1.5rem;margin-bottom:.2rem;"><i class="bi {{ $s['icon'] }}"></i></div>
                        <div style="font-size:1.3rem;font-weight:900;color:#0f172a;line-height:1;">{{ $s['val'] }}</div>
                        <div style="font-size:.68rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">{{ $s['lbl'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Live clock
function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const el = document.getElementById('liveClock');
    if (el) el.textContent = h + ':' + m;
}
setInterval(updateClock, 1000);

// Count-up animation
function animateCountUp(el) {
    const target = parseInt(el.dataset.target) || 0;
    const duration = 1200;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current);
        if (current >= target) clearInterval(timer);
    }, 16);
}

// Progress bar animation
function animateProgressBars() {
    document.querySelectorAll('.db-progress-fill').forEach(bar => {
        const pct = bar.dataset.pct || 0;
        setTimeout(() => { bar.style.width = pct + '%'; }, 300);
    });
}

// Intersection Observer for animations
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Count up
            entry.target.querySelectorAll('.count-up').forEach(animateCountUp);
            // Progress bars
            animateProgressBars();
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.db-stat-row, .db-info-card').forEach(el => observer.observe(el));

// Also trigger immediately for elements already in view
window.addEventListener('load', () => {
    document.querySelectorAll('.count-up').forEach(animateCountUp);
    setTimeout(animateProgressBars, 400);
});
</script>
@endsection