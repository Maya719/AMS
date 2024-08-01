<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->load->view('front/meta'); ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/fontawesome-all.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/iofrm-style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/iofrm-theme9.css') ?>">
    <style>
        :root {
            --theme-color:
                <?= theme_color() ?>;
        }
    </style>
</head>

<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>Get more things done with Loggin platform.</h3>
                    <p>Access to the most powerfull tool in the entire design and web industry.</p>
                    <img src="<?= base_url('assets/front/four/auth-pages/images/graphic5.svg') ?>" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="website-logo-inside">
                            <a href="<?= base_url('/') ?>">
                                <div class="logo">
                                    <img class="logo-size" src="<?= base_url('assets2/images/logos/' . full_logo()) ?>" alt="logo">
                                </div>
                            </a>
                        </div>
                        <form action="<?= base_url('payment/create-payment') ?>" method="POST" id="create-company" autocomplete="off">
                            <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                            <select class="form-control mb-3" aria-label="Default select example" name="plan_id" id="plan_id">
                                <?php foreach ($plans as $plan) : ?>
                                    <?php if ($plan["id"] != 1) : ?>
                                        <option value="<?= $plan['id'] ?>"><?= $plan['title'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>

                            <div id="paymentDiv">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="flexRadioDefault1" value="stripe" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Stripe
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="flexRadioDefault2" value="myFatoorah">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        myFatoorah
                                    </label>
                                </div>
                                <input class="form-control" type="text" name="name" placeholder="Card Holder" autocomplete="off">
                                <div id="card-element" class="form-control" style="background-color: #fff;"></div>
                            </div>
                            <div id="card-errors" role="alert"></div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn savebtn">Submit</button>
                                <a href="<?=base_url('/')?>" class="ibtn savebtn">Use Trail</a>
                            </div>
                        </form>
                        <div class="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/front/four/auth-pages/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/main.js') ?>"></script>
    <script>
        paypal_client_id = "<?= get_payment_paypal() ?>";
        get_stripe_publishable_key = "<?= get_stripe_publishable_key() ?>";
        razorpay_key_id = "<?= get_razorpay_key_id() ?>";
        offline_bank_transfer = "<?= get_offline_bank_transfer() ?>";
        paystack_user_email_id = "<?= $user->email ?>";
        paystack_public_key = "<?= get_paystack_public_key() ?>";
    </script>
    <?php if (get_stripe_publishable_key()) { ?>
        <script src="https://js.stripe.com/v3/"></script>
    <?php } ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stripe = Stripe(get_stripe_publishable_key);
            var elements = stripe.elements();
            var card = elements.create('card', {
                hidePostalCode: true
            });
            card.mount('#card-element');
            var form = document.getElementById('create-company');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: document.querySelector('input[name="name"]').value
                    }
                }).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        stripePaymentMethodHandler(result.paymentMethod);
                    }
                });
            });

            function stripePaymentMethodHandler(paymentMethod) {
                var newForm = document.createElement('form');
                newForm.method = 'POST';
                newForm.action = form.action;

                var hiddenInputs = [{
                        name: 'paymentMethodId',
                        value: paymentMethod.id
                    },
                    {
                        name: 'name',
                        value: document.querySelector('input[name="name"]').value
                    },
                    {
                        name: 'saas_id',
                        value: document.querySelector('input[name="saas_id"]').value
                    },
                    {
                        name: 'plan_id',
                        value: document.querySelector('select[name="plan_id"]').value
                    }
                ];

                hiddenInputs.forEach(function(input) {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', input.name);
                    hiddenInput.setAttribute('value', input.value);
                    newForm.appendChild(hiddenInput);
                });

                document.body.appendChild(newForm);
                newForm.submit();
                document.body.removeChild(newForm);
            }
        });
    </script>


</body>

</html>