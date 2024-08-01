<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/register9.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 06:18:08 GMT -->

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
                        <form action="<?= base_url('auth/create-company') ?>" method="POST" id="create-company">
                            <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                            <input class="form-control" type="text" name="company_name" placeholder="Company Name" required>
                            <input class="form-control" type="text" name="address" placeholder="Address" required>
                            <input class="form-control" type="text" name="city" placeholder="City" required>
                            <input class="form-control" type="text" name="state" placeholder="State" required>
                            <input class="form-control" type="text" name="country" placeholder="Country" required>
                            <input class="form-control" type="text" name="zip_code" placeholder="Zip Code" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn savebtn">Submit</button>
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
        var base_url = '<?= base_url() ?>';
        $(document).ready(function() {
            $(".savebtn").click(function(e) {
                e.preventDefault();
                let save_button = $(this),
                    output_status = $('#create-company').find('.result'),
                    card = $('#create-company');
                output_status.html('');
                var form = $('#create-company');
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result['error'] == false) {
                            location.href = base_url + 'auth/purchase-plan/' + result.saas_id;
                        } else {
                            console.log('runn');
                            $('.result').prepend('<div class="alert alert-danger">' + result['message'] + '</div>');
                            $('.result').find('.alert').delay(4000).fadeOut();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        output_status.append('<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>');
                    },
                    complete: function() {
                    }
                });
            });
        });
    </script>
</body>

<!-- Mirrored from brandio.io/envato/iofrm/html/register9.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 06:18:08 GMT -->

</html>