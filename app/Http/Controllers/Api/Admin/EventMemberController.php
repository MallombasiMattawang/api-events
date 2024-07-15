<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventMemberResource;
use App\Models\EventMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class EventMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventMembers = EventMember::with('event','eventJersey','eventCategory')->when(request()->search, function ($eventMembers) {
            $eventMembers = $eventMembers->where('first_name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(25);

        //append query string to pagination links
        $eventMembers->appends(['search' => request()->search]);

        //return with Api Resource
        return new EventMemberResource(true, 'List Data Events Member', $eventMembers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'payment_receipt'         => 'required|image|mimes:jpeg,jpg,png|max:5000',
                'event_id'           => 'required',
                'first_name'           => 'required',
                'last_name'           => 'required',
                'community'           => 'required',
                'name_bib'          => 'required',
                'email' => 'required|email|unique:event_members,email',
                'no_whatsapp'           => 'required',
                'event_jersey_id'           => 'required',
                'no_whatsapp'           => 'required',
                'event_category_id'           => 'required',
                'gender'           => 'required',
                'no_hp_emergency'           => 'required',
                'payment'           => 'required',
                'status'           => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('payment_receipt');
        $image->storeAs('public/payment_receipt', $image->hashName());

        $invoice = EventMember::generateInvoiceNumber();
        $kode_paid = null;
        if ($request->status == 'PAID') {
            $kode_paid = EventMember::generatePaidNumber();
        }

        $eventMember = EventMember::create(
            [
                'payment_receipt'       => $image->hashName(),
                'event_id'           => $request->event_id,
                'invoice'           => $invoice,
                'first_name'           => $request->first_name,
                'last_name'           => $request->last_name,
                'community'           => $request->community,
                'name_bib'          => $request->name_bib,
                'email'           => $request->email,
                'no_whatsapp'           => $request->no_whatsapp,
                'event_jersey_id'           => $request->event_jersey_id,
                'no_whatsapp'           => $request->no_whatsapp,
                'event_category_id'           => $request->event_category_id,
                'gender'           => $request->gender,
                'no_hp_emergency'           => $request->no_hp_emergency,
                'payment'           => $request->payment,
                'status'           => $request->status,
                'kode_paid'     => $kode_paid,
                'no_member'     => $kode_paid,
            ]
        );


        if ($eventMember) {
            //return success with Api Resource
            return new EventMemberResource(true, 'Data EventMember Member Berhasil Disimpan!', $eventMember);
        }

        //return failed with Api Resource
        return new EventMemberResource(false, 'Data EventMember Member Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventMember = EventMember::whereId($id)->first();

        if ($eventMember) {
            //return success with Api Resource
            return new EventMemberResource(true, 'Detail Data Event Member!', $eventMember);
        }

        //return failed with Api Resource
        return new EventMemberResource(false, 'Detail Data Event Member Tidak DItemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventMember $eventMember)
    {
        $validator = Validator::make($request->all(), [
            // 'payment_receipt'         => 'image|mimes:jpeg,jpg,png|max:5000',
            'event_id'           => 'required',
            'first_name'           => 'required',
            'last_name'           => 'required',
            'community'           => 'required',
            'name_bib'          => 'required',
            // 'email' => 'required|email|unique:event_members,email,' . $eventMember->id,
            'no_whatsapp'           => 'required',
            'event_jersey_id'           => 'required',
            'no_whatsapp'           => 'required',
            'event_category_id'           => 'required',
            'gender'           => 'required',
            'no_hp_emergency'           => 'required',
            'payment'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kode_paid = null;
        if ($request->status == 'PAID' && $eventMember->kode_paid != null) {
            $kode_paid = EventMember::generatePaidNumber();
        }

        //check image update
        if ($request->file('payment_receipt')) {

            //remove old image
            Storage::disk('local')->delete('public/payment_receipt/' . basename($eventMember->image));

            //upload new image
            $image = $request->file('payment_receipt');
            $image->storeAs('public/payment_receipt', $image->hashName());

            $eventMember->update([                
                'payment_receipt'       => $image->hashName(),
                'event_id'           => $request->event_id,
                'first_name'           => $request->first_name,
                'last_name'           => $request->last_name,
                'community'           => $request->community,
                'name_bib'          => $request->name_bib,
                'email'           => $request->email,
                'no_whatsapp'           => $request->no_whatsapp,
                'event_jersey_id'           => $request->event_jersey_id,
                'no_whatsapp'           => $request->no_whatsapp,
                'event_category_id'           => $request->event_category_id,
                'gender'           => $request->gender,
                'no_hp_emergency'           => $request->no_hp_emergency,
                'payment'           => $request->payment,
                'status'           => $request->status,
                'kode_paid'     => $kode_paid,
                'no_member'     => $kode_paid,
            ]);
        }

        $eventMember->update([
            
            'event_id'           => $request->event_id,
            'first_name'           => $request->first_name,
            'last_name'           => $request->last_name,
            'community'           => $request->community,
            'name_bib'          => $request->name_bib,
            'email'           => $request->email,
            'no_whatsapp'           => $request->no_whatsapp,
            'event_jersey_id'           => $request->event_jersey_id,
            'no_whatsapp'           => $request->no_whatsapp,
            'event_category_id'           => $request->event_category_id,
            'gender'           => $request->gender,
            'no_hp_emergency'           => $request->no_hp_emergency,
            'payment'           => $request->payment,
            'status'           => $request->status,
                'kode_paid'     => $kode_paid,
                'no_member'     => $kode_paid,
        ]);

        if ($eventMember) {
            //return success with Api Resource
            return new EventMemberResource(true, 'Data Event Member Berhasil Diupdate!', $eventMember);
        }

        //return failed with Api Resource
        return new EventMemberResource(false, 'Data Event Member Gagal Disupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventMember $eventMember)
    {
        //remove image
        Storage::disk('local')->delete('public/payment_receipt/' . basename($eventMember->payment_receipt));

        if ($eventMember->delete()) {
            //return success with Api Resource
            return new EventMemberResource(true, 'Data Event Member Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new EventMemberResource(false, 'Data Event Member Gagal Dihapus!', null);
    }
}
