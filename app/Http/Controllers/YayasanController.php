<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class YayasanController extends Controller
{
    public function index()
    {
        $totalPendaftar = Murid::count();
        $muridDiterima = Murid::whereIn('status', ['Diterima', 'Aktif', 'Verified'])->count();
        $prosesVerifikasi = Murid::where('status', 'Checking')->count();
        return view('ketua.dashboard', [
            'totalPendaftar' => $totalPendaftar,
            'muridDiterima' => $muridDiterima,
            'prosesVerifikasi' => $prosesVerifikasi
        ]);
    }

    public function showLaporanPendaftaran(Request $request)
    {
        $filterStatus = $request->input('filter_status');
        $filterPayment = $request->input('filter_payment');
        $filterTahun = $request->input('filter_tahun', date('Y'));
        $query = Murid::with(['pembayaran']);
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
        if ($filterTahun) {
            $query->where('tahun_masuk', $filterTahun);
        }
        if ($filterPayment) {
            if ($filterPayment == 'Belum Bayar') {
                $query->doesntHave('pembayaran');
            } else {
                $query->whereHas('pembayaran', function ($q) use ($filterPayment) {
                    $q->where('status_bayar', $filterPayment);
                });
            }
        }
        $murids = $query->latest()->get();
        $availableTahun = Murid::select('tahun_masuk')
            ->distinct()
            ->whereNotNull('tahun_masuk')
            ->orderBy('tahun_masuk', 'desc')
            ->pluck('tahun_masuk');
        $totalHasil = $murids->count();
        $totalDiterima = $murids->where('status', 'Verified')->count();
        $totalLunas = $murids->filter(function ($murid) {
            return $murid->pembayaran && $murid->pembayaran->status_bayar == 'Paid';
        })->count();
        return view('ketua.laporan_pendaftaran.index', compact(
            'murids',
            'availableTahun',
            'totalHasil',
            'totalDiterima',
            'totalLunas'
        ));
    }
}
