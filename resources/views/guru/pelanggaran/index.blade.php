@extends('layouts.guru')

@section('title', 'Daftar Pelanggaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pelanggaran</h1>
        <a href="{{ route('guru.pelanggaran.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Pelanggaran
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Jenis Pelanggaran</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Deskripsi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($pelanggaran as $item)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $item->santri->nama }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $item->jenis_pelanggaran }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($item->tanggal)
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ Str::limit($item->deskripsi, 50) }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="javascript:void(0)" onclick="viewPelanggaran('{{ $item->id_pelanggaran }}', '{{ $item->santri->nama }}', '{{ $item->jenis_pelanggaran }}', '{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : 'N/A' }}', '{{ $item->deskripsi }}', '{{ $item->sanksi }}')" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('guru.pelanggaran.edit', $item->id_pelanggaran) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('guru.pelanggaran.destroy', $item->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                    <td colspan="5" class="py-3 px-6 text-center">Tidak ada data pelanggaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $pelanggaran->links() }}
    </div>
</div>

<!-- Modal View Pelanggaran -->
<div id="viewPelanggaranModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="pelanggaranTitle"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>Nama Santri:</strong> <span id="pelanggaranSantri"></span><br>
                                <strong>Jenis Pelanggaran:</strong> <span id="pelanggaranJenis"></span><br>
                                <strong>Tanggal:</strong> <span id="pelanggaranTanggal"></span><br>
                                <strong>Deskripsi:</strong> <span id="pelanggaranDeskripsi"></span><br>
                                <strong>Sanksi:</strong> <span id="pelanggaranSanksi"></span><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewPelanggaran(id, santri, jenis, tanggal, deskripsi, sanksi) {
    document.getElementById('pelanggaranTitle').textContent = 'Detail Pelanggaran';
    document.getElementById('pelanggaranSantri').textContent = santri;
    document.getElementById('pelanggaranJenis').textContent = jenis;
    document.getElementById('pelanggaranTanggal').textContent = tanggal;
    document.getElementById('pelanggaranDeskripsi').textContent = deskripsi;
    document.getElementById('pelanggaranSanksi').textContent = sanksi;

    document.getElementById('viewPelanggaranModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('viewPelanggaranModal').classList.add('hidden');
}
</script>

@endsection
