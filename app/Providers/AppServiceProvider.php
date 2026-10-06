<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Assignment;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerAuthLogs();
        $this->registerModelLogs();
    }

    private function registerAuthLogs(): void
    {
        Event::listen(Login::class, fn (Login $e) =>
            ActivityLog::record('login', 'Login ke sistem', null, $e->user));

        Event::listen(Logout::class, fn (Logout $e) =>
            $e->user && ActivityLog::record('logout', 'Logout dari sistem', null, $e->user));

        Event::listen(Failed::class, fn (Failed $e) =>
            ActivityLog::record('login_failed', 'Percobaan login gagal untuk email ' . ($e->credentials['email'] ?? '-'), null, null, $e->credentials['email'] ?? null));
    }

    private function registerModelLogs(): void
    {
        $labels = [
            User::class    => ['akun',       fn ($m) => $m->username],
            Student::class => ['siswa',      fn ($m) => $m->full_name ?? $m->getKey()],
            Teacher::class => ['guru',       fn ($m) => $m->full_name ?? $m->getKey()],
            Classes::class => ['kelas',      fn ($m) => $m->class_name ?? $m->getKey()],
            Subject::class => ['mata pelajaran', fn ($m) => $m->subject_name ?? $m->getKey()],
            Assignment::class => ['soal', fn ($m) => $m->title ?? $m->getKey()],
        ];

        foreach ($labels as $class => [$noun, $name]) {
            $class::created(fn (Model $m) =>
                ActivityLog::record('created', "Menambah {$noun} \"{$name($m)}\"", $m));

            $class::updated(function (Model $m) use ($noun, $name) {
                $changed = array_keys(array_diff_key($m->getChanges(), ['updated_at' => 1]));

                // Penghapusan (soft delete via archived)
                if (in_array('archived', $changed) && $m->archived) {
                    return ActivityLog::record('deleted', "Menghapus {$noun} \"{$name($m)}\"", $m);
                }
                if (! $changed) {
                    return;
                }
                $fields = implode(', ', array_map(fn ($f) => $f === 'password' ? 'password' : $f, $changed));
                ActivityLog::record('updated', "Mengubah {$noun} \"{$name($m)}\" ({$fields})", $m);
            });

            $class::deleted(fn (Model $m) =>
                ActivityLog::record('deleted', "Menghapus {$noun} \"{$name($m)}\"", $m));
        }
    }
}
