@extends('layouts.orangtua')

@section('title', 'Prestasi Santri')

@section('header', 'Prestasi Santri')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto mt-6">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Daftar Prestasi</h2>
        <div class="bg-green-50 p-6 rounded-lg shadow-md">
            
            <h3 class="text-2xl font-semibold mb-4 flex items-center">
                <i class="fas fa-trophy mr-2 text-green-600"></i>
                Daftar Prestasi
            </h3>
            
            @if($prestasis->isEmpty())
                <p class="text-gray-600">Tidak ada data prestasi untuk santri ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perlombaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Prestasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggara</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($prestasis as $prestasi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prestasi->nama_perlombaan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prestasi->jenis_prestasi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prestasi->penyelenggara }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prestasi->peringkat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <a href="javascript:void(0)" onclick="viewPrestasi('{{ $prestasi->nama_perlombaan }}', '{{ $prestasi->jenis_prestasi }}', '{{ $prestasi->penyelenggara }}', '{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d-m-Y') }}', '{{ $prestasi->peringkat }}')" class="text-blue-500 hover:text-blue-700 mr-4">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal View Prestasi -->
    <div id="viewPrestasiModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-trophy text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="prestasiTitle">Detail Prestasi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <strong>Nama Perlombaan:</strong> <span id="prestasiNamaPerlombaan"></span><br>
                                    <strong>Jenis Prestasi:</strong> <span id="prestasiJenis"></span><br>
                                    <strong>Penyelenggara:</strong> <span id="prestasiPenyelenggara"></span><br>
                                    <strong>Tanggal:</strong> <span id="prestasiTanggal"></span><br>
                                    <strong>Peringkat:</strong> <span id="prestasiPeringkat"></span><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function viewPrestasi(nama_perlombaan, jenis, penyelenggara, tanggal, peringkat) {
        document.getElementById('prestasiTitle').textContent = 'Detail Prestasi';
        document.getElementById('prestasiNamaPerlombaan').textContent = nama_perlombaan;
        document.getElementById('prestasiJenis').textContent = jenis;
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
