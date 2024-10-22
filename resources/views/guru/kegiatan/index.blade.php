@extends('layouts.guru')

@section('title', 'Daftar Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Kegiatan</h1>
        <a href="{{ route('guru.kegiatan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Kegiatan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama Kegiatan</th>
                    <th class="py-3 px-6 text-left">Jenis Kegiatan</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Waktu</th>
                    <th class="py-3 px-6 text-left">Tempat</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($kegiatan as $item)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $item->nama_kegiatan }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $item->jenis_kegiatan }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($item->waktu)
                            {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $item->tempat }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('guru.kegiatan.edit', $item->id_kegiatan) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('guru.kegiatan.destroy', $item->id_kegiatan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="border-b border-gray-200">
                    <td colspan="6" class="py-3 px-6 text-center">Tidak ada data kegiatan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $kegiatan->links() }}
    </div>
</div>
@endsection
