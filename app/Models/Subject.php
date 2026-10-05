<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'tbl_subjects';
    protected $primaryKey = 'subject_id';
    
    // Tambahkan baris ini:
    protected $fillable = ['subject_code', 'subject_name', 'credits', 'archived'];
}