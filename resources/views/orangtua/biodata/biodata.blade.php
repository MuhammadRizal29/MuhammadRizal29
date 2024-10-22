@extends('layouts.orangtua')

@section('title', 'Biodata Santri')

@section('header', 'Biodata Santri')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto mt-6">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Biodata Santri</h2>
        <div class="flex bg-green-50 p-6 rounded-lg shadow-md">
            <!-- Santri Photo -->
            <div class="w-1/3 flex justify-center items-center">
                <img src="{{ $santri->foto ? asset('storage/' . $santri->foto) : asset('images/default-avatar.png') }}" alt="Foto Santri" class="w-full h-120 object-cover rounded-lg border-2 border-gray-300">
            </div>
            <!-- Biodata -->
            <div class="w-2/3 pl-6">
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Nama:</span>
                        <span class="text-gray-900">{{ $santri->nama }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">NIS:</span>
                        <span class="text-gray-900">{{ $santri->nis }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Jenis Kelamin:</span>
                        <span class="text-gray-900">{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Tempat Lahir:</span>
                        <span class="text-gray-900">{{ $santri->tempat_lahir }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Tanggal Lahir:</span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d-m-Y') }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Alamat:</span>
                        <span class="text-gray-900">{{ $santri->alamat }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">No. Telepon:</span>
                        <span class="text-gray-900">{{ $santri->no_telp }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="font-semibold text-gray-700 w-40">Kelas:</span>
                        <span class="text-gray-900">{{ $santri->kelas ? $santri->kelas->nama_kelas : 'Tidak tersedia' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
