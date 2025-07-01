@extends('layouts.master')

@section('title')
    Data Konten Edukasi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Data Konten Edukasi</li>
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
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Form -->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="form-post" class="modal-content" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="post-id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Form Post</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control tinymce"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Lampiran</label>
                        <input type="file" name="lampiran" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Post</h5>
                </div>
                <div class="modal-body">
                    <h4 id="detail-judul"></h4>
                    <p><strong>Deskripsi:</strong></p>
                    <div id="detail-deskripsi"></div>
                    <p><strong>Lampiran:</strong></p>
                    <div id="detail-lampiran"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
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
                ajax: '{{ route('posts.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'judul'
                    },
                    {
                        data: 'deskripsi'
                    },
                    {
                        data: 'lampiran',
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

            tinymce.init({
                selector: 'textarea.tinymce',
                height: 300,
                menubar: false,
                plugins: 'lists link image preview code',
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | code preview',
                branding: false,
            });

            $('#btn-tambah').click(() => {
                save_method = 'add';
                $('#form-post')[0].reset();
                $('#post-id').val('');
                $('#modal-form').modal('show');
            });

            $(document).on('click', '.edit-post', function() {
                save_method = 'edit';
                let id = $(this).data('id');
                $.get(`/posts/${id}/edit`, function(res) {
                    $('#post-id').val(res.id);
                    $('[name=judul]').val(res.judul);
                    tinymce.get('deskripsi').setContent(res.deskripsi ?? '');
                    $('#modal-form').modal('show');
                });
            });

            $('#form-post').submit(function(e) {
                e.preventDefault();
                tinymce.triggerSave();

                let formData = new FormData(this);
                let id = $('#post-id').val();
                let url = save_method === 'add' ? `{{ route('posts.store') }}` : `/posts/${id}`;
                let method = save_method === 'add' ? 'POST' : 'POST';

                if (save_method === 'edit') formData.append('_method', 'PUT');

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message || 'Gagal menyimpan data'
                        });
                    }
                });
            });

            $(document).on('click', '.view-post', function() {
                let id = $(this).data('id');

                $.get(`/posts/${id}`, function(res) {
                    $('#detail-judul').text(res.judul);
                    $('#detail-deskripsi').html(res.deskripsi ?? '-');

                    let lampiranHtml = '-';
                    if (res.lampiran) {
                        let ext = res.lampiran.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png'].includes(ext)) {
                            lampiranHtml =
                                `<img src="/storage/${res.lampiran}" width="200" class="img-fluid">`;
                        } else if (ext === 'pdf') {
                            lampiranHtml =
                                `<a href="/storage/${res.lampiran}" target="_blank">Lihat PDF</a>`;
                        } else if (ext === 'mp4') {
                            lampiranHtml =
                                `<video src="/storage/${res.lampiran}" width="300" controls></video>`;
                        }
                    }

                    $('#detail-lampiran').html(lampiranHtml);
                    $('#modal-detail').modal('show');
                });
            });

            $(document).on('click', '.delete-post', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/posts/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire('Terhapus', res.message, 'success');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
