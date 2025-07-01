@extends('layouts.auth')
@section('content')
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">NiceAdmin</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                    <p class="text-center small">Enter your personal details to create account</p>
                                </div>
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-octagon me-1"></i>
                                        {!! $error !!}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-octagon me-1"></i>
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @elseif($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('register') }}" method="post" class="row g-3 needs-validation"
                                    novalidate>
                                    @csrf

                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your name!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label"> Email</label>
                                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Nik</label>
                                        <input type="number" name="nik" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your nik!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">No HP</label>
                                        <input type="number" name="phone" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your phone!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Usia</label>
                                        <input type="number" name="usia" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your usia!</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" id="yourName" required>
                                        <div class="invalid-feedback">Please, enter your name!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword"
                                            required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <label for="yourPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="yourPassword" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div> --}}

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{ route('login') }}">Log
                                                in</a>
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="credits">
                            <a href="{{ url('/') }}">
                                Copyright ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ $settings->nama_aplikasi }}.
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection
