@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
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
    .sf-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23f97316' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 1rem center; }
</style>

<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-pencil-square"></i></div>
            <p class="sf-side-title">Edit Data Kelas</p>
            <p class="sf-side-desc">Perbarui informasi kelas. Pastikan semua data sudah benar sebelum menyimpan.</p>
            <div class="sf-preview-card">
                <div class="sf-preview-label"><i class="bi bi-building"></i> Kelas yang diedit</div>
                <div class="d-flex align-items-center gap-3">
                    <div class="sf-preview-avatar"><i class="bi bi-building" style="font-size:1.1rem;"></i></div>
                    <div>
                        <div class="sf-preview-name">{{ $class->class_name }}</div>
                        <div class="sf-preview-sub">TA: {{ $class->academic_year }}</div>
                    </div>
                </div>
            </div>
            <div class="sf-edit-note"><i class="bi bi-info-circle-fill" style="flex-shrink:0;margin-top:2px;"></i> Perubahan tersimpan setelah klik <strong>"Update Data"</strong>.</div>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-shield-exclamation"></i> Perhatian</div>
            <ul>
                <li><i class="bi bi-exclamation-circle-fill"></i> Mengubah nama kelas mempengaruhi data siswa terkait</li>
                <li><i class="bi bi-exclamation-circle-fill"></i> Pastikan tahun ajaran formatnya benar: "2024/2025"</li>
            </ul>
        </div>
    </div>

    <div class="sf-main-card">
        <div class="sf-form-banner">
            <i class="bi bi-pencil-fill"></i>
            <span>Mengedit kelas <strong>{{ $class->class_name }}</strong></span>
            <span class="sf-edit-badge"><i class="bi bi-pencil-fill"></i> Mode Edit</span>
        </div>
        <form action="{{ route('classes.update', $class->class_id) }}" method="POST" id="sfForm">
            @csrf @method('PUT')
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Detail Kelas</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-field">
                    <label for="class_name"><i class="bi bi-building"></i> Nama Kelas <span class="req">*</span></label>
                    <input type="text" name="class_name" id="class_name" placeholder="Contoh: X IPA 1, XI IPS 2..." value="{{ old('class_name', $class->class_name) }}" autofocus required>
                    @error('class_name')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="academic_year"><i class="bi bi-calendar3"></i> Tahun Ajaran <span class="req">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" placeholder="Contoh: 2024/2025" value="{{ old('academic_year', $class->academic_year) }}" required>
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
                            <option value="{{ $teacher->teacher_id }}" {{ (old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->teacher_id) ? 'selected' : '' }}>
                                {{ $teacher->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('homeroom_teacher_id')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-update" id="sfBtn"><i class="bi bi-check-circle-fill"></i> Update Data Kelas</button>
                <a href="{{ route('classes.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
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
