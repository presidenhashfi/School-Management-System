@extends('layouts.app')

@section('title', 'Kenaikan Kelas & Kelulusan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Kelas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kenaikan Kelas</li>
@endsection

@section('content')
<div class="ph">
    <div>
        <div class="ph-eyebrow"><i class="bi bi-arrow-up-circle-fill"></i> Manajemen Akademik</div>
        <h1 class="ph-title">Kenaikan Kelas &amp; Kelulusan</h1>
        <p class="ph-sub">Proses kenaikan jenjang untuk siswa per rombel. Siswa Kelas XII yang diproses akan ditandai Lulus secara otomatis.</p>
    </div>
</div>

{{-- Step 1: Select Origin Class --}}
<section class="card-ui" style="margin-bottom:var(--s5)">
    <div class="card-ui-head">
        <h2 class="card-ui-title">
            <span class="sf-sec-num" style="width:22px;height:22px;font-size:.7rem">1</span>
            Pilih Ruang Kelas Asal
        </h2>
    </div>
    <div class="card-ui-body">
        <form method="GET" action="{{ route('promotion.index') }}" class="d-flex gap-3 flex-wrap align-items-end">
            <div style="flex:1;min-width:260px">
                <label for="from" class="form-label" style="font-size:.82rem;font-weight:700;color:var(--ink-2)">
                    Kelas Asal Siswa:
                </label>
                <select name="from" id="from" class="form-select" onchange="this.form.submit()" style="font-weight:700">
                    <option value="">— Pilih kelas yang ingin dinaikkan —</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->class_id }}" @selected($from && $from->class_id === $c->class_id)>
                            Kelas {{ $c->class_name }} (Tahun Ajaran {{ $c->academic_year }})
                        </option>
                    @endforeach
                </select>
            </div>
            <noscript><button class="btn-ui btn-ui-primary">Tampilkan Siswa</button></noscript>
        </form>
    </div>
</section>

{{-- Step 2: Destination & Student Selection --}}
@if($from)
<form method="POST" action="{{ route('promotion.store') }}" id="promoForm">
    @csrf
    <input type="hidden" name="from_class_id" value="{{ $from->class_id }}">
    
    <section class="card-ui">
        <div class="card-ui-head">
            <div class="d-flex align-items-center gap-2">
                <span class="sf-sec-num" style="width:22px;height:22px;font-size:.7rem">2</span>
                <h2 class="card-ui-title m-0">
                    Daftar Siswa {{ $from->class_name }}
                    <span class="pill">{{ $students->count() }} Siswa Aktif</span>
                </h2>
            </div>

            @if($isGraduating)
                <span class="tag" style="background:#faf5ff;color:#7c3aed;border-color:#e9d5ff;font-weight:800">
                    <i class="bi bi-mortarboard-fill me-1"></i> Status Akhir: Lulus (Wisuda)
                </span>
            @else
                <div class="d-flex align-items-center gap-2">
                    <label for="target_class_id" class="m-0 text-muted" style="font-size:.82rem;font-weight:700">Tujuan Kenaikan:</label>
                    <select name="target_class_id" id="target_class_id" class="form-select" style="width:auto;font-weight:800;font-size:.86rem" required>
                        <option value="">— Pilih Rombel Tujuan (Kelas {{ $from->nextGrade() }}) —</option>
                        @foreach($targets as $t)
                            <option value="{{ $t->class_id }}">{{ $t->class_name }} ({{ $t->academic_year }})</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        @if($isGraduating)
            <div style="background:#faf5ff;border-bottom:1px solid #e9d5ff;padding:var(--s4) var(--s5)">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;border-radius:12px;background:#ede9fe;color:#7c3aed;display:grid;place-items:center;font-size:1.35rem">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div>
                        <div style="font-weight:900;color:#5b21b6;font-size:.92rem">Kelulusan Siswa Tingkat XII</div>
                        <div style="font-size:.82rem;color:#6d28d9">
                            Siswa terpilih akan menyelesaikan studi di sekolah ini dan ditandai dengan status <strong>Lulus</strong>.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(! $isGraduating && $targets->isEmpty())
            <div class="card-ui-body">
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Belum ada rombel untuk tingkat <strong>Kelas {{ $from->nextGrade() }}</strong>. Harap buat kelas tujuan terlebih dahulu pada menu Tambah Kelas.
                </div>
            </div>
        @elseif($students->isEmpty())
            <div class="empty">
                <div class="empty-icon"><i class="bi bi-people" aria-hidden="true"></i></div>
                <h3>Tidak Ada Siswa Aktif</h3>
                <p>Kelas {{ $from->class_name }} saat ini tidak memiliki siswa aktif yang dapat diproses.</p>
            </div>
        @else
            <div class="tbl-wrap">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th style="width:52px"><input type="checkbox" id="checkAll" checked aria-label="Pilih semua siswa"></th>
                            <th>NIS</th>
                            <th>Nama Lengkap Siswa</th>
                            <th>Status Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td>
                                    <input type="checkbox" name="student_ids[]" value="{{ $s->student_id }}" class="row-check" checked aria-label="Pilih {{ $s->full_name }}">
                                </td>
                                <td><span class="tag tag-mono">{{ $s->nis }}</span></td>
                                <td class="cell-primary">
                                    <div class="cell-main">
                                        <div class="avatar" style="width:30px;height:30px;font-size:.7rem" aria-hidden="true">
                                            {{ strtoupper(substr($s->full_name, 0, 2)) }}
                                        </div>
                                        <span class="cell-name">{{ $s->full_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="tag tag-accent tag-dot">Siswa Aktif</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-ui-body bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span class="text-muted" style="font-size:.82rem">
                    <i class="bi bi-info-circle me-1"></i> Siswa yang tidak dicentang akan tetap berada di kelas saat ini (tinggal kelas).
                </span>
                <button type="submit" class="btn-ui btn-ui-primary" onclick="return confirm('{{ $isGraduating ? 'Konfirmasi kelulusan untuk seluruh siswa terpilih?' : 'Konfirmasi kenaikan kelas untuk siswa terpilih?' }}')">
                    <i class="bi {{ $isGraduating ? 'bi-mortarboard-fill' : 'bi-arrow-up-circle-fill' }}" aria-hidden="true"></i>
                    {{ $isGraduating ? 'Proses Kelulusan Siswa Terpilih' : 'Proses Kenaikan Siswa Terpilih' }}
                </button>
            </div>
        @endif
    </section>
</form>

<script>
var all = document.getElementById('checkAll');
if (all) {
    all.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(function (c) { c.checked = all.checked; });
    });
}
</script>
@endif
@endsection
