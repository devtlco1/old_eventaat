importScripts('https://www.gstatic.com/firebasejs/9.20.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.20.0/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyC0LD0uty3jsHJIK09ZaK_59Em7TgRGnIo",
    authDomain: "amjad-a610c.firebaseapp.com",
    projectId: "amjad-a610c",
    storageBucket: "amjad-a610c.firebasestorage.app",
    messagingSenderId: "811880597056",
    appId: "1:811880597056:web:1ca14adcb4fc2fa68a01a5",
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
