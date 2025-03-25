@extends('layouts.app')

@section('title', 'Daftar Klaim untuk ' . $donation->food_name)

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-primary fw-bold">
        <i class="fas fa-utensils"></i> Klaim untuk "{{ $donation->food_name }}"
    </h1>

    @if (session('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Penerima</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($claims as $index => $claim)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $claim->user->name ?? $claim->name }}</td>
                <td>
                    <span class="badge {{ $claim->status == 'collected' ? 'bg-success' : 'bg-warning' }}">
                        {{ ucfirst($claim->status) }}
                    </span>
                </td>
                <td>
                    @if ($claim->status === 'pending')
                        <form method="POST" action="{{ route('claims.approve', $claim->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i> Setujui
                            </button>
                        </form>
                
                        <form method="POST" action="{{ route('claims.reject', $claim->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times-circle"></i> Tolak
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>
                            <i class="fas fa-check-circle"></i> {{ ucfirst($claim->status) }}
                        </button>
                    @endif
                </td>                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
