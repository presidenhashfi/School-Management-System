@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
@include('_partials.page-styles')
<div class="sf-outer">
    @include('users._form', ['action' => route('users.store')])
</div>
@endsection
