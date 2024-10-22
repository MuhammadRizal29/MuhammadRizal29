@extends('layouts.guru')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Prestasi</h1>
        <a href="{{ route('guru.prestasi.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Mohon periksa kembali input Anda.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 p-6">
        <form action="{{ route('guru.prestasi.update', $prestasi->id_prestasi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">Santri:</label>
                <select name="nis" id="nis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nis') border-red-500 @enderror">
                    <option value="">Pilih Santri</option>
                    @foreach($santri as $s)
                        <option value="{{ $s->nis }}" {{ old('nis', $prestasi->nis) == $s->nis ? 'selected' : '' }}>
                            {{ $s->nis }} - {{ $s->nama }}
                        </option>
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
                    <option value="Akademik" {{ old('jenis_prestasi', $prestasi->jenis_prestasi) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="Non-Akademik" {{ old('jenis_prestasi', $prestasi->jenis_prestasi) == 'Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                </select>
                @error('jenis_prestasi')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_perlombaan" class="block text-gray-700 text-sm font-bold mb-2">Nama Perlombaan:</label>
                <input type="text" name="nama_perlombaan" id="nama_perlombaan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_perlombaan') border-red-500 @enderror" value="{{ old('nama_perlombaan', $prestasi->nama_perlombaan) }}">
                @error('nama_perlombaan')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="penyelenggara" class="block text-gray-700 text-sm font-bold mb-2">Penyelenggara:</label>
                <input type="text" name="penyelenggara" id="penyelenggara" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('penyelenggara') border-red-500 @enderror" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}">
                @error('penyelenggara')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal') border-red-500 @enderror" value="{{ old('tanggal', $prestasi->tanggal ? \Carbon\Carbon::parse($prestasi->tanggal)->format('Y-m-d') : '') }}">
                @error('tanggal')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="peringkat" class="block text-gray-700 text-sm font-bold mb-2">Peringkat:</label>
                <input type="text" name="peringkat" id="peringkat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('peringkat') border-red-500 @enderror" value="{{ old('peringkat', $prestasi->peringkat) }}">
                @error('peringkat')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Prestasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
