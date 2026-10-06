@extends('layouts.app')

@section('title', 'Kenaikan Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kenaikan Kelas</li>
@endsection

@section('content')
<div class="ph">
    <div>
        <div class="ph-eyebrow">Akademik</div>
        <h1 class="ph-title">Kenaikan Kelas</h1>
        <p class="ph-sub">Pindahkan siswa ke tingkat berikutnya. Siswa kelas XII yang dipilih ditandai lulus. Siswa yang tidak dicentang tetap di kelasnya.</p>
    </div>
</div>

<section class="card-ui" style="margin-bottom:var(--s5)">
    <div class="card-ui-body">
        <form method="GET" action="{{ route('promotion.index') }}" class="d-flex gap-2 flex-wrap align-items-end">
            <div>
                <label for="from" class="form-label" style="font-size:.8rem">Kelas asal</label>
                <select name="from" id="from" class="form-select" onchange="this.form.submit()">
                    <option value="">— Pilih kelas —</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->class_id }}" @selected($from && $from->class_id === $c->class_id)>{{ $c->class_name }} · {{ $c->academic_year }}</option>
                    @endforeach
                </select>
            </div>
            <noscript><button class="btn-ui btn-ui-primary">Tampilkan</button></noscript>
        </form>
    </div>
</section>

@if($from)
<form method="POST" action="{{ route('promotion.store') }}" id="promoForm">
    @csrf
    <input type="hidden" name="from_class_id" value="{{ $from->class_id }}">
    <section class="card-ui">
        <div class="card-ui-head">
            <h2 class="card-ui-title">Siswa {{ $from->class_name }} <span class="pill">{{ $students->count() }}</span></h2>
            @if($isGraduating)
                <span class="tag tag-accent">Tujuan: Lulus</span>
            @else
                <div class="d-flex align-items-center gap-2">
                    <label for="target_class_id" class="m-0" style="font-size:.8rem">Naik ke</label>
                    <select name="target_class_id" id="target_class_id" class="form-select" style="width:auto" required>
                        <option value="">— Pilih kelas tujuan —</option>
                        @foreach($targets as $t)
                            <option value="{{ $t->class_id }}">{{ $t->class_name }} · {{ $t->academic_year }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        @if(! $isGraduating && $targets->isEmpty())
            <div class="card-ui-body"><div class="alert alert-warning mb-0">Belum ada kelas tingkat {{ $from->nextGrade() }}. Buat kelas tujuan terlebih dahulu.</div></div>
        @elseif($students->isEmpty())
            <div class="empty"><div class="empty-icon"><i class="bi bi-people" aria-hidden="true"></i></div><h3>Tidak ada siswa aktif</h3><p>Kelas ini tidak memiliki siswa untuk dinaikkan.</p></div>
        @else
            <div class="tbl-wrap">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th style="width:48px"><input type="checkbox" id="checkAll" checked aria-label="Pilih semua"></th>
                            <th>NIS</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td><input type="checkbox" name="student_ids[]" value="{{ $s->student_id }}" class="row-check" checked aria-label="Pilih {{ $s->full_name }}"></td>
                                <td><span class="tag tag-mono">{{ $s->nis }}</span></td>
                                <td class="cell-primary"><span class="cell-name">{{ $s->full_name }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-ui-body">
                <button type="submit" class="btn-ui btn-ui-primary" onclick="return confirm('{{ $isGraduating ? 'Tandai siswa terpilih sebagai lulus?' : 'Naikkan siswa terpilih ke kelas tujuan?' }}')">
                    <i class="bi bi-arrow-up-circle" aria-hidden="true"></i> {{ $isGraduating ? 'Luluskan Siswa Terpilih' : 'Naikkan Siswa Terpilih' }}
                </button>
            </div>
        @endif
    </section>
</form>
<script>
var all = document.getElementById('checkAll');
if (all) { all.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(function (c) { c.checked = all.checked; });
}); }
</script>
@endif
@endsection
