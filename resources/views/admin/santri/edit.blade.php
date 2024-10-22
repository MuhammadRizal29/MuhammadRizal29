@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Edit Santri</h2>
        <form action="{{ route('admin.santri.update', $santri->c_santri) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @method('PUT')
            @csrf
            <div class="mb-4">
                <label for="c_santri" class="block text-gray-700 text-sm font-bold mb-2">Kode Santri:</label>
                <input type="text" name="c_santri" id="c_santri" value="{{ $santri->c_santri }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
            </div>
            <div class="mb-4">
                <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">NIS:</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis', $santri->nis) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nis') border-red-500 @enderror" required>
                @error('nis')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $santri->nama) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama') border-red-500 @enderror" required>
                @error('nama')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin:</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="" disabled>Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tempat_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tempat_lahir') border-red-500 @enderror" required>
                @error('tempat_lahir')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror" required>
                @error('tanggal_lahir')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
                <textarea name="alamat" id="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror" rows="3" required>{{ old('alamat', $santri->alamat) }}</textarea>
                @error('alamat')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon:</label>
                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $santri->no_telp) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('no_telp') border-red-500 @enderror" required>
                @error('no_telp')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto:</label>
                <input type="file" name="foto" id="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('foto') border-red-500 @enderror">
                @if($santri->foto)
                    <p class="text-gray-600 text-xs mt-2">Foto saat ini: <a href="{{ asset('storage/' . $santri->foto) }}" target="_blank">{{ $santri->foto }}</a></p>
                @endif
                @error('foto')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="c_kelas" class="block text-gray-700 text-sm font-bold mb-2">Kelas:</label>
                <select name="c_kelas" id="c_kelas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('c_kelas') border-red-500 @enderror" required>
                    <option value="" disabled>Pilih Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->c_kelas }}" {{ old('c_kelas', $santri->c_kelas) == $k->c_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('c_kelas')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="c_orangtua" class="block text-gray-700 text-sm font-bold mb-2">Orang Tua/Wali:</label>
                <select name="c_orangtua" id="c_orangtua" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('c_orangtua') border-red-500 @enderror" required>
                    <option value="" disabled>Pilih Orang Tua/Wali</option>
                    @foreach($orangtua as $o)
                    <option value="{{ $o->c_orangtua }}" {{ old('c_orangtua', $santri->c_orangtua) == $o->c_orangtua ? 'selected' : '' }}>{{ $o->nama }}</option>
                    @endforeach
                </select>
                @error('c_orangtua')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
