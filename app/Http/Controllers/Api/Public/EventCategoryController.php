<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventCategoryResource;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function all()
    {
        //get eventCategories
        $eventCategories = EventCategory::latest()->get();

        //return with Api Resource
        return new EventCategoryResource(true, 'List Data Event Categories', $eventCategories);
    }
}
