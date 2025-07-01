@extends('layouts.mobile-auth')

@section('title', 'Login')

@section('content')
    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button></a>Sign In</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style bg-24" data-card-height="cover-card">
            <div class="card-center">
                <div class="ms-5 me-5">
                    <h2 class="text-center color-white font-800 fa-4x">LOGIN</h2>
                    <p class="color-highlight font-12 text-center ">Let's get you into your account</p>
                    <div class="mt-2 mb-0">
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-user"></i>
                                <input type="email" class="form-control validate-name" name="email" id="form1a"
                                    placeholder="Email">
                                <label for="form1a" class="color-blue-dark font-10 mt-1">Email</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>

                            <div class="input-style input-transparent no-borders has-icon validate-field mt-4">
                                <i class="fa fa-lock"></i>
                                <input type="password" class="form-control validate-password" name="password" id="form3a"
                                    placeholder="Password">
                                <label for="form3a" class="color-blue-dark font-10 mt-1">Password</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>

                            <div class="row">
                                <div class="col-6 pt-3"><a href="system-forgot-2.html"
                                        class="color-white opacity-50 font-10">Recover Account</a></div>
                                <div class="col-6 pt-3 text-end"><a href="{{ route('mobile.register') }}"
                                        class="color-white opacity-50 font-10">Create Account</a></div>
                            </div>

                            <button type="submit"
                                class="btn btn-m mt-8 mb-4 btn-full bg-green-dark rounded-sm text-uppercase font-900">Login</button>
                            <div class="divider bg-white opacity-10"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-overlay bg-black opacity-85"></div>
        </div>
    </div>
    <!-- end of page content-->
@endsection
