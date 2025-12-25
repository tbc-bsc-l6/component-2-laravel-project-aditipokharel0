<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrolments')
            ->withPivot(['start_date', 'completion_date', 'result'])
            ->withTimestamps();
    }
}
