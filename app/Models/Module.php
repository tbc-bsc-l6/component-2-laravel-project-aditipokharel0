<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Enrolment;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'is_active',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function activeEnrolments()
    {
        return $this->hasMany(Enrolment::class)->where('status', 'active');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrolments', 'module_id', 'student_id')
            ->withPivot(['start_date', 'completion_date', 'status', 'result', 'result_set_at'])
            ->withTimestamps();
    }

    public function activeStudents()
    {
        return $this->belongsToMany(User::class, 'enrolments', 'module_id', 'student_id')
            ->wherePivot('status', 'active')
            ->withPivot(['start_date', 'completion_date', 'status', 'result', 'result_set_at'])
            ->withTimestamps();
    }
}
