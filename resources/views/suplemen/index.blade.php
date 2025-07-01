@extends('layouts.master')

@section('title')
    Data Suplemen
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Suplemen</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <button class="btn btn-primary btn-sm" id="btn-tambah">
                        <i class="fa fa-plus-circle"></i>
                        Tambah
                    </button>
                    <p></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Suplemen</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-suplemen" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-header">
                    <h5 class="modal-title">Form Suplemen</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="digunakan">Digunakan</option>
                            <option value="tidak">Tidak Digunakan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!--end row-->
@endsection
@push('scripts')
    <script>
        let table;
        let save_method = 'add';

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('suplemen.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'status',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        orderable: false
                    }
                ]
            });

            // Tambah
            $('#btn-tambah').click(function() {
                save_method = 'add';
                $('#form-suplemen')[0].reset();
                $('#modal-form').modal('show');
            });

            // Edit
            $(document).on('click', '.edit-suplemen', function() {
                save_method = 'edit';
                let id = $(this).data('id');
                $.get(`/suplemen/${id}/edit`, function(res) {
                    $('#id').val(res.id);
                    $('[name=nama]').val(res.nama);
                    $('[name=deskripsi]').val(res.deskripsi);
                    $('[name=status]').val(res.status);
                    $('#modal-form').modal('show');
                });
            });

            // Submit
            $('#form-suplemen').submit(function(e) {
                e.preventDefault();

                let id = $('#id').val();
                let url = save_method === 'add' ? `{{ route('suplemen.store') }}` : `/suplemen/${id}`;
                let method = save_method === 'add' ? 'POST' : 'PUT';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function(err) {
                        if (err.status === 409) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Duplikat Data',
                                text: err.responseJSON.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: err.responseJSON?.message ||
                                    'Gagal menyimpan data'
                            });
                        }
                    }
                });
            });


            // Hapus
            $(document).on('click', '.delete-suplemen', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/suplemen/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
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
                                    title: 'Gagal menghapus data',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
