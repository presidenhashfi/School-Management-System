<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    public const GRADES = ['X', 'XI', 'XII'];

    protected $table = 'tbl_classes';
protected $primaryKey = 'class_id';
protected $fillable = ['class_name', 'grade', 'section', 'homeroom_teacher_id', 'academic_year', 'archived'];

    /** Mapel kelas ini = semua mapel pada tingkat yang sama. */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'grade', 'grade');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'class_id', 'class_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id', 'class_id');
    }

    /** Tingkat berikutnya, atau null bila sudah XII (lulus). */
    public function nextGrade(): ?string
    {
        $i = array_search($this->grade, self::GRADES, true);

        return $i === false ? null : (self::GRADES[$i + 1] ?? null);
    }
}
