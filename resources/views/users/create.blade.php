@extends('layouts.app')

@section('content')
<h1>Tambah Pengguna</h1>
<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <label>Nama (Opsional)</label>
    <input type="text" name="name">

    <label>Email (Opsional)</label>
    <input type="email" name="email">

    <label>Password (Opsional)</label>
    <input type="password" name="password">

    <label>Role</label>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
        <option value="donatur">Donatur</option>
        <option value="sr">SR</option>
    </select>

    <label>No. HP (Opsional)</label>
    <input type="text" name="phone">

    <button type="submit">Simpan</button>
</form>
@endsection
