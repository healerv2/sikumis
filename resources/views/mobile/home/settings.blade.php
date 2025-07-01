@extends('layouts.mobile')
@section('title', 'Pengaturan')

@section('content')
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Pengaturan</h2>
        </div>

        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        {{-- <div class="card card-style">
            <div class="content mb-0">
                <h3 class="font-600">Basic Info</h3>
                <p>
                    Basic details about you. Set them here. These can be connected to your database and shown on the user
                    profile.
                </p>

                <div class="input-style has-borders hnoas-icon input-style-always-active validate-field mb-4">
                    <input type="name" class="form-control validate-name" id="form1" placeholder="John Doe">
                    <label for="form1" class="color-highlight font-400 font-13">Name</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>

                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                    <input type="email" class="form-control validate-email" id="form2" placeholder="name@domain.com">
                    <label for="form2" class="color-highlight font-400 font-13">Email</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>

                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                    <input type="tel" class="form-control validate-tel" id="form3" placeholder="+1 234 567 8990">
                    <label for="form3" class="color-highlight font-400 font-13">Phone Number</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>

                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                    <input type="text" class="form-control validate-text" id="form44"
                        placeholder="Melbourne, Victoria">
                    <label for="form44" class="color-highlight font-400 font-13">Location</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>

                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                    <input type="passord" class="form-control validate-passord" id="form4" placeholder="******">
                    <label for="form4" class="color-highlight font-400 font-13">Password</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>


            </div>
        </div> --}}

        <div class="card card-style">
            <div class="content mb-0">
                <h3 class="font-600">Informasi Pribadi</h3>
                <p>Lengkapi data profil Anda berikut.</p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ implode(', ', $errors->all()) }}
                    </div>
                @endif

                <form method="POST" action="{{ route('mobile.settings.updateProfile') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $user->nik) }}"
                            required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Usia</label>
                        <input type="number" name="usia" class="form-control" value="{{ old('usia', $user->usia) }}"
                            required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Nomor HP</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"
                            required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    {{-- <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Foto</label>
                        <input type="file" name="foto" class="form-control">
                        @if ($user->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $user->foto) }}" width="100" class="rounded"
                                    alt="Foto Profil">
                            </div>
                        @endif
                    </div> --}}

                    <div class="mb-3">
                        <button
                            class="btn btn-full btn-margins bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900"
                            type="submit">
                            Simpan Informasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-style">
            <div class="content mb-0">
                <h3 class="font-600">Ganti Password</h3>
                <p>Form untuk ganti password.</p>
                <form method="POST" action="{{ route('mobile.settings.changePassword') }}">
                    @csrf @method('PUT')

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-3">
                        <label class="color-highlight">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <button
                            class="btn btn-full btn-margins bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900"
                            type="submit">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Pengaturan Notifikasi --}}
        <div class="card card-style">
            <div class="content mb-3 pb-2">
                <h3 class="font-600">Account Settings</h3>
                <p>Atur preferensi pengingat konsumsi suplemen.</p>

                {{-- Toggle Notifikasi --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa fa-bell bg-green-dark color-white p-3 rounded-circle font-16"></i>
                        </div>
                        <div>
                            <h5 class="mb-n1 font-15">Notifikasi Vitamin</h5>
                            <p class="font-11 mt-1 mb-0 color-theme opacity-50">Aktifkan atau nonaktifkan pengingat</p>
                        </div>
                        <div class="form-check form-switch ios-switch switch-s">
                            <input class="ios-input" type="checkbox" id="toggleNotif"
                                {{ $user->notifikasi ? 'checked' : '' }}>
                            <label class="custom-control-label" for="toggleNotif"></label>
                        </div>
                    </div>
                    {{-- <div class="form-check form-switch ios-switch switch-s">
                        <input class="ios-input" type="checkbox" id="toggleNotif" {{ $user->notifikasi ? 'checked' : '' }}>
                        <label class="custom-control-label" for="toggleNotif"></label>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="card card-style">
            <div class="content mb-3 pb-2">
                <h3 class="font-600">Account System</h3>
                <p></p>
                <form method="POST" action="{{ route('mobile.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-full bg-red-dark text-uppercase font-700 rounded-sm mt-3">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>




        {{-- <a href="#"
            class="btn btn-full btn-margins bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900">Save
            Information</a> --}}

        {{-- Modal Pengaturan Waktu & Interval --}}
        <div id="menu-vitamin-settings" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="300"
            data-menu-effect="menu-over">
            <div class="content mt-3">
                <h4 class="mb-2">Pengaturan Vitamin</h4>
                <form method="POST" action="{{ route('mobile.settings.update') }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="ajax" value="vitamin">

                    <div class="form-group mb-3">
                        <label>Jam Pengingat</label>
                        <input type="time" name="jam" class="form-control" value="{{ $user->jam ?? '08:00' }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Interval per Hari</label>
                        <select name="interval" class="form-select">
                            <option value="1" {{ $user->interval == 1 ? 'selected' : '' }}>1x</option>
                            <option value="2" {{ $user->interval == 2 ? 'selected' : '' }}>2x</option>
                            <option value="3" {{ $user->interval == 3 ? 'selected' : '' }}>3x</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="btn btn-full bg-blue-dark text-uppercase font-700 rounded-sm">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('toggleNotif')?.addEventListener('change', function() {
            const isChecked = this.checked ? 1 : 0;

            fetch("{{ route('mobile.settings.update') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        ajax: 'toggle_notifikasi',
                        notifikasi: isChecked,
                        _method: "PUT"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('✅ Sukses update notifikasi:', data);
                })
                .catch(err => {
                    console.error('❌ Gagal update notifikasi', err);
                    alert('Gagal menyimpan pengaturan notifikasi.');
                });
        });
    </script>
@endpush
