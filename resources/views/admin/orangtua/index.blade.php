@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold leading-tight">Daftar Orang Tua</h2>
            <a href="{{ route('admin.orangtua.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Orang Tua
            </a>
        </div>
        
        <!-- Search Form -->
        <div class="my-2 flex sm:flex-row flex-col">
            <form action="{{ route('admin.orangtua') }}" method="GET" class="flex flex-row mb-1 sm:mb-0 w-full">
                <div class="relative flex-grow">
                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}" placeholder="Cari orang tua..."
                        class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No. Telepon
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Hubungan dengan Santri
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="orangTuaTable">
                        @forelse($orangTua as $ot)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $ot->nama }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $ot->no_telp }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $ot->hubungan_dengan_santri }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="javascript:void(0)" onclick="viewOrangtua('{{ $ot->nama }}', '{{ $ot->no_telp }}', '{{ $ot->alamat }}', '{{ $ot->pekerjaan }}', '{{ $ot->hubungan_dengan_santri }}', '{{ $ot->username }}')" class="text-blue-600 hover:text-blue-900 mr-4">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orangtua.edit', $ot->c_orangtua) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.orangtua.destroy', $ot->c_orangtua) }}" method="POST" class="inline-block">
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
                            <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                Tidak ada data orang tua.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                    {{ $orangTua->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Orang Tua -->
<div id="viewOrangtuaModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
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
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="orangtuaName"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <strong>Nama:</strong> <span id="orangtuaNama"></span><br>
                                <strong>No. Telepon:</strong> <span id="orangtuaNoTelp"></span><br>
                                <strong>Alamat:</strong> <span id="orangtuaAlamat"></span><br>
                                <strong>Pekerjaan:</strong> <span id="orangtuaPekerjaan"></span><br>
                                <strong>Hubungan dengan Santri:</strong> <span id="orangtuaHubungan"></span><br>
                                <strong>Username:</strong> <span id="orangtuaUsername"></span><br>
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
function viewOrangtua(nama, noTelp, alamat, pekerjaan, hubungan, username) {
    document.getElementById('orangtuaNama').textContent = nama;
    document.getElementById('orangtuaNoTelp').textContent = noTelp;
    document.getElementById('orangtuaAlamat').textContent = alamat;
    document.getElementById('orangtuaPekerjaan').textContent = pekerjaan;
    document.getElementById('orangtuaHubungan').textContent = hubungan;
    document.getElementById('orangtuaUsername').textContent = username;

    document.getElementById('viewOrangtuaModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('viewOrangtuaModal').classList.add('hidden');
}
</script>
@endsection
