<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Prestasi;
use App\Models\Hafalan;
use App\Models\Pelanggaran;
use App\Models\Kegiatan;
use App\Models\Guru;

class GuruController extends Controller
{
    // Dashboard Guru
    public function dashboard()
    {
        $guru = Auth::guard('guru')->user();
        $kelasWali = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelasWali) {
            $totalSantri = Santri::where('c_kelas', $kelasWali->c_kelas)->count();
            $santriIds = Santri::where('c_kelas', $kelasWali->c_kelas)->pluck('nis');
            $totalPrestasi = Prestasi::whereIn('nis', $santriIds)->count();
        } else {
            $totalSantri = 0;
            $totalPrestasi = 0;
        }

        return view('guru.dashboard', compact('guru', 'kelasWali', 'totalSantri', 'totalPrestasi'));
    }

    // CRUD untuk Kelas
    public function kelasIndex()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $santri = Santri::where('c_kelas', $kelas->c_kelas)->paginate(10);
            return view('guru.kelas.index', compact('kelas', 'santri', 'guru'));
        } else {
            return view('guru.kelas.index')->with('message', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function kelasCreate()
    {
        $guru = Auth::guard('guru')->user();
        return view('guru.kelas.create', compact('guru'));
    }

    public function kelasStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'wali_kelas' => 'required|exists:guru,c_guru',
        ]);

        Kelas::create($validatedData);
        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function kelasEdit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $guru = Auth::guard('guru')->user();
        $santri = Santri::where('c_kelas', $kelas->c_kelas)->get();

        return view('guru.kelas.edit', compact('kelas', 'santri', 'guru'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'wali_kelas' => 'required|exists:guru,c_guru',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($validatedData);
        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }

    // CRUD untuk Santri
    public function santriShow($nis)
    {
        $santri = Santri::findOrFail($nis);
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas && $santri->c_kelas == $kelas->c_kelas) {
            return view('guru.santri.show', compact('santri'));
        } else {
            return redirect()->route('guru.kelas.index')->with('error', 'Anda tidak memiliki akses ke data santri ini.');
        }
    }

    // CRUD untuk Hafalan
    public function hafalanIndex()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $hafalan = Hafalan::with('santri')
                ->whereHas('santri', function($query) use ($kelas) {
                    $query->where('c_kelas', $kelas->c_kelas);
                })
                ->paginate(10);
            return view('guru.hafalan.index', compact('hafalan', 'kelas'));
        } else {
            return view('guru.hafalan.index')->with('message', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function hafalanCreate()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $santri = Santri::where('c_kelas', $kelas->c_kelas)->get();
            $gurus = Guru::all();
            return view('guru.hafalan.create', compact('santri', 'gurus'));
        } else {
            return redirect()->route('guru.hafalan.index')->with('error', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function hafalanStore(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'guru_pembimbing' => 'required|exists:guru,c_guru',
            'surat' => 'required|string|max:255',
            'ayat' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        Hafalan::create($validatedData);
        return redirect()->route('guru.hafalan.index')->with('success', 'Hafalan berhasil ditambahkan');
    }

    public function hafalanEdit($id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $guru = Auth::guard('guru')->user();
        $santri = Santri::where('c_kelas', $hafalan->santri->c_kelas)->get();
        $guruList = Guru::all();

        return view('guru.hafalan.edit', compact('hafalan', 'santri', 'guruList'));
    }

    public function hafalanUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'guru_pembimbing' => 'required|exists:guru,c_guru',
            'surat' => 'required|string|max:255',
            'ayat' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $hafalan = Hafalan::findOrFail($id);
        $hafalan->update($validatedData);
        return redirect()->route('guru.hafalan.index')->with('success', 'Hafalan berhasil diperbarui');
    }

    public function hafalanDestroy($id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $hafalan->delete();
        return redirect()->route('guru.hafalan.index')->with('success', 'Hafalan berhasil dihapus');
    }

    // CRUD untuk Pelanggaran
    public function pelanggaranIndex()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $pelanggaran = Pelanggaran::with('santri')
                ->whereHas('santri', function($query) use ($kelas) {
                    $query->where('c_kelas', $kelas->c_kelas);
                })
                ->paginate(10);
            return view('guru.pelanggaran.index', compact('pelanggaran', 'kelas'));
        } else {
            return view('guru.pelanggaran.index')->with('message', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function pelanggaranCreate()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $santri = Santri::where('c_kelas', $kelas->c_kelas)->get();
            return view('guru.pelanggaran.create', compact('santri', 'guru'));
        } else {
            return redirect()->route('guru.pelanggaran.index')->with('error', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function pelanggaranStore(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_pelanggaran' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'sanksi' => 'required|string',
        ]);

        Pelanggaran::create($validatedData);
        return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan');
    }

    public function pelanggaranEdit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $guru = Auth::guard('guru')->user();
        $santri = Santri::where('c_kelas', $pelanggaran->santri->c_kelas)->get();

        return view('guru.pelanggaran.edit', compact('pelanggaran', 'santri', 'guru'));
    }

    public function pelanggaranUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_pelanggaran' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update($validatedData);
        return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran berhasil diperbarui');
    }

    public function pelanggaranDestroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();
        return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus');
    }

    // CRUD untuk Kegiatan
    public function kegiatanIndex()
{
    $guru = Auth::guard('guru')->user();
    $kegiatan = Kegiatan::paginate(10);

    return view('guru.kegiatan.index', compact('kegiatan', 'guru'));
}

public function kegiatanCreate()
{
    $guru = Auth::guard('guru')->user();
    return view('guru.kegiatan.create', compact('guru'));
}

public function kegiatanStore(Request $request)
{
    $validatedData = $request->validate([
        'nama_kegiatan' => 'required|string|max:255',
        'jenis_kegiatan' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'tempat' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'waktu' => 'required|date_format:H:i', // Validasi format jam
    ]);

    Kegiatan::create($validatedData);

    return redirect()->route('guru.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
}

public function kegiatanEdit($id)
{
    $kegiatan = Kegiatan::findOrFail($id);
    $guru = Auth::guard('guru')->user();

    return view('guru.kegiatan.edit', compact('kegiatan', 'guru'));
}

public function kegiatanUpdate(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama_kegiatan' => 'required|string|max:255',
        'jenis_kegiatan' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'tempat' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'waktu' => 'required|date_format:H:i', // Validasi format jam
    ]);

    $kegiatan = Kegiatan::findOrFail($id);
    $kegiatan->update($validatedData);

    return redirect()->route('guru.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui');
}

public function kegiatanDestroy($id)
{
    $kegiatan = Kegiatan::findOrFail($id);
    $kegiatan->delete();

    return redirect()->route('guru.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
}
    // CRUD untuk Prestasi
    public function prestasiIndex()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $santriIds = Santri::where('c_kelas', $kelas->c_kelas)->pluck('nis');
            $prestasi = Prestasi::whereIn('nis', $santriIds)->paginate(10);
            return view('guru.prestasi.index', compact('prestasi', 'kelas'));
        } else {
            return view('guru.prestasi.index')->with('message', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function prestasiCreate()
    {
        $guru = Auth::guard('guru')->user();
        $kelas = Kelas::where('wali_kelas', $guru->c_guru)->first();

        if ($kelas) {
            $santri = Santri::where('c_kelas', $kelas->c_kelas)->get();
            return view('guru.prestasi.create', compact('santri'));
        } else {
            return redirect()->route('guru.prestasi.index')->with('error', 'Anda tidak memiliki kelas yang dibimbing.');
        }
    }

    public function prestasiStore(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_prestasi' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'peringkat' => 'required|string|max:255',
            'nama_perlombaan' => 'required|string|max:255', // Validasi untuk nama_perlombaan
        ]);

        Prestasi::create($validatedData);
        return redirect()->route('guru.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan');
    }

    public function prestasiEdit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $guru = Auth::guard('guru')->user();
        $santri = Santri::where('c_kelas', $prestasi->santri->c_kelas)->get();

        return view('guru.prestasi.edit', compact('prestasi', 'santri', 'guru'));
    }

    public function prestasiUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_prestasi' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'peringkat' => 'required|string|max:255',
            'nama_perlombaan' => 'required|string|max:255', // Validasi untuk nama_perlombaan
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($validatedData);
        return redirect()->route('guru.prestasi.index')->with('success', 'Prestasi berhasil diperbarui');
    }

    public function prestasiDestroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();
        return redirect()->route('guru.prestasi.index')->with('success', 'Prestasi berhasil dihapus');
    }
    /**
     * Menampilkan halaman pengaturan guru.
     */
    public function showPengaturan()
    {
        $guru = Auth::guard('guru')->user();
        return view('guru.pengaturan', compact('guru'));
    }

    /**
     * Memperbarui pengaturan guru.
     */
    /**
 * Memperbarui pengaturan guru.
 */
public function updatePengaturan(Request $request)
{
    $guru = Auth::guard('guru')->user();

    $request->validate([
        'password' => 'nullable|string|min:8|confirmed',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $updateData = [];

    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($guru->foto) {
            Storage::delete('public/' . $guru->foto);
        }

        // Simpan foto baru
        $fotoPath = $request->file('foto')->store('guru_photos', 'public');
        $updateData['foto'] = $fotoPath;
    }

    // Update data guru
    Guru::where('c_guru', $guru->c_guru)->update($updateData);

    return redirect()->route('guru.pengaturan')->with('success', 'Pengaturan berhasil diperbarui.');
}
}