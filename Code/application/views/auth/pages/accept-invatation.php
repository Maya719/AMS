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
                    <h3>Regain your access with Loggin platform.</h3>
                    <p>A password reset link is on its way to your email. Use it to restore your account and continue enjoying the most powerful tool in the entire design and web industry.</p>
                    <img src="<?= base_url('assets/front/four/auth-pages/images/forgot-password.svg') ?>" alt="">
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
                        <form action="<?= base_url('auth/create-special-role') ?>" method="POST" id="forgot-password">
                            <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                            <input type="hidden" name="group_id" value="<?= $group_id ?>">
                            <input type="hidden" name="employee_id" id="employee_id">
                            <input type="text" class="form-control" placeholder="<?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?>" name="email" value="<?= $email ?>" readonly>
                            <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
                            <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
                            <input class="form-control" type="text" name="phone" placeholder="Phone" required>
                            <input type="password" class="form-control" placeholder="Password" name="password" pattern="^.{8}.*$" tabindex="1" required autofocus>
                            <input type="password" name="password_confirm" placeholder="Confirm Password" pattern="^.{8}.*$" class="form-control" tabindex="2" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn savebtn">Create</button>
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
                    output_status = $('#forgot-password').find('.result'),
                    card = $('#forgot-password');
                save_button.html('Sending');
                output_status.html('');
                var form = $('#forgot-password');
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result['error'] == false) {
                            window.location.href = base_url;
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
                        save_button.html('Send');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            getEmployeeId();

            function getEmployeeId() {
                $.ajax({
                    url: '<?= base_url('users/get_employee_id') ?>',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var employee_id = response.max_employee_id;
                        employee_id++;
                        $('#employee_id').val(employee_id);
                    },
                });
            }
        });
    </script>
</body>

</html>