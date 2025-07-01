@extends('layouts.mobile')

@section('title', $post->judul)

@section('content')
    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="{{ url()->previous() }}" data-back-button><i class="fa fa-arrow-left"></i></a>Content </h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style rounded-l bg-14 mb-n5" data-card-height="350">
            <div class="card-bottom p-3 pb-5 mb-3">

                <h1 class="color-white font-600 font-18 pt-3">
                    {{ $post->judul }}
                </h1>
            </div>
            <div class="card-overlay bg-gradient"></div>
        </div>

        <div class="card card-style mt-n5">
            <div class="card mb-0">
                <div class="content">
                    <h1 class="font-600 font-18 line-height-m">{{ $post->judul }}</h1>
                    <span class="d-block mb-3">{{ $post->created_at->format('d M Y') }}</span>
                    <p>{!! $post->deskripsi !!}</p>

                    {{-- Tampilkan lampiran jika ada --}}
                    @if ($post->lampiran)
                        <div class="mt-3">
                            @php
                                $ext = pathinfo($post->lampiran, PATHINFO_EXTENSION);
                                $url = asset('storage/' . $post->lampiran);
                            @endphp

                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $url }}" alt="Lampiran Gambar" class="img-fluid rounded"
                                    style="max-height: 300px;">
                            @elseif ($ext === 'pdf')
                                <embed src="{{ $url }}" type="application/pdf" width="100%" height="500px" />
                                <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary mt-2">Buka
                                    PDF</a>
                            @elseif ($ext === 'mp4')
                                <video controls width="100%" class="mt-2 rounded">
                                    <source src="{{ $url }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            @else
                                <a href="{{ $url }}" class="btn btn-sm btn-secondary">Download Lampiran</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
