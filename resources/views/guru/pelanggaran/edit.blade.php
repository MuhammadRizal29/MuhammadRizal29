@extends('layouts.guru')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Edit Data Pelanggaran</h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Validation Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.pelanggaran.update', $pelanggaran->id_pelanggaran) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">NIS Santri:</label>
                <select name="nis" id="nis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nis') border-red-500 @enderror" required>
                    <option value="">Pilih Santri</option>
                    @foreach($santri as $s)
                        <option value="{{ $s->nis }}" {{ old('nis', $pelanggaran->nis) == $s->nis ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jenis_pelanggaran" class="block text-gray-700 text-sm font-bold mb-2">Jenis Pelanggaran:</label>
                <input type="text" name="jenis_pelanggaran" id="jenis_pelanggaran" value="{{ old('jenis_pelanggaran', $pelanggaran->jenis_pelanggaran) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_pelanggaran') border-red-500 @enderror" required>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal ? \Carbon\Carbon::parse($pelanggaran->tanggal)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal') border-red-500 @enderror" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="sanksi" class="block text-gray-700 text-sm font-bold mb-2">Sanksi:</label>
                <input type="text" name="sanksi" id="sanksi" value="{{ old('sanksi', $pelanggaran->sanksi) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('sanksi') border-red-500 @enderror" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Perubahan
                </button>
                <a href="{{ route('guru.pelanggaran.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
