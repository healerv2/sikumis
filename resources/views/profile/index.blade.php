@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">
        Profile</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3">
            <div class="card profile">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/' . auth()->user()->foto ?? '') }}" alt=""
                            class="rounded-circle img-thumbnail avatar-xl">
                        <div class="online-circle">
                            <i class="fa fa-circle text-success"></i>
                        </div>
                        <h4 class="mt-3">{{ $profil->name }}</h4>
                        <p class="text-muted font-size-13">
                            @if (auth()->user()->level == 1)
                                <p>admin</p>
                            @else
                                <p>members</p>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Contact</h5>
                    <ul class="list-unstyled mb-0">
                        <li class=""><i class="mdi mdi-phone me-2 text-success font-size-18"></i> <b>
                                phone </b> : {{ $profil->phone }}</li>
                        <li class="mt-2"><i class="mdi mdi-email-outline text-success font-size-18 mt-2 me-2"></i>
                            <b> Email </b> : {{ $profil->email }}
                        </li>

                    </ul>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-9">
            <div class="card">
                <div class="card-body profile">
                    <form class="custom-validation" action=" {{ route('profil.update', $profil->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $profil->name }}" placeholder="Nama" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $profil->email }}" placeholder="Email" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone (WA)</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ $profil->phone }}" placeholder="Phone (WA)" />
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <div>
                                <textarea class="form-control" name="alamat" id="alamat" rows="5">  {{ $profil->alamat }}</textarea>
                            </div>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <div class="mb-3">
                                <input type="file" name="foto" id="foto" class="form-control"
                                    placeholder="Foto" />
                                <span class="text-danger" style="font-size: 13px">Kosongkan jika tidak ingin
                                    mengubah.</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="old_password" id="old_password" class="form-control"
                                placeholder="Password" />
                            <span class="text-danger" style="font-size: 13px">Kosongkan jika tidak ingin
                                mengubah.</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" data-match="#password" placeholder="Konfirmasi Password" />
                        </div>
                        <div class="mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                        class="fas fa-save"></i>
                                    Save
                                </button>
                                <a class="btn btn-danger waves-effect ms-1" href="{{ route('dashboard') }}"><i
                                        class="fas fa-undo-alt"></i> Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->

        </div>
    </div>
    <!--end row-->
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#old_password').on('keyup', function() {
                if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
                else $('#password, #password_confirmation').attr('required', false);
            });
        });
    </script>
@endpush
