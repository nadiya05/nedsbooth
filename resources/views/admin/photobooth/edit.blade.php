@extends('layouts.landing')

@section('title', 'Edit Frame')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6 max-w-md w-full mx-auto">
    <h2 class="text-lg font-semibold mb-4">Edit Frame</h2>
    <form action="{{ route('admin.frames.update', $frame->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4 text-left">
            <label for="name" class="block text-sm font-medium">Frame Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full rounded border-gray-300" value="{{ $frame->name }}" required>
        </div>
        <div class="mb-4 text-left">
            <label for="preset" class="block text-sm font-medium">Ukuran hasil dan jumlah foto</label>
            <select name="preset" id="preset" class="mt-1 block w-full rounded border-gray-300" required>
                @foreach(['classic' => '3 foto · Classic · 600 × 1800 px', 'classic_hd' => '3 foto · Classic HD · 800 × 2400 px', 'compact' => '2 foto · Compact · 600 × 1200 px', 'compact_hd' => '2 foto · Compact HD · 800 × 1600 px', 'single' => '1 foto · Single Card · 600 × 800 px', 'single_hd' => '1 foto · Single Card HD · 1200 × 1600 px'] as $key => $label)
                    <option value="{{ $key }}" @selected(match ($key) { 'classic' => $frame->width === 600 && $frame->height === 1800, 'classic_hd' => $frame->width === 800 && $frame->height === 2400, 'compact' => $frame->width === 600 && $frame->height === 1200, 'compact_hd' => $frame->width === 800 && $frame->height === 1600, 'single' => $frame->width === 600 && $frame->height === 800, 'single_hd' => $frame->width === 1200 && $frame->height === 1600 })>{{ $label }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Pilih preset dengan rasio sesuai file overlay.</p>
        </div>
        <div class="mb-4 text-left">
            <label for="image" class="block text-sm font-medium">Change Image (optional)</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full">
            <p class="text-sm mt-1">Current: {{ $frame->image_path }}</p>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full">Update Frame</button>
    </form>
</div>
@endsection
