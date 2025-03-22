@extends('layouts.app')

@section('title', 'Daftar Klaim')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Statistik Klaim --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pending</h5>
                        <p class="card-text fs-3">{{ $pending }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Collected</h5>
                        <p class="card-text fs-3">{{ $collected }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Cancelled</h5>
                        <p class="card-text fs-3">{{ $cancelled }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Statistik --}}
        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title text-center">Distribusi Status Klaim</h5>
                        <canvas id="claimChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">Jumlah Klaim per Hari</h5>
                        <canvas id="claimBarChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- CSS untuk Chart --}}
        <style>
            .chart-canvas {
                max-width: 100%;
                height: 300px !important; /* Ukuran chart agar seimbang */
            }
        </style>

        {{-- Tabel Klaim --}}
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Daftar Klaim</h1>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('claims.create') }}" class="btn btn-primary">Buat Klaim</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>Nomor Antrean</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nama Makanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claims as $claim)
                                <tr class="text-center">
                                    <td>{{ $claim->queue_number }}</td>
                                    <td>{{ $claim->user ? $claim->user->name : 'Guest' }}</td>
                                    <td>{{ $claim->donation->food_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $claim->status === 'pending' ? 'warning' : 
                                            ($claim->status === 'collected' ? 'success' : 'danger') }}">
                                            {{ ucfirst($claim->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('claims.show', $claim) }}" class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js untuk Statistik --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctxPie = document.getElementById('claimChart').getContext('2d');
        var claimChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Collected', 'Cancelled'],
                datasets: [{
                    data: [{{ $pending }}, {{ $collected }}, {{ $cancelled }}],
                    backgroundColor: ['#ffc107', '#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        var ctxBar = document.getElementById('claimBarChart').getContext('2d');
        var claimBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($claimsPerDay->pluck('date')) !!},
                datasets: [{
                    label: 'Total Claims',
                    data: {!! json_encode($claimsPerDay->pluck('total')) !!},
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
