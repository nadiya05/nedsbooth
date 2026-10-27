@extends('layouts.landing')

@section('title', 'Kelola Frame')

@section('content')

<!-- Kontainer Tabel -->
<div class="bg-white rounded-2xl shadow-lg p-6 max-w-3xl w-full mx-auto">
    <div class="mb-5 flex items-center justify-between">
        <span class="text-sm text-gray-600">Admin: {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="text-sm text-pink-600 underline">Keluar</button></form>
    </div>

    <!-- Judul dan Tombol di dalam kontainer -->
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Frame</h2>
        <a href="{{ route('admin.frames.create') }}" class="bg-blue-500 hover:bg-green-600 text-white py-2 px-4 rounded">Tambah</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm border border-grey">
            <thead class="bg-pink-100 text-gray-700 border-b border-grey">
                <tr>
                    <th class="px-4 py-2 border-r border-grey">#</th>
                    <th class="px-4 py-2 border-r border-grey">Nama</th>
                    <th class="px-4 py-2 border-r border-grey">Preview</th>
                    <th class="px-4 py-2 border-r border-grey">Format hasil</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($frames as $index => $frame)
                <tr class="border-t border-grey">
                    <td class="px-4 py-2 border-r border-grey">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border-r border-grey">{{ $frame->name }}</td>
                    <td class="px-4 py-2 border-r border-grey">
                        <img src="{{ asset('storage/' . $frame->image_path) }}" alt="{{ $frame->name }}" class="w-24 rounded shadow">
                    </td>
                    <td class="px-4 py-2 border-r border-grey">{{ $frame->shot_count }} foto · {{ $frame->width }} × {{ $frame->height }} px</td>
                    <td class="px-4 py-2 space-x-1">
                        <a href="{{ route('admin.frames.edit', $frame->id) }}" class="inline-block bg-yellow-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.frames.destroy', $frame->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">Hapus</button>
                        </form>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
