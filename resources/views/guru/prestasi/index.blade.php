@extends('layouts.guru')

@section('title', 'Daftar Prestasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Prestasi</h1>
        <a href="{{ route('guru.prestasi.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Prestasi
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
                    <th class="py-3 px-6 text-left">Nama Santri</th>
                    <th class="py-3 px-6 text-left">Jenis Prestasi</th>
                    <th class="py-3 px-6 text-left">Nama Perlombaan</th>
                    <th class="py-3 px-6 text-left">Penyelenggara</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($prestasi as $p)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $p->santri->nama ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $p->jenis_prestasi }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $p->nama_perlombaan ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        {{ $p->penyelenggara }}
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if($p->tanggal)
                            {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="javascript:void(0)" onclick="viewPrestasi('{{ $p->id_prestasi }}', '{{ $p->santri->nama ?? 'N/A' }}', '{{ $p->jenis_prestasi }}', '{{ $p->nama_perlombaan ?? 'N/A' }}', '{{ $p->penyelenggara }}', '{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') : 'N/A' }}', '{{ $p->peringkat ?? 'N/A' }}')" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('guru.prestasi.edit', $p->id_prestasi) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('guru.prestasi.destroy', $p->id_prestasi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                    <td colspan="6" class="py-3 px-6 text-center">Tidak ada data prestasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $prestasi->links() }}
    </div>
</div>

<!-- Modal View Prestasi -->
<div id="viewPrestasiModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="prestasiTitle"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>Nama Santri:</strong> <span id="prestasiSantri"></span><br>
                                <strong>Jenis Prestasi:</strong> <span id="prestasiJenis"></span><br>
                                <strong>Nama Perlombaan:</strong> <span id="prestasiPerlombaan"></span><br>
                                <strong>Penyelenggara:</strong> <span id="prestasiPenyelenggara"></span><br>
                                <strong>Tanggal:</strong> <span id="prestasiTanggal"></span><br>
                                <strong>Peringkat:</strong> <span id="prestasiPeringkat"></span><br>
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
function viewPrestasi(id, santri, jenis, perlombaan, penyelenggara, tanggal, peringkat) {
    document.getElementById('prestasiTitle').textContent = 'Detail Prestasi';
    document.getElementById('prestasiSantri').textContent = santri;
    document.getElementById('prestasiJenis').textContent = jenis;
    document.getElementById('prestasiPerlombaan').textContent = perlombaan;
    document.getElementById('prestasiPenyelenggara').textContent = penyelenggara;
    document.getElementById('prestasiTanggal').textContent = tanggal;
    document.getElementById('prestasiPeringkat').textContent = peringkat || 'N/A';

    document.getElementById('viewPrestasiModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('viewPrestasiModal').classList.add('hidden');
}
</script>

@endsection
