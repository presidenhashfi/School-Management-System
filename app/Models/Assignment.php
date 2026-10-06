<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    protected $table = 'tbl_assignments';
    protected $primaryKey = 'assignment_id';
    protected $fillable = ['subject_id', 'class_id', 'created_by', 'title', 'description', 'due_at', 'archived'];

    protected function casts(): array
    {
        return ['due_at' => 'datetime'];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'assignment_id', 'assignment_id');
    }

    public function isClosed(): bool
    {
        return $this->due_at !== null && $this->due_at->isPast();
    }
}
