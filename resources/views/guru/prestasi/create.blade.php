@extends('layouts.guru')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Tambah Data Prestasi</h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('guru.prestasi.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-4">
                <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">NIS Santri:</label>
                <select name="nis" id="nis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nis') border-red-500 @enderror" required>
                    <option value="">Pilih Santri</option>
                    @foreach($santri as $s)
                        <option value="{{ $s->nis }}" {{ old('nis') == $s->nis ? 'selected' : '' }}>{{ $s->nis }} - {{ $s->nama }}</option>
                    @endforeach
                </select>
                @error('nis')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jenis_prestasi" class="block text-gray-700 text-sm font-bold mb-2">Jenis Prestasi:</label>
                <select name="jenis_prestasi" id="jenis_prestasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis_prestasi') border-red-500 @enderror" required>
                    <option value="">Pilih Jenis Prestasi</option>
                    <option value="Akademik" {{ old('jenis_prestasi') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="Non-Akademik" {{ old('jenis_prestasi') == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                </select>
                @error('jenis_prestasi')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_perlombaan" class="block text-gray-700 text-sm font-bold mb-2">Nama Perlombaan:</label>
                <input type="text" name="nama_perlombaan" id="nama_perlombaan" value="{{ old('nama_perlombaan') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_perlombaan') border-red-500 @enderror" required>
                @error('nama_perlombaan')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="penyelenggara" class="block text-gray-700 text-sm font-bold mb-2">Penyelenggara:</label>
                <input type="text" name="penyelenggara" id="penyelenggara" value="{{ old('penyelenggara') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('penyelenggara') border-red-500 @enderror" required>
                @error('penyelenggara')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal') border-red-500 @enderror" required>
                @error('tanggal')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="peringkat" class="block text-gray-700 text-sm font-bold mb-2">Peringkat:</label>
                <input type="text" name="peringkat" id="peringkat" value="{{ old('peringkat') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('peringkat') border-red-500 @enderror" required>
                @error('peringkat')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
                <a href="{{ route('guru.prestasi.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
