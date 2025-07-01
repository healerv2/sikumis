@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row mb-4">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
            <div class="col-md-3">
                <label>Wilayah</label>
                <select class="form-select" name="wilayah">
                    <option value="">Semua</option>
                    @foreach ($wilayahList as $w)
                        <option value="{{ $w }}" {{ request('wilayah') == $w ? 'selected' : '' }}>
                            {{ $w }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Usia</label>
                <select class="form-select" name="usia">
                    <option value="">Semua</option>
                    <option value="20" {{ request('usia') == '20' ? 'selected' : '' }}>Di bawah 20</option>
                    <option value="20-30" {{ request('usia') == '20-30' ? 'selected' : '' }}>20 - 30</option>
                    <option value="31-40" {{ request('usia') == '31-40' ? 'selected' : '' }}>31 - 40</option>
                    <option value="41" {{ request('usia') == '41' ? 'selected' : '' }}>Di atas 40</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Jenis Suplemen</label>
                <select class="form-select" name="suplemen">
                    <option value="">Semua</option>
                    @foreach ($suplemenList as $id => $nama)
                        <option value="{{ $id }}" {{ request('suplemen') == $id ? 'selected' : '' }}>
                            {{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="overview-content">
                                <i class="mdi mdi-account-multiple text-primary"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <p class="text-muted font-size-13 mb-1">User Aktif</p>
                            <h4 class="mb-0 font-size-20">{{ $totalUserAktif }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="overview-content">
                                <i class="mdi mdi-check-circle-outline text-success"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <p class="text-muted font-size-13 mb-1">Patuh</p>
                            <h4 class="mb-0 font-size-20">{{ $totalPatuh }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="overview-content">
                                <i class="mdi mdi-close-circle-outline text-danger"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <p class="text-muted font-size-13 mb-1">Tidak Patuh</p>
                            <h4 class="mb-0 font-size-20">{{ $totalTidakPatuh }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-content">
                <div class="card-body border-bottom">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="overview-content">
                                <i class="mdi mdi-chart-donut text-info"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <p class="text-muted font-size-13 mb-1">Kepatuhan (%)</p>
                            <h4 class="mb-0 font-size-20">{{ $tingkatKepatuhan }}%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Grafik Kepatuhan Mingguan</h5>
            <canvas id="chartKepatuhan"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartKepatuhan').getContext('2d');
        const chartKepatuhan = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafikLabels) !!},
                datasets: [{
                    label: 'Kepatuhan Harian',
                    data: {!! json_encode($grafikData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
@endpush
