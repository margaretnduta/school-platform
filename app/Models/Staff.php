<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'national_id',
        'role',
        'department',
        'subject',
        'joining_date',
        'employment_type',
        'status',
        'address',
        'photo',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRoleNameAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->role));
    }
}