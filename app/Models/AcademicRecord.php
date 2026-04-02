<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'class',
        'term',
        'year',
        'marks',
        'total_marks',
        'grade',
        'points',
        'status',
        'remarks',
        'recorded_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Auto calculate grade from marks
    public static function calculateGrade($marks, $total = 100)
    {
        $percentage = ($marks / $total) * 100;

        if ($percentage >= 80) return ['grade' => 'A',  'points' => '12', 'status' => 'pass'];
        if ($percentage >= 75) return ['grade' => 'A-', 'points' => '11', 'status' => 'pass'];
        if ($percentage >= 70) return ['grade' => 'B+', 'points' => '10', 'status' => 'pass'];
        if ($percentage >= 65) return ['grade' => 'B',  'points' => '9',  'status' => 'pass'];
        if ($percentage >= 60) return ['grade' => 'B-', 'points' => '8',  'status' => 'pass'];
        if ($percentage >= 55) return ['grade' => 'C+', 'points' => '7',  'status' => 'pass'];
        if ($percentage >= 50) return ['grade' => 'C',  'points' => '6',  'status' => 'pass'];
        if ($percentage >= 45) return ['grade' => 'C-', 'points' => '5',  'status' => 'pass'];
        if ($percentage >= 40) return ['grade' => 'D+', 'points' => '4',  'status' => 'pass'];
        if ($percentage >= 35) return ['grade' => 'D',  'points' => '3',  'status' => 'pass'];
        if ($percentage >= 30) return ['grade' => 'D-', 'points' => '2',  'status' => 'pass'];
        return                        ['grade' => 'E',  'points' => '1',  'status' => 'fail'];
    }

    public function getTermNameAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->term));
    }
}