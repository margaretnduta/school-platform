<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'dormitory_id',
        'room_number',
        'total_beds',
        'occupied_beds',
        'status',
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function beds()
    {
        return $this->hasMany(DormitoryBed::class);
    }

    public function getAvailableBedsAttribute()
    {
        return $this->total_beds - $this->occupied_beds;
    }
}