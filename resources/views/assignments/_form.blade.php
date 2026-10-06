@php($isEdit = isset($assignment))
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
@endpush

<form action="{{ $isEdit ? route('assignments.update', $assignment->assignment_id) : route('assignments.store') }}" method="POST" id="sfForm">
    @csrf
    @if($isEdit)
        @method('PUT')
    @else
        <input type="hidden" name="class_id" value="{{ $class->class_id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->subject_id }}">
    @endif

    <div class="sf-sec-hdr">
        <div class="sf-sec-num">1</div>
        <div class="sf-sec-title">Informasi Soal</div>
        <div class="sf-sec-line"></div>
    </div>
    <div class="sf-fields">
        <div class="sf-grid2">
            <div class="sf-field">
                <label><i class="bi bi-building"></i> Kelas</label>
                <div><span class="tag tag-accent">{{ $class->class_name }}</span> <span class="text-muted" style="font-size:.8rem">{{ $class->academic_year }}</span></div>
            </div>
            <div class="sf-field">
                <label><i class="bi bi-journal-text"></i> Mata Pelajaran</label>
                <div><span class="tag tag-mono">{{ $subject->subject_code }}</span> {{ $subject->subject_name }}</div>
            </div>
            <div class="sf-field">
                <label for="due_at"><i class="bi bi-calendar-event"></i> Batas Pengumpulan</label>
                <input type="datetime-local" name="due_at" id="due_at"
                       value="{{ old('due_at', isset($assignment) && $assignment->due_at ? $assignment->due_at->format('Y-m-d\TH:i') : '') }}">
                @error('due_at')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
            </div>
            <div class="sf-field" style="grid-column:1/-1;">
                <label for="title"><i class="bi bi-type"></i> Judul Soal <span class="req">*</span></label>
                <input type="text" name="title" id="title" maxlength="150" placeholder="Contoh: Latihan Bab 3 — Persamaan Linear"
                       value="{{ old('title', $assignment->title ?? '') }}" required>
                @error('title')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="sf-sec-hdr">
        <div class="sf-sec-num">2</div>
        <div class="sf-sec-title">Isi Soal</div>
        <div class="sf-sec-line"></div>
    </div>
    <div class="sf-fields">
        <div class="sf-field">
            <label id="editorLabel"><i class="bi bi-pencil-square"></i> Instruksi &amp; pertanyaan <span class="req">*</span></label>
            <div id="editor" aria-labelledby="editorLabel" style="min-height:260px;background:#fff;font-size:.95rem;"></div>
            <input type="hidden" name="description" id="description" value="{{ old('description', $assignment->description ?? '') }}">
            @error('description')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
        </div>
    </div>

    <div class="sf-footer">
        <button type="submit" class="btn-sf btn-sf-submit" id="sfBtn"><i class="bi bi-floppy-fill"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Soal' }}</button>
        <a href="{{ $isEdit ? route('assignments.show', $assignment->assignment_id) : route('classes.show', $class->class_id) }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
        <span class="sf-req-note"><span>*</span> Wajib diisi</span>
    </div>
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
(function () {
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis instruksi dan soal di sini...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ script: 'sub' }, { script: 'super' }],
                ['blockquote', 'code-block', 'link'],
                [{ align: [] }],
                ['clean']
            ]
        }
    });

    var field = document.getElementById('description');
    if (field.value) { quill.clipboard.dangerouslyPasteHTML(field.value); }

    var form = document.getElementById('sfForm');
    form.addEventListener('submit', function (e) {
        if (quill.getText().trim().length === 0) {
            e.preventDefault();
            quill.focus();
            alert('Isi soal wajib diisi.');
            return;
        }
        field.value = quill.root.innerHTML;
        var b = document.getElementById('sfBtn');
        b.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        b.disabled = true;
    });
})();
</script>
@endpush
