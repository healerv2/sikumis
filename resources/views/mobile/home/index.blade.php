{{-- @extends('layouts.mobile')

@section('title', 'Beranda')

@section('content')
    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button></a>Halo, {{ Auth::user()->name }} 👋</h2>
            <a href="#" data-menu="menu-main" class="bg-fade-highlight-light shadow-xl preload-img"
                data-src="images/avatars/5s.png"></a>
        </div>
        <div class="card header-card shape-rounded" data-card-height="350">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style bg-transparent mx-0 mb-n2 mt-n3 shadow-0">
            <div class="content mt-2">
                <div class="search-results disabled-search-list mt-3">
                    <div class="card card-style mx-0 px-2 p-0 mb-0">
                        <a href="#" class="d-flex py-2" data-filter-item
                            data-filter-name="all hamburger cheeseburger cheese burger">
                            <div class="align-self-center">
                                <img src="images/food/1s.jpg" class="rounded-sm me-3" width="35" alt="img">
                            </div>
                            <div class="align-self-center">
                                <strong class="color-theme font-16 d-block mb-0">Burgers</strong>
                            </div>
                            <div class="ms-auto text-center align-self-center pe-2">
                                <h5 class="line-height-xs font-16 font-600 mb-0">$29.<sup class="font-11 pt-1">05</sup></h5>
                            </div>
                        </a>
                        <a href="#" class="d-flex py-2" data-filter-item data-filter-name="all pizza">
                            <div class="align-self-center">
                                <img src="images/food/2s.jpg" class="rounded-sm me-3" width="35" alt="img">
                            </div>
                            <div class="align-self-center">
                                <strong class="color-theme font-16 d-block mb-0">Pizza</strong>
                            </div>
                            <div class="ms-auto text-center align-self-center pe-2">
                                <h5 class="line-height-xs font-16 font-600 mb-0">$19.<sup class="font-11 pt-1">99</sup></h5>
                            </div>
                        </a>
                        <a href="#" class="d-flex py-2" data-filter-item
                            data-filter-name="all steak pork chicken beef meat">
                            <div class="align-self-center">
                                <img src="images/food/4s.jpg" class="rounded-sm me-3" width="35" alt="img">
                            </div>
                            <div class="align-self-center">
                                <strong class="color-theme font-16 d-block mb-0">Steaks</strong>
                            </div>
                            <div class="ms-auto text-center align-self-center pe-2">
                                <h5 class="line-height-xs font-16 font-600 mb-0">$39.<sup class="font-11 pt-1">99</sup></h5>
                            </div>
                        </a>
                        <a href="#" class="d-flex py-2" data-filter-item data-filter-name="all fruit salad">
                            <div class="align-self-center">
                                <img src="images/food/9s.jpg" class="rounded-sm me-3" width="35" alt="img">
                            </div>
                            <div class="align-self-center">
                                <strong class="color-theme font-16 d-block mb-0">Salads</strong>
                            </div>
                            <div class="ms-auto text-center align-self-center pe-2">
                                <h5 class="line-height-xs font-16 font-600 mb-0">$19.<sup class="font-11 pt-1">99</sup></h5>
                            </div>
                        </a>
                        <a href="#" class="d-flex py-2" data-filter-item
                            data-filter-name="all fruit berry strawberry">
                            <div class="align-self-center">
                                <img src="images/food/7s.jpg" class="rounded-sm me-3" width="35" alt="img">
                            </div>
                            <div class="align-self-center">
                                <strong class="color-theme font-16 d-block mb-0">Fruit Cups</strong>
                            </div>
                            <div class="ms-auto text-center align-self-center pe-2">
                                <h5 class="line-height-xs font-16 font-600 mb-0">$25.<sup class="font-11 pt-1">99</sup></h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="search-no-results disabled mt-4">
                <div class="card card-style">
                    <div class="content">
                        <h1>No Results</h1>
                        <p>
                            Your search brought up no results. Try using a different keyword. Or try typing all
                            to see all items in the demo. These can be linked to anything you want.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-style mx-0 shadow-0 mb-0 bg-transparent">
            <div class="splide double-slider slider-no-dots visible-slider" id="double-slider-1a">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <a href="#" class="mx-3">
                                <div class="card card-style me-0 mb-0" style="background-image:url(images/food/1.jpg);"
                                    data-card-height="250">
                                    <div class="card-bottom p-2 px-3">
                                        <h4 class="color-white">Burgers</h4>
                                    </div>
                                    <div class="card-overlay bg-gradient opacity-80"></div>
                                </div>
                            </a>
                        </div>
                        <div class="splide__slide">
                            <a href="#" class="mx-3">
                                <div class="card card-style me-0 mb-0" style="background-image:url(images/food/2.jpg);"
                                    data-card-height="250">
                                    <div class="card-bottom p-2 px-3">
                                        <h4 class="color-white">Pizza</h4>
                                    </div>
                                    <div class="card-overlay bg-gradient opacity-80"></div>
                                </div>
                            </a>
                        </div>
                        <div class="splide__slide">
                            <a href="#" class="mx-3">
                                <div class="card card-style me-0 mb-0" style="background-image:url(images/food/4.jpg);"
                                    data-card-height="250">
                                    <div class="card-bottom p-2 px-3">
                                        <h4 class="color-white">Steaks</h4>
                                    </div>
                                    <div class="card-overlay bg-gradient opacity-80"></div>
                                </div>
                            </a>
                        </div>
                        <div class="splide__slide">
                            <a href="#" class="mx-3">
                                <div class="card card-style me-0 mb-0" style="background-image:url(images/food/9.jpg);"
                                    data-card-height="250">
                                    <div class="card-bottom p-2 px-3">
                                        <h4 class="color-white">Salads</h4>
                                    </div>
                                    <div class="card-overlay bg-gradient opacity-80"></div>
                                </div>
                            </a>
                        </div>
                        <div class="splide__slide">
                            <a href="#" class="mx-3">
                                <div class="card card-style me-0 mb-0" style="background-image:url(images/food/7.jpg);"
                                    data-card-height="250">
                                    <div class="card-bottom p-2 px-3">
                                        <h4 class="color-white">Fruits</h4>
                                    </div>
                                    <div class="card-overlay bg-gradient opacity-80"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card preload-img mt-2" data-src="images/pictures/20s.jpg">
            <div class="card-body">
                <h4 class="color-white pt-3 font-24">Today's Picks</h4>
                <p class="color-white pt-1">
                    Carefully picked by our chef to make your taste buds loose their minds
                </p>
                <div class="card card-style bg-transparent m-0 shadow-0">
                    <div class="row mb-0">
                        <div class="col-6 pe-2">
                            <a href="#" class="card card-style mx-0 mb-3" data-menu="menu-product">
                                <img src="images/food/1.jpg" alt="img" class="img-fluid">
                                <div class="p-2">
                                    <h4 class="mb-0 font-600">Burgers</h4>
                                    <p class="mb-0 font-11 mt-n1">Freshly Cooked</p>
                                </div>
                                <div class="divider mb-0"></div>
                                <h5 class="py-3 pb-2 px-2 font-13 font-600">
                                    $14.50
                                    <span class="bg-blue-dark font-11 px-2 font-600 rounded-xs shadow-xxl float-end">10%
                                        OFF</span>
                                </h5>
                            </a>
                        </div>
                        <div class="col-6 ps-2">
                            <a href="#" class="card card-style mx-0 mb-3" data-menu="menu-product">
                                <img src="images/food/2.jpg" alt="img" class="img-fluid">
                                <div class="p-2">
                                    <h4 class="mb-0 font-600">Pizzas</h4>
                                    <p class="mb-0 font-11 mt-n1">Italian Original Recipe</p>
                                </div>
                                <div class="divider mb-0"></div>
                                <h5 class="py-3 pb-2 px-2 font-13 font-600">
                                    $19.35
                                    <span class="bg-blue-dark font-11 px-2 font-600 rounded-xs shadow-xxl float-end">25%
                                        OFF</span>
                                </h5>
                            </a>
                        </div>
                        <div class="col-6 pe-2">
                            <a href="#" class="card card-style mx-0 mb-3" data-menu="menu-product">
                                <img src="images/food/4.jpg" alt="img" class="img-fluid">
                                <div class="p-2">
                                    <h4 class="mb-0 font-600">Grilled Steak</h4>
                                    <p class="mb-0 font-11 mt-n1">Local meat, freshly served.</p>
                                </div>
                                <div class="divider mb-0"></div>
                                <h5 class="py-3 pb-2 px-2 font-13 font-600">
                                    $29.15
                                    <span class="bg-blue-dark font-11 px-2 font-600 rounded-xs shadow-xxl float-end">5%
                                        OFF</span>
                                </h5>
                            </a>
                        </div>
                        <div class="col-6 ps-2">
                            <a href="#" class="card card-style mx-0 mb-3" data-menu="menu-product">
                                <img src="images/food/7.jpg" alt="img" class="img-fluid">
                                <div class="p-2">
                                    <h4 class="mb-0 font-600">Strawberry Cup</h4>
                                    <p class="mb-0 font-11 mt-n1">Fresh and Sweet</p>
                                </div>
                                <div class="divider mb-0"></div>
                                <h5 class="py-3 pb-2 px-2 font-13 font-600">
                                    $8.35
                                    <span class="bg-blue-dark font-11 px-2 font-600 rounded-xs shadow-xxl float-end">3%
                                        OFF</span>
                                </h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-overlay bg-highlight opacity-90"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <div class="d-flex px-3 mb-2">
            <h4 class="mb-2 font-600">Recommended for You</h4>
        </div>
        <div class="splide single-slider slider-no-dots slider-no-arrows visible-slider" id="single-slider-3">
            <div class="splide__track">
                <div class="splide__list">
                    <div class="splide__slide">
                        <div class="card card-style">
                            <img src="images/food/2w.jpg" alt="img" class="img-fluid">
                            <div class="content mt-3">
                                <h2 class="font-17">Pizza <span class="float-end">$17.50</span></h2>
                                <p class="mb-3">
                                    Baked with an original Italian recipe in a wood based oven for the best flavor.
                                </p>
                                <a href="#"
                                    class="btn btn-s rounded-s text-uppercase bg-blue-dark font-700 btn-full">Add to
                                    Bag</a>
                            </div>
                        </div>
                    </div>
                    <div class="splide__slide">
                        <div class="card card-style">
                            <img src="images/food/1w.jpg" alt="img" class="img-fluid">
                            <div class="content mt-3">
                                <h2 class="font-17">American Burger <span class="float-end">$19.30</span></h2>
                                <p class="mb-3">
                                    Nothing compares to the American recipe for a burger. Juicy and tender.
                                </p>
                                <a href="#"
                                    class="btn btn-s rounded-s text-uppercase bg-blue-dark font-700 btn-full">Add to
                                    Bag</a>
                            </div>
                        </div>
                    </div>
                    <div class="splide__slide">
                        <div class="card card-style">
                            <img src="images/food/4w.jpg" alt="img" class="img-fluid">
                            <div class="content mt-3">
                                <h2 class="font-17">Grilled Steak <span class="float-end">$3.45</span></h2>
                                <p class="mb-3">
                                    The fresh taste of a grilled steak with the flavor of a homemade bbq
                                </p>
                                <a href="#"
                                    class="btn btn-s rounded-s text-uppercase bg-blue-dark font-700 btn-full">Add to
                                    Bag</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.mobile')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="page-title page-title-small">
            <h2>Hai, {{ Auth::user()->name }} 👋</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="210">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>
        <div class="card header-card shape-rounded" data-card-height="200">
            <div class="card-overlay bg-highlight opacity-90"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-center text-center">
                <button class="btn btn-sm bg-white text-dark mt-3" data-bs-toggle="modal"
                    data-bs-target="#modal-setting-user">
                    <i class="fa fa-bell me-2"></i> Atur Notifikasi
                </button>
            </div>
        </div>

        <!-- Modal Pengaturan Notifikasi User -->
        <div class="modal fade" id="modal-setting-user" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <form class="modal-content" id="form-setting-user">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="modal-header">
                        <h5 class="modal-title">Pengaturan Notifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Terima Notifikasi Suplemen?</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ auth()->user()->notificationSetting?->status ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ auth()->user()->notificationSetting?->status === 0 ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary w-100">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>



        {{-- Status Hari Ini --}}
        <div class="card card-style">
            <div class="content">
                <h4 class="mb-2">Status Hari Ini</h4>
                @if ($catatanHariIni)
                    <span class="badge bg-success">✅ Sudah Minum</span>
                @else
                    <span class="badge bg-danger">❌ Belum Minum</span>
                @endif
            </div>
        </div>

        {{-- Jadwal Hari Ini --}}
        <div class="card card-style">
            <div class="content">
                <h4 class="mb-3">Jadwal Suplemen Hari Ini</h4>
                @if (count($jadwalHariIni))
                    <ul class="list-group">
                        @foreach ($jadwalHariIni as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item['nama'] }}</span>
                                <span>{{ $item['jam'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Tidak ada jadwal hari ini.</p>
                @endif
            </div>
        </div>


        {{-- Chart Progres --}}
        {{-- <div class="card card-style">
            <div class="content">
                <h4 class="mb-3">Progress Konsumsi</h4>
                <canvas id="progressChart" height="150"></canvas>
            </div>
        </div> --}}

        {{-- Post Terbaru --}}
        <div class="card card-style">
            <div class="content">
                <h4 class="mb-3">Berita & Tips Terbaru</h4>
                @forelse($posts as $post)
                    <div class="mb-3">
                        <h5 class="mb-1">{{ $post->judul }}</h5>
                        <p class="text-muted mb-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->deskripsi), 80) }}
                        </p>
                        <a href="{{ route('mobile.posts.show', $post->id) }}" class="font-12">Baca Selengkapnya</a>
                    </div>
                @empty
                    <p class="text-muted">Belum ada postingan terbaru.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('progressChart').getContext('2d');
            const progressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($grafik['labels']) !!},
                    datasets: [{
                        label: 'Kepatuhan Minum Suplemen (%)',
                        data: {!! json_encode($grafik['data']) !!},
                        backgroundColor: '#4caf50',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        });
    </script> --}}
    {{-- <script>
        $('#form-setting-user').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('setting-notifikasi.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    $('#modal-setting-user').modal('hide');
                    Swal.fire('Berhasil', res.message, 'success');
                },
                error: function(err) {
                    Swal.fire('Gagal', err.responseJSON?.message || 'Terjadi kesalahan', 'error');
                }
            });
        });
    </script> --}}
@endpush
