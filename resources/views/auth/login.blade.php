@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1 class="mb-4">Login</h1>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
    <a href="{{ route('register') }}" class="btn btn-link">Daftar</a>
</form>
@endsection
