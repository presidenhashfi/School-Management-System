<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Submission;
use App\Models\Teacher;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    /** Soal dikelola dari halaman kelas; daftar mandiri tidak lagi dipakai. */
    public function index()
    {
        return redirect()->route('classes.index');
    }

    public function create(Request $request)
    {
        [$class, $subject] = $this->resolveScope($request->query('class_id'), $request->query('subject_id'));

        return view('assignments.create', compact('class', 'subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);
        [$class, $subject] = $this->resolveScope($request->class_id, $request->subject_id);

        $data = $this->validated($request) + [
            'class_id' => $class->class_id,
            'subject_id' => $subject->subject_id,
            'created_by' => auth()->id(),
        ];
        Assignment::create($data);

        return redirect()->route('classes.show', $class->class_id)->with('success', 'Soal berhasil dibuat!');
    }

    public function show($id)
    {
        $assignment = $this->findAccessible($id);
        $assignment->load('subject', 'author', 'class');

        $user = auth()->user();
        $submission = null;
        $submissions = collect();

        if ($user->role === 'student') {
            $submission = $assignment->submissions()
                ->where('student_id', $this->currentStudent()->student_id)
                ->first();
        } else {
            $submissions = $assignment->submissions()->with('student')->latest('submitted_at')->get();
        }

        return view('assignments.show', compact('assignment', 'submission', 'submissions'));
    }

    public function edit($id)
    {
        $assignment = $this->findManageable($id);
        $class = $assignment->class;
        abort_unless($class, 404, 'Soal ini belum terhubung ke kelas. Buat ulang dari halaman kelas.');

        return view('assignments.edit', [
            'assignment' => $assignment,
            'class' => $class,
            'subject' => $assignment->subject,
        ]);
    }

    public function update(Request $request, $id)
    {
        $assignment = $this->findManageable($id);
        $assignment->update($this->validated($request)); // kelas & mapel tidak bisa dipindah

        return redirect()->route('assignments.show', $assignment->assignment_id)
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $assignment = $this->findManageable($id);
        $assignment->update(['archived' => 1]); // Soft delete, konsisten dengan modul lain

        return $assignment->class_id
            ? redirect()->route('classes.show', $assignment->class_id)->with('success', 'Soal berhasil dihapus!')
            : redirect()->route('classes.index')->with('success', 'Soal berhasil dihapus!');
    }

    public function submit(Request $request, $id)
    {
        $assignment = $this->findAccessible($id);
        $student = $this->currentStudent();

        if ($assignment->isClosed()) {
            return back()->with('error', 'Batas waktu pengumpulan sudah lewat.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:10240',
        ], [
            'file.required' => 'Pilih file PDF terlebih dahulu.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.mimetypes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $file = $request->file('file');
        $path = $file->store("submissions/{$assignment->assignment_id}", 'local');

        $existing = Submission::where('assignment_id', $assignment->assignment_id)
            ->where('student_id', $student->student_id)
            ->first();

        if ($existing) {
            Storage::disk('local')->delete($existing->file_path);
        }

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->assignment_id, 'student_id' => $student->student_id],
            [
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'submitted_at' => now(),
            ]
        );

        return back()->with('success', 'Jawaban PDF berhasil dikumpulkan!');
    }

    public function download($id)
    {
        $submission = Submission::with('assignment')->findOrFail($id);
        $user = auth()->user();

        if ($user->role === 'student') {
            abort_unless($submission->student_id === $this->currentStudent()->student_id, 403);
        } else {
            $this->authorizeManage($submission->assignment);
        }

        abort_unless(Storage::disk('local')->exists($submission->file_path), 404, 'File tidak ditemukan.');

        return Storage::disk('local')->download($submission->file_path, $submission->original_name);
    }

    // ------------------------------------------------------------------

    /**
     * Pastikan kombinasi kelas + mapel valid: mapel harus berada pada tingkat kelas,
     * dan guru hanya boleh untuk mapel yang diampunya.
     */
    private function resolveScope($classId, $subjectId): array
    {
        $class = Classes::where('archived', 0)->findOrFail($classId);
        $subject = Subject::where('archived', 0)->findOrFail($subjectId);

        abort_unless($class->grade && $subject->grade === $class->grade, 422, 'Mapel tidak termasuk dalam tingkat kelas ini.');

        if (auth()->user()->role === 'teacher') {
            abort_unless($subject->subject_id === $this->teacherSubjectId(), 403);
        }

        return [$class, $subject];
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:200000',
            'due_at' => 'nullable|date',
        ]);

        $data['description'] = HtmlSanitizer::clean($data['description']);

        // Editor kosong menyisakan "<p><br></p>"; cek teks aslinya.
        if (trim(html_entity_decode(strip_tags($data['description']))) === '') {
            throw ValidationException::withMessages(['description' => 'Isi soal wajib diisi.']);
        }

        return $data;
    }

    private function teacherSubjectId(): int
    {
        $teacher = Teacher::where('user_id', auth()->id())->where('archived', 0)->first();
        abort_unless($teacher, 403, 'Data guru tidak ditemukan.');

        return $teacher->subject_id;
    }

    private function currentStudent(): Student
    {
        $student = Student::where('user_id', auth()->id())->where('archived', 0)->where('status', 'active')->first();
        abort_unless($student, 403, 'Data siswa aktif tidak ditemukan.');

        return $student;
    }

    private function authorizeManage(Assignment $assignment): void
    {
        if (auth()->user()->role === 'teacher') {
            abort_unless($assignment->subject_id === $this->teacherSubjectId(), 403);
        }
    }

    private function findAccessible($id): Assignment
    {
        $assignment = Assignment::where('archived', 0)->findOrFail($id);

        if (auth()->user()->role === 'teacher') {
            $this->authorizeManage($assignment);
        }

        // Siswa hanya boleh mengakses soal untuk kelasnya sendiri.
        if (auth()->user()->role === 'student') {
            abort_unless($assignment->class_id === $this->currentStudent()->class_id, 403, 'Soal ini bukan untuk kelas Anda.');
        }

        return $assignment;
    }

    private function findManageable($id): Assignment
    {
        $assignment = Assignment::where('archived', 0)->findOrFail($id);
        $this->authorizeManage($assignment);

        return $assignment;
    }
}
