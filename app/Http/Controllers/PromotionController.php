<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classes::where('archived', 0)->whereNotNull('grade')
            ->orderBy('academic_year', 'desc')->orderBy('grade')->orderBy('section')->get();

        $from = null;
        $students = collect();
        $targets = collect();

        if ($request->filled('from')) {
            $from = $classes->firstWhere('class_id', (int) $request->from);
            abort_unless($from, 404);

            $students = Student::where('class_id', $from->class_id)
                ->where('archived', 0)->where('status', 'active')
                ->orderBy('full_name')->get();

            $next = $from->nextGrade();
            $targets = $next ? $classes->where('grade', $next)->values() : collect();
        }

        return view('promotion.index', [
            'classes' => $classes,
            'from' => $from,
            'students' => $students,
            'targets' => $targets,
            'isGraduating' => $from && $from->nextGrade() === null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_class_id' => 'required|integer|exists:tbl_classes,class_id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'integer',
            'target_class_id' => 'nullable|integer|exists:tbl_classes,class_id',
        ], [
            'student_ids.required' => 'Pilih minimal satu siswa.',
        ]);

        $from = Classes::findOrFail($request->from_class_id);
        $next = $from->nextGrade();

        $students = Student::where('class_id', $from->class_id)
            ->where('archived', 0)->where('status', 'active')
            ->whereIn('student_id', $request->student_ids)->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa valid yang dipilih.');
        }

        if ($next === null) {
            // Tingkat XII: lulus
            DB::transaction(fn () => $students->each->update(['status' => 'graduated']));

            return redirect()->route('promotion.index')
                ->with('success', $students->count() . ' siswa ditandai lulus.');
        }

        $target = Classes::where('archived', 0)->where('grade', $next)->find($request->target_class_id);
        if (! $target) {
            return back()->withInput()->with('error', "Pilih kelas tujuan pada tingkat {$next}.");
        }

        DB::transaction(fn () => $students->each->update(['class_id' => $target->class_id]));

        return redirect()->route('promotion.index', ['from' => $from->class_id])
            ->with('success', "{$students->count()} siswa naik dari {$from->class_name} ke {$target->class_name}.");
    }
}
