<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'class',
        'total_marks',
        'pass_marks',
        'teacher_id',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    public function records()
    {
        return $this->hasMany(AcademicRecord::class);
    }
}