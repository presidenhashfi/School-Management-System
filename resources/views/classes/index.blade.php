@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Classes</li>
@endsection

@section('content')
@include('_partials.page-styles')


{{-- HERO --}}
<div style="background:linear-gradient(135deg,#2563eb 0%,#4f46e5 50%,#7c3aed 100%);border-radius:24px;padding:2.25rem 2.75rem;margin-bottom:2rem;position:relative;overflow:hidden;color:white;box-shadow:0 10px 40px rgba(37,99,235,.38);">
    <div class="hero-blob1"></div><div class="hero-blob2"></div><div class="hero-blob3"></div>
    <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
        <div>
            <div class="hero-icon-wrap"><i class="bi bi-building-fill"></i></div>
            <h2 style="color:white;font-size:1.75rem;font-weight:800;margin:0 0 0.3rem;letter-spacing:-0.5px;">Data Kelas</h2>
            <p style="color:rgba(255,255,255,.75);font-size:.88rem;margin:0 0 1.25rem;">Kelola seluruh kelas dan wali kelas</p>
            @php $totalKelas = $classes->count(); @endphp
            <div class="hero-stats">
                <div class="hero-stat"><span class="s-num">{{ $totalKelas }}</span><span class="s-lbl">Total Kelas</span></div>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('classes.create') }}" class="btn-hero-add">
                <i class="bi bi-plus-circle-fill"></i> Tambah Kelas
            </a>
        @endif
    </div>
</div>

{{-- TABLE CARD --}}
<div class="pg-card">
    <div class="pg-toolbar">
        <div class="d-flex align-items-center gap-2">
            <span class="pg-toolbar-title">Daftar Kelas</span>
            <span class="pg-count-pill">{{ $totalKelas }} kelas</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table pg-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Tahun Ajaran</th>
                    @if(auth()->user()->role === 'admin')<th class="text-center" style="width:110px;">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $index => $class)
                    <tr style="animation-delay:{{ $index * 0.05 }}s;">
                        <td><span class="row-chip">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-avatar" style="background:linear-gradient(135deg,#3b82f6,#6366f1);">
                                    <i class="bi bi-building" style="font-size:.85rem;"></i>
                                </div>
                                <span style="font-weight:700;color:#0f172a;">{{ $class->class_name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($class->homeroom)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="teacher-mini-avatar">{{ strtoupper(substr($class->homeroom, 0, 2)) }}</div>
                                    <span style="font-size:.875rem;font-weight:500;color:#374151;">{{ $class->homeroom }}</span>
                                </div>
                            @else
                                <span class="empty-val">— belum ada wali kelas —</span>
                            @endif
                        </td>
                        <td>
                            <span class="year-badge">
                                <i class="bi bi-calendar3" style="font-size:.65rem;"></i>
                                {{ $class->academic_year }}
                            </span>
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="act-wrap">
                                    <a href="{{ route('classes.edit', $class->class_id) }}" class="act-btn edit" data-tip="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('classes.destroy', $class->class_id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" data-tip="Hapus" onclick="return confirm('Yakin hapus kelas {{ $class->class_name }}?')"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="p-0">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-building"></i></div>
                            <h6>Belum ada kelas terdaftar</h6>
                            <p>Tambahkan kelas pertama untuk mulai mengelola data akademik</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
