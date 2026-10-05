@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('_partials.page-styles')
<style>
    .sf-sidebar-card { background:linear-gradient(160deg,#dc2626 0%,#ea580c 55%,#f59e0b 100%); box-shadow:0 12px 40px rgba(220,38,38,.4); }
    .sf-sec-num { background:linear-gradient(135deg,#ef4444,#f97316); box-shadow:0 3px 8px rgba(239,68,68,.4); }
    .sf-field label i { color:#ef4444; }
    .sf-field input:focus, .sf-field select:focus { border-color:#ef4444; box-shadow:0 0 0 4px rgba(239,68,68,.1); }
    .sf-field::after { background:linear-gradient(90deg,#ef4444,#f97316); }
    .btn-sf-submit { background:linear-gradient(135deg,#dc2626,#ea580c); box-shadow:0 6px 20px rgba(220,38,38,.4); color:white; }
    .btn-sf-submit:hover { background:linear-gradient(135deg,#b91c1c,#c2410c); box-shadow:0 10px 30px rgba(220,38,38,.5); color:white; }
    .sf-tips-title { color:#dc2626; }
    .sf-tips-card li i { color:#f87171; }
    .sf-footer { background:#fff5f5; border-color:#fecaca; }
</style>

<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-book-fill"></i></div>
            <p class="sf-side-title">Tambah Mata Pelajaran</p>
            <p class="sf-side-desc">Daftarkan mata pelajaran baru ke dalam sistem akademik sekolah.</p>
            <ul class="sf-steps">
                <li class="sf-step"><div class="sf-step-dot done">1</div><div class="sf-step-info"><strong>Kode & Nama</strong><span>Identitas mata pelajaran</span></div></li>
                <li class="sf-step"><div class="sf-step-dot done">2</div><div class="sf-step-info"><strong>Bobot SKS</strong><span>Jumlah satuan kredit</span></div></li>
                <li class="sf-step"><div class="sf-step-dot">3</div><div class="sf-step-info"><strong>Simpan</strong><span>Konfirmasi & simpan data</span></div></li>
            </ul>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-lightbulb-fill"></i> Tips Pengisian</div>
            <ul>
                <li><i class="bi bi-check-circle-fill"></i> Kode mapel harus unik: "MTK-101", "BIO-201"</li>
                <li><i class="bi bi-check-circle-fill"></i> SKS biasanya bernilai 2–4 per mata pelajaran</li>
                <li><i class="bi bi-check-circle-fill"></i> Nama mata pelajaran sebaiknya lengkap dan jelas</li>
            </ul>
        </div>
    </div>

    <div class="sf-main-card">
        <form action="{{ route('subjects.store') }}" method="POST" id="sfForm">
            @csrf
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Identitas Mata Pelajaran</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-grid2">
                    <div class="sf-field">
                        <label for="subject_code"><i class="bi bi-hash"></i> Kode Mapel <span class="req">*</span></label>
                        <input type="text" name="subject_code" id="subject_code" placeholder="Contoh: MTK-101" value="{{ old('subject_code') }}" autofocus required>
                        @error('subject_code')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field">
                        <label for="credits"><i class="bi bi-clock"></i> Bobot SKS <span class="req">*</span></label>
                        <input type="number" name="credits" id="credits" placeholder="Contoh: 3" value="{{ old('credits') }}" min="1" max="10" required>
                        @error('credits')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field" style="grid-column:1/-1;">
                        <label for="subject_name"><i class="bi bi-journal-text"></i> Nama Mata Pelajaran <span class="req">*</span></label>
                        <input type="text" name="subject_name" id="subject_name" placeholder="Masukkan nama mata pelajaran lengkap..." value="{{ old('subject_name') }}" required>
                        @error('subject_name')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-submit" id="sfBtn"><i class="bi bi-floppy-fill"></i> Simpan Mata Pelajaran</button>
                <a href="{{ route('subjects.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
                <span class="sf-req-note"><span>*</span> Wajib diisi</span>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('sfForm').addEventListener('submit',function(){
    const b=document.getElementById('sfBtn');b.innerHTML='<i class="bi bi-hourglass-split"></i> Menyimpan...';b.disabled=true;b.style.opacity='.75';
});
</script>
@endsection