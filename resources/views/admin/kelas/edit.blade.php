{{-- resources/views/admin/kelas/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Edit Data Kelas</h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.kelas.update', $kelas->c_kelas) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_kelas" class="block text-gray-700 text-sm font-bold mb-2">Nama Kelas:</label>
                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_kelas') border-red-500 @enderror" required>
                @error('nama_kelas')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tingkat" class="block text-gray-700 text-sm font-bold mb-2">Tingkat:</label>
                <select name="tingkat" id="tingkat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tingkat') border-red-500 @enderror" required>
                    <option value="SMP" {{ (old('tingkat', $kelas->tingkat) == 'SMP') ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ (old('tingkat', $kelas->tingkat) == 'SMA') ? 'selected' : '' }}>SMA</option>
                </select>
                @error('tingkat')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="wali_kelas" class="block text-gray-700 text-sm font-bold mb-2">Wali Kelas:</label>
                <select name="wali_kelas" id="wali_kelas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('wali_kelas') border-red-500 @enderror" required>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->c_guru }}" {{ (old('wali_kelas', $kelas->wali_kelas) == $guru->c_guru) ? 'selected' : '' }}>{{ $guru->nama }}</option>
                    @endforeach
                </select>
                @error('wali_kelas')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update
                </button>
                <a href="{{ route('admin.kelas') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
