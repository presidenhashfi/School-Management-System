@extends('layouts.app')

@section('title', 'Manajemen Akun')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Akun</li>
@endsection

@section('content')
<div class="ph">
    <div>
        <div class="ph-eyebrow">Administrasi</div>
        <h1 class="ph-title">Manajemen Akun</h1>
        <p class="ph-sub">Buat, ubah, dan hapus akun pengguna serta tentukan role-nya.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Akun</a>
</div>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Daftar Akun <span class="pill">{{ $users->count() }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="t-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td class="num">{{ $index + 1 }}</td>
                        <td class="cell-primary" data-label="Username">
                            <div class="cell-main">
                                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($user->username, 0, 2)) }}</div>
                                <span class="cell-name">{{ $user->username }}</span>
                            </div>
                        </td>
                        <td data-label="Email">{{ $user->email }}</td>
                        <td data-label="Role"><span class="tag tag-accent">{{ ucfirst($user->role) }}</span></td>
                        <td class="cell-actions t-right">
                            <div class="act-wrap">
                                <a href="{{ route('users.edit', $user->user_id) }}" class="act-btn" title="Edit" aria-label="Edit {{ $user->username }}"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                                @if($user->user_id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="act-btn del" title="Hapus" aria-label="Hapus {{ $user->username }}" onclick="return confirm('Yakin hapus akun {{ $user->username }}?')"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></div>
                                <h3>Belum ada akun</h3>
                                <p>Tambahkan akun pertama untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
