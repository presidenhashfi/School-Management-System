@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('_partials.page-styles')
<style>
    .sf-sidebar-card { background:linear-gradient(160deg,#2563eb 0%,#4f46e5 55%,#7c3aed 100%); box-shadow:0 12px 40px rgba(37,99,235,.4); }
    .sf-sec-num { background:linear-gradient(135deg,#3b82f6,#6366f1); box-shadow:0 3px 8px rgba(59,130,246,.4); }
    .sf-field label i { color:#3b82f6; }
    .sf-field input:focus, .sf-field select:focus { border-color:#3b82f6; box-shadow:0 0 0 4px rgba(59,130,246,.1); }
    .sf-field::after { background:linear-gradient(90deg,#3b82f6,#6366f1); }
    .btn-sf-submit { background:linear-gradient(135deg,#2563eb,#4f46e5); box-shadow:0 6px 20px rgba(37,99,235,.4); color:white; }
    .btn-sf-submit:hover { background:linear-gradient(135deg,#1d4ed8,#4338ca); box-shadow:0 10px 30px rgba(37,99,235,.5); color:white; }
    .sf-tips-title { color:#2563eb; }
    .sf-tips-card li i { color:#60a5fa; }
    .sf-footer { background:#f0f9ff; border-color:#bae6fd; }
    .sf-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232563eb' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 1rem center; }
</style>

<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-building-add"></i></div>
            <p class="sf-side-title">Tambah Kelas Baru</p>
            <p class="sf-side-desc">Lengkapi informasi kelas yang ingin didaftarkan ke sistem akademik.</p>
            <ul class="sf-steps">
                <li class="sf-step"><div class="sf-step-dot done">1</div><div class="sf-step-info"><strong>Detail Kelas</strong><span>Nama & tahun ajaran</span></div></li>
                <li class="sf-step"><div class="sf-step-dot done">2</div><div class="sf-step-info"><strong>Wali Kelas</strong><span>Pilih guru wali kelas (opsional)</span></div></li>
                <li class="sf-step"><div class="sf-step-dot">3</div><div class="sf-step-info"><strong>Simpan Data</strong><span>Klik tombol simpan</span></div></li>
            </ul>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-lightbulb-fill"></i> Tips Pengisian</div>
            <ul>
                <li><i class="bi bi-check-circle-fill"></i> Format nama kelas: "X IPA 1", "XI IPS 2", dll.</li>
                <li><i class="bi bi-check-circle-fill"></i> Format tahun ajaran: "2024/2025"</li>
                <li><i class="bi bi-check-circle-fill"></i> Wali kelas bisa diisi belakangan</li>
            </ul>
        </div>
    </div>

    <div class="sf-main-card">
        <form action="{{ route('classes.store') }}" method="POST" id="sfForm">
            @csrf
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Detail Kelas</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-field">
                    <label for="class_name"><i class="bi bi-building"></i> Nama Kelas <span class="req">*</span></label>
                    <input type="text" name="class_name" id="class_name" placeholder="Contoh: X IPA 1, XI IPS 2..." value="{{ old('class_name') }}" autofocus required>
                    @error('class_name')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="academic_year"><i class="bi bi-calendar3"></i> Tahun Ajaran <span class="req">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" placeholder="Contoh: 2024/2025" value="{{ old('academic_year') }}" required>
                    @error('academic_year')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
            </div>
            <div class="sf-divider"></div>
            <div class="sf-sec-hdr" style="margin-top:1.25rem;">
                <div class="sf-sec-num">2</div>
                <div class="sf-sec-title">Wali Kelas</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-field" style="margin-bottom:2rem;">
                    <label for="homeroom_teacher_id"><i class="bi bi-person-badge-fill"></i> Wali Kelas <span class="opt-pill">Opsional</span></label>
                    <select name="homeroom_teacher_id" id="homeroom_teacher_id">
                        <option value="">— Pilih guru wali kelas —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}" {{ old('homeroom_teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>
                                {{ $teacher->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('homeroom_teacher_id')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-submit" id="sfBtn"><i class="bi bi-floppy-fill"></i> Simpan Data Kelas</button>
                <a href="{{ route('classes.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
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
