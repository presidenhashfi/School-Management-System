@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Guru</li>
@endsection

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $totalGuru = $teachers->count();
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Data Guru</h1>
        <p class="ph-sub">Kelola seluruh data guru dan pengampu mata pelajaran.</p>
    </div>
    @if($isAdmin)
        <a href="{{ route('teachers.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Guru</a>
    @endif
</div>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Daftar Guru <span class="pill">{{ $totalGuru }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Email</th>
                    @if($isAdmin)<th class="t-right">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $index => $teacher)
                    <tr>
                        <td class="num">{{ $index + 1 }}</td>
                        <td data-label="NIP"><span class="tag tag-mono">{{ $teacher->nip }}</span></td>
                        <td class="cell-primary" data-label="Guru">
                            <div class="cell-main">
                                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($teacher->full_name, 0, 2)) }}</div>
                                <div style="min-width:0">
                                    <div class="cell-name">{{ $teacher->full_name }}</div>
                                    <div class="cell-sub">Guru</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Mapel">
                            @if($teacher->subject_name)
                                <span class="tag tag-accent">{{ $teacher->subject_name }}</span>
                            @else
                                <span class="muted-val">Belum ada mapel</span>
                            @endif
                        </td>
                        <td data-label="Email">
                            @if($teacher->email)
                                <span style="overflow-wrap:anywhere">{{ $teacher->email }}</span>
                            @else
                                <span class="muted-val">—</span>
                            @endif
                        </td>
                        @if($isAdmin)
                            <td class="cell-actions t-right">
                                <div class="act-wrap">
                                    <a href="{{ route('teachers.edit', $teacher->teacher_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $teacher->full_name }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" title="Hapus" aria-label="Hapus {{ $teacher->full_name }}" onclick="return confirm('Yakin hapus guru {{ $teacher->full_name }}?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></div>
                                <h3>Belum ada guru terdaftar</h3>
                                <p>Tambahkan guru pertama untuk mulai mengelola data akademik.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
