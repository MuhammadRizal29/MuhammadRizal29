@extends('layouts.guru')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Hafalan</h2>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.hafalan.update', $hafalan->id_hafalan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Santri -->
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700">Santri</label>
                        <select id="nis" name="nis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="">Pilih Santri</option>
                            @foreach ($santri as $s)
                                <option value="{{ $s->nis }}" {{ $hafalan->nis == $s->nis ? 'selected' : '' }}>
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Surat -->
                    <div>
                        <label for="surat" class="block text-sm font-medium text-gray-700">Surat</label>
                        <input type="text" id="surat" name="surat" value="{{ old('surat', $hafalan->surat) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" />
                    </div>

                    <!-- Ayat -->
                    <div>
                        <label for="ayat" class="block text-sm font-medium text-gray-700">Ayat</label>
                        <input type="text" id="ayat" name="ayat" value="{{ old('ayat', $hafalan->ayat) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" />
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $hafalan->tanggal_mulai) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" />
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $hafalan->tanggal_selesai) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" />
                    </div>

                    <!-- Guru Pembimbing -->
                    <div>
                        <label for="guru_pembimbing" class="block text-sm font-medium text-gray-700">Guru Pembimbing</label>
                        <select id="guru_pembimbing" name="guru_pembimbing" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                            <option value="">Pilih Guru</option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->c_guru }}" {{ $hafalan->guru_pembimbing == $guru->c_guru ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Update
                    </button>
                    <a href="{{ route('guru.hafalan.index') }}" class="ml-4 px-4 py-2 bg-gray-300 text-gray-800 rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
