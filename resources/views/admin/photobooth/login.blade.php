@extends('layouts.landing')

@section('title', 'Login Admin')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full mx-auto text-left">
    <h1 class="text-2xl font-semibold text-center mb-2">Login Admin</h1>
    <p class="text-sm text-gray-500 text-center mb-6">Masuk untuk mengelola frame photo booth.</p>
    @if($errors->any())<div class="bg-red-100 text-red-700 rounded p-3 mb-4">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <label class="block text-sm font-medium mb-1" for="email">Email</label>
        <input class="w-full border rounded p-2 mb-4" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
        <label class="block text-sm font-medium mb-1" for="password">Password</label>
        <input class="w-full border rounded p-2 mb-4" id="password" name="password" type="password" required>
        <label class="flex gap-2 items-center text-sm mb-5"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
        <button class="w-full rounded-full bg-pink-500 text-white py-2">Masuk</button>
    </form>
</div>
@endsection
