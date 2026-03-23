<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';

    protected $fillable = [
        'name',
        'level',
        'stream',
        'capacity',
        'class_teacher_id',
        'room_number',
        'status',
    ];

    public function classTeacher()
    {
        return $this->belongsTo(Staff::class, 'class_teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class', 'name');
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->student_count;
    }
}