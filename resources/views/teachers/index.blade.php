@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Teachers</li>
@endsection

@section('content')
@include('_partials.page-styles')

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#059669 0%,#10b981 50%,#34d399 100%);border-radius:24px;padding:2.25rem 2.75rem;margin-bottom:2rem;position:relative;overflow:hidden;color:white;box-shadow:0 10px 40px rgba(5,150,105,.38);">
    <div class="hero-blob1"></div><div class="hero-blob2"></div><div class="hero-blob3"></div>
    <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
        <div>
            <div class="hero-icon-wrap"><i class="bi bi-person-workspace"></i></div>
            <h2 style="color:white;font-size:1.75rem;font-weight:800;margin:0 0 .3rem;letter-spacing:-.5px;">Data Guru</h2>
            <p style="color:rgba(255,255,255,.75);font-size:.88rem;margin:0 0 1.25rem;">Kelola seluruh data guru dan pengampu mata pelajaran</p>
            @php $totalGuru = $teachers->count(); @endphp
            <div class="hero-stats">
                <div class="hero-stat"><span class="s-num">{{ $totalGuru }}</span><span class="s-lbl">Total Guru</span></div>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('teachers.create') }}" class="btn-hero-add" style="color:#065f46;">
                <i class="bi bi-plus-circle-fill"></i> Tambah Guru
            </a>
        @endif
    </div>
</div>

{{-- TABLE CARD --}}
<div class="pg-card">
    <div class="pg-toolbar">
        <div class="d-flex align-items-center gap-2">
            <span class="pg-toolbar-title">Daftar Guru</span>
            <span class="pg-count-pill" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#065f46;border-color:#6ee7b7;">{{ $totalGuru }} guru</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table pg-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Email</th>
                    @if(auth()->user()->role === 'admin')<th class="text-center" style="width:110px;">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $index => $teacher)
                    <tr style="animation-delay:{{ $index * 0.05 }}s;">
                        <td><span class="row-chip">{{ $index + 1 }}</span></td>
                        <td><span class="nip-chip"><i class="bi bi-person-vcard" style="font-size:.65rem;"></i>{{ $teacher->nip }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-avatar" style="background:linear-gradient(135deg,#059669,#10b981);">{{ strtoupper(substr($teacher->full_name,0,2)) }}</div>
                                <div>
                                    <div style="font-weight:700;color:#0f172a;font-size:.9rem;">{{ $teacher->full_name }}</div>
                                    <div style="font-size:.72rem;color:#94a3b8;font-weight:500;">Guru</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($teacher->subject_name)
                                <span class="subj-badge"><i class="bi bi-book-fill" style="font-size:.65rem;"></i>{{ $teacher->subject_name }}</span>
                            @else
                                <span class="empty-val">— belum ada mapel —</span>
                            @endif
                        </td>
                        <td style="color:#64748b;font-size:.83rem;">
                            @if($teacher->email)
                                <div class="d-flex align-items-center gap-1">
                                    <i class="bi bi-envelope" style="color:#94a3b8;font-size:.75rem;"></i>
                                    {{ $teacher->email }}
                                </div>
                            @else
                                <span class="empty-val">—</span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="act-wrap">
                                    <a href="{{ route('teachers.edit', $teacher->teacher_id) }}" class="act-btn edit" data-tip="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" data-tip="Hapus" onclick="return confirm('Yakin hapus guru {{ $teacher->full_name }}?')"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="p-0">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-person-workspace"></i></div>
                            <h6>Belum ada guru terdaftar</h6>
                            <p>Tambahkan guru pertama untuk mulai mengelola data akademik</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
