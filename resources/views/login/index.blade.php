@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('logo/' . $settings->path_logo) }}" height="100px" alt="">
                        <span class="d-none d-lg-block">{{ $settings->nama_aplikasi }}</span>
                    </a>
                </div>
                <!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                            <p class="text-center small">Enter your email & password to login</p>
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
                        <form action="{{ route('login') }}" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email" required>
                                    @error('email')
                                        {{-- <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> --}}
                                    @enderror
                                    {{-- <div class="invalid-feedback">Please enter your username.</div> --}}
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="yourPassword" required>
                                @error('password')
                                    {{-- <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> --}}
                                @enderror
                                {{-- <div class="invalid-feedback">Please enter your password!</div> --}}
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true"
                                        id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                            <div class="col-12">
                                <h5 class="card-title text-center pb-0 fs-6">
                                    <a href="{{ url('/') }}">
                                        Copyright ©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> {{ $settings->nama_aplikasi }}.
                                    </a>
                                </h5>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
