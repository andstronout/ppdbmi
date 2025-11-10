<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\DataOrtu;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
  public function index()
  {
    $murid = Murid::with('pembayaran')
      ->where('user_id', Auth::id())
      ->first();
    return view('user.dashboard', compact('murid'));
  }

  public function showBiodataForm()
  {
    $murid = Murid::where('user_id', Auth::id())->first();
    return view('user.biodata', compact('murid'));
  }

  public function store(Request $request)
  {
    $murid = Murid::where('user_id', Auth::id())->first();
    $rules = [
      'nama_lengkap' => 'required|string|max:100',
      'nik' => [
        'required',
        'digits:16',
        Rule::unique('murids')->ignore($murid->id ?? null),
      ],
      'tempat_lahir' => 'nullable|string|max:50',
      'tanggal_lahir' => 'nullable|date',
      'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
      'nama_ayah' => 'nullable|string|max:100',
      'nama_ibu' => 'nullable|string|max:100',
      'no_whatsapp' => 'nullable|string|max:15',
      'kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8048',
      'akte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8048',

    ];
    $validatedData = $request->validate($rules);
    $nik = $request->nik;
    if ($request->hasFile('kartu_keluarga')) {
      if ($murid && $murid->kartu_keluarga) {
        Storage::disk('public')->delete($murid->kartu_keluarga);
      }
      $file = $request->file('kartu_keluarga');
      $extension = $file->getClientOriginalExtension();
      $fileName = 'kk_' . $nik . '.' . $extension;
      $path = $file->storeAs('berkas_murid/kartu_keluarga', $fileName, 'public');
      $validatedData['kartu_keluarga'] = $path;
    }
    if ($request->hasFile('akte')) {
      if ($murid && $murid->akte) {
        Storage::disk('public')->delete($murid->akte);
      }

      $file = $request->file('akte');
      $extension = $file->getClientOriginalExtension();
      $fileName = 'akte_' . $nik . '.' . $extension;
      $path = $file->storeAs('berkas_murid/akte', $fileName, 'public');

      $validatedData['akte'] = $path;
    }
    if (!$murid || !$murid->tahun_masuk) {
      $validatedData['tahun_masuk'] = date('Y');
    }
    if (!$murid || !$murid->status) {
      $validatedData['status'] = 'Checking';
    }
    $murid = Murid::updateOrCreate(
      ['user_id' => Auth::id()],
      $validatedData
    );

    DataOrtu::updateOrCreate(
      ['murid_id' => $murid->id],
      $validatedData
    );
    DataOrtu::updateOrCreate(
      ['murid_id' => $murid->id],
      $validatedData
    );
    return redirect()->route('user.biodata')
      ->with('success', 'Biodata Anda telah berhasil disimpan!');
  }

  public function showPembayaranForm()
  {
    $murid = Murid::where('user_id', auth()->user()->id)->first();
    if (!$murid) {
      return redirect()->route('user.biodata')
        ->withErrors(['gagal' => 'Harap lengkapi biodata Anda terlebih dahulu sebelum melakukan pembayaran.']);
    }
    $pembayaran = Pembayaran::where('murid_id', $murid->id)->first();
    return view('user.pembayaran', compact('pembayaran'));
  }

  public function storePembayaran(Request $request)
  {
    $murid = Murid::where('user_id', Auth::id())->first();
    if (!$murid) {
      return redirect()->route('user.biodata')
        ->withErrors(['gagal' => 'Data biodata tidak ditemukan.']);
    }

    $pembayaran = Pembayaran::where('murid_id', $murid->id)->first();
    $rules = [
      'jumlah_bayar' => 'required|numeric|min:300000',
      'bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4048',
    ];
    if (!$pembayaran) {
      $rules['bukti_bayar'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:4048';
    }
    $validatedData = $request->validate($rules);
    $data = [
      'jumlah_bayar' => $validatedData['jumlah_bayar'],
      'tanggal_bayar' => now(),
      'status_bayar' => 'Pending',
    ];
    if ($request->hasFile('bukti_bayar')) {
      if ($pembayaran && $pembayaran->bukti_bayar) {
        Storage::disk('public')->delete($pembayaran->bukti_bayar);
      }

      $file = $request->file('bukti_bayar');
      $fileName = 'bukti_' . $murid->id . '_' . time() . '.' . $file->getClientOriginalExtension();
      $path = $file->storeAs('bukti_pembayaran', $fileName, 'public');
      $data['bukti_bayar'] = $path;
    }
    Pembayaran::updateOrCreate(
      ['murid_id' => $murid->id],
      $data
    );
    return redirect()->route('user.pembayaran')
      ->with('success', 'Konfirmasi pembayaran Anda telah berhasil diunggah dan sedang diproses.');
  }
}
