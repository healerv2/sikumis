@extends('layouts.master')

@section('title', 'Data Pasien')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Filter Data Pasien</h5>
            <div class="row mb-3">
                <div class="col-md-2">
                    <input type="text" id="filter-nama" class="form-control" placeholder="Nama">
                </div>
                <div class="col-md-2">
                    <input type="text" id="filter-nik" class="form-control" placeholder="NIK">
                </div>
                <div class="col-md-1">
                    <input type="number" id="filter-usia" class="form-control" placeholder="Usia">
                </div>
                <div class="col-md-2">
                    <input type="text" id="filter-alamat" class="form-control" placeholder="Wilayah">
                </div>
                <div class="col-md-2">
                    <select id="filter-status" class="form-control">
                        <option value="">Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filter-risiko" class="form-control">
                        <option value="">Risiko</option>
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="btn-filter" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>

            <table class="table table-bordered" id="table-pasien">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>Usia</th>
                        <th>Alamat</th>
                        <th>Kategori Risiko</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('#table-pasien').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('pasien.index') }}',
                    data: function(d) {
                        d.nama = $('#filter-nama').val();
                        d.nik = $('#filter-nik').val();
                        d.usia = $('#filter-usia').val();
                        d.alamat = $('#filter-alamat').val();
                        d.status_users = $('#filter-status').val();
                        d.kategori_risiko = $('#filter-risiko').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'usia'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'kategori_risiko',
                        defaultContent: '-'
                    },
                    {
                        data: 'status',
                        searchable: false,
                        orderable: false
                    },
                ],
                responsive: true,
            });

            $('#btn-filter').on('click', function() {
                table.ajax.reload();
            });

            // Live search global
            $('#table-pasien_filter input').off().on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endpush
