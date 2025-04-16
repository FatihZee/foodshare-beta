@extends('layouts.app')

@section('title', 'Daftar Donasi')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Available</h5>
                        <p class="card-text fs-3">{{ $available }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Claimed</h5>
                        <p class="card-text fs-3">{{ $claimed }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Completed</h5>
                        <p class="card-text fs-3">{{ $completed }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title text-center">Distribusi Status Donasi</h5>
                        <canvas id="donationChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="card w-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">Jumlah Donasi per Hari</h5>
                        <canvas id="donationBarChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .chart-canvas {
                max-width: 100%;
                height: 300px !important;
            }
        </style>

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Daftar Donasi</h1>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('donations.create') }}" class="btn btn-primary">Tambah Donasi</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark text-center align-middle">
                            <tr class="text-center">
                                <th>Nama Makanan</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Lokasi</th>
                                <th>Donatur</th>
                                <th>Status</th>
                                <th>Kadaluarsa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                            @foreach ($donations as $donation)
                                <tr class="text-center">
                                    <td>{{ $donation->food_name }}</td>
                                    <td>{{ optional($donation->category)->name ?: 'Tidak Ada Kategori' }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->location }}</td>
                                    <td>{{ $donation->donor_name ?: 'Hamba Allah' }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $donation->status === 'available' ? 'primary' : 
                                            ($donation->status === 'claimed' ? 'warning' : 'success') 
                                        }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>                                    
                                    <td>{{ \Carbon\Carbon::parse($donation->expiration)->setTimezone('Asia/Jakarta')->translatedFormat('d M Y H:i:s') }}</td>
                                    <td>
                                        <div class="d-flex flex-nowrap justify-content-center gap-1">
                                            @if ($donation->maps)
                                                <a href="{{ $donation->maps }}" target="_blank" class="btn btn-secondary btn-sm px-2" title="Lihat Lokasi">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('donations.show', $donation) }}" class="btn btn-info btn-sm px-2" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('donations.claims', $donation->id) }}" class="btn btn-primary btn-sm px-2" title="Lihat Klaim">
                                                <i class="fas fa-users"></i>
                                            </a>
                                    
                                            @if (Auth::check() && (Auth::id() === $donation->donor_id || auth()->user()->role === 'admin'))
                                                <a href="{{ route('donations.edit', $donation) }}" class="btn btn-warning btn-sm px-2" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm deleteButton">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>                                                            
                                            @endif
                                        </div>
                                    </td>                                                                                                 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctxPie = document.getElementById('donationChart').getContext('2d');
        var donationChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Available', 'Claimed', 'Completed'],
                datasets: [{
                    data: [{{ $available }}, {{ $claimed }}, {{ $completed }}],
                    backgroundColor: ['#007bff', '#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        var ctxBar = document.getElementById('donationBarChart').getContext('2d');
        var donationBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($donationsPerDay->pluck('date')) !!},
                datasets: [{
                    label: 'Total Donations',
                    data: {!! json_encode($donationsPerDay->pluck('total')) !!},
                    backgroundColor: '#2470db'
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                let form = this.closest("form");

                Swal.fire({
                    title: "Konfirmasi Hapus",
                    text: "Apakah Anda yakin ingin menghapus donasi ini? Aksi ini tidak dapat dibatalkan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Donasi Anda telah berhasil dihapus.",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => {
                            form.submit();
                        }, 2000);
                    }
                });
            });
        });
    </script>

@endsection
