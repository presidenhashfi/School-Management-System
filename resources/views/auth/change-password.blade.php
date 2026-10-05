@extends('layouts.app')

@section('title', 'Ganti Password')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
@endsection

@section('content')
@include('_partials.page-styles')
<div class="sf-outer">
    <div class="sf-main-card">
        <form action="{{ route('password.update') }}" method="POST" id="sfForm">
            @csrf @method('PUT')
            <div class="sf-sec-hdr">
                <div class="sf-sec-num">1</div>
                <div class="sf-sec-title">Ganti Password</div>
                <div class="sf-sec-line"></div>
            </div>
            <div class="sf-fields">
                <div class="sf-grid2">
                    <div class="sf-field" style="grid-column:1/-1;">
                        <label for="current_password"><i class="bi bi-lock"></i> Password Saat Ini <span class="req">*</span></label>
                        <input type="password" name="current_password" id="current_password" autocomplete="current-password" required autofocus>
                        @error('current_password')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field">
                        <label for="password"><i class="bi bi-key"></i> Password Baru <span class="req">*</span></label>
                        <input type="password" name="password" id="password" minlength="6" autocomplete="new-password" required>
                        @error('password')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="sf-field">
                        <label for="password_confirmation"><i class="bi bi-key-fill"></i> Konfirmasi Password Baru <span class="req">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>
                    </div>
                </div>
            </div>
            <div class="sf-footer">
                <button type="submit" class="btn-sf btn-sf-submit"><i class="bi bi-floppy-fill"></i> Simpan Password</button>
                <a href="{{ route('dashboard') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
