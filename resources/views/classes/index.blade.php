@extends('layouts.app')

@section('title', 'Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kelas</li>
@endsection

@section('content')
@php $isAdmin = auth()->user()->role === 'admin'; @endphp

<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Kelas</h1>
        <p class="ph-sub">Pilih tingkat, lalu rombel untuk membuka mata pelajaran dan soal kelas tersebut.</p>
    </div>
    @if($isAdmin)
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('promotion.index') }}" class="btn-ui btn-ui-ghost"><i class="bi bi-arrow-up-circle" aria-hidden="true"></i> Kenaikan Kelas</a>
            <a href="{{ route('classes.create') }}" class="btn-ui btn-ui-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Kelas</a>
        </div>
    @endif
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:var(--s5);margin-bottom:var(--s5)">
    @foreach($byGrade as $grade => $rombels)
        <section class="card-ui">
            <div class="card-ui-head">
                <h2 class="card-ui-title">Kelas {{ $grade }} <span class="pill">{{ $rombels->count() }} rombel</span></h2>
            </div>
            <div class="card-ui-body">
                <label for="grade-{{ $grade }}" class="form-label" style="font-size:.8rem">Rombel</label>
                <select id="grade-{{ $grade }}" class="form-select" data-class-nav @disabled($rombels->isEmpty())>
                    <option value="">{{ $rombels->isEmpty() ? 'Belum ada rombel' : '— Pilih rombel —' }}</option>
                    @foreach($rombels as $r)
                        <option value="{{ route('classes.show', $r->class_id) }}">{{ $r->class_name }} · {{ $r->academic_year }}</option>
                    @endforeach
                </select>
            </div>
        </section>
    @endforeach
</div>

@if($isAdmin && $unassigned->isNotEmpty())
<section class="card-ui">
    <div class="card-ui-head">
        <h2 class="card-ui-title">Perlu diatur tingkatnya <span class="pill">{{ $unassigned->count() }}</span></h2>
    </div>
    <div class="card-ui-body">
        <p class="text-muted" style="font-size:.85rem">Nama kelas lama ini tidak bisa dikonversi otomatis. Edit untuk menentukan tingkat dan rombel.</p>
        <div class="d-flex flex-wrap gap-2">
            @foreach($unassigned as $c)
                <a href="{{ route('classes.edit', $c->class_id) }}" class="btn-ui btn-ui-ghost"><i class="bi bi-pencil" aria-hidden="true"></i> {{ $c->class_name }}</a>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
document.querySelectorAll('[data-class-nav]').forEach(function (el) {
    el.addEventListener('change', function () { if (el.value) { window.location.href = el.value; } });
});
</script>
@endsection
