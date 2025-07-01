@extends('layouts.master')

@section('title', 'Notifikasi Massal')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Kirim Notifikasi Massal</h5>
        </div>
        <div class="card-body">
            <form id="form-massal">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea name="pesan" id="pesan" rows="4" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL (opsional)</label>
                    <input type="text" name="url" id="url" class="form-control"
                        placeholder="https://link-tujuan.com">
                </div>
                <div class="mb-3">
                    <label for="users" class="form-label">Pilih User (Level 2)</label>
                    <select name="users[]" id="users" class="form-control" multiple required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#users').select2({
                placeholder: 'Pilih user yang ingin dikirimi notifikasi',
                width: '100%'
            });

            $('#form-massal').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('notifikasi.kirim.massal') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#form-massal')[0].reset();
                        $('#users').val(null).trigger('change');
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message ||
                                'Terjadi kesalahan saat mengirim notifikasi'
                        });
                    }
                });
            });
        });
    </script>
@endpush
