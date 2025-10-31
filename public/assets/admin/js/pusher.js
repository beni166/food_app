// Place ce code dans un fichier JS chargé par ta page (ex: resources/js/app.js)
// Ou directement dans une balise <script> dans ta vue Blade

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'c6628c266b5cadd67167', // Ton PUSHER_APP_KEY
    cluster: 'mt1', // Ton PUSHER_APP_CLUSTER
    forceTLS: true
});

window.Echo.channel('my-channel')
    .listen('.my-event', (e) => {
        console.log('Événement reçu !', e);
        alert('Nouveau message : ' + e.message);
    });