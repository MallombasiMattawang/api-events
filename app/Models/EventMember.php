<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EventMember extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'invoice',
        'first_name',
        'last_name',
        'community',
        'name_bib',
        'email',
        'no_whatsapp',
        'event_jersey_id',
        'no_whatsapp',
        'event_category_id',
        'gender',
        'no_hp_emergency',
        'payment',
        'payment_receipt',
        'status',
        'no_member',
        'kode_paid',
        're_register'
    ];

    public static function generateInvoiceNumber()
    {
        $kode_book = 'INV-';

        // Generate a unique ID based on current timestamp and random number
        $uniqueId = uniqid();

        // Take the last 5 characters of the unique ID
        $uniqueCode = substr($uniqueId, -5);

        return $kode_book . $uniqueCode;
    }

    public static function generatePaidNumber()
    {
        $kode_book = 'OBU-';
        
        // Get the last kode_paid number
        $lastPaid = self::orderBy('kode_paid', 'desc')->first();

        if (!$lastPaid) {
            $number = 1;
        } else {
            $lastNumber = (int)substr($lastPaid->kode_paid, strlen($kode_book));
            $number = $lastNumber + 1;
        }

        // return $kode_book . str_pad($number, 5, '0', STR_PAD_LEFT);
        return $kode_book . $number;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventJersey()
    {
        return $this->belongsTo(EventJersey::class);
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class);
    }

     /**
     * payment_receipt
     *
     * @return Attribute
     */
    protected function paymentReceipt(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/payment_receipt/' . $image),
        );
    }
}
