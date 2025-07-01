@extends('layouts.master')

@section('title', 'Pengaturan Notifikasi Suplemen')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="table-setting">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Suplemen</th>
                        <th>Interval</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-setting" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="form-setting" class="modal-content">
                @csrf
                <input type="hidden" name="user_id" id="user_id">

                <div class="modal-header">
                    <h5 class="modal-title">Atur Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row">
                    <div class="col-md-6 mb-3">
                        <label>Jam Notifikasi</label>
                        <input type="time" name="waktu_notifikasi" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Interval</label>
                        <select name="interval" class="form-control" required>
                            <option value="15_menit">15 Menit</option>
                            <option value="30_menit">30 Menit</option>
                            <option value="45_menit">45 Menit</option>
                            <option value="1_jam">1 Jam</option>
                            <option value="2_jam">2 Jam</option>
                            <option value="6_jam">6 Jam</option>
                            <option value="12_jam">12 Jam</option>
                            <option value="1_hari">1 Hari</option>
                            <option value="2_hari">2 Hari</option>
                            <option value="mingguan">Mingguan</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Suplemen</label>
                        <select name="suplemen_id[]" class="form-control" id="suplemen_id" multiple required>
                            @foreach ($suplemen as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            $('#suplemen_id').select2({
                dropdownParent: $('#modal-setting'),
                width: '100%',
                placeholder: 'Pilih Suplemen'
            });

            table = $('#table-setting').DataTable({
                ajax: '{{ route('setting-notifikasi.index') }}',
                processing: true,
                responsive: true,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'suplemen'
                    },
                    {
                        data: 'interval'
                    },
                    {
                        data: 'jam'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.edit-setting', function() {
                const id = $(this).data('id');
                $('#form-setting')[0].reset();
                $('#suplemen_id').val(null).trigger('change');

                $.get("{{ url('setting-notifikasi') }}/" + id + "/edit", function(res) {
                    $('#user_id').val(res.id);
                    $('input[name=waktu_notifikasi]').val(res.notification_setting
                        ?.waktu_notifikasi || '');
                    $('select[name=interval]').val(res.notification_setting?.interval || '1_hari');
                    $('select[name=status]').val(res.notification_setting?.status ?? 0);

                    if (res.suplemen) {
                        const ids = res.suplemen.map(s => s.id);
                        $('#suplemen_id').val(ids).trigger('change');
                    }

                    $('#modal-setting').modal('show');
                });
            });

            $('#form-setting').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('setting-notifikasi.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#modal-setting').modal('hide');
                        table.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message || 'Gagal menyimpan data'
                        });
                    }
                });
            });
        });
    </script>
@endpush
