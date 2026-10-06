<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Siswa langsung masuk ke kelasnya sendiri.
        if ($user->role === 'student') {
            $student = Student::where('user_id', $user->user_id)->where('archived', 0)->first();
            abort_unless($student, 403, 'Data siswa tidak ditemukan.');
            abort_if($student->status !== 'active', 403, 'Anda sudah lulus dan tidak terdaftar di kelas aktif.');

            return redirect()->route('classes.show', $student->class_id);
        }

        $all = Classes::where('archived', 0)->orderBy('academic_year', 'desc')->orderBy('section')->get();

        $byGrade = collect(Classes::GRADES)->mapWithKeys(fn ($g) => [$g => $all->where('grade', $g)->values()]);
        $unassigned = $all->whereNull('grade')->values(); // Data lama yang belum punya tingkat

        return view('classes.index', compact('byGrade', 'unassigned'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $class = Classes::where('archived', 0)->findOrFail($id);
        $student = null;

        if ($user->role === 'student') {
            $student = Student::where('user_id', $user->user_id)->where('archived', 0)->where('status', 'active')->first();
            abort_unless($student && $student->class_id === $class->class_id, 403, 'Anda bukan siswa kelas ini.');
        }

        $subjects = $class->subjects()->where('archived', 0)->orderBy('subject_name')->get();

        if ($user->role === 'teacher') {
            $teacher = Teacher::where('user_id', $user->user_id)->where('archived', 0)->first();
            abort_unless($teacher, 403, 'Data guru tidak ditemukan.');
            $subjects = $subjects->where('subject_id', $teacher->subject_id)->values();
        }

        $assignments = Assignment::where('archived', 0)
            ->where('class_id', $class->class_id)
            ->whereIn('subject_id', $subjects->pluck('subject_id'))
            ->withCount('submissions')
            ->latest()
            ->get()
            ->groupBy('subject_id');

        $submittedIds = $student
            ? \App\Models\Submission::where('student_id', $student->student_id)->pluck('assignment_id')->all()
            : [];

        $siblings = $class->grade
            ? Classes::where('archived', 0)->where('grade', $class->grade)->orderBy('section')->get()
            : collect();

        $homeroom = $class->homeroom_teacher_id ? Teacher::find($class->homeroom_teacher_id) : null;

        return view('classes.show', compact('class', 'subjects', 'assignments', 'submittedIds', 'siblings', 'homeroom'));
    }

    public function create()
    {
        $teachers = Teacher::where('archived', 0)->get();
        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        Classes::create($validated);
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        $teachers = Teacher::where('archived', 0)->get();
        return view('classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validated($request, $id);
        $class = Classes::findOrFail($id);
        $class->update($validated);
        return redirect()->route('classes.show', $class->class_id)->with('success', 'Kelas berhasil diubah!');
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->update(['archived' => 1]);
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus!');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        $data = $request->validate([
            'grade' => ['required', Rule::in(Classes::GRADES)],
            'section' => [
                'required', 'string', 'max:20',
                Rule::unique('tbl_classes')
                    ->where(fn ($q) => $q->where('grade', $request->grade)
                        ->where('academic_year', $request->academic_year)
                        ->where('archived', 0))
                    ->ignore($ignoreId, 'class_id'),
            ],
            'homeroom_teacher_id' => 'nullable|integer',
            'academic_year' => 'required|string|max:20',
        ], [
            'section.unique' => 'Kelas dengan tingkat, rombel, dan tahun ajaran ini sudah ada.',
        ]);

        $data['section'] = strtoupper(trim($data['section']));
        $data['class_name'] = $data['grade'] . ' ' . $data['section'];

        return $data;
    }
}