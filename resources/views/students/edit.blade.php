@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')

<div class="sf-outer">
    {{-- ═══ LEFT SIDEBAR ═══ --}}
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <p class="sf-side-title">Edit Data Siswa</p>
            <p class="sf-side-desc">Perbarui informasi siswa di bawah ini. Pastikan semua data sudah benar sebelum menyimpan.</p>

            {{-- Student Preview --}}
            <div class="sf-student-preview">
                <div class="sf-preview-label">
                    <i class="bi bi-person-circle"></i> Siswa yang diedit
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="sf-preview-avatar">
                        {{ strtoupper(substr($student->full_name, 0, 2)) }}
                    </div>
                    <div class="sf-preview-info">
                        <div class="sf-preview-name">{{ $student->full_name }}</div>
                        <div class="sf-preview-nis">NIS: {{ $student->nis }}</div>
                    </div>
                </div>
            </div>

            <div class="sf-edit-note">
                <i class="bi bi-info-circle-fill" style="flex-shrink:0; margin-top:2px;"></i>
                Perubahan akan langsung tersimpan ke database setelah klik <strong>"Update Data"</strong>.
            </div>
        </div>

        <div class="sf-tips-card">
            <div class="tips-title">
                <i class="bi bi-shield-exclamation"></i> Perhatian
            </div>
            <ul>
                <li>
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Pastikan NIS tidak bentrok dengan siswa lain
                </li>
                <li>
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Mengubah akun akan memindahkan akses login siswa
                </li>
                <li>
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Kelas yang diubah akan mempengaruhi laporan akademik
                </li>
            </ul>
        </div>
    </div>

    {{-- ═══ MAIN FORM CARD ═══ --}}
    <div class="sf-main-card">

        {{-- Top banner --}}
        <div class="sf-form-banner">
            <i class="bi bi-pencil-fill"></i>
            <span>Anda sedang mengedit data <strong>{{ $student->full_name }}</strong></span>
            <span class="sf-edit-badge"><i class="bi bi-pencil-fill"></i> Mode Edit</span>
        </div>

        <form action="{{ route('students.update', $student->student_id) }}" method="POST" id="sfForm">
            @csrf
            @method('PUT')

            {{-- SECTION 1 --}}
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
                            <option value="">— Pilih akun pengguna —</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}"
                                    {{ (old('user_id', $student->user_id) == $user->user_id) ? 'selected' : '' }}>
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
                                <option value="{{ $kelas->class_id }}"
                                    {{ (old('class_id', $student->class_id) == $kelas->class_id) ? 'selected' : '' }}>
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

            {{-- SECTION 2 --}}
            <div class="sf-section-header" style="margin-top:1.25rem;">
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
                               value="{{ old('nis', $student->nis) }}" required>
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
                               value="{{ old('date_of_birth', $student->date_of_birth) }}">
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="sf-field" style="grid-column: 1 / -1;">
                        <label for="full_name">
                            <i class="bi bi-type"></i>
                            Nama Lengkap <span class="req">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name"
                               placeholder="Masukkan nama lengkap siswa..."
                               value="{{ old('full_name', $student->full_name) }}" required>
                        @error('full_name')
                            <div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="sf-footer">
                <button type="submit" class="btn-sf-update" id="sfUpdateBtn">
                    <i class="bi bi-check-circle-fill"></i> Update Data Siswa
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
    const btn = document.getElementById('sfUpdateBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengupdate...';
    btn.style.opacity = '0.75';
    btn.disabled = true;
});
</script>
@endsection