@extends('layouts.vertical', ['title' => 'Admin Manage Fees'])

@section('content')
    @include("layouts.shared/page-title", ["subtitle" => "Admin", "title" => "Kelola Biaya User"])

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Kelola Biaya User</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="py-2 px-4 border-r">Nama User</th>
                    <th class="py-2 px-4 border-r">ID</th>
                    <th class="py-2 px-4 border-r">Level</th>
                    <th class="py-2 px-4 border-r">Biaya Tahunan</th>
                    <th class="py-2 px-4 border-r">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="py-2 px-4 border-r">{{ $user->nama_lengkap }}</td>
                        <td class="py-2 px-4 border-r">{{ $user->id }}</td>
                        <td class="py-2 px-4 border-r">{{ $user->level }}</td>
                        <td class="py-2 px-4 border-r">Rp {{ number_format($user->annual_fee ?? 0, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 border-r">
                            <a href="{{ route('admin.manage-fees.show', $user->id) }}" class="bg-blue-600 text-white py-1 px-3 rounded-lg hover:bg-blue-700">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection