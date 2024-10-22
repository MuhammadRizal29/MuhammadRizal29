@extends('layouts.guru')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <div class="bg-white shadow-md rounded-lg px-8 py-6">
        <h2 class="text-2xl font-semibold mb-6">Tambah Hafalan</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.hafalan.store') }}" method="POST">
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
                <label for="guru_pembimbing" class="block text-gray-700 font-medium mb-2">Guru Pembimbing</label>
                <select name="guru_pembimbing" id="guru_pembimbing" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Pilih Guru Pembimbing</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->c_guru }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="surat" class="block text-gray-700 font-medium mb-2">Surat</label>
                <input type="text" name="surat" id="surat" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('surat') }}">
            </div>

            <div class="mb-4">
                <label for="ayat" class="block text-gray-700 font-medium mb-2">Ayat</label>
                <input type="text" name="ayat" id="ayat" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('ayat') }}">
            </div>

            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('tanggal_mulai') }}">
            </div>

            <div class="mb-4">
                <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" value="{{ old('tanggal_selesai') }}">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('guru.hafalan.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
