@extends('layouts.orangtua')

@section('title', 'Hafalan Santri')

@section('header', 'Hafalan Santri')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto mt-6">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Daftar Hafalan</h2>
        <div class="bg-green-50 p-6 rounded-lg shadow-md">
            
            <h3 class="text-2xl font-semibold mb-4 flex items-center">
                <i class="fas fa-book-reader mr-2 text-green-600"></i>
                Daftar Hafalan
            </h3>
            
            @if($hafalans->isEmpty())
                <p class="text-gray-600">Tidak ada data hafalan untuk santri ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ayat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($hafalans as $hafalan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $hafalan->surat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $hafalan->ayat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($hafalan->tanggal_mulai)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $hafalan->tanggal_selesai ? \Carbon\Carbon::parse($hafalan->tanggal_selesai)->format('d-m-Y') : 'Belum selesai' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $hafalan->guru ? $hafalan->guru->nama : 'Tidak tersedia' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
