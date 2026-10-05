@extends('layouts.app')

@section('title', 'Edit Akun')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
@include('_partials.page-styles')
<div class="sf-outer">
    @include('users._form', ['action' => route('users.update', $user->user_id)])
</div>
@endsection
