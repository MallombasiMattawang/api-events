<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventCategoryResource;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Validator;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get eventCategories
        $eventCategories = EventCategory::with('event')->when(request()->search, function ($eventCategories) {
            $eventCategories = $eventCategories->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $eventCategories->appends(['search' => request()->search]);

        //return with Api Resource
        return new EventCategoryResource(true, 'List Data Event Categories', $eventCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'name'     => 'required|unique:event_categories',
            'member_limit' => 'required|integer',
            'cost' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create eventCategory
        $eventCategory = EventCategory::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'member_limit' => $request->member_limit,
            'cost' => $request->cost,
        ]);

        if ($eventCategory) {
            //return success with Api Resource
            return new EventCategoryResource(true, 'Data Event Category Berhasil Disimpan!', $eventCategory);
        }

        //return failed with Api Resource
        return new EventCategoryResource(false, 'Data Event Category Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventCategory = EventCategory::whereId($id)->first();

        if ($eventCategory) {
            //return success with Api Resource
            return new EventCategoryResource(true, 'Detail Data Event Category!', $eventCategory);
        }

        //return failed with Api Resource
        return new EventCategoryResource(false, 'Detail Data Event Category Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventCategory $eventCategory)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'name'     => 'required|unique:event_categories,name,' . $eventCategory->id,
            'member_limit' => 'required|integer',
            'cost' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update eventCategory without image
        $eventCategory->update([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'member_limit' => $request->member_limit,
            'cost' => $request->cost,
        ]);

        if ($eventCategory) {
            //return success with Api Resource
            return new EventCategoryResource(true, 'Data EventCategory Berhasil Diupdate!', $eventCategory);
        }

        //return failed with Api Resource
        return new EventCategoryResource(false, 'Data EventCategory Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventCategory $eventCategory)
    {
        if ($eventCategory->delete()) {
            //return success with Api Resource
            return new EventCategoryResource(true, 'Data Event Category Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new EventCategoryResource(false, 'Data Event Category Gagal Dihapus!', null);
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        //get eventCategories
        $eventCategories = EventCategory::latest()->get();

        //return with Api Resource
        return new EventCategoryResource(true, 'List Data Event Categories', $eventCategories);
    }
}

