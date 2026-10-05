@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<style>


.sf-outer {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.75rem;
    max-width: 960px;
    margin: 0 auto;
    align-items: start;
}

@media (max-width: 860px) {
    .sf-outer { grid-template-columns: 1fr; }
}

/* ----- LEFT SIDEBAR ----- */
.sf-sidebar { position: sticky; top: 82px; }

.sf-sidebar-card {
    background: linear-gradient(160deg, #d97706 0%, #ea580c 55%, #dc2626 100%);
    border-radius: 24px;
    padding: 2rem 1.75rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(234,88,12,0.4);
}

.sf-sidebar-card::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
    pointer-events: none;
}

.sf-sidebar-card::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -30px;
    width: 140px; height: 140px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    pointer-events: none;
}

.sf-side-icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,0.18);
    border: 1.5px solid rgba(255,255,255,0.3);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(6px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    position: relative; z-index: 1;
}

.sf-side-title {
    font-size: 1.25rem;
    font-weight: 800;
    margin: 0 0 0.4rem;
    letter-spacing: -0.3px;
    position: relative; z-index: 1;
}

.sf-side-desc {
    font-size: 0.82rem;
    opacity: 0.78;
    margin: 0 0 1.5rem;
    line-height: 1.5;
    position: relative; z-index: 1;
}

/* Student preview card */
.sf-student-preview {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    backdrop-filter: blur(6px);
    position: relative; z-index: 1;
}

.sf-preview-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.7;
    margin-bottom: 0.65rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.sf-preview-avatar {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: rgba(255,255,255,0.25);
    border: 2px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}

.sf-preview-info { flex: 1; overflow: hidden; }

.sf-preview-name {
    font-weight: 700;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.15rem;
}

.sf-preview-nis {
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
    opacity: 0.7;
    font-weight: 600;
}

/* Warning note */
.sf-edit-note {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.77rem;
    opacity: 0.85;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    margin-top: 1rem;
    line-height: 1.45;
    position: relative; z-index: 1;
}

/* Tips card */
.sf-tips-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem 1.4rem;
    margin-top: 1.25rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #eef2f7;
}

.sf-tips-card .tips-title {
    font-size: 0.78rem;
    font-weight: 800;
    color: #ea580c;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.sf-tips-card ul { margin: 0; padding: 0; list-style: none; }

.sf-tips-card li {
    font-size: 0.78rem;
    color: #64748b;
    padding: 0.3rem 0;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    border-bottom: 1px solid #f8fafc;
    font-weight: 500;
    line-height: 1.4;
}

.sf-tips-card li:last-child { border-bottom: none; }
.sf-tips-card li i { color: #fb923c; font-size: 0.8rem; flex-shrink: 0; margin-top: 2px; }

/* ----- MAIN FORM CARD ----- */
.sf-main-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
    border: 1px solid #eef2f7;
}

/* Form top banner */
.sf-form-banner {
    background: linear-gradient(135deg, #fff7ed, #ffedd5);
    border-bottom: 1px solid #fed7aa;
    padding: 1rem 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sf-form-banner i { color: #ea580c; font-size: 0.9rem; }

.sf-form-banner span {
    font-size: 0.82rem;
    color: #92400e;
    font-weight: 600;
}

.sf-edit-badge {
    margin-left: auto;
    background: linear-gradient(135deg, #fed7aa, #fdba74);
    color: #9a3412;
    font-size: 0.7rem;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    border: 1px solid #fdba74;
}

/* Section header */
.sf-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.4rem 2rem 0;
    margin-bottom: 1.25rem;
}

.sf-section-num {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: white;
    font-size: 0.75rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 3px 8px rgba(245,158,11,0.4);
}

.sf-section-title { font-size: 0.85rem; font-weight: 700; color: #1e293b; }
.sf-section-line { flex: 1; height: 1px; background: linear-gradient(90deg, #e2e8f0, transparent); }

/* Fields */
.sf-fields { padding: 0 2rem; }

.sf-grid2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 1.25rem;
}

@media (max-width: 600px) { .sf-grid2 { grid-template-columns: 1fr; } }

.sf-field {
    margin-bottom: 1.3rem;
    position: relative;
}

.sf-field label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: 0.45rem;
}

.sf-field label i { font-size: 0.78rem; color: #fb923c; }
.sf-field .req { color: #ef4444; margin-left: 1px; }

.opt-pill {
    background: #f1f5f9;
    color: #94a3b8;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.sf-field input,
.sf-field select {
    width: 100%;
    border: 2px solid #e8ecf4;
    border-radius: 12px;
    padding: 0.72rem 1rem;
    font-size: 0.875rem;
    color: #1e293b;
    background: #f9fafb;
    transition: all 0.25s ease;
    font-family: 'Inter', sans-serif;
    outline: none;
    -webkit-appearance: none;
    appearance: none;
}

.sf-field select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23f97316' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
    cursor: pointer;
}

.sf-field input::placeholder { color: #c8d0dd; font-weight: 400; }

.sf-field input:focus,
.sf-field select:focus {
    border-color: #f97316;
    background: white;
    box-shadow: 0 0 0 4px rgba(249,115,22,0.1);
}

/* Changed field highlight */
.sf-field input:not(:placeholder-shown),
.sf-field select:not([value=""]) {
    background: white;
}

.sf-field::after {
    content: '';
    position: absolute;
    left: 0; bottom: 0;
    width: 0; height: 2px;
    background: linear-gradient(90deg, #f59e0b, #f97316);
    border-radius: 2px;
    transition: width 0.3s ease;
    pointer-events: none;
}

.sf-field:focus-within::after { width: 100%; }

/* Error */
.sf-error {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    color: #ef4444;
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 0.4rem;
    padding: 0.35rem 0.6rem;
    background: #fff5f5;
    border-radius: 7px;
    border-left: 3px solid #ef4444;
}

/* Divider */
.sf-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e8ecf4 30%, #e8ecf4 70%, transparent);
    margin: 0.5rem 0 0;
}

/* Footer */
.sf-footer {
    padding: 1.5rem 2rem 2rem;
    background: #fffbf5;
    border-top: 1px solid #fef3c7;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-sf-update {
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: white;
    border: none;
    padding: 0.82rem 2rem;
    border-radius: 14px;
    font-weight: 800;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.25s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 6px 20px rgba(245,158,11,0.4);
    cursor: pointer;
}

.btn-sf-update:hover {
    background: linear-gradient(135deg, #d97706, #ea580c);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 30px rgba(245,158,11,0.5);
    color: white;
}

.btn-sf-update:active { transform: translateY(-1px) scale(0.99); }

.btn-sf-cancel {
    background: transparent;
    color: #64748b;
    border: 2px solid #e2e8f0;
    padding: 0.8rem 1.5rem;
    border-radius: 14px;
    font-weight: 700;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-sf-cancel:hover {
    background: #f1f5f9;
    color: #374151;
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

.sf-req-note {
    margin-left: auto;
    font-size: 0.75rem;
    color: #94a3b8;
    font-weight: 500;
}

.sf-req-note span { color: #ef4444; }
</style>

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