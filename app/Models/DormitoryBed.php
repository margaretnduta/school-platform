<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryBed extends Model
{
    use HasFactory;

    protected $fillable = [
        'dormitory_id',
        'dormitory_room_id',
        'student_id',
        'bed_number',
        'position',
        'status',
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function room()
    {
        return $this->belongsTo(DormitoryRoom::class, 'dormitory_room_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}