@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container px-6 mx-auto grid">
    <!-- Profile Section -->
    <div class="flex items-center my-6 bg-white rounded-lg shadow-xs p-4">
        <div class="mr-4">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/'.Auth::user()->foto) }}" alt="Profile Picture" class="w-20 h-20 rounded-full object-cover">
            @else
                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            @endif
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-700">
                Welcome, {{ Auth::user()->nama }}
            </h2>
            <p class="text-sm text-gray-600">{{ Auth::user()->nip }}</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
        <!-- Kelas Wali Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Kelas Wali
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $kelasWali ? $kelasWali->nama_kelas : 'Belum ditugaskan' }}
                </p>
            </div>
        </div>
        <!-- Total Santri Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Santri
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalSantri }}
                </p>
            </div>
        </div>
        <!-- Total Prestasi Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Prestasi
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPrestasi }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection