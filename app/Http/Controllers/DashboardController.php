<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data (mengabaikan yang di-soft delete / archived = 1)
        $studentsCount = Student::where('archived', 0)->count();
        $teachersCount = Teacher::where('archived', 0)->count();
        $classesCount = Classes::where('archived', 0)->count();
        $subjectsCount = Subject::where('archived', 0)->count();

        return view('dashboard.index', compact(
            'studentsCount', 'teachersCount', 'classesCount', 'subjectsCount'
        ));
    }
}