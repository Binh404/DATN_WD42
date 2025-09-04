// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT,
//     wssPort: import.meta.env.VITE_PUSHER_PORT,
//     enabledTransports: ["ws", "wss"],
// // });
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
});
// import Echo from 'laravel-echo';

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
//     forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// // Kiểm tra trạng thái kết nối Reverb
// window.Echo.connector.connection.on('open', () => {
//     console.log('✅ Đã kết nối WebSocket thành công với server Reverb!');
// });

// window.Echo.connector.connection.on('close', () => {
//     console.log('❌ Đã ngắt kết nối WebSocket với server Reverb!');
// });



