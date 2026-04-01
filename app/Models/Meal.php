<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'session',
        'class',
        'description',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function records()
    {
        return $this->hasMany(MealRecord::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getSessionNameAttribute()
    {
        return ucfirst($this->session);
    }

    public function getTakenCountAttribute()
    {
        return $this->records()->where('status', 'taken')->count();
    }

    public function getNotTakenCountAttribute()
    {
        return $this->records()->where('status', 'not_taken')->count();
    }
}