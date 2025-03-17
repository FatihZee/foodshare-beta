@extends('layouts.app')

@section('content')
<h1>Edit Pengguna</h1>
<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf @method('PUT')
    <label>Nama</label>
    <input type="text" name="name" value="{{ $user->name }}">

    <label>Email</label>
    <input type="email" name="email" value="{{ $user->email }}">

    <label>Password (Opsional)</label>
    <input type="password" name="password">

    <label>Role</label>
    <select name="role">
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="donatur" {{ $user->role == 'donatur' ? 'selected' : '' }}>Donatur</option>
        <option value="sr" {{ $user->role == 'sr' ? 'selected' : '' }}>SR</option>
    </select>

    <label>No. HP</label>
    <input type="text" name="phone" value="{{ $user->phone }}">

    <button type="submit">Update</button>
</form>
@endsection
