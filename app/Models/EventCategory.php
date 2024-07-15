<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'event_id','name', 'slug', 'member_limit', 'cost'
    ];

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
