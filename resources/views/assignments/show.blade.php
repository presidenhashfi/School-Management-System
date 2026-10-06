@extends('layouts.app')

@section('title', $assignment->title . ' — Soal ' . ($assignment->class->class_name ?? ''))

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
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($assignment->title, 36) }}</li>
@endsection

@section('content')
@php
    $role = auth()->user()->role;
    $canManage = in_array($role, ['admin', 'teacher']);
    $fmtSize = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 1) . ' MB' : number_format($b / 1024, 0) . ' KB';
@endphp

{{-- Assignment Header --}}
<div class="ph">
    <div>
        <div class="ph-eyebrow">
            <i class="bi bi-mortarboard" aria-hidden="true"></i>
            {{ $assignment->class->class_name ?? 'Kelas' }} · {{ $assignment->subject->subject_name ?? 'Mapel' }}
        </div>
        <h1 class="ph-title">{{ $assignment->title }}</h1>
        <div class="d-flex align-items-center gap-3 flex-wrap mt-2">
            <span class="text-muted" style="font-size:.86rem">
                <i class="bi bi-person-fill text-primary" aria-hidden="true"></i> Dibuat oleh: <strong>{{ $assignment->author->username ?? '-' }}</strong>
            </span>
            @if($assignment->due_at)
                <span class="tag {{ $assignment->isClosed() ? 'text-danger bg-danger-subtle' : 'tag-accent' }}">
                    <i class="bi {{ $assignment->isClosed() ? 'bi-lock-fill' : 'bi-alarm-fill' }}" aria-hidden="true"></i>
                    Batas: {{ $assignment->due_at->translatedFormat('d F Y, H:i') }} WIB
                </span>
            @else
                <span class="tag"><i class="bi bi-infinity" aria-hidden="true"></i> Tanpa Batas Waktu</span>
            @endif
        </div>
    </div>
    @if($canManage)
        <div class="d-flex gap-2">
            <a href="{{ route('assignments.edit', $assignment->assignment_id) }}" class="btn-ui btn-ui-ghost">
                <i class="bi bi-pencil" aria-hidden="true"></i> Edit Soal
            </a>
            @if($assignment->class_id)
                <a href="{{ route('classes.show', $assignment->class_id) }}" class="btn-ui btn-ui-ghost">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali ke Kelas
                </a>
            @endif
        </div>
    @endif
</div>

{{-- Assignment Question Content (Quill Reading View) --}}
<section class="card-ui" style="margin-bottom:var(--s5)">
    <div class="card-ui-head">
        <h2 class="card-ui-title">
            <i class="bi bi-file-earmark-text-fill text-primary" aria-hidden="true"></i>
            Instruksi &amp; Lembar Soal
        </h2>
    </div>
    <div class="card-ui-body" style="background:#ffffff;padding:var(--s6)">
        <div class="ql-snow">
            <div class="ql-editor" style="padding:0;height:auto;overflow:visible;font-size:1.02rem;line-height:1.75;color:var(--ink)">
                {!! $assignment->description !!}
            </div>
        </div>
    </div>
</section>

{{-- Student Submission Section --}}
@if($role === 'student')
<section class="card-ui" style="margin-bottom:var(--s6)">
    <div class="card-ui-head">
        <h2 class="card-ui-title">
            <i class="bi bi-cloud-arrow-up-fill text-primary" aria-hidden="true"></i>
            Pengumpulan Lembar Jawaban (Format PDF)
        </h2>
    </div>
    <div class="card-ui-body">
        @if($submission)
            <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:var(--r-md);padding:var(--s4) var(--s5);margin-bottom:var(--s5)">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div style="width:48px;height:48px;border-radius:14px;background:#dcfce7;color:#16a34a;display:grid;place-items:center;font-size:1.5rem">
                        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:900;color:#166534;font-size:1rem;margin-bottom:2px">
                            Jawaban Anda Berhasil Terkumpul!
                        </div>
                        <div style="font-size:.85rem;color:#15803d">
                            File: <strong>{{ $submission->original_name }}</strong> ({{ $fmtSize($submission->file_size) }}) · Dikirim pada {{ $submission->submitted_at->translatedFormat('d M Y, H:i') }} WIB
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('submissions.download', $submission->submission_id) }}" class="btn-ui btn-ui-accent" style="padding:.5rem 1.1rem;min-height:38px;font-size:.85rem">
                            <i class="bi bi-file-earmark-pdf-fill" aria-hidden="true"></i> Unduh PDF Jawaban
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($assignment->isClosed())
            <div class="alert alert-warning mb-0">
                <i class="bi bi-lock-fill me-2" aria-hidden="true"></i>
                Batas waktu pengumpulan telah berakhir. Pengiriman jawaban baru atau penggantian berkas sudah ditutup.
            </div>
        @else
            <form action="{{ route('assignments.submit', $assignment->assignment_id) }}" method="POST" enctype="multipart/form-data" id="submitForm">
                @csrf
                
                {{-- Dropzone Area --}}
                <div class="pdf-dropzone" id="dropzone" onclick="document.getElementById('fileInput').click()">
                    <div class="pdf-icon-badge">
                        <i class="bi bi-file-earmark-pdf-fill" aria-hidden="true"></i>
                    </div>
                    <div class="pdf-dropzone-title">
                        {{ $submission ? 'Pilih file PDF baru untuk mengganti jawaban sebelumnya' : 'Klik atau Tarik Berkas PDF ke Sini' }}
                    </div>
                    <p class="pdf-dropzone-hint">
                        Maksimal ukuran file 10 MB · Dokumen format PDF (.pdf)
                    </p>
                    <div class="pdf-file-selected" id="fileSelectedBadge" style="display:none">
                        <i class="bi bi-check2-circle"></i> <span id="fileNameDisplay">file.pdf</span>
                    </div>
                </div>

                <input type="file" name="file" id="fileInput" class="d-none" accept="application/pdf,.pdf" required>
                @error('file')<div class="sf-error mt-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                    <span class="text-muted" style="font-size:.8rem">
                        <i class="bi bi-info-circle me-1"></i> Jawaban yang diunggah akan langsung dapat diperiksa oleh guru mata pelajaran.
                    </span>
                    <button type="submit" class="btn-ui btn-ui-primary" id="submitBtn">
                        <i class="bi bi-send-fill" aria-hidden="true"></i>
                        {{ $submission ? 'Kirim Ulang Jawaban PDF' : 'Kumpulkan Jawaban Sekarang' }}
                    </button>
                </div>
            </form>
        @endif
    </div>
</section>
@else
{{-- Teacher & Admin View: Submissions List --}}
<section class="card-ui" style="margin-bottom:var(--s6)">
    <div class="card-ui-head">
        <h2 class="card-ui-title">
            <i class="bi bi-people-fill text-primary" aria-hidden="true"></i>
            Daftar Jawaban Siswa
            <span class="pill">{{ $submissions->count() }} Terkumpul</span>
        </h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Waktu Pengumpulan</th>
                    <th>Ukuran File</th>
                    <th class="t-right">Unduh Berkas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $i => $s)
                    @php $isLate = $assignment->due_at && $s->submitted_at->gt($assignment->due_at); @endphp
                    <tr>
                        <td class="num">{{ $i + 1 }}</td>
                        <td data-label="NIS"><span class="tag tag-mono">{{ $s->student->nis ?? '-' }}</span></td>
                        <td class="cell-primary" data-label="Nama">
                            <div class="cell-main">
                                <div class="avatar" style="width:32px;height:32px;font-size:.72rem" aria-hidden="true">
                                    {{ strtoupper(substr($s->student->full_name ?? 'S', 0, 2)) }}
                                </div>
                                <span class="cell-name">{{ $s->student->full_name ?? '-' }}</span>
                            </div>
                        </td>
                        <td data-label="Waktu">
                            {{ $s->submitted_at->translatedFormat('d M Y, H:i') }} WIB
                            @if($isLate)
                                <span class="tag" style="background:#fee2e2;color:#991b1b;border-color:#fecaca">Terlambat</span>
                            @else
                                <span class="tag tag-accent">Tepat Waktu</span>
                            @endif
                        </td>
                        <td data-label="Ukuran">{{ $fmtSize($s->file_size) }}</td>
                        <td class="t-right" data-label="File">
                            <a href="{{ route('submissions.download', $s->submission_id) }}" class="btn-ui btn-ui-ghost" style="padding:.4rem .9rem;min-height:34px;font-size:.82rem">
                                <i class="bi bi-file-earmark-pdf-fill text-danger" aria-hidden="true"></i> Unduh PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-inbox" aria-hidden="true"></i></div>
                                <h3>Belum Ada Jawaban yang Masuk</h3>
                                <p>Siswa di kelas ini belum mengunggah lembar jawaban PDF untuk soal ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endif

@push('scripts')
<script>
(function() {
    var fileInput = document.getElementById('fileInput');
    var dropzone = document.getElementById('dropzone');
    var badge = document.getElementById('fileSelectedBadge');
    var nameDisplay = document.getElementById('fileNameDisplay');
    var form = document.getElementById('submitForm');
    var btn = document.getElementById('submitBtn');

    if (fileInput && dropzone) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                var f = fileInput.files[0];
                var sz = (f.size / (1024 * 1024)).toFixed(2) + ' MB';
                nameDisplay.textContent = f.name + ' (' + sz + ')';
                badge.style.display = 'inline-flex';
            }
        });

        // Drag and drop handlers
        ['dragenter', 'dragover'].forEach(function(evt) {
            dropzone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function(evt) {
            dropzone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', function(e) {
            if (e.dataTransfer && e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                var f = fileInput.files[0];
                var sz = (f.size / (1024 * 1024)).toFixed(2) + ' MB';
                nameDisplay.textContent = f.name + ' (' + sz + ')';
                badge.style.display = 'inline-flex';
            }
        });
    }

    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengunggah...';
            btn.disabled = true;
        });
    }
})();
</script>
@endpush
@endsection
