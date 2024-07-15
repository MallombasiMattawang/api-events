<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventMember;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        //count posts
        $posts = Post::count();

        //count events
        $events = Event::count();

        //count event categories
        $eventCategories = EventCategory::count();

        //count event categories
        $eventMembers = EventMember::count();

        //return response json
        return response()->json([
            'success'   => true,
            'message'   => 'List Data on Dashboard',
            'data'      => [
                'posts'             => $posts,
                'events'            => $events,
                'eventCategories'   => $eventCategories,
                'eventMembers'      => $eventMembers
            ]
        ]);
    }
}
