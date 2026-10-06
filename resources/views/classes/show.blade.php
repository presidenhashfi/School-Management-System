@extends('layouts.app')

@section('title', 'Ruang Kelas ' . $class->class_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    @if(auth()->user()->role !== 'student')
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">{{ $class->class_name }}</li>
@endsection

@section('content')
@php
    $role = auth()->user()->role;
    $canManage = in_array($role, ['admin', 'teacher']);
    $totalAssignments = $assignments->flatten()->count();
@endphp

{{-- Classroom Hero Banner --}}
<div class="classroom-banner">
    <div class="classroom-banner-inner">
        <div>
            <div class="classroom-badge">
                <i class="bi bi-mortarboard-fill" aria-hidden="true"></i> Kelas {{ $class->grade ?? '-' }} · TA {{ $class->academic_year }}
            </div>
            <h1 class="classroom-title">Ruang {{ $class->class_name }}</h1>
            <div class="classroom-teacher">
                <i class="bi bi-person-badge-fill" aria-hidden="true"></i>
                <span>Wali Kelas: <strong>{{ $homeroom->full_name ?? 'Belum ditentukan' }}</strong></span>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">
            @if($role !== 'student' && $siblings->count() > 1)
                <div class="d-flex align-items-center gap-2 bg-white rounded-pill px-3 py-1 shadow-sm">
                    <label for="switchClass" class="m-0 text-muted" style="font-size:.76rem;font-weight:700">Pindah Rombel:</label>
                    <select id="switchClass" class="form-select border-0 p-0 m-0" style="width:auto;font-weight:800;font-size:.85rem;background-color:transparent;cursor:pointer">
                        @foreach($siblings as $s)
                            <option value="{{ route('classes.show', $s->class_id) }}" @selected($s->class_id === $class->class_id)>
                                {{ $s->class_name }} ({{ $s->academic_year }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($role === 'admin')
                <a href="{{ route('classes.edit', $class->class_id) }}" class="btn-ui btn-ui-ghost" style="background:rgba(255,255,255,.9);min-height:38px;padding:.4rem 1rem">
                    <i class="bi bi-pencil" aria-hidden="true"></i> Edit
                </a>
                <form action="{{ route('classes.destroy', $class->class_id) }}" method="POST" class="m-0">
                    @csrf @method('DELETE')
                    <button class="btn-ui btn-ui-ghost" style="background:rgba(255,255,255,.9);color:var(--danger);min-height:38px;padding:.4rem 1rem" onclick="return confirm('Yakin hapus kelas {{ $class->class_name }}?')">
                        <i class="bi bi-trash3" aria-hidden="true"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@if(! $class->grade)
    <div class="alert alert-warning mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Kelas ini belum memiliki tingkat, sehingga mata pelajarannya belum dapat ditentukan secara otomatis.
    </div>
@endif

{{-- Subject and Assignments List --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h2 style="font-size:1.25rem;font-weight:900;margin:0;color:var(--ink)">Mata Pelajaran &amp; Tugas Kelas</h2>
        <p class="text-muted m-0" style="font-size:.85rem">
            {{ $role === 'student' ? 'Kerjakan soal latihan dari guru dan unggah jawaban dalam format PDF.' : 'Daftar mata pelajaran pada tingkat ini beserta soal tugas untuk siswa.' }}
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="pill"><i class="bi bi-journal-check me-1"></i> {{ $subjects->count() }} Mapel</span>
        <span class="pill"><i class="bi bi-file-earmark-text me-1"></i> {{ $totalAssignments }} Soal Aktif</span>
    </div>
</div>

@forelse($subjects as $subject)
    @php $list = $assignments->get($subject->subject_id, collect()); @endphp
    <section class="card-ui" style="margin-bottom:var(--s5)">
        <div class="card-ui-head">
            <div class="d-flex align-items-center gap-3">
                <div style="width:36px;height:36px;border-radius:10px;background:var(--accent-soft);color:var(--accent);display:grid;place-items:center;font-size:1.1rem;box-shadow:var(--shadow-sm);">
                    <i class="bi bi-journal-bookmark-fill" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="card-ui-title m-0">
                        <span class="tag tag-mono">{{ $subject->subject_code }}</span> {{ $subject->subject_name }}
                    </h3>
                    <div style="font-size:.75rem;color:var(--muted);font-weight:600;margin-top:2px">
                        Bobot: {{ number_format($subject->credits, 0) }} SKS · Tingkat Kelas {{ $subject->grade }}
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="pill">{{ $list->count() }} soal</span>
                @if($canManage)
                    <a href="{{ route('assignments.create', ['class_id' => $class->class_id, 'subject_id' => $subject->subject_id]) }}" class="btn-ui btn-ui-primary" style="padding:.45rem 1rem;min-height:36px;font-size:.82rem">
                        <i class="bi bi-plus-lg" aria-hidden="true"></i> Buat Soal
                    </a>
                @endif
            </div>
        </div>

        @if($list->isEmpty())
            <div class="card-ui-body text-center py-4" style="color:var(--muted);font-size:.88rem">
                <div style="font-size:1.5rem;color:var(--faint);margin-bottom:.3rem"><i class="bi bi-journal-x"></i></div>
                Belum ada soal tugas yang diterbitkan untuk mata pelajaran ini.
            </div>
        @else
            <div class="tbl-wrap">
                <table class="tbl tbl-stack">
                    <thead>
                        <tr>
                            <th>Judul Soal</th>
                            <th>Batas Waktu Pengumpulan</th>
                            <th class="t-center">{{ $role === 'student' ? 'Status Pengerjaan' : 'Jawaban Terkumpul' }}</th>
                            <th class="t-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $a)
                            <tr>
                                <td class="cell-primary" data-label="Judul">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-text text-primary" style="font-size:1.15rem" aria-hidden="true"></i>
                                        <a href="{{ route('assignments.show', $a->assignment_id) }}" class="cell-name">
                                            {{ $a->title }}
                                        </a>
                                    </div>
                                </td>
                                <td data-label="Batas Waktu">
                                    @if($a->due_at)
                                        <span class="tag {{ $a->isClosed() ? 'text-danger bg-danger-subtle' : 'tag-accent' }}">
                                            <i class="bi {{ $a->isClosed() ? 'bi-lock-fill' : 'bi-clock-history' }}"></i>
                                            {{ $a->due_at->translatedFormat('d M Y, H:i') }} WIB
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:.82rem">Tanpa batas waktu</span>
                                    @endif
                                </td>
                                <td class="t-center" data-label="{{ $role === 'student' ? 'Status' : 'Jawaban' }}">
                                    @if($role === 'student')
                                        @if(in_array($a->assignment_id, $submittedIds))
                                            <span class="tag tag-accent tag-dot">
                                                <i class="bi bi-check-circle-fill text-success"></i> Terkumpul
                                            </span>
                                        @elseif($a->isClosed())
                                            <span class="tag" style="background:#fee2e2;color:#991b1b;border-color:#fecaca">
                                                <i class="bi bi-x-circle-fill"></i> Ditutup
                                            </span>
                                        @else
                                            <span class="tag" style="background:#fef3c7;color:#92400e;border-color:#fde68a">
                                                <i class="bi bi-hourglass-split"></i> Belum Dikerjakan
                                            </span>
                                        @endif
                                    @else
                                        <span class="pill" style="font-size:.8rem">
                                            <i class="bi bi-file-earmark-check-fill me-1"></i> {{ $a->submissions_count }} Siswa
                                        </span>
                                    @endif
                                </td>
                                <td class="cell-actions t-right">
                                    <div class="act-wrap">
                                        <a href="{{ route('assignments.show', $a->assignment_id) }}" class="act-btn" title="Buka Soal" aria-label="Buka {{ $a->title }}">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        @if($canManage)
                                            <a href="{{ route('assignments.edit', $a->assignment_id) }}" class="act-btn" title="Edit Soal" aria-label="Edit {{ $a->title }}">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('assignments.destroy', $a->assignment_id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="act-btn del" title="Hapus Soal" aria-label="Hapus {{ $a->title }}" onclick="return confirm('Yakin hapus soal ini?')">
                                                    <i class="bi bi-trash3" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@empty
    <section class="card-ui">
        <div class="empty">
            <div class="empty-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></div>
            <h3>Belum Ada Mata Pelajaran</h3>
            <p>{{ $role === 'teacher' ? 'Mata pelajaran yang Anda ampu tidak terdaftar di tingkat kelas ini.' : 'Daftarkan mata pelajaran untuk tingkat kelas ini agar muncul di ruang kelas.' }}</p>
        </div>
    </section>
@endforelse

<script>
var sw = document.getElementById('switchClass');
if (sw) { sw.addEventListener('change', function () { window.location.href = sw.value; }); }
</script>
@endsection
