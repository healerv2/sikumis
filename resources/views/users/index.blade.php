@extends('layouts.master')

@section('title')
    Data User
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data User</li>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>NIK</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="form-user" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="user-id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Form Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No HP</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Usia</label>
                        <input type="number" name="usia" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Level</label>
                        <select name="level" class="form-control">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kategori Risiko</label>
                        <select name="kategori_risiko" id="kategori_risiko" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Password (Kosongkan jika tidak diubah)</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                autocomplete="new-password">
                            <div class="input-group-text">
                                <input type="checkbox" id="toggle-password"> <small class="ms-1">Lihat</small>
                            </div>
                        </div>
                        <small class="text-muted">Minimal 6 karakter jika ingin mengganti password</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!--end row-->
@endsection

@push('scripts')
    <script>
        // Tampilkan/sembunyikan password
        $('#toggle-password').on('change', function() {
            const passwordInput = $('#password');
            const type = $(this).is(':checked') ? 'text' : 'password';
            passwordInput.attr('type', type);
        });

        let table;
        let save_method = 'add';

        $(function() {
            // Init datatable
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: data => data.level == 1 ?
                            '<span class="badge bg-success">admin</span>' :
                            '<span class="badge bg-danger">user</span>'
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: data => data.status_users == 1 ?
                            '<span class="badge bg-primary">aktif</span>' :
                            '<span class="badge bg-warning">non aktif</span>'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });


            $(function() {
                // tombol tambah
                $('#btn-tambah').click(function() {
                    save_method = 'add';
                    $('#form-user')[0].reset();
                    $('#user-id').val('');
                    $('[name=password]').val('');
                    $('#modal-form').modal('show');
                    $('#modalLabel').text('Tambah User');
                });

                // klik edit
                $(document).on('click', '.edit-users', function() {
                    save_method = 'edit';
                    const id = $(this).data('id');

                    $.get(`/user/${id}/edit`, function(data) {
                        $('#modal-form').modal('show');
                        $('#modalLabel').text('Edit User');

                        $('#user-id').val(data.id);
                        $('[name=name]').val(data.name);
                        $('[name=email]').val(data.email);
                        $('[name=phone]').val(data.phone);
                        $('[name=nik]').val(data.nik);
                        $('[name=usia]').val(data.usia);
                        $('[name=alamat]').val(data.alamat);
                        $('[name=level]').val(data.level);
                        $('[name=password]').val('');
                        $('#kategori_risiko').val(data.kategori_risiko);
                    });
                });

                // submit form
                $('#form-user').submit(function(e) {
                    e.preventDefault();

                    const password = $('[name=password]').val();
                    if (password && password.length < 6) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Password terlalu pendek',
                            text: 'Minimal 6 karakter jika ingin mengganti password.'
                        });
                        return;
                    }

                    const id = $('#user-id').val();
                    const url = save_method == 'add' ? `{{ route('user.store') }}` : `/user/${id}`;
                    const method = save_method == 'add' ? 'POST' : 'PUT';

                    $('#method').val(method); // untuk method spoofing PUT
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
            });

            // Hapus user
            $(document).on('click', '.delete-users', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/user/${id}`,
                            method: 'DELETE',
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
