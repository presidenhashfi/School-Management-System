@extends('layouts.app')

@section('title', 'Edit Soal')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.show', $class->class_id) }}">{{ $class->class_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="sf-outer">
    <div class="sf-sidebar">
        <div class="sf-sidebar-card">
            <div class="sf-side-icon"><i class="bi bi-pencil-fill"></i></div>
            <p class="sf-side-title">Edit Soal</p>
            <p class="sf-side-desc">Perubahan isi soal langsung terlihat oleh siswa. Jawaban yang sudah dikumpulkan tidak terhapus.</p>
        </div>
    </div>
    <div class="sf-main-card">
        @include('assignments._form')
    </div>
</div>
@endsection
