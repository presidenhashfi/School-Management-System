@extends('layouts.app')

@section('title', 'Manajemen Mata Pelajaran')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Mapel</li>
@endsection

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $totalSubj = $subjects->count();
    $totalSks = $subjects->sum('credits');
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Mata Pelajaran</h1>
        <p class="ph-sub">Kelola seluruh mata pelajaran yang tersedia di sekolah.</p>
    </div>
    @if($isAdmin)
        <a href="{{ route('subjects.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Mapel</a>
    @endif
</div>

<section class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));max-width:420px" aria-label="Ringkasan">
    <div class="stat" style="padding:var(--s4)"><div class="stat-num">{{ $totalSubj }}</div><div class="stat-label">Total mapel</div></div>
    <div class="stat" style="padding:var(--s4)"><div class="stat-num">{{ $totalSks }}</div><div class="stat-label">Total SKS</div></div>
</section>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Daftar Mata Pelajaran <span class="pill">{{ $totalSubj }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Mata Pelajaran</th>
                    <th class="t-center">Tingkat</th>
                    <th class="t-center">SKS</th>
                    @if($isAdmin)<th class="t-right">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $index => $subject)
                    <tr>
                        <td class="num">{{ $index + 1 }}</td>
                        <td data-label="Kode"><span class="tag tag-mono">{{ $subject->subject_code }}</span></td>
                        <td class="cell-primary" data-label="Mapel">
                            <div class="cell-main">
                                <div class="avatar" aria-hidden="true"><i class="bi bi-journal-text"></i></div>
                                <span class="cell-name">{{ $subject->subject_name }}</span>
                            </div>
                        </td>
                        <td class="t-center" data-label="Tingkat">@if($subject->grade)<span class="tag">{{ $subject->grade }}</span>@else<span class="muted-val">Belum diatur</span>@endif</td>
                        <td class="t-center" data-label="SKS"><span class="tag tag-accent">{{ number_format($subject->credits, 0, ',', '.') }} SKS</span></td>
                        @if($isAdmin)
                            <td class="cell-actions t-right">
                                <div class="act-wrap">
                                    <a href="{{ route('subjects.edit', $subject->subject_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $subject->subject_name }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('subjects.destroy', $subject->subject_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" title="Hapus" aria-label="Hapus {{ $subject->subject_name }}" onclick="return confirm('Yakin hapus mapel {{ $subject->subject_name }}?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></div>
                                <h3>Belum ada mata pelajaran</h3>
                                <p>Tambahkan mata pelajaran pertama untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
