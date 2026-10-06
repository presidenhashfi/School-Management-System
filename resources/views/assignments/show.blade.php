@extends('layouts.app')

@section('title', $assignment->title)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    @if(auth()->user()->role !== 'student')
        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    @endif
    @if($assignment->class)
        <li class="breadcrumb-item"><a href="{{ route('classes.show', $assignment->class_id) }}">{{ $assignment->class->class_name }}</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($assignment->title, 40) }}</li>
@endsection

@section('content')
@php
    $role = auth()->user()->role;
    $canManage = in_array($role, ['admin', 'teacher']);
    $fmtSize = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 1) . ' MB' : number_format($b / 1024, 0) . ' KB';
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">{{ $assignment->class->class_name ?? '' }} · {{ $assignment->subject->subject_name ?? 'Soal' }}</div>
        <h1 class="ph-title">{{ $assignment->title }}</h1>
        <p class="ph-sub">
            Dibuat oleh {{ $assignment->author->username ?? '-' }}
            @if($assignment->due_at) · Batas {{ $assignment->due_at->translatedFormat('d M Y H:i') }}@endif
        </p>
    </div>
    @if($canManage)
        <a href="{{ route('assignments.edit', $assignment->assignment_id) }}" class="btn-ui btn-ui-ghost"><i class="bi bi-pencil" aria-hidden="true"></i> Edit</a>
    @endif
</div>

<section class="card-ui" style="margin-bottom:var(--s5)">
    <div class="card-ui-head"><h2 class="card-ui-title">Isi Soal</h2></div>
    <div class="card-ui-body ql-snow">
        <div class="ql-editor" style="padding:0;height:auto;overflow:visible">{!! $assignment->description !!}</div>
    </div>
</section>

@if($role === 'student')
<section class="card-ui">
    <div class="card-ui-head"><h2 class="card-ui-title">Jawaban Anda</h2></div>
    <div class="card-ui-body">
        @if($submission)
            <p style="margin:0 0 var(--s4)">
                <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                <a href="{{ route('submissions.download', $submission->submission_id) }}">{{ $submission->original_name }}</a>
                <span class="text-muted">({{ $fmtSize($submission->file_size) }}) · dikumpulkan {{ $submission->submitted_at->translatedFormat('d M Y H:i') }}</span>
            </p>
        @endif

        @if($assignment->isClosed())
            <div class="alert alert-warning mb-0">Batas waktu pengumpulan sudah lewat.</div>
        @else
            <form action="{{ route('assignments.submit', $assignment->assignment_id) }}" method="POST" enctype="multipart/form-data" id="submitForm">
                @csrf
                <label for="file" class="form-label">{{ $submission ? 'Ganti jawaban (PDF, maks. 10 MB)' : 'Unggah jawaban (PDF, maks. 10 MB)' }}</label>
                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept="application/pdf,.pdf" required>
                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <button type="submit" class="btn-ui btn-ui-primary" style="margin-top:var(--s4)" id="submitBtn">
                    <i class="bi bi-upload" aria-hidden="true"></i> {{ $submission ? 'Kirim Ulang' : 'Kumpulkan' }}
                </button>
            </form>
        @endif
    </div>
</section>
@else
<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Jawaban Siswa <span class="pill">{{ $submissions->count() }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr><th>#</th><th>NIS</th><th>Nama</th><th>Dikumpulkan</th><th>Ukuran</th><th class="t-right">File</th></tr>
            </thead>
            <tbody>
                @forelse($submissions as $i => $s)
                    <tr>
                        <td class="num">{{ $i + 1 }}</td>
                        <td data-label="NIS"><span class="tag tag-mono">{{ $s->student->nis ?? '-' }}</span></td>
                        <td class="cell-primary" data-label="Nama"><span class="cell-name">{{ $s->student->full_name ?? '-' }}</span></td>
                        <td data-label="Dikumpulkan">
                            {{ $s->submitted_at->translatedFormat('d M Y H:i') }}
                            @if($assignment->due_at && $s->submitted_at->gt($assignment->due_at))<span class="tag">Terlambat</span>@endif
                        </td>
                        <td data-label="Ukuran">{{ $fmtSize($s->file_size) }}</td>
                        <td class="t-right">
                            <a href="{{ route('submissions.download', $s->submission_id) }}" class="btn-ui btn-ui-ghost"><i class="bi bi-download" aria-hidden="true"></i> PDF</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-inbox" aria-hidden="true"></i></div>
                                <h3>Belum ada jawaban</h3>
                                <p>Jawaban PDF yang diunggah siswa akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endif
@endsection
