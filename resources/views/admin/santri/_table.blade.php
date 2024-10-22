@forelse($santri as $s)
<tr>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">{{ $s->nis }}</p>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">{{ $s->nama }}</p>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">{{ $s->kelas->nama_kelas }}</p>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p class="text-gray-900 whitespace-no-wrap">{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
    </td>
    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <a href="javascript:void(0)" onclick="viewSantri('{{ $s->c_santri }}', '{{ $s->nis }}', '{{ $s->nama }}', '{{ $s->kelas->nama_kelas }}', '{{ $s->jenis_kelamin }}', '{{ $s->tempat_lahir }}', '{{ $s->tanggal_lahir }}', '{{ $s->alamat }}', '{{ $s->no_telp }}', '{{ $s->orangTua->nama }}', '{{ $s->orangTua->alamat }}', '{{ $s->orangTua->no_telp }}')" class="text-blue-600 hover:text-blue-900 mr-4">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.santri.edit', $s->c_santri) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.santri.destroy', $s->c_santri) }}" method="POST" class="inline-block">
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
        Tidak ada data santri.
    </td>
</tr>
@endforelse
