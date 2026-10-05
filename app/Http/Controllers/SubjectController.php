<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('archived', 0)->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create'); // Akan kita buat nanti
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:10|unique:tbl_subjects,subject_code',
            'subject_name' => 'required|string|max:100',
            'credits' => 'required|integer',
        ]);

        Subject::create($validated);
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:10|unique:tbl_subjects,subject_code,' . $id . ',subject_id',
            'subject_name' => 'required|string|max:100',
            'credits' => 'required|integer',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($validated);
        
        return redirect()->route('subjects.index')->with('success', 'Data mata pelajaran berhasil diubah!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update(['archived' => 1]); // Soft delete
        
        return redirect()->route('subjects.index')->with('success', 'Data mata pelajaran berhasil dihapus!');
    }
}