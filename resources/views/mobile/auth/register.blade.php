@extends('layouts.mobile-auth')

@section('title', 'Registrasi')

@section('content')
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Daftar</h2>
        </div>

        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style bg-24" data-card-height="cover-card">
            <div class="card-center">
                <div class="ms-4 me-4 mb-0 mt-1">
                    <h2 class="text-center color-white font-800 fa-3x">REGISTER</h2>
                    <p class="color-highlight font-12 text-center">Buat akun gratis Anda sekarang!</p>

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        {{-- Field list --}}
                        @php
                            $fields = [
                                ['name' => 'name', 'type' => 'text', 'icon' => 'user', 'label' => 'Nama Lengkap'],
                                ['name' => 'nik', 'type' => 'text', 'icon' => 'id-card', 'label' => 'NIK'],
                                ['name' => 'usia', 'type' => 'number', 'icon' => 'user-clock', 'label' => 'Usia'],
                                ['name' => 'alamat', 'type' => 'text', 'icon' => 'map-marker-alt', 'label' => 'Alamat'],
                                ['name' => 'phone', 'type' => 'tel', 'icon' => 'phone', 'label' => 'Nomor HP'],
                                ['name' => 'email', 'type' => 'email', 'icon' => 'at', 'label' => 'Email'],
                                ['name' => 'password', 'type' => 'password', 'icon' => 'lock', 'label' => 'Password'],
                                [
                                    'name' => 'password_confirmation',
                                    'type' => 'password',
                                    'icon' => 'lock',
                                    'label' => 'Konfirmasi Password',
                                ],
                            ];
                        @endphp

                        @foreach ($fields as $field)
                            <div class="input-style input-transparent no-borders has-icon mt-2">
                                <i class="fa fa-{{ $field['icon'] }}"></i>
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                    placeholder="{{ $field['label'] }}" required>
                                <label class="color-blue-dark font-10 mt-1">{{ $field['label'] }}</label>
                                <em>(required)</em>
                            </div>
                        @endforeach

                        <button type="submit"
                            class="btn btn-m btn-full rounded-sm shadow-l bg-green-dark text-uppercase font-900 mt-4">
                            Daftar Sekarang
                        </button>
                    </form>

                    <div class="divider mt-4"></div>
                    <p class="text-center mb-0">
                        <a href="{{ route('mobile.login') }}" class="color-highlight opacity-80 font-12">
                            Sudah punya akun? Login di sini
                        </a>
                    </p>
                </div>
            </div>
            <div class="card-overlay bg-black opacity-85"></div>
        </div>
    </div>
@endsection
