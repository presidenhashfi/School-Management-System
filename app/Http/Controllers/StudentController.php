<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // Memenuhi syarat brief: Menggunakan JOIN
        $students = Student::select('tbl_students.*', 'tbl_classes.class_name', 'tbl_users.username')
            ->leftJoin('tbl_classes', 'tbl_students.class_id', '=', 'tbl_classes.class_id')
            ->leftJoin('tbl_users', 'tbl_students.user_id', '=', 'tbl_users.user_id')
            ->where('tbl_students.archived', 0)
            ->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = Classes::where('archived', 0)->get();
        // Ambil user yang rolenya student dan belum terikat dengan data siswa lain
        $users = User::where('role', 'student')
            ->where('archived', 0)
            ->whereNotIn('user_id', Student::where('archived', 0)->pluck('user_id'))
            ->get();

        return view('students.create', compact('classes', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'class_id' => 'required|integer',
            'full_name' => 'required|string|max:100',
            'nis' => 'required|string|max:20|unique:tbl_students,nis',
            'date_of_birth' => 'nullable|date',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = Classes::where('archived', 0)->get();
        // Ambil user student yang belum terikat, ditambah user milik siswa ini sendiri
        $users = User::where('role', 'student')
            ->where('archived', 0)
            ->where(function ($query) use ($student) {
                $query->whereNotIn('user_id', Student::where('archived', 0)->pluck('user_id'))
                      ->orWhere('user_id', $student->user_id);
            })->get();

        return view('students.edit', compact('student', 'classes', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'class_id' => 'required|integer',
            'full_name' => 'required|string|max:100',
            'nis' => 'required|string|max:20|unique:tbl_students,nis,' . $id . ',student_id',
            'date_of_birth' => 'nullable|date',
        ]);

        $student = Student::findOrFail($id);
        $student->update($validated);
        
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diubah!');
    }

    public function destroy($id)
    {
        // Memenuhi syarat brief: Soft Delete
        $student = Student::findOrFail($id);
        $student->update(['archived' => 1]);
        
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}