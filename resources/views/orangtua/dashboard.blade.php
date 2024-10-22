@extends('layouts.orangtua')

@section('title', 'Dashboard Orang Tua')

@section('header', 'Dashboard Orang Tua')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl mx-auto mt-6 space-y-6">
        <!-- Welcome Message -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat datang, {{ Auth::user()->nama }}!</h1>
            <p class="text-gray-600">Ini adalah dashboard Anda. Anda bisa melihat informasi tentang anak Anda di sini.</p>
        </div>

        <!-- Kegiatan Section -->
        <div class="bg-green-50 p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-green-800 mb-4 flex items-center">
                <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
                Kegiatan Terbaru
            </h2>
            @if($kegiatans->isEmpty())
                <p class="text-gray-600">Tidak ada kegiatan terbaru.</p>
            @else
                <div class="space-y-4">
                    @foreach($kegiatans as $kegiatan)
                        <div class="kegiatan-box relative p-4 bg-white rounded-lg shadow-md flex flex-col border-l-4 border-green-500 transition-transform transform hover:scale-105 cursor-pointer">
                            <div class="flex-shrink-0 mb-2">
                                <i class="fas fa-calendar-day text-green-500 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h3>
                                <p class="text-gray-600">{{ $kegiatan->jenis_kegiatan }}</p>
                                <p class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}
                                    @if($kegiatan->waktu)
                                        @php
                                            $waktu = \Carbon\Carbon::parse($kegiatan->waktu)->format('H:i');
                                        @endphp
                                        <span class="text-gray-500">Pukul {{ $waktu }}</span>
                                    @endif
                                </p>
                                <p class="text-gray-700 mt-2">{{ $kegiatan->deskripsi }}</p>
                                <p class="text-gray-500 mt-1">{{ $kegiatan->tempat }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
