const CACHE_NAME = 'absensi-v2';

const urlsToCache = [
    '/',
    '/dashboard',
    '/assets/css/style.css',
    '/assets/img/favicon.png',
    '/assets/img/icon/192x192.png'
];

/* INSTALL */
self.addEventListener('install', event => {

    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
    );
});

/* ACTIVATE */
self.addEventListener('activate', event => {

    event.waitUntil(

        caches.keys().then(keys => {

            return Promise.all(

                keys.map(key => {

                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }

                })

            );

        })

    );

    self.clients.claim();
});

/* FETCH */
self.addEventListener('fetch', event => {

    if (event.request.method !== 'GET') return;

    event.respondWith(

        caches.match(event.request)

            .then(response => {

                /* CACHE FIRST */
                if (response) {
                    return response;
                }

                return fetch(event.request)

                    .then(networkResponse => {

                        /* JANGAN CACHE FILE BESAR */
                        if (
                            !networkResponse ||
                            networkResponse.status !== 200 ||
                            networkResponse.type !== 'basic'
                        ) {
                            return networkResponse;
                        }

                        /* HANYA CACHE CSS JS IMAGE */
                        const url = event.request.url;

                        if (
                            url.includes('.css') ||
                            url.includes('.js') ||
                            url.includes('.png') ||
                            url.includes('.jpg') ||
                            url.includes('.jpeg') ||
                            url.includes('.webp')
                        ) {

                            const responseClone =
                                networkResponse.clone();

                            caches.open(CACHE_NAME)

                                .then(cache => {
                                    cache.put(
                                        event.request,
                                        responseClone
                                    );
                                });

                        }

                        return networkResponse;

                    })

                    .catch(() => {

                        /* OFFLINE */
                        return caches.match('/dashboard');

                    });

            })

    );

});