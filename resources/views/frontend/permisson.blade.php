<button id="notify-btn">Enable Notifications</button>

<script>
    // Register the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
            .then(function (registration) {
                console.log('Service Worker registered with scope:', registration.scope);

                // Event listener for the "Enable Notifications" button
                document.getElementById('notify-btn').addEventListener('click', function () {
                    if ('Notification' in window) {
                        Notification.requestPermission().then(function (permission) {
                            if (permission === 'granted') {
                                console.log('Notification permission granted.');
                                subscribeUserToPush(); // Call function to create push subscription
                            } else if (permission === 'denied') {
                                console.log('Notification permission denied.');
                            }
                        });
                    }
                });

                // Function to subscribe user to push notifications
                function subscribeUserToPush() {
                    navigator.serviceWorker.ready.then(function (registration) {
                        const vapidPublicKey = 'BK24CtQ_7GTgXrhpbCz9VR-ligTi5zyIUga7IkUbve0tOg2J0XiczWDtuXpyme3dheQQQ67J6JVkrKrx7r7jCa8'; // Replace with your VAPID public key
                        const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

                        registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: convertedVapidKey
                        }).then(function (subscription) {
                            JSON.stringify(subscription)
                            console.log('User subscribed:', subscription);

                            // Send the subscription to your server
                            // Uncomment and configure this block as needed to save the subscription
                            fetch('/save-subscription', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
                                },
                                body: JSON.stringify(subscription)
                            }).then(response => response.json())
                              .then(data => console.log('Subscription saved:', data))
                              .catch(error => console.log('Failed to save subscription:', error));
                        }).catch(function (error) {
                            console.error('Failed to subscribe the user:', error);
                        });
                    });
                }

                // Helper function to convert the VAPID key to a Uint8Array
                function urlBase64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
                    const rawData = window.atob(base64);
                    return Uint8Array.from([...rawData].map((char) => char.charCodeAt(0)));
                }
            })
            .catch(function (error) {
                console.log('Service Worker registration failed:', error);
            });
    } else {
        console.log("Service workers are not supported in this browser.");
    }
</script>
