<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js"></script>

    </head>
    <body class="antialiased">
    <h1>Generate FCM Token</h1>
    <button id="generateTokenBtn">Generate Token</button>
    <p id="fcmToken"></p>

    <script>
        // Your Firebase configuration object
        const firebaseConfig = {
            apiKey: "AIzaSyC0LD0uty3jsHJIK09ZaK_59Em7TgRGnIo",
            authDomain: "amjad-a610c.firebaseapp.com",
            projectId: "amjad-a610c",
            storageBucket: "amjad-a610c.firebasestorage.app",
            messagingSenderId: "811880597056",
            appId: "1:811880597056:web:1ca14adcb4fc2fa68a01a5",
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        // Request permission and generate token
        const vapidKey = 'BJ1EPgQ5PenQ1RTZHtSlYxlUkfYBm5vJ51VRuFBh_3mZixQ75KkycaiCPIx2SRaiEWlhdRRuuTb3_F2KexMA2VM'; // Replace with your valid VAPID key from Firebase

        document.getElementById('generateTokenBtn').addEventListener('click', async () => {
            try {
                // Request notification permission
                const permission = await Notification.requestPermission();

                if (permission === 'granted') {
                    // Get the FCM token using the correct VAPID key
                    const token = await messaging.getToken({ vapidKey });

                    if (token) {
                        // Display the token and send it to your server
                        document.getElementById('fcmToken').innerText = token;
                        console.log('FCM Token:', token);

                        // Send the token to the Laravel backend (if needed)
                        fetch('/save-fcm-token', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ token }),
                        });
                    } else {
                        console.log('No token generated');
                    }
                } else {
                    console.log('Notification permission not granted');
                }
            } catch (error) {
                console.error('Error generating FCM token:', error);
            }
        });
    </script>
    </body>
</html>
