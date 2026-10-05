@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Siswa</li>
@endsection

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $totalSiswa = $students->count();
    $punyaKelas = $students->filter(fn($s) => !empty($s->class_name))->count();
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Data Siswa</h1>
        <p class="ph-sub">Kelola seluruh data siswa sekolah dengan mudah dan terorganisir.</p>
    </div>
    @if($isAdmin)
        <a href="{{ route('students.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Siswa</a>
    @endif
</div>

<section class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));max-width:420px" aria-label="Ringkasan">
    <div class="stat" style="padding:var(--s4)"><div class="stat-num">{{ $totalSiswa }}</div><div class="stat-label">Total siswa</div></div>
    <div class="stat" style="padding:var(--s4)"><div class="stat-num">{{ $punyaKelas }}</div><div class="stat-label">Sudah punya kelas</div></div>
</section>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Daftar Siswa <span class="pill">{{ $totalSiswa }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Tgl Daftar</th>
                    @if($isAdmin)<th class="t-right">Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                    <tr>
                        <td class="num">{{ $index + 1 }}</td>
                        <td class="cell-primary" data-label="Siswa">
                            <div class="cell-main">
                                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($student->full_name, 0, 2)) }}</div>
                                <div style="min-width:0">
                                    <div class="cell-name">{{ $student->full_name }}</div>
                                    <div class="cell-sub">{{ $student->email ?? 'Siswa' }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="NIS"><span class="tag tag-mono">{{ $student->nis }}</span></td>
                        <td data-label="Kelas">
                            @if($student->class_name)
                                <span class="tag tag-accent">{{ $student->class_name }}</span>
                            @else
                                <span class="muted-val">Belum ada kelas</span>
                            @endif
                        </td>
                        <td data-label="Tgl Daftar"><span class="muted-val">{{ \Carbon\Carbon::parse($student->created_at)->translatedFormat('d M Y') }}</span></td>
                        @if($isAdmin)
                            <td class="cell-actions t-right">
                                <div class="act-wrap">
                                    <a href="{{ route('students.edit', $student->student_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $student->full_name }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" id="del-{{ $student->student_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="act-btn del" title="Hapus" aria-label="Hapus {{ $student->full_name }}"
                                            onclick="return confirm('Yakin hapus siswa {{ $student->full_name }}?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-people" aria-hidden="true"></i></div>
                                <h3>Belum ada siswa terdaftar</h3>
                                <p>Tambahkan siswa pertama untuk mulai mengelola data akademik.</p>
                                @if($isAdmin)
                                    <a href="{{ route('students.create') }}" class="btn-ui btn-ui-primary mt-3"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Siswa</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
