<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventJersey extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'size', 'amount', 'stock'
    ];

    public function eventMembers()
    {
        return $this->hasMany(EventMember::class);
    }
}
