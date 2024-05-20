function changePushButtonState(test = '') { }

const applicationServerKey =
  'BMBlr6YznhYMX3NgcWIDRxZXs0sh7tCv7_YCsWcww0ZCv9WGg-tRCXfMEHTiBPCksSqeve1twlbmVAZFv7GSuj0';

navigator.serviceWorker.register('serviceWorker.js').then(
  () => {
    console.log('[SW] Service worker has been registered');
    push_updateSubscription();
  },
  (e) => {
    console.error('[SW] Service worker registration failed', e);
    changePushButtonState('incompatible');
  }
);

const pushButton = document.querySelector('#push-subscription-button');
pushButton.addEventListener('click', function () {
  push_subscribe();
});

function push_updateSubscription() {
  navigator.serviceWorker.ready
    .then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.getSubscription())
    .then(subscription => {
      changePushButtonState('disabled');
      if (!subscription) {
        // We aren't subscribed to push, so set UI to allow the user to enable push
        return;
      }
      // Keep your server in sync with the latest endpoint
      return push_sendSubscriptionToServer(subscription, 'POST');
    })
    .then(subscription => subscription && changePushButtonState('enabled')) // Set your UI to show they have subscribed for push messages
    .catch(e => {
      console.error('Error when updating the subscription', e);
    });
}

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
  const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function checkNotificationPermission() {
  return new Promise((resolve, reject) => {
    if (Notification.permission === 'denied') {
      return reject(new Error('Push messages are blocked.'));
    }

    if (Notification.permission === 'granted') {
      return resolve();
    }

    if (Notification.permission === 'default') {
      return Notification.requestPermission().then(result => {
        if (result !== 'granted') {
          reject(new Error('Bad permission result'));
        } else {
          resolve();
        }
      });
    }
    return reject(new Error('Unknown permission'));
  });
}

function push_subscribe() {
  return checkNotificationPermission()
    .then(() => navigator.serviceWorker.ready)
    .then(serviceWorkerRegistration =>
      serviceWorkerRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(applicationServerKey),
      })
    )
    .then(subscription => {
      // Subscription was successful
      // create subscription on your server
      return push_sendSubscriptionToServer(subscription, 'POST');
    })
    .then((subscription) => subscription && changePushButtonState('enabled')) // update your UI
    .catch((e) => {
      if (Notification.permission === 'denied') {
        // The user denied the notification permission which
        // means we failed to subscribe and the user will need
        // to manually change the notification permission to
        // subscribe to push messages
        console.warn('Notifications are denied by the user.');
        changePushButtonState('incompatible');
      } else {
        // A problem occurred with the subscription; common reasons
        // include network errors or the user skipped the permission
        console.error('Impossible to subscribe to push notifications', e);
        changePushButtonState('disabled');
      }
    });
}

function push_sendSubscriptionToServer(subscription, method) {


  navigator.serviceWorker.ready
    .then((serviceWorkerRegistration) => serviceWorkerRegistration.pushManager.getSubscription())
    .then((subscription) => {
      if (!subscription) {
        alert('Please enable push notifications');
        return;
      }
      const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
      const jsonSubscription = subscription.toJSON();
      return fetch('api/push_subscription', {
        method,
        // body: JSON.stringify(Object.assign(jsonSubscription, { contentEncoding }))
        body: JSON.stringify(jsonSubscription)
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    });


  // // const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
  // const jsonSubscription = subscription.toJSON();
}