import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


window.Echo.channel('highest-stock-price')
    .listen('NewHighestPrice', (event) => {
        console.log(event);

        /** Set the new value. */
        const maxValueElement = document.getElementById('max_' + event.symbol);
        maxValueElement.textContent = event.value;

        /** Set the new percentage value. */
        const maxPercentageElement = document.getElementById('max_percentage_' + event.symbol);
        maxPercentageElement.textContent = event.movePercentage;

        /** Set the new icon. */
        const maxIconElement = document.getElementById('max_icon_' + event.symbol);
        switch(event.moveDirection) {
            case 'up':
                maxIconElement.textContent = ' 🔼';
                break;
            case 'down':
                maxIconElement.textContent = ' 🔽';
                break;
            case 'same':
                maxIconElement.textContent = ' ➖';
                break;
        }
    });
