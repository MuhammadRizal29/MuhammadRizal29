@extends('layouts.guru')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white shadow-md rounded-lg px-8 py-6">
        <h2 class="text-2xl font-semibold mb-6">Tambah Pelanggaran</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('guru.pelanggaran.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nis" class="block text-gray-700 font-medium mb-2">Santri</label>
                <select name="nis" id="nis" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Pilih Santri</option>
                    @foreach($santri as $s)
                        <option value="{{ $s->nis }}">{{ $s->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jenis_pelanggaran" class="block text-gray-700 font-medium mb-2">Jenis Pelanggaran</label>
                <input type="text" name="jenis_pelanggaran" id="jenis_pelanggaran" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('jenis_pelanggaran') }}">
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('tanggal') }}">
            </div>

            <div class="mb-4">
                <label for="sanksi" class="block text-gray-700 font-medium mb-2">Sanksi</label>
                <input type="text" name="sanksi" id="sanksi" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('sanksi') }}">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('guru.pelanggaran.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
