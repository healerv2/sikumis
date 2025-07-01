<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name') }} | Log in</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e88e5">
    <link rel="manifest" href="/manifest.json">

    <!-- Favicons -->
    <link href="{{ asset('logo/' . $settings->path_logo) }}" rel="icon" type="image/png">
    <link href="{{ asset('logo/' . $settings->path_logo) }}" rel="apple-touch-icon" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/auth/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/auth/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                @yield('content')
            </section>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('assets/auth/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/auth/js/main.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        let deferredPrompt;

        // Dengarkan event install prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('📦 Install prompt tersedia');

            // Tampilkan tombol manual jika perlu
            const installBtn = document.createElement('button');
            installBtn.innerText = 'Install App';
            installBtn.className = 'btn btn-success position-fixed bottom-0 end-0 m-3';
            installBtn.style.zIndex = 9999;
            document.body.appendChild(installBtn);

            installBtn.addEventListener('click', async () => {
                deferredPrompt.prompt();
                const choice = await deferredPrompt.userChoice;
                if (choice.outcome === 'accepted') {
                    console.log('✅ User accepted install');
                } else {
                    console.log('❌ User dismissed install');
                }
                deferredPrompt = null;
                installBtn.remove();
            });
        });

        // Register Service Worker
        // if ('serviceWorker' in navigator) {
        //     navigator.serviceWorker.register('/service-worker.js').then(async reg => {
        //         console.log('✅ Service Worker registered:', reg);

        //         const permission = await Notification.requestPermission();
        //         if (permission === 'granted') {
        //             subscribeToPush(reg);
        //         }
        //     }).catch(err => {
        //         console.error('❌ SW registration failed:', err);
        //     });
        // }


        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(reg => {
                    console.log('✅ Service Worker registered', reg);

                    if (Notification.permission === 'default') {
                        Notification.requestPermission().then(permission => {
                            if (permission === 'granted') {
                                subscribeToPush(reg);
                            }
                        });
                    } else if (Notification.permission === 'granted') {
                        subscribeToPush(reg);
                    }
                }).catch(err => {
                    console.error('❌ Service Worker error', err);
                });
        }


        async function subscribeToPush(registration) {
            const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
            const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

            const existingSub = await registration.pushManager.getSubscription();
            if (existingSub) {
                await existingSub.unsubscribe();
                console.log('🔁 Unsubscribed existing subscription');
            }

            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: convertedVapidKey
            });

            await fetch('{{ url('/webpush/subscribe') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(subscription),
            });

            console.log('✅ Subscribed to push notifications');
        }


        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    </script>


    @stack('scripts')
</body>

</html>
