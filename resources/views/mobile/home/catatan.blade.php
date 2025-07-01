@extends('layouts.mobile')

@section('title', 'Catatan Harian')

@section('content')
    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Catatan Konsumsi</h2>
        </div>

        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <div class="card card-style">
            <div class="content">
                <h4 class="mb-2">Status Hari Ini</h4>
                @if ($catatanHariIni?->status_minum)
                    <span class="badge bg-success">✅ Sudah Minum</span>
                @else
                    <span class="badge bg-danger">❌ Belum Minum</span>
                @endif
            </div>
        </div>


        <div class="card card-style">
            <div class="content">
                <h4 class="mb-3">Catatan Hari Ini</h4>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ implode(', ', $errors->all()) }}
                    </div>
                @endif
                <form method="POST" action="{{ route('catatan.store') }}">
                    @csrf

                    <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
                    {{-- ✅ Default value jika tidak dicentang --}}
                    <input type="hidden" name="status_minum" value="0">

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="status_minum" id="status_minum" value="1"
                            {{ $catatanHariIni?->status_minum ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_minum">
                            Saya sudah minum suplemen hari ini
                        </label>
                    </div>

                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-highlight font-13">Catatan Tambahan</label>
                        <textarea class="form-control" name="catatan" rows="4" placeholder="Contoh: Merasa mual setelah minum...">{{ $catatanHariIni?->catatan }}</textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit"
                            class="btn btn-full btn-m bg-blue-dark text-uppercase font-900 rounded-sm">Simpan
                            Catatan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
