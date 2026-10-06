<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'tbl_students';
protected $primaryKey = 'student_id';
protected $fillable = ['user_id', 'class_id', 'nis', 'full_name', 'date_of_birth', 'status', 'archived'];
}
