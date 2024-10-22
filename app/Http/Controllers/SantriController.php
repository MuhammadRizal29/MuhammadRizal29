<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\OrangTua;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    // Menampilkan daftar santri
    public function index()
    {
        $santri = Santri::with('kelas')->get();
        return view('admin.santri.index', compact('santri'));
    }

    // Menampilkan form untuk menambahkan santri baru
    public function create()
    {
        $kelas = Kelas::all();
        $orangtua = OrangTua::all();
        return view('admin.santri.create', compact('kelas', 'orangtua'));
    }

    // Menyimpan santri baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:santri,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'c_kelas' => 'required|exists:kelas,c_kelas',
            'c_orangtua' => 'required|exists:orang_tua,c_orangtua',
        ]);

        $santri = new Santri($request->all());
        
        // Menyimpan foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/foto'), $filename);
            $santri->foto = $filename;
        }

        $santri->save();

        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit santri
    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        $kelas = Kelas::all();
        $orangtua = OrangTua::all();
        return view('admin.santri.edit', compact('santri', 'kelas', 'orangtua'));
    }

    // Memperbarui data santri di database
    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:santri,nis,' . $id . ',c_santri',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'c_kelas' => 'required|exists:kelas,c_kelas',
            'c_orangtua' => 'required|exists:orang_tua,c_orangtua',
        ]);

        $santri->fill($request->all());
        
        // Menyimpan foto baru jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/foto'), $filename);
            $santri->foto = $filename;
        }

        $santri->save();

        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil diperbarui.');
    }

    // Menghapus santri dari database
    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        
        // Menghapus file foto jika ada
        if ($santri->foto && file_exists(public_path('images/foto/' . $santri->foto))) {
            unlink(public_path('images/foto/' . $santri->foto));
        }

        $santri->delete();

        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil dihapus.');
    }
}
