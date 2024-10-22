@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('header')
    Admin Dashboard
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>
        
        <!-- Dashboard content -->
        <div class="mt-6">
            <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Total Santri -->
                <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white">
                    <div class="p-4 flex items-center">
                        <div class="p-3 rounded-full bg-indigo-600 text-white mr-4">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Santri</p>
                            <p class="text-lg font-semibold text-gray-700">{{ $totalSantri }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Guru -->
                <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white">
                    <div class="p-4 flex items-center">
                        <div class="p-3 rounded-full bg-green-600 text-white mr-4">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Guru</p>
                            <p class="text-lg font-semibold text-gray-700">{{ $totalGuru }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Kelas -->
                <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white">
                    <div class="p-4 flex items-center">
                        <div class="p-3 rounded-full bg-pink-600 text-white mr-4">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Kelas</p>
                            <p class="text-lg font-semibold text-gray-700">{{ $totalKelas }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional dashboard components -->

    </div>
@endsection
