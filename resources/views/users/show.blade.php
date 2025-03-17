@extends('layouts.app')

@section('content')
<h1>Detail Pengguna</h1>
<p>Nama: {{ $user->name }}</p>
<p>Email: {{ $user->email ?? 'Guest' }}</p>
<p>Role: {{ $user->role }}</p>
<p>No. HP: {{ $user->phone }}</p>
<a href="{{ route('users.index') }}">Kembali</a>
@endsection
