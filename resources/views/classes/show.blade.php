@extends('layouts.app')

@section('title', 'Kelas ' . $class->class_name)

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
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Kelas {{ $class->grade ?? '-' }} · {{ $class->academic_year }}</div>
        <h1 class="ph-title">{{ $class->class_name }}</h1>
        <p class="ph-sub">Wali kelas: {{ $homeroom->full_name ?? 'belum ditentukan' }}</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        @if($role !== 'student' && $siblings->count() > 1)
            <label for="switchClass" class="visually-hidden">Pindah rombel</label>
            <select id="switchClass" class="form-select" style="width:auto">
                @foreach($siblings as $s)
                    <option value="{{ route('classes.show', $s->class_id) }}" @selected($s->class_id === $class->class_id)>{{ $s->class_name }} · {{ $s->academic_year }}</option>
                @endforeach
            </select>
        @endif
        @if($role === 'admin')
            <a href="{{ route('classes.edit', $class->class_id) }}" class="btn-ui btn-ui-ghost"><i class="bi bi-pencil" aria-hidden="true"></i> Edit</a>
            <form action="{{ route('classes.destroy', $class->class_id) }}" method="POST" class="m-0">
                @csrf @method('DELETE')
                <button class="btn-ui btn-ui-ghost" onclick="return confirm('Yakin hapus kelas {{ $class->class_name }}?')"><i class="bi bi-trash3" aria-hidden="true"></i> Hapus</button>
            </form>
        @endif
    </div>
</div>

@if(! $class->grade)
    <div class="alert alert-warning">Kelas ini belum memiliki tingkat, sehingga mata pelajarannya belum bisa ditentukan.</div>
@endif

@forelse($subjects as $subject)
    @php $list = $assignments->get($subject->subject_id, collect()); @endphp
    <section class="card-ui" style="margin-bottom:var(--s5)">
        <div class="card-ui-head">
            <h2 class="card-ui-title">
                <span class="tag tag-mono">{{ $subject->subject_code }}</span> {{ $subject->subject_name }}
                <span class="pill">{{ $list->count() }} soal</span>
            </h2>
            @if($canManage)
                <a href="{{ route('assignments.create', ['class_id' => $class->class_id, 'subject_id' => $subject->subject_id]) }}" class="btn-ui btn-ui-primary">
                    <i class="bi bi-plus-lg" aria-hidden="true"></i> Buat Soal
                </a>
            @endif
        </div>
        @if($list->isEmpty())
            <div class="card-ui-body text-muted" style="font-size:.86rem">Belum ada soal untuk mapel ini.</div>
        @else
            <div class="tbl-wrap">
                <table class="tbl tbl-stack">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Batas Waktu</th>
                            <th class="t-center">{{ $role === 'student' ? 'Status' : 'Jawaban' }}</th>
                            <th class="t-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $a)
                            <tr>
                                <td class="cell-primary" data-label="Judul"><a href="{{ route('assignments.show', $a->assignment_id) }}" class="cell-name">{{ $a->title }}</a></td>
                                <td data-label="Batas Waktu">
                                    @if($a->due_at)
                                        <span class="tag {{ $a->isClosed() ? '' : 'tag-accent' }}">{{ $a->due_at->translatedFormat('d M Y H:i') }}</span>
                                    @else
                                        <span class="text-muted">Tanpa batas</span>
                                    @endif
                                </td>
                                <td class="t-center" data-label="{{ $role === 'student' ? 'Status' : 'Jawaban' }}">
                                    @if($role === 'student')
                                        @if(in_array($a->assignment_id, $submittedIds))
                                            <span class="tag tag-accent tag-dot">Terkumpul</span>
                                        @elseif($a->isClosed())
                                            <span class="tag tag-dot">Ditutup</span>
                                        @else
                                            <span class="tag tag-dot">Belum</span>
                                        @endif
                                    @else
                                        <span class="pill">{{ $a->submissions_count }}</span>
                                    @endif
                                </td>
                                <td class="cell-actions t-right">
                                    <div class="act-wrap">
                                        <a href="{{ route('assignments.show', $a->assignment_id) }}" class="act-btn" title="Lihat" aria-label="Lihat {{ $a->title }}"><i class="bi bi-eye" aria-hidden="true"></i></a>
                                        @if($canManage)
                                            <a href="{{ route('assignments.edit', $a->assignment_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $a->title }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                            <form action="{{ route('assignments.destroy', $a->assignment_id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="act-btn del" title="Hapus" aria-label="Hapus {{ $a->title }}" onclick="return confirm('Yakin hapus soal ini?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
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
            <h3>Belum ada mata pelajaran</h3>
            <p>{{ $role === 'teacher' ? 'Mapel Anda tidak terdaftar pada tingkat kelas ini.' : 'Atur tingkat pada mata pelajaran agar muncul di kelas ini.' }}</p>
        </div>
    </section>
@endforelse

<script>
var sw = document.getElementById('switchClass');
if (sw) { sw.addEventListener('change', function () { window.location.href = sw.value; }); }
</script>
@endsection
