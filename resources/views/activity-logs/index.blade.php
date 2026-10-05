@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Log Aktivitas</li>
@endsection

@section('content')
<div class="ph">
    <div>
        <div class="ph-eyebrow">Administrasi</div>
        <h1 class="ph-title">Log Aktivitas</h1>
        <p class="ph-sub">Riwayat aktivitas pengguna di dalam sistem.</p>
    </div>
</div>

<form method="GET" action="{{ route('activity-logs.index') }}" class="d-flex flex-wrap gap-2 mb-3">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="max-width:280px" placeholder="Cari user / deskripsi..." aria-label="Cari log">
    <select name="action" class="form-select" style="max-width:200px" aria-label="Filter aksi">
        <option value="">Semua aksi</option>
        @foreach($actions as $a)
            <option value="{{ $a }}" @selected(request('action') === $a)>{{ $a }}</option>
        @endforeach
    </select>
    <button class="btn-ui btn-ui-primary" type="submit"><i class="bi bi-search" aria-hidden="true"></i> Filter</button>
    @if(request()->hasAny(['q','action']))
        <a href="{{ route('activity-logs.index') }}" class="btn-ui btn-ui-ghost">Reset</a>
    @endif
</form>

<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Riwayat <span class="pill">{{ $logs->total() }}</span></h2>
    </div>
    <div class="tbl-wrap">
        <table class="tbl tbl-stack">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pengguna</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td data-label="Waktu">{{ $log->created_at?->format('d M Y H:i:s') }}</td>
                        <td data-label="Pengguna">
                            {{ $log->username ?? '-' }}
                            @if($log->role)<span class="tag tag-mono">{{ $log->role }}</span>@endif
                        </td>
                        <td data-label="Aksi"><span class="tag tag-accent">{{ $log->action }}</span></td>
                        <td data-label="Deskripsi">{{ $log->description }}</td>
                        <td data-label="IP">{{ $log->ip_address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-cell p-0">
                            <div class="empty">
                                <div class="empty-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></div>
                                <h3>Belum ada aktivitas</h3>
                                <p>Aktivitas pengguna akan tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="mt-3">{{ $logs->links('pagination::bootstrap-5') }}</div>
@endsection
