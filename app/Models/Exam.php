<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'term',
        'year',
        'level',
        'stream',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($now->isBefore($start)) {
            return 'planned';
        } elseif ($now->isBetween($start, $end)) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }
}
