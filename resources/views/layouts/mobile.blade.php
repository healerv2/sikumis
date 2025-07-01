<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Suplemen App')</title>
    <!-- Meta untuk iOS & Android -->
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('mobile/manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('mobile/app/icons/icon-192x192.png') }}">


    <link rel="stylesheet" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}">
    {{-- <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/app/icons/icon-192x192.png') }}"> --}}

</head>

<body class="theme-light" data-highlight="blue2">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        {{-- Header --}}
        <div class="header header-fixed header-auto-show header-logo-app">
            <a href="#" class="header-title">SuplemenApp</a>
            <a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
        </div>

        {{-- Page content --}}
        @yield('content')

        {{-- Toast Notifikasi --}}
        <div id="notification-realtime"
            class="toast toast-top toast-ios position-fixed start-50 translate-middle-x mt-3" role="alert"
            aria-live="assertive" aria-atomic="true" style="display: none; max-width: 300px; z-index: 9999;">
            <div class="toast-header bg-highlight text-white">
                <i class="fa fa-bell me-2"></i>
                <strong class="me-auto">Notifikasi</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="notif-message">
                ...
            </div>
        </div>

        {{-- Audio Notifikasi --}}
        <audio id="notif-sound" preload="auto">
            <source src="{{ asset('mobile/sounds/notif.mp3') }}" type="audio/mpeg">
        </audio>

        <div id="notif-permission-popup" class="card card-style mx-3" style="display:none;">
            <div class="content">
                <h4>Izinkan Notifikasi</h4>
                <p>Agar kamu tidak melewatkan pengingat minum suplemen.</p>
                <button onclick="requestNotifPermission()" class="btn btn-success w-100 mb-2">Izinkan</button>
                <button onclick="hideNotifPopup()" class="btn btn-secondary w-100">Nanti Saja</button>
            </div>
        </div>




        {{-- Footer --}}
        <div id="footer-bar" class="footer-bar-5">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="{{ route('mobile.jadwal.index') }}"><i class="fas fa-heart"></i><span>Jadwal</span></a>
            <a href="{{ route('catatan.index') }}"><i class="fas fa-heart"></i><span>Catatan</span></a>
            <a href="{{ route('mobile.settings.edit') }}"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('mobile/scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('mobile/scripts/custom.js') }}"></script>
    <script src="{{ asset('mobile/_service-worker.js') }}"></script>

    {{-- Pusher & Laravel Echo --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>

    <script>
        Pusher.logToConsole = true;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true,
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        Echo.private('user.{{ auth()->id() }}')
            .listen('.vitamin.reminder', (e) => {
                //console.log("📢 Notifikasi diterima:", e.message);

                document.getElementById('notif-message').innerText = e.message;

                const notifEl = document.getElementById('notification-realtime');
                notifEl.style.display = 'block';
                const toast = new bootstrap.Toast(notifEl);
                toast.show();

                const audio = document.getElementById('notif-sound');
                if (audio) {
                    audio.play().catch(err => {
                        // console.warn('🔇 Audio gagal diputar:', err);
                    });
                }
            });

        Echo.private('user.{{ auth()->id() }}')
            .listen('.notification.updated', (e) => {
                console.log("📢 Notifikasi masuk:", e.title, e.body);

                document.getElementById('notif-message').innerText = e.body;

                const notifEl = document.getElementById('notification-realtime');
                notifEl.style.display = 'block';
                new bootstrap.Toast(notifEl).show();

                document.getElementById('notif-sound')?.play();
            });


        // 🛡️ Aktifkan audio saat user interaksi pertama
        document.addEventListener('click', function enableAudio() {
            const audio = document.getElementById('notif-sound');
            if (audio) {
                audio.muted = false;
                const play = audio.play();
                if (play !== undefined) {
                    play.catch(() => {});
                }
            }
            document.removeEventListener('click', enableAudio);
        });
    </script>


    {{-- @if (auth()->check())
        <script>
            window.addEventListener('load', () => {
                if (Notification.permission !== 'granted') {
                    setTimeout(() => {
                        document.getElementById('notif-permission-popup').style.display = 'block';
                    }, 2000);
                }
            });

            function hideNotifPopup() {
                document.getElementById('notif-permission-popup').style.display = 'none';
            }

            function requestNotifPermission() {
                Notification.requestPermission().then(async (permission) => {
                    if (permission === 'granted') {
                        hideNotifPopup();
                        await subscribeToWebPush(); // ⬅️ SUBSCRIBE langsung setelah izin diberikan
                    } else {
                        hideNotifPopup();
                        console.warn('❌ Izin notifikasi ditolak oleh pengguna.');
                    }
                });
            }

            async function subscribeToWebPush() {
                if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                    return console.warn('❌ Push API tidak didukung di browser ini.');
                }

                try {
                    const reg = await navigator.serviceWorker.register('/service-worker.js');
                    console.log('✅ Service Worker aktif:', reg);

                    const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
                    const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

                    const existing = await reg.pushManager.getSubscription();
                    if (existing) {
                        await existing.unsubscribe();
                    }

                    const newSub = await reg.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: convertedVapidKey
                    });

                    await fetch('{{ url('/webpush/subscribe') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(newSub)
                    });

                    console.log('✅ Berhasil subscribe ke WebPush!');
                } catch (err) {
                    console.error('❌ Gagal subscribe:', err);
                }
            }

            function urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
                const rawData = atob(base64);
                return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
            }
        </script>
    @endif --}}

    @if (auth()->check())
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(async (registration) => {
                        console.log('✅ Service Worker registered:', registration);

                        const permission = Notification.permission;
                        if (permission !== 'granted') {
                            const result = await Notification.requestPermission();
                            if (result !== 'granted') return;
                        }

                        const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
                        const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

                        const existingSub = await registration.pushManager.getSubscription();
                        if (existingSub) await existingSub.unsubscribe(); // agar tidak bentrok

                        const newSubscription = await registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: convertedVapidKey
                        });

                        await fetch('{{ url('/webpush/subscribe') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(newSubscription),
                        });

                        console.log('✅ Push subscribed:', newSubscription);
                    })
                    .catch(error => {
                        console.error('❌ Service Worker registration failed:', error);
                    });
            }

            function urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding)
                    .replace(/-/g, '+')
                    .replace(/_/g, '/');

                const rawData = window.atob(base64);
                return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
            }
        </script>
    @endif


    @stack('scripts')
</body>

</html>
