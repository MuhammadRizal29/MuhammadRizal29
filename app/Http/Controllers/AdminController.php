<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard untuk Admin
    public function dashboard()
    {
        $totalSantri = Santri::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        return view('admin.dashboard', compact('totalSantri', 'totalGuru', 'totalKelas'));
    }

    // Pengelolaan Santri
    public function santri(Request $request)
    {
        $query = Santri::with('kelas');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nis', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('kelas', function($q) use ($searchTerm) {
                      $q->where('nama_kelas', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $perPage = $request->input('per_page', 10);
        $santri = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.santri._table', compact('santri'))->render();
        }

        return view('admin.santri.index', compact('santri'));
    }

    public function santriCreate()
    {
        $kelas = Kelas::all();
        $orangtua = OrangTua::all();
        $c_santri = $this->generateSantriCode();
        return view('admin.santri.create', compact('kelas', 'orangtua', 'c_santri'));
    }

    public function santriStore(Request $request)
    {
        $validatedData = $request->validate([
            'c_santri' => 'required|unique:santri',
            'nis' => 'required|unique:santri',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_telp' => 'required',
            'c_kelas' => 'required|exists:kelas,c_kelas',
            'c_orangtua' => 'required|exists:orangtua,c_orangtua',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('santri_photos', 'public');
            $validatedData['foto'] = $fotoPath;
        }

        Santri::create($validatedData);

        return redirect()->route('admin.santri')->with('success', 'Data santri berhasil ditambahkan');
    }

    public function santriEdit($id)
    {
        $santri = Santri::findOrFail($id);
        $kelas = Kelas::all();
        $orangtua = OrangTua::all();
        return view('admin.santri.edit', compact('santri', 'kelas', 'orangtua'));
    }

    public function santriUpdate(Request $request, $id)
{
    // Find the santri record based on c_santri
    $santri = Santri::where('c_santri', $id)->firstOrFail();

    // Validate request data
    $validatedData = $request->validate([
        'nis' => 'required|unique:santri,nis,'.$santri->c_santri.',c_santri',
        'nama' => 'required',
        'jenis_kelamin' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required',
        'no_telp' => 'required',
        'c_kelas' => 'required|exists:kelas,c_kelas',
        'c_orangtua' => 'required|exists:orangtua,c_orangtua',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle photo upload
    if ($request->hasFile('foto')) {
        if ($santri->foto) {
            Storage::disk('public')->delete($santri->foto);
        }
        $fotoPath = $request->file('foto')->store('santri_photos', 'public');
        $validatedData['foto'] = $fotoPath;
    }

    // Update santri record
    $santri->update($validatedData);

    return redirect()->route('admin.santri')->with('success', 'Data santri berhasil diupdate');
}


    public function santriDestroy($id)
    {
        $santri = Santri::findOrFail($id);
        
        if ($santri->foto) {
            Storage::disk('public')->delete($santri->foto);
        }
        
        $santri->delete();

        return redirect()->route('admin.santri')->with('success', 'Data santri berhasil dihapus');
    }

    private function generateSantriCode()
    {
        $lastSantri = Santri::orderBy('c_santri', 'desc')->first();
        if (!$lastSantri) {
            return 'S001';
        }
        
        $lastCode = intval(substr($lastSantri->c_santri, 1));
        $newCode = $lastCode + 1;
        return 'S' . str_pad($newCode, 3, '0', STR_PAD_LEFT);
    }

    // Pengelolaan Guru
    public function guru(Request $request)
    {
        $query = Guru::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nip', 'LIKE', "%{$searchTerm}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $guru = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.guru._table', compact('guru'))->render();
        }

        return view('admin.guru.index', compact('guru'));
    }

    public function guruCreate()
    {
        return view('admin.guru.create');
    }

    public function guruStore(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:guru,email',
            'username' => 'required|unique:guru,username',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate c_guru
        $lastGuru = Guru::orderBy('c_guru', 'desc')->first();
        $lastCode = $lastGuru ? intval(substr($lastGuru->c_guru, 1)) : 0;
        $newCode = 'G' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
        $validatedData['c_guru'] = $newCode;

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru_photos', 'public');
            $validatedData['foto'] = $fotoPath;
        }

        try {
            Guru::create($validatedData);
            return redirect()->route('admin.guru')->with('success', 'Data guru berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function guruEdit($c_guru)
    {
        $guru = Guru::findOrFail($c_guru);
        return view('admin.guru.edit', compact('guru'));
    }

    public function guruUpdate(Request $request, $c_guru)
    {
        $validatedData = $request->validate([
            'nip' => 'required|unique:guru,nip,'.$c_guru.',c_guru',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:guru,email,'.$c_guru.',c_guru',
            'username' => 'required|unique:guru,username,'.$c_guru.',c_guru',
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $guru = Guru::findOrFail($c_guru);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $fotoPath = $request->file('foto')->store('guru_photos', 'public');
            $validatedData['foto'] = $fotoPath;
        }

        // Update password only if it's provided
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $guru->update($validatedData);

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function guruDestroy($c_guru)
    {
        $guru = Guru::findOrFail($c_guru);
        
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }
        
        $guru->delete();

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil dihapus');
    }

    // Pengelolaan Orang Tua
    public function orangTua(Request $request)
    {
        $query = OrangTua::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('no_telp', 'LIKE', "%{$searchTerm}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $orangTua = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.orangtua._table', compact('orangTua'))->render();
        }

        return view('admin.orangtua.index', compact('orangTua'));
    }

    public function orangTuaCreate()
    {
        $c_orangtua = $this->generateOrangTuaCode();
        return view('admin.orangtua.create', compact('c_orangtua'));
    }

    public function orangTuaStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'pekerjaan' => 'required|string',
            'hubungan_dengan_santri' => 'required|string',
            'username' => 'required|unique:orangtua|string',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData['c_orangtua'] = $this->generateOrangTuaCode();

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('orangtua_photos', 'public');
            $validatedData['foto'] = $fotoPath;
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        OrangTua::create($validatedData);

        return redirect()->route('admin.orangtua')->with('success', 'Data orang tua berhasil ditambahkan');
    }

    public function orangTuaEdit($c_orangtua)
    {
        $orangTua = OrangTua::findOrFail($c_orangtua);
        return view('admin.orangtua.edit', compact('orangTua'));
    }

    public function orangTuaUpdate(Request $request, $c_orangtua)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'pekerjaan' => 'required|string',
            'hubungan_dengan_santri' => 'required|string',
            'username' => 'required|string|unique:orangtua,username,'.$c_orangtua.',c_orangtua',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $orangTua = OrangTua::findOrFail($c_orangtua);

        if ($request->hasFile('foto')) {
            if ($orangTua->foto) {
                Storage::disk('public')->delete($orangTua->foto);
            }
            $fotoPath = $request->file('foto')->store('orangtua_photos', 'public');
            $validatedData['foto'] = $fotoPath;
        }
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $orangTua->update($validatedData);

        return redirect()->route('admin.orangtua')->with('success', 'Data orang tua berhasil diperbarui');
    }

    public function orangTuaDestroy($c_orangtua)
    {
        $orangTua = OrangTua::findOrFail($c_orangtua);

        if ($orangTua->foto) {
            Storage::disk('public')->delete($orangTua->foto);
        }

        $orangTua->delete();

        return redirect()->route('admin.orangtua')->with('success', 'Data orang tua berhasil dihapus');
    }

    private function generateOrangTuaCode()
    {
        $lastOrangTua = OrangTua::orderBy('c_orangtua', 'desc')->first();
        if (!$lastOrangTua) {
            return 'OT001';
        }
        
        $lastCode = intval(substr($lastOrangTua->c_orangtua, 2));
        $newCode = $lastCode + 1;
        return 'OT' . str_pad($newCode, 3, '0', STR_PAD_LEFT);
    }

    // Pengelolaan Kelas
    public function kelas(Request $request)
    {
        $query = Kelas::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama_kelas', 'LIKE', "%{$searchTerm}%");
        }

        $perPage = $request->input('per_page', 10);
        $kelas = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.kelas._table', compact('kelas'))->render();
        }

        return view('admin.kelas.index', compact('kelas'));
    }

    public function kelasCreate()
    {
        $guru = Guru::all();
        return view('admin.kelas.create', compact('guru'));
    }

    public function kelasStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|unique:kelas',
            'tingkat' => 'required|in:SMP,SMA',
            'wali_kelas' => 'required|exists:guru,c_guru',
        ]);

        $lastKelas = Kelas::orderBy('c_kelas', 'desc')->first();
        $lastCode = $lastKelas ? intval(substr($lastKelas->c_kelas, 1)) : 0;
        $newCode = 'K' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT);
        $validatedData['c_kelas'] = $newCode;

        try {
            Kelas::create($validatedData);
            return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kelasEdit($c_kelas)
    {
        $kelas = Kelas::findOrFail($c_kelas);
        $gurus = Guru::all();
        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    public function kelasUpdate(Request $request, $c_kelas)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,'.$c_kelas.',c_kelas',
            'tingkat' => 'required|in:SMP,SMA',
            'wali_kelas' => 'required|exists:guru,c_guru',
        ]);

        $kelas = Kelas::findOrFail($c_kelas);
        $kelas->update($validatedData);

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function kelasDestroy($c_kelas)
    {
        $kelas = Kelas::findOrFail($c_kelas);
        $kelas->delete();

        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil dihapus');
    }

    public function kelasView($c_kelas)
    {
        $kelas = Kelas::with('santris', 'waliKelas')->findOrFail($c_kelas);
        return view('admin.kelas.view', compact('kelas'));
    }

    public function getSantri($c_kelas)
    {
        try {
            $kelas = Kelas::findOrFail($c_kelas);
            $santri = $kelas->santris()->with('orangTua')->get()->map(function ($s) {
                return [
                    'nis' => $s->nis,
                    'nama' => $s->nama,
                    'jenis_kelamin' => $s->jenis_kelamin,
                    'tempat_lahir' => $s->tempat_lahir,
                    'tanggal_lahir' => $s->tanggal_lahir,
                    'alamat' => $s->alamat,
                    'no_telp' => $s->no_telp,
                    'orang_tua' => $s->orangTua ? [
                        'nama' => $s->orangTua->nama,
                        'alamat' => $s->orangTua->alamat,
                        'no_telp' => $s->orangTua->no_telp,
                    ] : null,
                ];
            });

            return response()->json($santri);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data santri: ' . $e->getMessage()], 500);
        }
    }

    // Metode-metode tambahan untuk fitur lain
    public function hafalan()
    {
        // Implementasi untuk menampilkan data hafalan
        return view('admin.hafalan.index');
    }

    public function prestasi()
    {
        // Implementasi untuk menampilkan data prestasi
        return view('admin.prestasi.index');
    }

    public function kegiatan()
    {
        // Implementasi untuk menampilkan data kegiatan
        return view('admin.kegiatan.index');
    }

    public function pelanggaran()
    {
        // Implementasi untuk menampilkan data pelanggaran
        return view('admin.pelanggaran.index');
    }
}