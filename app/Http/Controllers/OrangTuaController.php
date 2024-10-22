<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Santri; 
use App\Models\Hafalan;
use App\Models\Prestasi;
use App\Models\Pelanggaran;
use App\Models\Kegiatan;


class OrangTuaController extends Controller
{
    // Dashboard Orang Tua
    public function dashboard()
{
    $orangTua = Auth::guard('orangtua')->user();

    // Fetch the 'Santri' data associated with the parent
    $santri = Santri::where('c_orangtua', $orangTua->c_orangtua)->first();

    // Fetch the latest 'Kegiatan' data (or customize as needed)
    $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->take(5)->get();

    return view('orangtua.dashboard', compact('orangTua', 'santri', 'kegiatans'));
}

    // Show Biodata Anak
    public function showBiodata()
    {
        // Get the logged-in parent
        $orangTua = Auth::guard('orangtua')->user();

        // Fetch the 'Santri' data associated with the parent
        $santri = Santri::where('c_orangtua', $orangTua->c_orangtua)->first();

        // Return the view with the 'Santri' data
        return view('orangtua.biodata.biodata', compact('santri'));
    }

    // Show Hafalan Santri
    public function showHafalan()
    {
        // Get the logged-in parent
        $orangTua = Auth::guard('orangtua')->user();

        // Fetch the 'Santri' data associated with the parent
        $santri = Santri::where('c_orangtua', $orangTua->c_orangtua)->firstOrFail();

        // Fetch the 'Hafalan' data for the specified Santri
        $hafalans = Hafalan::where('nis', $santri->nis)->with('guru')->get();

        // Return the view with the 'Santri' and 'Hafalan' data
        return view('orangtua.hafalan.hafalan', compact('santri', 'hafalans'));
    }

    public function showPrestasi()
    {
        // Get the logged-in parent
        $orangTua = Auth::guard('orangtua')->user();

        // Fetch the 'Santri' data associated with the parent
        $santri = Santri::where('c_orangtua', $orangTua->c_orangtua)->firstOrFail();

        // Fetch the 'Prestasi' data for the specified Santri
        $prestasis = Prestasi::where('nis', $santri->nis)->get();

        // Return the view with the 'Santri' and 'Prestasi' data
        return view('orangtua.prestasi.prestasi', compact('santri', 'prestasis'));
    }
    public function showPelanggaran()
    {
        // Get the logged-in parent
        $orangTua = Auth::guard('orangtua')->user();

        // Fetch the 'Santri' data associated with the parent
        $santri = Santri::where('c_orangtua', $orangTua->c_orangtua)->firstOrFail();

        // Fetch the 'Pelanggaran' data for the specified Santri
        $pelanggarans = Pelanggaran::where('nis', $santri->nis)->get();

        // Return the view with the 'Santri' and 'Pelanggaran' data
        return view('orangtua.pelanggaran.pelanggaran', compact('santri', 'pelanggarans'));
    }

}