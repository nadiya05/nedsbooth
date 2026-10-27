@extends('layouts.landing')

@section('title', 'Add Frame')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 max-w-md w-full mx-auto">
    <h2 class="text-lg font-semibold mb-4">Tambah Frame Photo Booth</h2>
    <form action="{{ route('admin.frames.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4 text-left">
            <label for="name" class="block text-sm font-medium">Nama frame</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full rounded border-gray-300" required>
        </div>
        <div class="mb-4 text-left">
            <label for="preset" class="block text-sm font-medium">Ukuran hasil dan jumlah foto</label>
            <select name="preset" id="preset" class="mt-1 block w-full rounded border-gray-300" required>
                <option value="classic">3 foto · Classic · 600 × 1800 px</option>
                <option value="classic_hd">3 foto · Classic HD · 800 × 2400 px</option>
                <option value="compact">2 foto · Compact · 600 × 1200 px</option>
                <option value="compact_hd">2 foto · Compact HD · 800 × 1600 px</option>
                <option value="single">1 foto · Single Card · 600 × 800 px</option>
                <option value="single_hd">1 foto · Single Card HD · 1200 × 1600 px</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Ukuran ini menjadi kanvas foto. Siapkan file overlay dengan rasio yang sama.</p>
        </div>
        <div class="mb-4 text-left">
            <label for="image" class="block text-sm font-medium">Frame Image</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full" required>
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded w-full">Simpan Frame</button>
    </form>
</div>
@endsection
