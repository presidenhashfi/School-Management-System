@extends('layouts.app')

@section('title', 'Manajemen Mata Pelajaran')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Subjects</li>
@endsection

@section('content')
@include('_partials.page-styles')

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#dc2626 0%,#ea580c 50%,#f59e0b 100%);border-radius:24px;padding:2.25rem 2.75rem;margin-bottom:2rem;position:relative;overflow:hidden;color:white;box-shadow:0 10px 40px rgba(220,38,38,.35);">
    <div class="hero-blob1"></div><div class="hero-blob2"></div><div class="hero-blob3"></div>
    <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
        <div>
            <div class="hero-icon-wrap"><i class="bi bi-book-fill"></i></div>
            <h2 style="color:white;font-size:1.75rem;font-weight:800;margin:0 0 .3rem;letter-spacing:-.5px;">Data Mata Pelajaran</h2>
            <p style="color:rgba(255,255,255,.75);font-size:.88rem;margin:0 0 1.25rem;">Kelola seluruh mata pelajaran yang tersedia di sekolah</p>
            @php $totalSubj = $subjects->count(); $totalSks = $subjects->sum('credits'); @endphp
            <div class="hero-stats">
                <div class="hero-stat"><span class="s-num">{{ $totalSubj }}</span><span class="s-lbl">Total Mapel</span></div>
                <div class="hero-stat"><span class="s-num">{{ $totalSks }}</span><span class="s-lbl">Total SKS</span></div>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('subjects.create') }}" class="btn-hero-add" style="color:#9a3412;">
                <i class="bi bi-plus-circle-fill"></i> Tambah Mapel
            </a>
        @endif
    </div>
</div>

{{-- TABLE CARD --}}
<div class="pg-card">
    <div class="pg-toolbar">
        <div class="d-flex align-items-center gap-2">
            <span class="pg-toolbar-title">Daftar Mata Pelajaran</span>
            <span class="pg-count-pill" style="background:linear-gradient(135deg,#fee2e2,#fecaca);color:#9f1239;border-color:#fca5a5;">{{ $totalSubj }} mapel</span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table pg-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Kode</th>
                    <th>Nama Mata Pelajaran</th>
                    <th class="text-center">SKS</th>
                    @if(auth()->user()->role === 'admin')<th class="text-center" style="width:110px;">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $index => $subject)
                    <tr style="animation-delay:{{ $index * 0.05 }}s;">
                        <td><span class="row-chip">{{ $index + 1 }}</span></td>
                        <td><span class="code-chip"><i class="bi bi-hash" style="font-size:.65rem;"></i>{{ $subject->subject_code }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="item-avatar" style="background:linear-gradient(135deg,#dc2626,#f97316);">
                                    <i class="bi bi-journal-text" style="font-size:.85rem;"></i>
                                </div>
                                <span style="font-weight:700;color:#0f172a;">{{ $subject->subject_name }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="sks-badge">
                                <i class="bi bi-clock" style="font-size:.65rem;"></i>
                                {{ number_format($subject->credits, 0, ',', '.') }} SKS
                            </span>
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td>
                                <div class="act-wrap">
                                    <a href="{{ route('subjects.edit', $subject->subject_id) }}" class="act-btn edit" data-tip="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('subjects.destroy', $subject->subject_id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" data-tip="Hapus" onclick="return confirm('Yakin hapus mapel {{ $subject->subject_name }}?')"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="p-0">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-book"></i></div>
                            <h6>Belum ada mata pelajaran</h6>
                            <p>Tambahkan mata pelajaran pertama untuk memulai</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection