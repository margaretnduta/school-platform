<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'student_id',
        'status',
        'remarks',
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}