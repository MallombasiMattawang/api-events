<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function all()
    {
        //get events
        $events = Event::where('active', 'YES')->get();

        //return with Api Resource
        return new EventResource(true, 'List Data Event', $events);
    }
}
