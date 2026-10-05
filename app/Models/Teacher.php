<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'tbl_teachers';
    protected $primaryKey = 'teacher_id';
    protected $fillable = ['user_id', 'subject_id', 'full_name', 'nip', 'archived'];
}
