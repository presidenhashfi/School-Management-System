@extends('layouts.app')

@section('title', 'Buat Soal')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.show', $class->class_id) }}">{{ $class->class_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Buat</li>
@endsection

@section('content')
<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
            <p class="sf-side-title">Buat Soal</p>
            <p class="sf-side-desc">Tulis soal dengan editor teks. Siswa akan menjawab dengan mengunggah file PDF.</p>
        </div>
        <div class="sf-tips-card">
            <div class="sf-tips-title"><i class="bi bi-lightbulb-fill"></i> Tips</div>
            <ul>
                <li><i class="bi bi-check-circle-fill"></i> Jelaskan format jawaban yang diharapkan</li>
                <li><i class="bi bi-check-circle-fill"></i> Jawaban siswa dibatasi PDF maksimal 10 MB</li>
                <li><i class="bi bi-check-circle-fill"></i> Kosongkan batas waktu jika tidak ada tenggat</li>
            </ul>
        </div>
    </div>
    <div class="sf-main-card">
        @include('assignments._form')
    </div>
</div>
@endsection
