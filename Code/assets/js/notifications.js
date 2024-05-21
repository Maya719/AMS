const sendPushButton = document.querySelector('#send-push-button');
sendPushButton.addEventListener('click', () =>
  navigator.serviceWorker.ready
    .then((serviceWorkerRegistration) => serviceWorkerRegistration.pushManager.getSubscription())
    .then((subscription) => {
      if (!subscription) {
        alert('Please enable push notifications');
        return;
      }

      const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
      const jsonSubscription = subscription.toJSON();
      fetch('api/send_push_notification', {
        method: 'POST',
        body: JSON.stringify(Object.assign(jsonSubscription, { contentEncoding })),
      }).then(response => response.json()).then(data => { console.log(data) });
    })
);