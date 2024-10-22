@extends('layouts.guru')

@section('title', 'Informasi Kelas')

@section('content')
<div class="container mx-auto px-4 sm:px-8 max-w-3xl">
    <div class="py-8">
        <h1 class="text-3xl font-semibold leading-tight mb-6">Informasi Kelas</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(isset($kelas))
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
                <h2 class="text-2xl font-semibold mb-4">Detail Kelas</h2>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold mb-2">Nama Kelas:</p>
                    <p class="text-gray-900">{{ $kelas->nama_kelas }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold mb-2">Tingkat:</p>
                    <p class="text-gray-900">{{ $kelas->tingkat }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold mb-2">Wali Kelas:</p>
                    <p class="text-gray-900">{{ $guru->nama_guru }} (Anda)</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold mb-2">Jumlah Santri:</p>
                    <p class="text-gray-900">{{ $santri->total() }}</p>
                </div>
            </div>

            <h2 class="text-2xl font-semibold leading-tight mb-4">Daftar Santri</h2>
            
            @if($santri->count() > 0)
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">NIS</th>
                                <th class="py-3 px-6 text-left">Nama Santri</th>
                                <th class="py-3 px-6 text-left">Jenis Kelamin</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($santri as $s)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $s->nis }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $s->nama }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $s->jenis_kelamin }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="javascript:void(0)" onclick="viewSantri('{{ $s->nis }}', '{{ $s->nama }}', '{{ $s->jenis_kelamin }}', '{{ $s->tempat_lahir }}', '{{ $s->tanggal_lahir }}', '{{ $s->alamat }}', '{{ $s->no_telp }}', '{{ $s->orangTua->nama }}', '{{ $s->orangTua->alamat }}', '{{ $s->orangTua->no_telp }}')" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $santri->links() }}
                </div>
            @else
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">Tidak ada santri dalam kelas ini.</span>
                </div>
            @endif

        @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $message ?? 'Anda tidak memiliki kelas yang dibimbing.' }}</span>
            </div>
        @endif
    </div>
</div>

<!-- Modal View Santri -->
<div id="viewSantriModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="santriName"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>NIS:</strong> <span id="santriNis"></span><br>
                                <strong>Nama:</strong> <span id="santriNama"></span><br>
                                <strong>Jenis Kelamin:</strong> <span id="santriGender"></span><br>
                                <strong>Tempat Lahir:</strong> <span id="santriTempatLahir"></span><br>
                                <strong>Tanggal Lahir:</strong> <span id="santriTanggalLahir"></span><br>
                                <strong>Alamat:</strong> <span id="santriAlamat"></span><br>
                                <strong>No Telepon:</strong> <span id="santriNoTelp"></span><br>
                            </p>
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-900">Orang Tua</h4>
                                <p class="text-sm text-gray-500">
                                    <strong>Nama:</strong> <span id="ortuNama"></span><br>
                                    <strong>Alamat:</strong> <span id="ortuAlamat"></span><br>
                                    <strong>No Telepon:</strong> <span id="ortuNoTelp"></span>
                                </p>
                            </div>
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
function viewSantri(nis, nama, gender, tempat_lahir, tanggal_lahir, alamat, no_telp, ortuNama, ortuAlamat, ortuNoTelp) {
    document.getElementById('santriNis').textContent = nis;
    document.getElementById('santriNama').textContent = nama;
    document.getElementById('santriGender').textContent = gender === 'L' ? 'Laki-Laki' : 'Perempuan';
    document.getElementById('santriTempatLahir').textContent = tempat_lahir;
    document.getElementById('santriTanggalLahir').textContent = tanggal_lahir;
    document.getElementById('santriAlamat').textContent = alamat;
    document.getElementById('santriNoTelp').textContent = no_telp;
    document.getElementById('ortuNama').textContent = ortuNama;
    document.getElementById('ortuAlamat').textContent = ortuAlamat;
    document.getElementById('ortuNoTelp').textContent = ortuNoTelp;

    document.getElementById('viewSantriModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('viewSantriModal').classList.add('hidden');
}
</script>

@endsection
