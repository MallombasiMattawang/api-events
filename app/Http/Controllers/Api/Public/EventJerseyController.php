<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventJerseyResource;
use App\Models\EventJersey;
use Illuminate\Http\Request;

class EventJerseyController extends Controller
{
    //

    public function all()
    {
        //get eventJersey
        $eventJersey = EventJersey::latest()->get();

        //return with Api Resource
        return new EventJerseyResource(true, 'List Data Event Jersey', $eventJersey);
    }
}
