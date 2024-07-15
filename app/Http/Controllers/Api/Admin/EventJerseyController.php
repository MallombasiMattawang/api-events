<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventJerseyResource;
use App\Models\EventJersey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EventJerseyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get eventJersey
        $eventJersey = EventJersey::when(request()->search, function ($eventJersey) {
            $eventJersey = $eventJersey->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $eventJersey->appends(['search' => request()->search]);

        //return with Api Resource
        return new EventJerseyResource(true, 'List Data Event Jersey', $eventJersey);
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
            'size'     => 'required|unique:event_jerseys',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create eventJersey
        $eventJersey = EventJersey::create([
            'size' => $request->size,
            'amount' => $request->amount,
            'stock' => $request->amount
        ]);

        if ($eventJersey) {
            //return success with Api Resource
            return new EventJerseyResource(true, 'Data Event Jersey Berhasil Disimpan!', $eventJersey);
        }

        //return failed with Api Resource
        return new EventJerseyResource(false, 'Data Event Jersey Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventJersey = EventJersey::whereId($id)->first();

        if ($eventJersey) {
            //return success with Api Resource
            return new EventJerseyResource(true, 'Detail Data Event Jersey!', $eventJersey);
        }

        //return failed with Api Resource
        return new EventJerseyResource(false, 'Detail Data Event Jersey Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventJersey $eventJersey)
    {
        $validator = Validator::make($request->all(), [
             'size'     => 'required',
             'amount' => 'required|integer',
             'stock' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update eventJersey without image
        $eventJersey->update([
           'size' => $request->size,
            'amount' => $request->amount,
            'stock' => $request->stock
        ]);

        if ($eventJersey) {
            //return success with Api Resource
            return new EventJerseyResource(true, 'Data Event Jersey Berhasil Diupdate!', $eventJersey);
        }

        //return failed with Api Resource
        return new EventJerseyResource(false, 'Data Event Jersey Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventJersey $eventJersey)
    {
        if ($eventJersey->delete()) {
            //return success with Api Resource
            return new EventJerseyResource(true, 'Data Event Jersey Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new EventJerseyResource(false, 'Data Event Jersey Gagal Dihapus!', null);
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        //get eventJersey
        $eventJersey = EventJersey::latest()->get();

        //return with Api Resource
        return new EventJerseyResource(true, 'List Data Event Jersey', $eventJersey);
    }
}
