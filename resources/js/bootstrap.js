import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: true
});

// Canal privé pour les admins
Echo.private('admin.notifications')
    .listen('.notification', (e) => {
        console.log('Notif admin :', e.message);
    });

// Canal privé pour un utilisateur connecté
Echo.private(`user.${userId}.notifications`)
    .listen('.notification', (e) => {
        console.log('Notif user :', e.message);
    });


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
