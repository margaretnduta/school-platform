<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'detailed_description',
        'event_date',
        'location',
        'organizer',
        'image',
        'status',
        'max_participants',
        'registered_participants',
        'category',
        'is_public',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_public' => 'boolean',
    ];

    /**
     * Get the formatted date for display
     */
    public function getFormattedDateAttribute()
    {
        return $this->event_date->format('M d, Y');
    }

    /**
     * Get the formatted time for display
     */
    public function getFormattedTimeAttribute()
    {
        return $this->event_date->format('h:i A');
    }

    /**
     * Get automatic status based on event date and current date
     * Returns: upcoming, ongoing, completed, or cancelled
     */
    public function getStatusAttribute()
    {
        // If status is explicitly set to cancelled, keep it
        if ($this->attributes['status'] === 'cancelled') {
            return 'cancelled';
        }

        $now = now();
        $eventDate = $this->event_date;

        if ($eventDate->isFuture()) {
            return 'upcoming';
        } elseif ($eventDate->isToday()) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming' && $this->event_date->isFuture();
    }

    /**
     * Check if spots are available
     */
    public function hasAvailableSpots()
    {
        if (!$this->max_participants) {
            return true;
        }
        return $this->registered_participants < $this->max_participants;
    }

    /**
     * Get available spots count
     */
    public function getAvailableSpotsAttribute()
    {
        if (!$this->max_participants) {
            return null;
        }
        return $this->max_participants - $this->registered_participants;
    }
}
