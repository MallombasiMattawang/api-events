<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::when(request()->search, function ($events) {
            $events = $events->where('title', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $events->appends(['search' => request()->search]);

        //return with Api Resource
        return new EventResource(true, 'List Data Events', $events);
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
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:5000',
            'title'         => 'required|unique:events',
            'content'       => 'required',
            'event_start'   => 'required',
            'event_end'     => 'required',
            'event_address' => 'required',
            'event_contact' => 'required',
            'active' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/events', $image->hashName());

        $event = Event::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'user_id'       => auth()->guard('api')->user()->id,
            'content'       => $request->content,
            'event_start'   => $request->event_start,
            'event_end'     => $request->event_end,
            'event_address' => $request->event_address,
            'event_contact' => $request->event_contact,
            'active'        => $request->active,
        ]);


        if ($event) {
            //return success with Api Resource
            return new EventResource(true, 'Data Event Berhasil Disimpan!', $event);
        }

        //return failed with Api Resource
        return new EventResource(false, 'Data Event Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::whereId($id)->first();

        if ($event) {
            //return success with Api Resource
            return new EventResource(true, 'Detail Data Event!', $event);
        }

        //return failed with Api Resource
        return new EventResource(false, 'Detail Data Event Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:events,title,' . $event->id,
            'content'       => 'required',
            'event_start'   => 'required',
            'event_end'     => 'required',
            'event_address' => 'required',
            'event_contact' => 'required',
            'active'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('local')->delete('public/events/' . basename($event->image));

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/Events', $image->hashName());

            $event->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'user_id'       => auth()->guard('api')->user()->id,
                'content'       => $request->content,
                'event_start'   => $request->event_start,
                'event_end'     => $request->event_end,
                'event_address' => $request->event_address,
                'event_contact' => $request->event_contact,
                'active'        => $request->active,
            ]);
        }

        $event->update([
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'user_id'       => auth()->guard('api')->user()->id,
            'content'       => $request->content,
            'event_start'   => $request->event_start,
            'event_end'     => $request->event_end,
            'event_address' => $request->event_address,
            'event_contact' => $request->event_contact,
            'active'        => $request->active,
        ]);

        if ($event) {
            //return success with Api Resource
            return new EventResource(true, 'Data Event Berhasil Diupdate!', $event);
        }

        //return failed with Api Resource
        return new EventResource(false, 'Data Event Gagal Disupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //remove image
        Storage::disk('local')->delete('public/events/' . basename($event->image));

        if ($event->delete()) {
            //return success with Api Resource
            return new EventResource(true, 'Data Event Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new EventResource(false, 'Data Event Gagal Dihapus!', null);
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        //get events
        $events = Event::where('active', 'YES')->get();

        //return with Api Resource
        return new EventResource(true, 'List Data Event', $events);
    }
}
