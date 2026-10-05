@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kelas</li>
@endsection

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $totalKelas = $classes->count();
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Data Kelas</h1>
        <p class="ph-sub">Kelola seluruh kelas dan wali kelas.</p>
    </div>
    @if($isAdmin)
        <a href="{{ route('classes.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Kelas</a>
    @endif
</div>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Daftar Kelas <span class="pill">{{ $totalKelas }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Tahun Ajaran</th>
                    @if($isAdmin)<th class="t-right">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $index => $class)
                    <tr>
                        <td class="num">{{ $index + 1 }}</td>
                        <td class="cell-primary" data-label="Kelas">
                            <div class="cell-main">
                                <div class="avatar" aria-hidden="true"><i class="bi bi-building"></i></div>
                                <span class="cell-name">{{ $class->class_name }}</span>
                            </div>
                        </td>
                        <td data-label="Wali Kelas">
                            @if($class->homeroom)
                                <div class="cell-main">
                                    <div class="avatar" style="width:26px;height:26px;font-size:.6rem" aria-hidden="true">{{ strtoupper(substr($class->homeroom, 0, 2)) }}</div>
                                    <span>{{ $class->homeroom }}</span>
                                </div>
                            @else
                                <span class="muted-val">Belum ada wali kelas</span>
                            @endif
                        </td>
                        <td data-label="Tahun Ajaran"><span class="tag tag-mono">{{ $class->academic_year }}</span></td>
                        @if($isAdmin)
                            <td class="cell-actions t-right">
                                <div class="act-wrap">
                                    <a href="{{ route('classes.edit', $class->class_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $class->class_name }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('classes.destroy', $class->class_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" title="Hapus" aria-label="Hapus {{ $class->class_name }}" onclick="return confirm('Yakin hapus kelas {{ $class->class_name }}?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 5 : 4 }}" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-building" aria-hidden="true"></i></div>
                                <h3>Belum ada kelas terdaftar</h3>
                                <p>Tambahkan kelas pertama untuk mulai mengelola data akademik.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
