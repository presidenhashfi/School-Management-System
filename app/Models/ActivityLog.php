<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'tbl_activity_logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id', 'username', 'role', 'action',
        'subject_type', 'subject_id', 'description', 'ip_address',
    ];

    /**
     * Catat aktivitas. Aktor diambil dari user yang sedang login
     * kecuali $actor diberikan (mis. saat login/logout).
     */
    public static function record(string $action, string $description, ?Model $subject = null, ?User $actor = null, ?string $label = null): void
    {
        try {
            $actor ??= auth()->user();

            static::create([
                'user_id'      => $actor?->user_id,
                'username'     => $actor?->username ?? $label,
                'role'         => $actor?->role,
                'action'       => $action,
                'subject_type' => $subject ? class_basename($subject) : null,
                'subject_id'   => $subject?->getKey(),
                'description'  => $description,
                'ip_address'   => request()?->ip(),
            ]);
        } catch (\Throwable $e) {
            report($e); // logging tidak boleh menggagalkan proses utama
        }
    }
}
