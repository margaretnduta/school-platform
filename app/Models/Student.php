<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'class',
        'dormitory',
        'status',
        'address',
        'photo',
    ];

    // Full name helper
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}