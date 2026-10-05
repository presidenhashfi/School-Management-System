@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')

<div class="sf-outer">
    {{-- ═══ LEFT SIDEBAR ═══ --}}
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <p class="sf-side-title">Tambah Siswa Baru</p>
            <p class="sf-side-desc">Lengkapi semua informasi yang diperlukan untuk mendaftarkan siswa baru ke sistem.</p>

            <ul class="sf-steps">
                <li class="sf-step">
                    <div class="sf-step-dot active">1</div>
                    <div class="sf-step-info">
                        <strong>Akun & Kelas</strong>
                        <span>Pilih akun pengguna dan kelas</span>
                    </div>
                </li>
                <li class="sf-step">
                    <div class="sf-step-dot active">2</div>
                    <div class="sf-step-info">
                        <strong>Data Pribadi</strong>
                        <span>NIS, nama & tanggal lahir</span>
                    </div>
                </li>
                <li class="sf-step">
                    <div class="sf-step-dot">3</div>
                    <div class="sf-step-info">
                        <strong>Simpan Data</strong>
                        <span>Klik tombol simpan untuk selesai</span>
                    </div>
                </li>
            </ul>
        </div>

        <div class="sf-tips-card">
            <div class="tips-title">
                <i class="bi bi-lightbulb-fill"></i> Tips Pengisian
            </div>
            <ul>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    NIS harus unik dan tidak boleh sama dengan siswa lain
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Pilih akun dengan role <strong>Student</strong> yang belum terdaftar
                </li>
                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    Tanggal lahir bersifat opsional namun disarankan diisi
                </li>
            </ul>
        </div>
    </div>

    {{-- ═══ MAIN FORM CARD ═══ --}}
    <div class="sf-main-card">
        <form action="{{ route('students.store') }}" method="POST" id="sfForm">
            @csrf

            {{-- SECTION 1: Akun & Kelas --}}
            <div class="sf-section-header">
                <div class="sf-section-num">1</div>
                <div class="sf-section-title">Informasi Akun & Kelas</div>
                <div class="sf-section-line"></div>
            </div>

            <div class="sf-fields">
                <div class="sf-grid2">
                    {{-- Akun Pengguna --}}
                    <div class="sf-field" style="grid-column: 1 / -1;">
                        <label for="user_id">
                            <i class="bi bi-person-badge-fill"></i>
                            Akun Pengguna <span class="req">*</span>
                        </label>
                        <select name="user_id" id="user_id" required autofocus>
                            <option value="">— Pilih akun dengan role Student —</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->username }} · {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="sf-field" style="grid-column: 1 / -1;">
                        <label for="class_id">
                            <i class="bi bi-mortarboard-fill"></i>
                            Kelas <span class="req">*</span>
                        </label>
                        <select name="class_id" id="class_id" required>
                            <option value="">— Pilih kelas —</option>
                            @foreach($classes as $kelas)
                                <option value="{{ $kelas->class_id }}" {{ old('class_id') == $kelas->class_id ? 'selected' : '' }}>
                                    {{ $kelas->class_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="sf-divider"></div>

            {{-- SECTION 2: Data Pribadi --}}
            <div class="sf-section-header" style="margin-top: 1.25rem;">
                <div class="sf-section-num">2</div>
                <div class="sf-section-title">Data Pribadi Siswa</div>
                <div class="sf-section-line"></div>
            </div>

            <div class="sf-fields">
                <div class="sf-grid2">
                    {{-- NIS --}}
                    <div class="sf-field">
                        <label for="nis">
                            <i class="bi bi-upc-scan"></i>
                            NIS <span class="req">*</span>
                        </label>
                        <input type="text" name="nis" id="nis"
                               placeholder="Contoh: 2024001"
                               value="{{ old('nis') }}" required>
                        @error('nis')
                            <div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="sf-field">
                        <label for="date_of_birth">
                            <i class="bi bi-calendar-heart-fill"></i>
                            Tanggal Lahir <span class="opt-pill">Opsional</span>
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                               value="{{ old('date_of_birth') }}">
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="sf-field" style="grid-column: 1 / -1;">
                        <label for="full_name">
                            <i class="bi bi-type"></i>
                            Nama Lengkap <span class="req">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name"
                               placeholder="Masukkan nama lengkap siswa..."
                               value="{{ old('full_name') }}" required>
                        @error('full_name')
                            <div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="sf-footer">
                <button type="submit" class="btn-sf-submit" id="sfSubmitBtn">
                    <i class="bi bi-floppy-fill"></i> Simpan Data Siswa
                </button>
                <a href="{{ route('students.index') }}" class="btn-sf-cancel">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <span class="sf-req-note"><span>*</span> Wajib diisi</span>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('sfForm').addEventListener('submit', function() {
    const btn = document.getElementById('sfSubmitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split" style="animation: spin 1s linear infinite;"></i> Menyimpan...';
    btn.style.opacity = '0.75';
    btn.disabled = true;
});
</script>
@endsection