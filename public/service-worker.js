const CACHE_NAME = 'sikumis-cache-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/offline.html',
    '/logo.png',
    '/manifest.json',
    '/assets/auth/css/style.css',
    '/assets/auth/vendor/bootstrap/css/bootstrap.min.css',
    '/assets/auth/js/main.js',
];

// INSTALL: cache static assets
self.addEventListener('install', (event) => {
    console.log('[SW] Install event');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return Promise.all(
                    ASSETS_TO_CACHE.map((url) =>
                        fetch(url).then((response) => {
                            if (!response.ok) throw new Error(`Request for ${url} failed`);
                            return cache.put(url, response);
                        }).catch(err => {
                            console.warn(`[SW] Failed to cache ${url}:`, err.message);
                        })
                    )
                );
            })
            .then(() => self.skipWaiting())
    );
});

// ACTIVATE: remove old cache
self.addEventListener('activate', (event) => {
    console.log('[SW] Activate event');
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.map((key) => {
                if (key !== CACHE_NAME) {
                    console.log('[SW] Deleting old cache:', key);
                    return caches.delete(key);
                }
            }))
        ).then(() => self.clients.claim())
    );
});

// FETCH: serve from cache or fallback to offline
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .catch(() =>
                caches.match(event.request).then((res) => res || caches.match('/offline.html'))
            )
    );
});

// PUSH: show notification
// self.addEventListener('push', function (event) {
//     const data = event.data?.json() ?? {};
//     const title = data.title || 'Notifikasi';
//     const options = {
//         body: data.body || 'Ada notifikasi baru.',
//         icon: data.icon || '/logo.png',
//         badge: data.badge || '/logo.png',
//         data: { url: data.url || '/' }
//     };

//     event.waitUntil(
//         self.registration.showNotification(title, options)
//     );
// });

self.addEventListener('push', function (event) {
    let data = {};
    try {
        data = event.data ? event.data.json() : {};
    } catch (e) {
        // Fallback jika data bukan JSON
        data = {
            title: 'Notifikasi',
            body: event.data?.text() || 'Ada notifikasi baru.',
            url: '/'
        };
    }

    const title = data.title || 'Notifikasi';
    const options = {
        body: data.body || 'Ada notifikasi baru.',
        icon: data.icon || '/logo.png',
        badge: data.badge || '/logo.png',
        data: { url: data.url || '/' }
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});


// NOTIFICATION CLICK: navigate to url
self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (let client of clientList) {
                if (client.url === event.notification.data.url && 'focus' in client) {
                    return client.focus();
                }
            }
            return clients.openWindow(event.notification.data.url);
        })
    );
});
