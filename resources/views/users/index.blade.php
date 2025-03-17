@extends('layouts.app')

@section('content')
<h1>Daftar Pengguna</h1>
<a href="{{ route('users.create') }}">Tambah User</a>
<table>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email ?? 'Guest' }}</td>
        <td>{{ $user->role }}</td>
        <td>
            <a href="{{ route('users.show', $user) }}">Detail</a>
            <a href="{{ route('users.edit', $user) }}">Edit</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
