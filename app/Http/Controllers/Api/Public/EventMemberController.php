<?php

namespace App\Http\Controllers\Api\Public;

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
                // 'status'           => 'required',
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
            return new EventMemberResource(true, 'Pendaftaran Berhasil Berhasil, mohon tunggu verifikasi tim kami yang akan kami infokan di Email yang didaftarkan', $eventMember);
        }

        //return failed with Api Resource
        return new EventMemberResource(false, 'Pendaftaran Gagal, Terjadi Gangguan Sistem!', null);
    }
}
