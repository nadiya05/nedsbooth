@extends('layouts.landing')

@section('title', 'Choose Frame')

@section('content')
<style>
    .frame-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        justify-items: center;
        align-content: start;
        gap: 1.5rem;
        min-height: 75.75rem;
    }
    .frame-card {
        height: 24.25rem;
        display: flex;
        flex-direction: column;
    }
    .frame-pagination {
        min-height: 7rem;
        padding-top: 2rem;
    }
    .frame-pagination nav {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    .frame-pagination nav > div:last-child {
        width: 100%;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    .frame-pagination nav > div:last-child > div:first-child {
        text-align: center;
    }
    .frame-pagination nav > div:last-child > div:last-child {
        display: flex;
        justify-content: center;
    }
    @media (min-width: 640px) {
        .frame-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); min-height: 51.25rem; }
    }
    @media (min-width: 1024px) {
        .frame-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); min-height: 24.25rem; }
    }
</style>
<div class="my-8 py-8 px-6 bg-white rounded-2xl shadow-lg max-w-5xl mx-auto">

    <!-- Tombol kembali -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-sm text-pink-500 hover:underline">
            ← Back
        </a>
    </div>

    <!-- Judul di atas galeri -->
    <h1 class="text-xl font-semibold mb-8 text-gray-700 text-center">
        choose your layout ^^
    </h1>

    <!-- Galeri Frame -->
    <div class="frame-grid">
        @foreach($frames as $frame)
        <div class="frame-card bg-white p-4 rounded-lg shadow-md w-64">
            <img src="{{ asset('storage/' . $frame->image_path) }}" alt="{{ $frame->name }}" class="h-64 w-full object-contain mb-3 mx-auto">
            <p class="text-sm font-medium mb-0.5 truncate" title="{{ $frame->name }}">{{ $frame->name }}</p>
            <p class="text-xs text-gray-500 mb-3">{{ $frame->shot_count }} Foto</p>
            <a href="{{ route('photobooth.camera', $frame) }}"
               class="mt-auto block bg-pink-300 hover:bg-pink-400 text-white font-medium py-2 px-4 rounded-full transition duration-200">
                Choose
            </a>
        </div>
        @endforeach
        @if($frames->isEmpty())<p class="text-gray-500">Belum ada frame. Silakan kembali lagi nanti.</p>@endif
    </div>

    <div class="frame-pagination" aria-label="Navigasi halaman frame">
        @if($frames->hasPages())
            {{ $frames->links() }}
        @endif
    </div>
</div>
@endsection
