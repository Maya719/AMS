// self.addEventListener('push', function (event) {
//     if (!(self.Notification && self.Notification.permission === 'granted')) {
//         return;
//     }
//     const sendNotification = body => {
//         const title = "Web Push example";
//         return self.registration.showNotification(body['title'], {
//             body,
//         });
//     };
//     if (event.data) {
//         const payload = event.data.json();
//         event.waitUntil(sendNotification(payload.message));
//     }
// });



self.addEventListener('push', function (event) {
    const data = event.data.json();
    // console.log(data);
    const title = data.title || 'Your default title';
    const options = {
        body: data.body || 'Your default body',
        // icon: data.icon || 'path/to/default/icon.png',
        // Add any other options as needed
    };
    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
    const notification = event.notification;
    const url = notification.data.url; // Get the URL from the notification data

    notification.close(); // Close the notification

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});