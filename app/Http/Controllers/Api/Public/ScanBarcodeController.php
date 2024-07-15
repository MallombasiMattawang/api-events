<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\LayananResource;
use App\Http\Resources\LayananTiketResource;
use App\Models\LayananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScanBarcodeController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode'         => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tiket = LayananTiket::where('barcode', $request->barcode)
            ->where('is_active', 1)
            ->first();

        if ($tiket) {
            $tiket->update([
                'is_active' => 0
            ]);
            //return success with Api Resource
            return new LayananTiketResource(true, ' Tiket Ditemukan, Silahkan Masuk', $tiket);
        }

        //return failed with Api Resource
        return new LayananTiketResource(false, 'Tiket sudah tidak aktif!', null);
    }
}
