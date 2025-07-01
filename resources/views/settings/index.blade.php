@extends('layouts.master')

@section('title')
    Settings
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Settings </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="custom-validation" action="{{ route('settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Aplikasi</label>
                            <input type="text" name="nama_aplikasi" id="nama_aplikasi" class="form-control"
                                value="{{ $settings->nama_aplikasi }}" required placeholder="Nama Aplikasi" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="path_logo" id="path_logo" class="form-control" placeholder="Logo" />
                            <br>
                            <img src="{{ asset('logo/' . $settings->path_logo) }}" class="img-responsive"
                                style="max-width: 150px; max-height:300px">
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
                    <!-- end form -->
                </div>
                <!-- end cardbody -->
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
