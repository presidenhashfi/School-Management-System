<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Teacher;

class ClassesController extends Controller
{
    public function index()
    {
        // Menggunakan JOIN untuk mengambil nama wali kelas
        $classes = Classes::select('tbl_classes.*', 'tbl_teachers.full_name as homeroom')
            ->leftJoin('tbl_teachers', 'tbl_classes.homeroom_teacher_id', '=', 'tbl_teachers.teacher_id')
            ->where('tbl_classes.archived', 0)
            ->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::where('archived', 0)->get();
        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:50',
            'homeroom_teacher_id' => 'nullable|integer',
            'academic_year' => 'required|string|max:20',
        ]);
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
        $validated = $request->validate([
            'class_name' => 'required|string|max:50',
            'homeroom_teacher_id' => 'nullable|integer',
            'academic_year' => 'required|string|max:20',
        ]);
        $class = Classes::findOrFail($id);
        $class->update($validated);
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diubah!');
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->update(['archived' => 1]);
        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus!');
    }
}