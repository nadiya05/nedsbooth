@extends('layouts.landing')

@section('title', "ned’s booth")

@section('content')
  <div class="bg-white rounded-2xl shadow-lg p-8 max-w-sm w-full mx-auto">
    <p class="text-lg font-light mb-6 text-gray-700">
      create your moments<br>with us &lt;3
    </p>
    <div class="flex justify-center items-center space-x-4 mb-6">
      <img src="{{ asset('storage/frame-sample.png') }}" alt="Frame Sample" class="w-60 transform rotate-[60deg]">
    </div>
    <a href="{{ route('photobooth.index') }}"
       class="bg-pink-300 hover:bg-pink-400 text-white font-medium py-2 px-6 rounded-full inline-flex items-center justify-center transition duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-camera" viewBox="0 -2 20 20">
        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z"/>
        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
      </svg>
      start
    </a>
  </div>
@endsection
