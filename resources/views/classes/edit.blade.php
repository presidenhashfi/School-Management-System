@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
@include('_partials.page-styles')

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
                    <label for="grade"><i class="bi bi-layers"></i> Tingkat <span class="req">*</span></label>
                    <select name="grade" id="grade" required autofocus>
                        <option value="">— Pilih tingkat —</option>
                        @foreach(\App\Models\Classes::GRADES as $g)
                            <option value="{{ $g }}" @selected(old('grade', $class->grade) === $g)>Kelas {{ $g }}</option>
                        @endforeach
                    </select>
                    @error('grade')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="section"><i class="bi bi-building"></i> Rombel <span class="req">*</span></label>
                    <input type="text" name="section" id="section" maxlength="20" placeholder="Contoh: A, B, C" value="{{ old('section', $class->section) }}" required>
                    @error('section')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
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
