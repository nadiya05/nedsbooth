@extends('layouts.landing')

@section('title', 'Photo Result')

@section('content')
<div class="max-w-3xl mx-auto my-10 bg-white rounded-2xl shadow p-6 text-center">
    <h2 class="text-2xl font-bold mb-4">Foto kamu siap</h2>

    <!-- Gambar hasil -->
    <img id="final-photo" src="{{ $dataUrl }}" alt="Final Photo" class="rounded-xl shadow-md w-full max-w-md mx-auto">

    <!-- Tombol Download & Retake -->
    <div class="mt-6 flex justify-center gap-4">
        <a id="download-btn" href="{{ $dataUrl }}" download="photo-with-frame.png"
           class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-6 rounded-full">
            Unduh foto
        </a>

        <a href="{{ route('photobooth.index') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-6 rounded-full">
            ← Kembali ke frame
        </a>
    </div>
</div>
@endsection
