<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'slug', 
        'user_id', 
        'content', 
        'image', 
        'event_start',
        'event_end',
        'event_address',
        'event_contact',
        'active',
    ];

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }

    public function eventCategories()
    {
        return $this->hasMany(EventCategory::class);
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/events/' . $image),
        );
    }
}
