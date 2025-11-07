<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;

class PublicController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function cekPendaftaran(Request $request)
    {
        $murid = null;
        $notFound = false;
        $nik = $request->input('cariNik');

        if ($nik) {
            $murid = Murid::with('pembayaran')
                ->where('nik', $nik)
                ->first();
            if (!$murid) {
                $notFound = true;
            }
        }
        return view('cek_pendaftaran', compact('murid', 'notFound', 'nik'));
    }
}
