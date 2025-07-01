@extends('layouts.mobile')

@section('title', 'Pengaturan Jadwal Suplemen')

@section('content')
    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Jadwal Suplemen</h2>
        </div>

        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <div class="card card-style">
            <div class="content">
                <div class="d-flex">
                    <div>
                        <h1 class="mb-0 pt-1">Pengaturan Jadwal Suplemen</h1>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card card-style">
            <div class="content mb-0">
                <form id="form-jadwal" method="POST" action="{{ route('mobile.jadwal.store') }}">
                    @csrf

                    {{-- Input waktu konsumsi --}}
                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="waktu_notifikasi" class="color-highlight font-13">Waktu Minum</label>
                        <input type="time" name="waktu_notifikasi" id="waktu_notifikasi" class="form-control" required>
                    </div>

                    {{-- Interval pengingat --}}
                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="interval" class="color-highlight font-13">Interval Pengingat</label>
                        <select name="interval" id="interval" class="form-control" required>
                            <option value="15_menit">Setiap 15 Menit</option>
                            <option value="30_menit">Setiap 30 Menit</option>
                            <option value="45_menit">Setiap 45 Menit</option>
                            <option value="1_jam">Setiap 1 Jam</option>
                            <option value="2_jam">Setiap 2 Jam</option>
                            <option value="6_jam">Setiap 6 Jam</option>
                            <option value="12_jam">Setiap 12 Jam</option>
                            <option value="1_hari">Setiap Hari</option>
                            <option value="2_hari">Setiap 2 Hari</option>
                            <option value="mingguan">Mingguan</option>
                        </select>
                    </div>

                    {{-- Hidden status --}}
                    <input type="hidden" name="status" value="1">

                    <div class="mb-4">
                        <button type="submit"
                            class="btn btn-full btn-m bg-blue-dark text-uppercase font-900 rounded-sm">Simpan
                            Jadwal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
