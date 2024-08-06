<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/register9.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Jul 2024 06:18:08 GMT -->

<head>
  <style>
    :root {
      --theme-color:
        <?= theme_color() ?>;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view('front/meta'); ?>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/fontawesome-all.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/iofrm-style.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/four/auth-pages/css/iofrm-theme9.css') ?>">

</head>

<body>
  <div class="form-body">
    <div class="row">
      <div class="img-holder">
        <div class="bg"></div>
        <div class="info-holder">
          <h3>Recover access to your account with Loggin platform.</h3>
          <p>Reset your password to continue using the most powerful tool in the entire design and web industry.</p>
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
            <form action="" method="POST" id="forgot-password">
              <?php
              echo form_hidden($user_id);
              echo form_hidden($csrf);
              ?>
              <input type="password" class="form-control" placeholder="Password" name="new" pattern="^.{8}.*$" tabindex="1" required autofocus>
              <input type="password" name="new_confirm" placeholder="Confirm Password" pattern="^.{8}.*$" class="form-control" tabindex="2" required>
              <div class="form-button">
                <button id="submit" type="submit" class="ibtn savebtn">Send</button>
              </div>
            </form>
            <p>
              <?= $this->lang->line('at_least_8_characters_long') ? $this->lang->line('at_least_8_characters_long') : 'at least 8 characters long.' ?>
            </p>
            <?php
            if (isset($message) && !empty($message)) { ?>
              <div class="form-group alert alert-danger">
                <?php echo htmlspecialchars($message); ?>
              </div>
            <?php
            }
            ?>
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
  </script>
</body>

</html>