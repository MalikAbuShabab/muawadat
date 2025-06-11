// Listening for the push event
self.addEventListener('push', function (event) {
    // Parse the notification payload if it exists; otherwise, set default values
    const data = event.data ? event.data.json() : { title: 'Default title', body: 'Default message' };

    const options = {
        body: data.body,
        icon: '/images/icon.png',  // Path to your notification icon
        badge: '/images/badge.png' // Path to your notification badge icon
    };

    // Show the notification with the parsed data
    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// Handle notification click
self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow('/') // Open your app or a specific page
    );
});