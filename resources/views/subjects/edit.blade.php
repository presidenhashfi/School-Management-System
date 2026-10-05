@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
@include('_partials.page-styles')
<style>
    .sf-sidebar-card { background:linear-gradient(160deg,#d97706 0%,#ea580c 55%,#dc2626 100%); box-shadow:0 12px 40px rgba(234,88,12,.4); }
    .sf-sec-num { background:linear-gradient(135deg,#f59e0b,#f97316); box-shadow:0 3px 8px rgba(245,158,11,.4); }
    .sf-field label i { color:#f97316; }
    .sf-field input:focus, .sf-field select:focus { border-color:#f97316; box-shadow:0 0 0 4px rgba(249,115,22,.1); }
    .sf-field::after { background:linear-gradient(90deg,#f59e0b,#f97316); }
    .btn-sf-update { background:linear-gradient(135deg,#f59e0b,#f97316); box-shadow:0 6px 20px rgba(245,158,11,.4); color:white; }
    .btn-sf-update:hover { background:linear-gradient(135deg,#d97706,#ea580c); box-shadow:0 10px 30px rgba(245,158,11,.5); color:white; }
    .sf-tips-title { color:#ea580c; }
    .sf-tips-card li i { color:#fb923c; }
    .sf-footer { background:#fffbf5; border-color:#fef3c7; }
    .sf-form-banner { background:linear-gradient(135deg,#fff7ed,#ffedd5); border-color:#fed7aa; }
    .sf-form-banner i, .sf-form-banner span { color:#92400e; }
    .sf-edit-badge { background:linear-gradient(135deg,#fed7aa,#fdba74); color:#9a3412; border:1px solid #fdba74; }
</style>

<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-pencil-square"></i></div>
            <p class="sf-side-title">Edit Mata Pelajaran</p>
            <p class="sf-side-desc">Perbarui informasi mata pelajaran. Pastikan semua data benar.</p>
            <div class="sf-preview-card">
                <div class="sf-preview-label"><i class="bi bi-book"></i> Mapel yang diedit</div>
                <div class="d-flex align-items-center gap-3">
                    <div class="sf-preview-avatar"><i class="bi bi-journal-text" style="font-size:1.1rem;"></i></div>
                    <div>
                        <div class="sf-preview-name">{{ $subject->subject_name }}</div>
                        <div class="sf-preview-sub">{{ $subject->subject_code }} · {{ $subject->credits }} SKS</div>
                    </div>
                </div>
            </div>
            <div class="sf-edit-note"><i class="bi bi-info-circle-fill" style="flex-shrink:0;margin-top:2px;"></i> Perubahan tersimpan setelah klik <strong>"Update Data"</strong>.</div>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-shield-exclamation"></i> Perhatian</div>
            <ul>
                <li><i class="bi bi-exclamation-circle-fill"></i> Mengubah kode mapel harus tetap unik di sistem</li>
                <li><i class="bi bi-exclamation-circle-fill"></i> Perubahan SKS mempengaruhi laporan akademik</li>
            </ul>
        </div>
    </div>

    <div class="sf-main-card">
        <div class="sf-form-banner">
            <i class="bi bi-pencil-fill"></i>
            <span>Mengedit <strong>{{ $subject->subject_name }}</strong></span>
            <span class="sf-edit-badge"><i class="bi bi-pencil-fill"></i> Mode Edit</span>
        </div>
        <form action="{{ route('subjects.update', $subject->subject_id) }}" method="POST" id="sfForm">
            @csrf @method('PUT')
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Identitas Mata Pelajaran</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-grid2">
                    <div class="sf-field">
                        <label for="subject_code"><i class="bi bi-hash"></i> Kode Mapel <span class="req">*</span></label>
                        <input type="text" name="subject_code" id="subject_code" placeholder="Contoh: MTK-101" value="{{ old('subject_code', $subject->subject_code) }}" autofocus required>
                        @error('subject_code')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field">
                        <label for="credits"><i class="bi bi-clock"></i> Bobot SKS <span class="req">*</span></label>
                        <input type="number" name="credits" id="credits" placeholder="Contoh: 3" value="{{ old('credits', $subject->credits) }}" min="1" max="10" required>
                        @error('credits')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field" style="grid-column:1/-1;">
                        <label for="subject_name"><i class="bi bi-journal-text"></i> Nama Mata Pelajaran <span class="req">*</span></label>
                        <input type="text" name="subject_name" id="subject_name" placeholder="Masukkan nama mata pelajaran lengkap..." value="{{ old('subject_name', $subject->subject_name) }}" required>
                        @error('subject_name')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-update" id="sfBtn"><i class="bi bi-check-circle-fill"></i> Update Mata Pelajaran</button>
                <a href="{{ route('subjects.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
                <span class="sf-req-note"><span>*</span> Wajib diisi</span>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('sfForm').addEventListener('submit',function(){
    const b=document.getElementById('sfBtn');b.innerHTML='<i class="bi bi-hourglass-split"></i> Mengupdate...';b.disabled=true;b.style.opacity='.75';
});
</script>
@endsection