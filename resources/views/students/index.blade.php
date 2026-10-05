@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Students</li>
@endsection

@section('content')
<style>


/* ----- Hero Banner ----- */
.si-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 45%, #a855f7 100%);
    border-radius: 24px;
    padding: 2.25rem 2.75rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(99,102,241,0.35);
}

.si-hero-noise {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
}

.si-hero-blob1 {
    position: absolute;
    width: 280px; height: 280px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    top: -100px; right: -60px;
    pointer-events: none;
}

.si-hero-blob2 {
    position: absolute;
    width: 160px; height: 160px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    bottom: -60px; right: 200px;
    pointer-events: none;
}

.si-hero-blob3 {
    position: absolute;
    width: 80px; height: 80px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
    top: 20px; left: 60%;
    pointer-events: none;
}

.si-hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.si-hero-left { flex: 1; }

.si-hero-icon-wrap {
    width: 60px; height: 60px;
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem;
    color: white;
    margin-bottom: 1.1rem;
    backdrop-filter: blur(6px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.si-hero h2 {
    color: white;
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0 0 0.3rem;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.si-hero p {
    color: rgba(255,255,255,0.75);
    font-size: 0.88rem;
    margin: 0 0 1.25rem;
}

.si-hero-stats {
    display: flex;
    gap: 1.25rem;
    flex-wrap: wrap;
}

.si-hero-stat {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px;
    padding: 0.5rem 1rem;
    backdrop-filter: blur(6px);
    text-align: center;
}

.si-hero-stat .s-num {
    display: block;
    color: white;
    font-size: 1.3rem;
    font-weight: 800;
    line-height: 1;
}

.si-hero-stat .s-lbl {
    color: rgba(255,255,255,0.7);
    font-size: 0.68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.7px;
}

.btn-hero-add {
    background: white;
    color: #5b21b6;
    border: none;
    padding: 0.8rem 1.75rem;
    border-radius: 14px;
    font-weight: 800;
    font-size: 0.88rem;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.18);
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-hero-add:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    color: #4f46e5;
}

.btn-hero-add i {
    font-size: 1rem;
}

/* ----- Table Card ----- */
.si-card {
    background: white;
    border-radius: 22px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05), 0 8px 32px rgba(0,0,0,0.04);
    overflow: hidden;
    border: 1px solid #eef2f7;
}

.si-card-toolbar {
    padding: 1.1rem 1.75rem;
    background: #fafaff;
    border-bottom: 1px solid #f0f0fa;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.si-toolbar-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.si-toolbar-title {
    font-weight: 700;
    font-size: 0.92rem;
    color: #1e293b;
}

.si-count-pill {
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    color: #5b21b6;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #c4b5fd;
    letter-spacing: 0.3px;
}

/* Table */
.si-table { margin: 0; }

.si-table thead th {
    background: #f8f9ff;
    border-bottom: 1.5px solid #eef2f7;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-weight: 800;
    color: #94a3b8;
    padding: 0.9rem 1.5rem;
    white-space: nowrap;
}

.si-table tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border-color: #f8f9ff;
    font-size: 0.875rem;
    color: #374151;
}

.si-table tbody tr {
    transition: all 0.18s ease;
    border-bottom: 1px solid #f8f9ff;
}

.si-table tbody tr:hover {
    background: linear-gradient(90deg, #fafbff 0%, #f5f3ff 100%);
    transform: none;
}

.si-table tbody tr:last-child { border-bottom: none; }

/* Row number */
.row-num-chip {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    color: #94a3b8;
}

/* Student cell */
.student-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.s-avatar {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 0.78rem;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(99,102,241,0.35);
    letter-spacing: 0.5px;
}

.s-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.9rem;
    line-height: 1.2;
}

.s-sub {
    font-size: 0.72rem;
    color: #94a3b8;
    font-weight: 500;
    margin-top: 1px;
}

/* NIS chip */
.nis-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-family: 'Courier New', monospace;
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    color: #0369a1;
    border: 1px solid #bae6fd;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.nis-chip i { font-size: 0.65rem; }

/* Class badge */
.class-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    color: #5b21b6;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 700;
    border: 1px solid #c4b5fd;
}

/* Date */
.date-cell {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: #94a3b8;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Action buttons */
.act-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}

.act-btn {
    width: 34px; height: 34px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    transition: all 0.22s cubic-bezier(.34,1.56,.64,1);
    text-decoration: none;
    cursor: pointer;
    position: relative;
}

.act-btn::after {
    content: attr(data-tip);
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%; transform: translateX(-50%) scale(0.8);
    background: #1e293b;
    color: white;
    font-size: 0.65rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s;
    letter-spacing: 0.3px;
}

.act-btn:hover::after {
    opacity: 1;
    transform: translateX(-50%) scale(1);
}

.act-btn.edit {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}

.act-btn.edit:hover {
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: white;
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 6px 16px rgba(245,158,11,0.45);
}

.act-btn.del {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
}

.act-btn.del:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 6px 16px rgba(239,68,68,0.45);
}

/* Empty state */
.si-empty {
    padding: 5rem 2rem;
    text-align: center;
}

.si-empty-icon {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 28px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: #cbd5e1;
    margin-bottom: 1.5rem;
    border: 2px dashed #e2e8f0;
}

.si-empty h6 {
    color: #475569;
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 0.4rem;
}

.si-empty p {
    color: #94a3b8;
    font-size: 0.83rem;
    margin: 0;
}

/* Scroll fade */
@keyframes rowFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.si-table tbody tr { animation: rowFadeIn 0.3s ease both; }
.si-table tbody tr:nth-child(1)  { animation-delay: .04s; }
.si-table tbody tr:nth-child(2)  { animation-delay: .08s; }
.si-table tbody tr:nth-child(3)  { animation-delay: .12s; }
.si-table tbody tr:nth-child(4)  { animation-delay: .16s; }
.si-table tbody tr:nth-child(5)  { animation-delay: .20s; }
.si-table tbody tr:nth-child(6)  { animation-delay: .24s; }
.si-table tbody tr:nth-child(7)  { animation-delay: .28s; }
.si-table tbody tr:nth-child(8)  { animation-delay: .32s; }
.si-table tbody tr:nth-child(9)  { animation-delay: .36s; }
.si-table tbody tr:nth-child(10) { animation-delay: .40s; }
.si-table tbody tr:nth-child(11) { animation-delay: .44s; }
.si-table tbody tr:nth-child(12) { animation-delay: .48s; }
.si-table tbody tr:nth-child(13) { animation-delay: .52s; }
.si-table tbody tr:nth-child(14) { animation-delay: .56s; }
.si-table tbody tr:nth-child(15) { animation-delay: .60s; }
</style>

{{-- ═══ HERO ═══ --}}
<div class="si-hero">
    <div class="si-hero-noise"></div>
    <div class="si-hero-blob1"></div>
    <div class="si-hero-blob2"></div>
    <div class="si-hero-blob3"></div>

    <div class="si-hero-content">
        <div class="si-hero-left">
            <div class="si-hero-icon-wrap">
                <i class="bi bi-people-fill"></i>
            </div>
            <h2>Data Siswa</h2>
            <p>Kelola seluruh data siswa sekolah dengan mudah dan terorganisir</p>
            @php
                $totalSiswa  = $students->count();
                $punyaKelas  = $students->filter(fn($s) => !empty($s->class_name))->count();
            @endphp
            <div class="si-hero-stats">
                <div class="si-hero-stat">
                    <span class="s-num">{{ $totalSiswa }}</span>
                    <span class="s-lbl">Total Siswa</span>
                </div>
                <div class="si-hero-stat">
                    <span class="s-num">{{ $punyaKelas }}</span>
                    <span class="s-lbl">Punya Kelas</span>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('students.create') }}" class="btn-hero-add">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Siswa
            </a>
        @endif
    </div>
</div>

{{-- ═══ TABLE CARD ═══ --}}
<div class="si-card">
    <div class="si-card-toolbar">
        <div class="si-toolbar-left">
            <span class="si-toolbar-title">Daftar Siswa</span>
            <span class="si-count-pill">{{ $students->count() }} siswa</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table si-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Tgl Daftar</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="text-center" style="width:110px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                    <tr style="animation-delay: {{ $index * 0.05 }}s;">
                        <td>
                            <span class="row-num-chip">{{ $index + 1 }}</span>
                        </td>
                        <td>
                            <div class="student-cell">
                                <div class="s-avatar">{{ strtoupper(substr($student->full_name, 0, 2)) }}</div>
                                <div>
                                    <div class="s-name">{{ $student->full_name }}</div>
                                    <div class="s-sub">{{ $student->email ?? 'Siswa' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="nis-chip">
                                <i class="bi bi-upc-scan"></i>
                                {{ $student->nis }}
                            </span>
                        </td>
                        <td>
                            @if($student->class_name)
                                <span class="class-badge">
                                    <i class="bi bi-mortarboard-fill" style="font-size:0.65rem;"></i>
                                    {{ $student->class_name }}
                                </span>
                            @else
                                <span style="color:#e2e8f0; font-size:0.8rem; font-style:italic;">— tidak ada —</span>
                            @endif
                        </td>
                        <td>
                            <div class="date-cell">
                                <i class="bi bi-calendar3"></i>
                                {{ \Carbon\Carbon::parse($student->created_at)->translatedFormat('d M Y') }}
                            </div>
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="act-wrap">
                                    <a href="{{ route('students.edit', $student->student_id) }}"
                                       class="act-btn edit" data-tip="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student->student_id) }}"
                                          method="POST" class="d-inline" id="del-{{ $student->student_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="act-btn del" data-tip="Hapus"
                                            onclick="return confirm('Yakin hapus siswa {{ $student->full_name }}?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="p-0">
                            <div class="si-empty">
                                <div class="si-empty-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6>Belum ada siswa terdaftar</h6>
                                <p>Tambahkan siswa pertama untuk mulai mengelola data akademik</p>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('students.create') }}" class="btn-hero-add mt-3 d-inline-flex"
                                       style="background: linear-gradient(135deg,#6366f1,#8b5cf6); color:white; box-shadow: 0 4px 15px rgba(99,102,241,0.4);">
                                        <i class="bi bi-plus-circle-fill"></i> Tambah Sekarang
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection