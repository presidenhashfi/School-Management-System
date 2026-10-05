<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'tbl_classes';
protected $primaryKey = 'class_id';
protected $fillable = ['class_name', 'homeroom_teacher_id', 'academic_year', 'archived'];
}
