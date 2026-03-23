<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'rooms_count',
        'beds_per_room',
        'warden_name',
        'warden_phone',
        'description',
        'is_active',
    ];

    public function rooms()
    {
        return $this->hasMany(DormitoryRoom::class);
    }

    public function beds()
    {
        return $this->hasMany(DormitoryBed::class);
    }

    public function getTotalBedsAttribute()
    {
        return $this->rooms_count * $this->beds_per_room;
    }

    public function getOccupiedBedsAttribute()
    {
        return $this->beds()->where('status', 'occupied')->count();
    }

    public function getAvailableBedsAttribute()
    {
        return $this->total_beds - $this->occupied_beds;
    }
}