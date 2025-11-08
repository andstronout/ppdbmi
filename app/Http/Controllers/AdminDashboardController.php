<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminDashboardController extends Controller
{

    public function index()
    {
        $totalPendaftar = Murid::count();
        $muridDiterima = Murid::whereIn('status', ['Diterima', 'Aktif', 'Verified'])->count();
        $prosesVerifikasi = Murid::where('status', 'Checking')->count();
        return view('admin.dashboard', [
            'totalPendaftar' => $totalPendaftar,
            'muridDiterima' => $muridDiterima,
            'prosesVerifikasi' => $prosesVerifikasi
        ]);
    }

    public function daftar_murid(Request $request)
    {
        $filterStatus = $request->input('filter_status');
        $filterPayment = $request->input('filter_payment');
        $filterTahun = $request->input('filter_tahun');
        $query = Murid::with(['user', 'pembayaran']);
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
        return view('admin.daftar_murid.index', [
            'murids' => $murids,
            'availableTahun' => $availableTahun
        ]);
    }

    public function showListPembayaran()
    {
        $pembayarans = Pembayaran::with('murid')
            ->where('status_bayar', 'Pending')
            ->latest()
            ->get();

        return view('admin.verifikasi_pembayaran.index', compact('pembayarans'));
    }

    public function updatePembayaran(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status_bayar' => 'Paid'
        ]);

        return back()->with('success', 'Pembayaran untuk murid ' . $pembayaran->murid->nama_lengkap . ' telah DIVERIFIKASI.');
    }

    public function rejectPembayaran(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status_bayar' => 'Failed'
        ]);

        return back()->with('success', 'Pembayaran untuk murid ' . $pembayaran->murid->nama_lengkap . ' telah DITOLAK (Failed).');
    }

    public function show_verifikasi_berkas()
    {

        $murids = Murid::with(['user', 'pembayaran', 'dataOrtu'])
            ->where('status', 'Checking')
            ->whereHas('pembayaran', function ($query) {
                $query->where('status_bayar', 'Paid');
            })->latest()->get();

        return view('admin.verifikasi_berkas.index', compact('murids'));
    }

    public function approveVerifikasi(Murid $murid)
    {
        $tahunMasuk = $murid->tahun_masuk;
        $nomorUrut = str_pad($murid->id, 4, '0', STR_PAD_LEFT); // NPSN (misal: "20250017")
        $nomorIndukSiswa = $tahunMasuk . $nomorUrut;
        $murid->update([
            'status' => 'Verified',
            'catatan' => null,
            'npsn' => $nomorIndukSiswa
        ]);
        return back()->with('success', 'Murid bernama ' . $murid->nama_lengkap . ' telah Diterima.');
    }

    public function reviseVerifikasi(Request $request, Murid $murid)
    {
        $data = $request->validate([
            'catatan' => 'required|string|max:500',
        ]);
        $murid->update([
            'catatan' => $data['catatan'],
        ]);
        return back()->with('success', 'Catatan revisi untuk ' . $murid->nama_lengkap . ' telah disimpan.');
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
        return view('admin.laporan_pendaftaran.index', compact(
            'murids',
            'availableTahun',
            'totalHasil',
            'totalDiterima',
            'totalLunas'
        ));
    }
}
