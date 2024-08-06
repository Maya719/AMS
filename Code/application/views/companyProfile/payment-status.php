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
    <link href="<?=base_url('assets2/vendor/toastr/css/toastr.min.css')?>" rel="stylesheet" type="text/css"/>	
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        h1 {
            color: #FFFFFF;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }

        p {
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }

        i {
            color: <?= theme_color() ?>;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }

        .card {
            background: none;
            border: none;
            padding: 60px;
            border-radius: 4px;
            display: inline-block;
            margin: 0 auto;
            text-align: center;
        }
    </style>
    <style>
        :root {
            --theme-color: <?= theme_color() ?>;
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
                        <div class="card">
                            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                                <i class="checkmark">✓</i>
                            </div>
                            <h1>Success</h1>
                            <p>Thank you!<br> Your plan has been successfully activated.</p>
                        </div>
                        <div class="form-button">
                            <a id="submit" href="<?= base_url('/') ?>" class="ibtn savebtn">Back To Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/front/four/auth-pages/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/four/auth-pages/js/main.js') ?>"></script>
    <script src="<?= base_url('assets2/vendor/toastr/js/toastr.min.js') ?>"></script>
    <?php if ($this->session->flashdata('message') && $this->session->flashdata('message_type') == 'success') { ?>
        <script>
            toastr.success("<?= $this->session->flashdata('message'); ?>", "Success", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
            <?php $this->session->set_flashdata('message', null); ?>
        </script>
    <?php } ?>
</body>

</html>