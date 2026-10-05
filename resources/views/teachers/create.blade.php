@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teachers</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('_partials.page-styles')

<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-person-plus-fill"></i></div>
            <p class="sf-side-title">Tambah Guru Baru</p>
            <p class="sf-side-desc">Lengkapi informasi untuk mendaftarkan guru baru ke sistem akademik.</p>
            <ul class="sf-steps">
                <li class="sf-step"><div class="sf-step-dot done">1</div><div class="sf-step-info"><strong>Akun & Mapel</strong><span>Pilih akun dan mata pelajaran</span></div></li>
                <li class="sf-step"><div class="sf-step-dot done">2</div><div class="sf-step-info"><strong>Data Pribadi</strong><span>NIP dan nama lengkap</span></div></li>
                <li class="sf-step"><div class="sf-step-dot">3</div><div class="sf-step-info"><strong>Simpan</strong><span>Konfirmasi & simpan data</span></div></li>
            </ul>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-lightbulb-fill"></i> Tips Pengisian</div>
            <ul>
                <li><i class="bi bi-check-circle-fill"></i> Pilih akun dengan role <strong>Teacher</strong></li>
                <li><i class="bi bi-check-circle-fill"></i> NIP harus unik dan tidak duplikat</li>
                <li><i class="bi bi-check-circle-fill"></i> Satu guru bisa mengampu satu mata pelajaran</li>
            </ul>
        </div>
    </div>

    <div class="sf-main-card">
        <form action="{{ route('teachers.store') }}" method="POST" id="sfForm">
            @csrf
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Informasi Akun & Mata Pelajaran</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-field">
                    <label for="user_id"><i class="bi bi-person-badge-fill"></i> Akun Pengguna (Role: Teacher) <span class="req">*</span></label>
                    <select name="user_id" id="user_id" autofocus required>
                        <option value="">— Pilih akun teacher —</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                {{ $user->username }} · {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="subject_id"><i class="bi bi-book-fill"></i> Mata Pelajaran yang Diampu <span class="req">*</span></label>
                    <select name="subject_id" id="subject_id" required>
                        <option value="">— Pilih mata pelajaran —</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->subject_id }}" {{ old('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                {{ $subject->subject_name }} ({{ $subject->subject_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
            </div>
            <div class="sf-divider"></div>
            <div class="sf-sec-hdr" style="margin-top:1.25rem;">
                <div class="sf-sec-num">2</div>
                <div class="sf-sec-title">Data Pribadi Guru</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-grid2">
                    <div class="sf-field">
                        <label for="nip"><i class="bi bi-person-vcard"></i> NIP <span class="req">*</span></label>
                        <input type="text" name="nip" id="nip" placeholder="Nomor Induk Pegawai..." value="{{ old('nip') }}" required>
                        @error('nip')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field">
                        <label for="full_name"><i class="bi bi-type"></i> Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="full_name" id="full_name" placeholder="Nama lengkap guru..." value="{{ old('full_name') }}" required>
                        @error('full_name')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-submit" id="sfBtn"><i class="bi bi-floppy-fill"></i> Simpan Data Guru</button>
                <a href="{{ route('teachers.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
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
