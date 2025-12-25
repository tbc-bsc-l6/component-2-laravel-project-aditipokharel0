<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ---------- ROLE HELPERS ----------

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isOldStudent()
    {
        return $this->role === 'old_student';
    }

    // ---------- RELATIONSHIPS ----------

    public function modulesTeaching()
    {
        return $this->hasMany(Module::class, 'teacher_id');
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'enrolments')
            ->withPivot(['start_date', 'completion_date', 'result'])
            ->withTimestamps();
    }
}
