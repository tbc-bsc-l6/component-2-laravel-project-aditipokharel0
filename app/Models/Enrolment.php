<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $fillable = [
    'module_id',
    'student_id',
    'user_id',
    'start_date',
    'completion_date',
    'status',
    'result',
    'result_set_at',
];


    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
