@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('_partials.page-styles')

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
                    <label for="grade"><i class="bi bi-layers"></i> Tingkat <span class="req">*</span></label>
                    <select name="grade" id="grade" required autofocus>
                        <option value="">— Pilih tingkat —</option>
                        @foreach(\App\Models\Classes::GRADES as $g)
                            <option value="{{ $g }}" @selected(old('grade') === $g)>Kelas {{ $g }}</option>
                        @endforeach
                    </select>
                    @error('grade')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="section"><i class="bi bi-building"></i> Rombel <span class="req">*</span></label>
                    <input type="text" name="section" id="section" maxlength="20" placeholder="Contoh: A, B, C" value="{{ old('section') }}" required>
                    @error('section')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
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
