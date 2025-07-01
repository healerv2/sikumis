@extends('layouts.master')

@section('title')
    Laporan Konsumsi Suplemen
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <form class="row g-3 mb-4" method="GET" action="{{ route('laporan.index') }}">
                        <div class="col-md-3">
                            <label>Nama Pengguna</label>
                            <select name="nama" class="form-select">
                                <option value="">-- Semua Nama --</option>
                                @foreach ($listNama as $nama)
                                    <option value="{{ $nama }}" {{ request('nama') == $nama ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Periode</label>
                            <select name="periode" class="form-select">
                                <option value="harian" {{ request('periode') == 'harian' ? 'selected' : '' }}>Harian
                                </option>
                                <option value="mingguan" {{ request('periode') == 'mingguan' ? 'selected' : '' }}>Mingguan
                                </option>
                                <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ request('tanggal_mulai') ?? now()->startOfMonth()->toDateString() }}">
                        </div>

                        <div class="col-md-3">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ request('tanggal_selesai') ?? now()->toDateString() }}">
                        </div>

                        <div class="col-md-3">
                            <label>Usia</label>
                            <select name="usia" class="form-select">
                                <option value="">Semua</option>
                                <option value="20" {{ request('usia') == '20' ? 'selected' : '' }}>Di bawah 20</option>
                                <option value="20-30" {{ request('usia') == '20-30' ? 'selected' : '' }}>20-30</option>
                                <option value="31-40" {{ request('usia') == '31-40' ? 'selected' : '' }}>31-40</option>
                                <option value="41" {{ request('usia') == '41' ? 'selected' : '' }}>Di atas 40</option>
                            </select>
                        </div>

                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            <a href="{{ route('laporan.export', request()->all()) }}" class="btn btn-success">📥 Ekspor
                                Excel</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>NIK</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Status Minum</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->user->name ?? '-' }}</td>
                                        <td>{{ $row->user->email ?? '-' }}</td>
                                        <td>{{ $row->user->phone ?? '-' }}</td>
                                        <td>{{ $row->user->nik ?? '-' }}</td>
                                        <td>{{ $row->user->level == 1 ? 'Admin' : 'User' }}</td>
                                        <td>{{ $row->user->status_users == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                                        <td>{{ $row->tanggal ? $row->tanggal->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $row->status_minum ? 'Sudah Minum' : 'Belum Minum' }}</td>
                                        <td>{{ $row->catatan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
