@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Daftar Kelas</h2>
            <a href="{{ route('admin.kelas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kelas
            </a>
        </div>
        
        <!-- Search Form -->
        <div class="my-2 flex sm:flex-row flex-col">
            <form action="{{ route('admin.kelas') }}" method="GET" class="flex flex-row mb-1 sm:mb-0 w-full">
                <div class="relative flex-grow">
                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..."
                        class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
                <button type="submit" class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kode Kelas
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama Kelas
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tingkat
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Wali Kelas
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="kelasTable">
                        @forelse($kelas as $kls)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $kls->c_kelas }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $kls->nama_kelas }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $kls->tingkat }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ optional($kls->waliKelas)->nama }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="javascript:void(0)" onclick="viewKelas('{{ $kls->c_kelas }}', '{{ $kls->nama_kelas }}', '{{ $kls->tingkat }}', '{{ optional($kls->waliKelas)->nama }}')" class="text-blue-600 hover:text-blue-900 mr-4">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.kelas.edit', $kls->c_kelas) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kelas.destroy', $kls->c_kelas) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                Tidak ada data kelas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                    {{ $kelas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Kelas -->
<div id="viewKelasModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="kelasName"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>Kode Kelas:</strong> <span id="kelasKode"></span><br>
                                <strong>Nama Kelas:</strong> <span id="kelasNama"></span><br>
                                <strong>Tingkat:</strong> <span id="kelasTingkat"></span><br>
                                <strong>Wali Kelas:</strong> <span id="kelasWali"></span><br>
                            </p>
                        </div>
                        <div class="mt-4">
                            <h2 class="text-2xl font-semibold leading-tight mb-4">Daftar Santri</h2>
                            <div id="santriContainer">
                                <!-- Daftar santri akan diisi di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal('viewKelasModal')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Santri -->
<div id="viewSantriModal" class="fixed z-20 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="santriName"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>NIS:</strong> <span id="santriNis"></span><br>
                                <strong>Jenis Kelamin:</strong> <span id="santriJenisKelamin"></span><br>
                                <strong>Tempat Lahir:</strong> <span id="santriTempatLahir"></span><br>
                                <strong>Tanggal Lahir:</strong> <span id="santriTanggalLahir"></span><br>
                                <strong>Alamat:</strong> <span id="santriAlamat"></span><br>
                                <strong>No. Telp:</strong> <span id="santriNoTelp"></span><br>
                                <strong>Nama Orang Tua:</strong> <span id="santriNamaOrangTua"></span><br>
                                <strong>Alamat Orang Tua:</strong> <span id="santriAlamatOrangTua"></span><br>
                                <strong>No. Telp Orang Tua:</strong> <span id="santriNoTelpOrangTua"></span><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal('viewSantriModal')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewKelas(kode, nama, tingkat, wali) {
    document.getElementById('kelasKode').textContent = kode;
    document.getElementById('kelasNama').textContent = nama;
    document.getElementById('kelasTingkat').textContent = tingkat;
    document.getElementById('kelasWali').textContent = wali;
    document.getElementById('kelasName').textContent = nama;
    
    // Fetch santri data
    fetch(`/admin/kelas/${kode}/santri`)
        .then(response => response.json())
        .then(data => {
            const santriContainer = document.getElementById('santriContainer');
            if (data.length > 0) {
                let html = `
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
                `;
                
                data.forEach(santri => {
                    html += `
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${santri.nis}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                ${santri.nama}
                            </td>
                            <td class="py-3 px-6 text-left">
                                ${santri.jenis_kelamin}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="javascript:void(0)" onclick="viewSantri('${santri.nis}', '${santri.nama}', '${santri.jenis_kelamin}', '${santri.tempat_lahir}', '${santri.tanggal_lahir}', '${santri.alamat}', '${santri.no_telp}', '${santri.orang_tua ? santri.orang_tua.nama : ''}', '${santri.orang_tua ? santri.orang_tua.alamat : ''}', '${santri.orang_tua ? santri.orang_tua.no_telp : ''}')" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                html += `
                            </tbody>
                        </table>
                    </div>
                `;
                
                santriContainer.innerHTML = html;
            } else {
                santriContainer.innerHTML = `
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">Tidak ada santri dalam kelas ini.</span>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('santriContainer').innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">Terjadi kesalahan saat mengambil data santri.</span>
                </div>
            `;
        });

    document.getElementById('viewKelasModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function viewSantri(nis, nama, jenisKelamin, tempatLahir, tanggalLahir, alamat, noTelp, namaOrangTua, alamatOrangTua, noTelpOrangTua) {
    document.getElementById('santriName').textContent = nama;
    document.getElementById('santriNis').textContent = nis;
    document.getElementById('santriJenisKelamin').textContent = jenisKelamin;
    document.getElementById('santriTempatLahir').textContent = tempatLahir;
    document.getElementById('santriTanggalLahir').textContent = tanggalLahir;
    document.getElementById('santriAlamat').textContent = alamat;
    document.getElementById('santriNoTelp').textContent = noTelp;
    document.getElementById('santriNamaOrangTua').textContent = namaOrangTua || 'Tidak tersedia';
    document.getElementById('santriAlamatOrangTua').textContent = alamatOrangTua || 'Tidak tersedia';
    document.getElementById('santriNoTelpOrangTua').textContent = noTelpOrangTua || 'Tidak tersedia';

    document.getElementById('viewSantriModal').classList.remove('hidden');
}
</script>
@endsection