@extends('layouts.vertical', ['title' => 'Starter Page'])

@section('css')

@endsection

@section('content')

@include("layouts.shared/page-title", ["subtitle" => "Apps", "title" => "Starter Page"])

<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Program</h1>

    <form method="POST" action="{{ route('programs.update', $program) }}">
        @method('PUT') <!-- Penting untuk method PUT di Laravel -->
        @csrf
        <div class="mb-4">
            <label for="nama_program" class="block text-sm font-medium text-gray-700">Nama Program</label>
            <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program', $program->nama_program) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('nama_program')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="target" class="block text-sm font-medium text-gray-700">Target</label>
            <input type="text" name="target" id="target" value="{{ old('target', $program->target) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('target')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
            <select name="level" id="level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="regular" {{ old('level', $program->level) === 'regular' ? 'selected' : '' }}>Regular</option>
                <option value="tahfidz" {{ old('level', $program->level) === 'tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                <option value="both" {{ old('level', $program->level) === 'both' ? 'selected' : '' }}>Keduanya</option>
            </select>
            @error('level')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Jenis Isian</label>
            <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="numeric" {{ old('type', $program->type) === 'numeric' ? 'selected' : '' }}>Angka</option>
                <option value="boolean" {{ old('type', $program->type) === 'boolean' ? 'selected' : '' }}>Ya/Tidak</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="unit" class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="unit" id="unit" value="{{ old('unit', $program->unit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Contoh: halaman, kali, menit">
            @error('unit')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui Program</button>
        <a href="{{ route('programs.index') }}" class="ml-2 text-gray-600 hover:underline">Kembali</a>
    </form>
</div>

@endsection

@section('script')

@endsection