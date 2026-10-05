<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;

class TeacherController extends Controller
{
    public function index()
    {
        // Menggunakan JOIN untuk mengambil akun user dan mata pelajaran
        $teachers = Teacher::select('tbl_teachers.*', 'tbl_users.email', 'tbl_subjects.subject_name')
            ->leftJoin('tbl_users', 'tbl_teachers.user_id', '=', 'tbl_users.user_id')
            ->leftJoin('tbl_subjects', 'tbl_teachers.subject_id', '=', 'tbl_subjects.subject_id')
            ->where('tbl_teachers.archived', 0)
            ->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        // Ambil user dengan role teacher yang belum jadi guru
        $users = User::where('role', 'teacher')->where('archived', 0)
            ->whereNotIn('user_id', Teacher::where('archived', 0)->pluck('user_id'))->get();
        $subjects = Subject::where('archived', 0)->get();
        return view('teachers.create', compact('users', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'full_name' => 'required|string|max:100',
            'nip' => 'required|string|max:20|unique:tbl_teachers,nip',
        ]);
        Teacher::create($validated);
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $subjects = Subject::where('archived', 0)->get();
        $users = User::where('role', 'teacher')->where('archived', 0)
            ->where(function ($q) use ($teacher) {
                $q->whereNotIn('user_id', Teacher::where('archived', 0)->pluck('user_id'))
                  ->orWhere('user_id', $teacher->user_id);
            })->get();
        return view('teachers.edit', compact('teacher', 'users', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'full_name' => 'required|string|max:100',
            'nip' => 'required|string|max:20|unique:tbl_teachers,nip,' . $id . ',teacher_id',
        ]);
        $teacher = Teacher::findOrFail($id);
        $teacher->update($validated);
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil diubah!');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update(['archived' => 1]);
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil dihapus!');
    }
}