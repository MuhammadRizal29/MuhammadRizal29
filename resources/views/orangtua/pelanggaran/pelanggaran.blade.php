@extends('layouts.orangtua')

@section('title', 'Pelanggaran Santri')

@section('header', 'Pelanggaran Santri')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto mt-6">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Pelanggaran Santri</h2>
        <div class="bg-green-50 p-6 rounded-lg shadow-md">
        
            <h3 class="text-2xl font-semibold mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2 text-green-600"></i>
                Daftar Pelanggaran
            </h3>
            @if($pelanggarans->isEmpty())
                <p class="text-gray-600">Tidak ada data pelanggaran untuk santri ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pelanggaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sanksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pelanggarans as $pelanggaran)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pelanggaran->jenis_pelanggaran }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pelanggaran->deskripsi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pelanggaran->sanksi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
