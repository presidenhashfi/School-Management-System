@extends('layouts.app')

@section('title', 'Daftar Kelas & Soal')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kelas</li>
@endsection

@section('content')
@php
    $isAdmin = auth()->user()->role === 'admin';
    $gradeConfig = [
        'X'   => [
            'theme'    => 'x',
            'icon'     => 'bi-backpack2-fill',
            'stage'    => 'Tingkat Awal',
            'sub'      => 'Masa Adaptasi & Fondasi Akademik',
            'desc'     => 'Pilih rombel untuk membuka materi, mata pelajaran, dan soal latihan kelas 10.',
            'emptyMsg' => 'Belum ada rombel untuk Kelas X.',
        ],
        'XI'  => [
            'theme'    => 'xi',
            'icon'     => 'bi-book-half',
            'stage'    => 'Tingkat Menengah',
            'sub'      => 'Pendalaman Materi & Keilmuan',
            'desc'     => 'Pilih rombel untuk membuka materi, mata pelajaran, dan tugas aktif kelas 11.',
            'emptyMsg' => 'Belum ada rombel untuk Kelas XI.',
        ],
        'XII' => [
            'theme'    => 'xii',
            'icon'     => 'bi-mortarboard-fill',
            'stage'    => 'Tingkat Akhir',
            'sub'      => 'Persiapan Kelulusan & Ujian Akhir',
            'desc'     => 'Pilih rombel untuk membuka materi, persiapan kelulusan, dan tugas kelas 12.',
            'emptyMsg' => 'Belum ada rombel untuk Kelas XII.',
        ],
    ];
@endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow"><i class="bi bi-mortarboard" aria-hidden="true"></i> Ruang Akademik</div>
        <h1 class="ph-title">Tingkatan &amp; Ruang Kelas</h1>
        <p class="ph-sub">Pilih tingkatan kelas dan rombel untuk mengakses mata pelajaran serta pembuatan soal tugas.</p>
    </div>
    @if($isAdmin)
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('promotion.index') }}" class="btn-ui btn-ui-ghost">
                <i class="bi bi-arrow-up-circle-fill text-primary" aria-hidden="true"></i> Kenaikan Kelas
            </a>
            <a href="{{ route('classes.create') }}" class="btn-ui btn-ui-primary">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Kelas Baru
            </a>
        </div>
    @endif
</div>

{{-- 3 Grade Tiers (X, XI, XII) --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(310px,1fr));gap:var(--s5);margin-bottom:var(--s6)">
    @foreach($byGrade as $grade => $rombels)
        @php $cfg = $gradeConfig[$grade] ?? ['theme' => 'x', 'icon' => 'bi-building-fill', 'stage' => 'Tingkat Kelas', 'sub' => 'Akademik', 'desc' => 'Daftar rombel kelas', 'emptyMsg' => 'Belum ada rombel.']; @endphp
        <section class="grade-card grade-card-{{ $cfg['theme'] }}">
            <div class="grade-card-hero">
                <div class="grade-badge-wrap">
                    <div class="grade-icon grade-icon-{{ $cfg['theme'] }}">
                        <i class="bi {{ $cfg['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="grade-card-subtitle">{{ $cfg['stage'] }}</div>
                        <h2 class="grade-card-title">Kelas {{ $grade }}</h2>
                    </div>
                </div>
                <span class="pill">{{ $rombels->count() }} rombel</span>
            </div>

            <div style="padding:var(--s4) var(--s5) var(--s2)">
                <p style="font-size:.84rem;color:var(--muted);margin:0;line-height:1.5">{{ $cfg['desc'] }}</p>
            </div>

            @if($rombels->isEmpty())
                <div style="padding:var(--s5);text-align:center">
                    <div style="width:44px;height:44px;border-radius:12px;background:var(--surface-2);color:var(--faint);display:grid;place-items:center;margin:0 auto var(--s3);font-size:1.25rem;">
                        <i class="bi bi-inbox" aria-hidden="true"></i>
                    </div>
                    <p style="font-size:.85rem;color:var(--muted);margin:0 0 var(--s3)">{{ $cfg['emptyMsg'] }}</p>
                    @if($isAdmin)
                        <a href="{{ route('classes.create', ['grade' => $grade]) }}" class="btn-ui btn-ui-ghost" style="font-size:.8rem;padding:.4rem .9rem;min-height:34px">
                            <i class="bi bi-plus-lg"></i> Tambah Rombel {{ $grade }}
                        </a>
                    @endif
                </div>
            @else
                <div style="padding:var(--s3) var(--s5) 0">
                    <label class="form-label" style="font-size:.76rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:.4rem">
                        Pilih Rombel / Ruang:
                    </label>
                </div>
                <div class="rombel-chips">
                    @foreach($rombels as $r)
                        <a href="{{ route('classes.show', $r->class_id) }}" class="rombel-chip" title="Buka {{ $r->class_name }}">
                            <span><i class="bi bi-door-open-fill text-muted" aria-hidden="true"></i> {{ $r->class_name }}</span>
                            <span class="rombel-year">{{ $r->academic_year }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
</div>

@if($isAdmin && $unassigned->isNotEmpty())
<section class="card-ui" style="border-left:4px solid var(--warn);">
    <div class="card-ui-head" style="background:var(--warn-soft)">
        <h2 class="card-ui-title" style="color:var(--warn)">
            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
            Perlu Diatur Tingkat Kelas <span class="pill" style="background:#fff">{{ $unassigned->count() }} kelas</span>
        </h2>
    </div>
    <div class="card-ui-body">
        <p class="text-muted" style="font-size:.88rem;margin-bottom:var(--s4)">
            Data kelas berikut dibuat dengan format nama bebas sebelumnya dan belum diklasifikasikan ke tingkat <strong>X, XI, atau XII</strong>. Klik kelas untuk melengkapi tingkat dan rombelnya:
        </p>
        <div class="d-flex flex-wrap gap-2">
            @foreach($unassigned as $c)
                <a href="{{ route('classes.edit', $c->class_id) }}" class="btn-ui btn-ui-ghost" style="border-color:var(--warn-line)">
                    <i class="bi bi-pencil-fill" style="color:var(--warn)" aria-hidden="true"></i> {{ $c->class_name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
