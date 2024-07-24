<?php $this->load->view('includes/header'); ?>
<style>
  .hidden {
    display: none;
  }

  #example3 tbody td a {
    font-weight: bold;
    font-size: 12px;
  }
</style>
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <?php $this->load->view('includes/sidebar'); ?>
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card card-primary" id="settings-card">
              <form action="<?= base_url('settings/save-front-setting') ?>" method="POST" id="setting-form">
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group col-md-12">
                      <label class="d-block mt-3"><?= $this->lang->line('enable_or_disable_sections') ? $this->lang->line('enable_or_disable_sections') : 'Enable OR Disable Sections' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= $this->lang->line('disable_landing_page_option_to_disable_whole_frontend') ? $this->lang->line('disable_landing_page_option_to_disable_whole_frontend') : 'Disable Landing Page option to Disable whole frontend.' ?>"></i></label>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="landing_page" name="landing_page" value="<?= (isset($frontend_permissions->landing_page) && !empty($frontend_permissions->landing_page)) ? $frontend_permissions->landing_page : 0 ?>" <?= (isset($frontend_permissions->landing_page) && !empty($frontend_permissions->landing_page) && $frontend_permissions->landing_page == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="landing_page"><?= $this->lang->line('landing_page') ? $this->lang->line('landing_page') : 'Landing Page' ?></label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="home" name="home" value="<?= (isset($frontend_permissions->home) && !empty($frontend_permissions->home)) ? $frontend_permissions->home : 0 ?>" <?= (isset($frontend_permissions->home) && !empty($frontend_permissions->home) && $frontend_permissions->home == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="home"><?= $this->lang->line('home') ? $this->lang->line('home') : 'Home' ?></label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="features" name="features" value="<?= (isset($frontend_permissions->features) && !empty($frontend_permissions->features)) ? $frontend_permissions->features : 0 ?>" <?= (isset($frontend_permissions->features) && !empty($frontend_permissions->features) && $frontend_permissions->features == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="features"><?= $this->lang->line('features') ? $this->lang->line('features') : 'Features' ?></label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="subscription_plans" name="subscription_plans" value="<?= (isset($frontend_permissions->subscription_plans) && !empty($frontend_permissions->subscription_plans)) ? $frontend_permissions->subscription_plans : 0 ?>" <?= (isset($frontend_permissions->subscription_plans) && !empty($frontend_permissions->subscription_plans) && $frontend_permissions->subscription_plans == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="subscription_plans"><?= $this->lang->line('subscription_plans') ? $this->lang->line('subscription_plans') : 'Plans' ?></label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="contact" name="contact" value="<?= (isset($frontend_permissions->contact) && !empty($frontend_permissions->contact)) ? $frontend_permissions->contact : 0 ?>" <?= (isset($frontend_permissions->contact) && !empty($frontend_permissions->contact) && $frontend_permissions->contact == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="contact"><?= $this->lang->line('contact_form') ? $this->lang->line('contact_form') : 'Contact Form' ?></label>
                      </div>


                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="about" name="about" value="<?= (isset($frontend_permissions->about) && !empty($frontend_permissions->about)) ? $frontend_permissions->about : 0 ?>" <?= (isset($frontend_permissions->about) && !empty($frontend_permissions->about) && $frontend_permissions->about == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="about">About Us</label>
                      </div>


                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="<?= (isset($frontend_permissions->privacy) && !empty($frontend_permissions->privacy)) ? $frontend_permissions->privacy : 0 ?>" <?= (isset($frontend_permissions->privacy) && !empty($frontend_permissions->privacy) && $frontend_permissions->privacy == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="privacy">Privacy Policy</label>
                      </div>


                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" value="<?= (isset($frontend_permissions->terms) && !empty($frontend_permissions->terms)) ? $frontend_permissions->terms : 0 ?>" <?= (isset($frontend_permissions->terms) && !empty($frontend_permissions->terms) && $frontend_permissions->terms == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="terms">Terms and Conditions</label>
                      </div>

                    </div>


                    <div class="row gutters-sm justify-content-center <?= (isset($frontend_permissions->landing_page) && !empty($frontend_permissions->landing_page) && $frontend_permissions->landing_page == 1) ? 'd-flex' : 'd-none' ?>" id="landing_page_theme_div">
                      <div class="col-md-3 text-center">
                        <label class="imagecheck">
                          <input name="theme_name" type="radio" value="theme_one" class="imagecheck-input" <?= (isset($frontend_permissions->theme_name) && ($frontend_permissions->theme_name == 'theme_one' || $frontend_permissions->theme_name == '')) ? 'checked' : '' ?> />
                          <figure class="imagecheck-figure">
                            <img src="<?= base_url("assets/front/one/img/theme-preview.jpg") ?>" alt="<?= $this->lang->line('theme_one') ? htmlspecialchars($this->lang->line('theme_one')) : 'Theme One' ?>" class="imagecheck-image">
                          </figure>
                        </label>
                        <a href="<?= base_url('front/theme/one') ?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?= $this->lang->line('preview') ? htmlspecialchars($this->lang->line('preview')) : 'Preview' ?></a>
                      </div>
                      <div class="col-md-3 text-center">
                        <label class="imagecheck">
                          <input name="theme_name" type="radio" value="theme_two" class="imagecheck-input" <?= (isset($frontend_permissions->theme_name) && $frontend_permissions->theme_name == 'theme_two') ? 'checked' : '' ?> />
                          <figure class="imagecheck-figure">
                            <img src="<?= base_url("assets/front/two/img/theme-preview.jpg") ?>" alt="<?= $this->lang->line('theme_two') ? htmlspecialchars($this->lang->line('theme_two')) : 'Theme Two' ?>" class="imagecheck-image">
                          </figure>
                        </label>
                        <a href="<?= base_url('front/theme/two') ?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?= $this->lang->line('preview') ? htmlspecialchars($this->lang->line('preview')) : 'Preview' ?></a>
                      </div>
                      <div class="col-md-3 text-center">
                        <label class="imagecheck">
                          <input name="theme_name" type="radio" value="theme_three" class="imagecheck-input" <?= (isset($frontend_permissions->theme_name) && $frontend_permissions->theme_name == 'theme_three') ? 'checked' : '' ?> />
                          <figure class="imagecheck-figure">
                            <img src="<?= base_url("assets/front/three/img/theme-preview.jpg") ?>" alt="<?= $this->lang->line('theme_three') ? htmlspecialchars($this->lang->line('theme_three')) : 'Theme Three' ?>" class="imagecheck-image">
                          </figure>
                        </label>
                        <a href="<?= base_url('front/theme/three') ?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?= $this->lang->line('preview') ? htmlspecialchars($this->lang->line('preview')) : 'Preview' ?></a>
                      </div>
                      <div class="col-md-3 text-center">
                        <label class="imagecheck">
                          <input name="theme_name" type="radio" value="theme_four" class="imagecheck-input" <?= (isset($frontend_permissions->theme_name) && $frontend_permissions->theme_name == 'theme_four') ? 'checked' : '' ?> />
                          <figure class="imagecheck-figure">
                            <img src="<?= base_url("assets/front/four/img/theme-preview.png") ?>" alt="<?= $this->lang->line('theme_four') ? htmlspecialchars($this->lang->line('theme_four')) : 'Theme Four' ?>" class="imagecheck-image">
                          </figure>
                        </label>
                        <a href="<?= base_url('front/theme/four') ?>" target="_blank" class="btn btn-sm btn-icon icon-left btn-primary mt-1 mb-1"><i class="fas fa-eye"></i> <?= $this->lang->line('preview') ? htmlspecialchars($this->lang->line('preview')) : 'Preview' ?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-whitesmoke text-end">
                  <button type="button" class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
                </div>
                <div class="result"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>

    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    $(document).on('click', '.savebtn', function(e) {
      var modal = $('.result');
      var form = $('#setting-form');
      var formData = form.serialize();
      console.log(formData);

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {
            modal.append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
      });

      e.preventDefault();
    });
  </script>
</body>

</html>