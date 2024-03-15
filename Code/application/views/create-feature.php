<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap-iconpicker/bootstrap-iconpicker.min.css'); ?>">
<style>
  .nav {
    --bs-nav-link-padding-x: 1rem;
    --bs-nav-link-padding-y: 0.5rem;
    --bs-nav-link-font-weight: ;
    --bs-nav-link-color: var(--bs-link-color);
    --bs-nav-link-hover-color: var(--bs-link-hover-color);
    --bs-nav-link-disabled-color: var(--bs-secondary-color);
    display: flex;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
  }

  .nav-link2 {
    display: block;
    padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
    font-size: var(--bs-nav-link-font-size);
    font-weight: var(--bs-nav-link-font-weight);
    color: var(--bs-nav-link-color);
    text-decoration: none;
    background: none;
    border: 0;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
  }

  @media (prefers-reduced-motion: reduce) {
    .nav-link2 {
      transition: none;
    }
  }

  .nav-link2:hover,
  .nav-link2:focus {
    color: var(--bs-nav-link-hover-color);
  }

  .nav-link2:focus-visible {
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(136, 108, 192, 0.25);
  }

  .nav-link2.disabled,
  .nav-link2:disabled {
    color: var(--bs-nav-link-disabled-color);
    pointer-events: none;
    cursor: default;
  }

  .nav-tabs {
    --bs-nav-tabs-border-width: var(--bs-border-width);
    --bs-nav-tabs-border-color: var(--bs-border-color);
    --bs-nav-tabs-border-radius: var(--bs-border-radius);
    --bs-nav-tabs-link-hover-border-color: var(--bs-secondary-bg) var(--bs-secondary-bg) var(--bs-border-color);
    --bs-nav-tabs-link-active-color: var(--bs-emphasis-color);
    --bs-nav-tabs-link-active-bg: var(--bs-body-bg);
    --bs-nav-tabs-link-active-border-color: var(--bs-border-color) var(--bs-border-color) var(--bs-body-bg);
    border-bottom: var(--bs-nav-tabs-border-width) solid var(--bs-nav-tabs-border-color);
  }

  .nav-tabs .nav-link2 {
    margin-bottom: calc(-1 * var(--bs-nav-tabs-border-width));
    border: var(--bs-nav-tabs-border-width) solid transparent;
    border-top-left-radius: var(--bs-nav-tabs-border-radius);
    border-top-right-radius: var(--bs-nav-tabs-border-radius);
  }

  .nav-tabs .nav-link2:hover,
  .nav-tabs .nav-link2:focus {
    isolation: isolate;
    border-color: var(--bs-nav-tabs-link-hover-border-color);
  }

  .nav-tabs .nav-link2.active,
  .nav-tabs .nav-item.show .nav-link2 {
    color: var(--bs-nav-tabs-link-active-color);
    background-color: var(--bs-nav-tabs-link-active-bg);
    border-color: var(--bs-nav-tabs-link-active-border-color);
  }

  .nav-tabs .dropdown-menu {
    margin-top: calc(-1 * var(--bs-nav-tabs-border-width));
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  .nav-pills2 {
    --bs-nav-pills-border-radius: var(--bs-border-radius);
    --bs-nav-pills-link-active-color: #fff;
    --bs-nav-pills-link-active-bg: #886CC0;
  }

  .nav-pills2 .nav-link2 {
    border-radius: var(--bs-nav-pills-border-radius);
  }

  .nav-pills2 .nav-link2.active,
  .nav-pills2 .show>.nav-link2 {
    color: var(--bs-nav-pills-link-active-color);
    background-color: var(--theme-color);
  }

  .nav-underline {
    --bs-nav-underline-gap: 1rem;
    --bs-nav-underline-border-width: 0.125rem;
    --bs-nav-underline-link-active-color: var(--bs-emphasis-color);
    gap: var(--bs-nav-underline-gap);
  }

  .nav-underline .nav-link2 {
    padding-right: 0;
    padding-left: 0;
    border-bottom: var(--bs-nav-underline-border-width) solid transparent;
  }

  .nav-underline .nav-link2:hover,
  .nav-underline .nav-link2:focus {
    border-bottom-color: currentcolor;
  }

  .nav-underline .nav-link2.active,
  .nav-underline .show>.nav-link2 {
    font-weight: 700;
    color: var(--bs-nav-underline-link-active-color);
    border-bottom-color: currentcolor;
  }

  .nav-fill2>.nav-link2,
  .nav-fill2 .nav-item {
    flex: 1 1 auto;
    text-align: center;
  }

  .nav-justified>.nav-link2,
  .nav-justified .nav-item {
    flex-basis: 0;
    flex-grow: 1;
    text-align: center;
  }

  .nav-fill2 .nav-item .nav-link2,
  .nav-justified .nav-item .nav-link2 {
    width: 100%;
  }

  .tab-content>.tab-pane {
    display: none;
  }

  .tab-content>.active {
    display: block;
  }

  .popover {
    position: absolute;
    top: 20%;
    right: 30%;
    --bs-popover-font-size: 0.76562rem;
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
  <div id="loader">
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
    <!--**********************************
    Sidebar start
***********************************-->
    <?php $this->load->view('includes/sidebar'); ?>
    <!--**********************************
    Sidebar end
***********************************--> <!--**********************************
	Content body start
***********************************-->
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="col-xl-12">
          <div class="card">
            <form action="<?= base_url('front/save-feature') ?>" method="POST" id="feature-form">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="nav flex-column nav-pills2 mb-3">
                      <?php foreach ($lang as $kay => $lan) { ?>
                        <a href="#<?= htmlspecialchars($lan['language']) ?>" data-bs-toggle="pill" class="nav-link2 <?= $kay == 0 ? 'active show' : '' ?>"><?= ucfirst(htmlspecialchars($lan['language'])) ?></a>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <?php foreach ($lang as $kay => $lan) { ?>
                      <div class="tab-content">
                        <div id="<?= htmlspecialchars($lan['language']) ?>" class="tab-pane fade <?= $kay == 0 ? 'active show' : '' ?>">
                          <h4><?= ucfirst(htmlspecialchars($lan['language'])) ?>
                            <?php if ($lan['language'] == default_language()) { ?>
                              <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= $this->lang->line('must_enter_title_and_description_for_default_language') ? $this->lang->line('must_enter_title_and_description_for_default_language') : 'Must enter Title and Description for default language.' ?>"></i>
                            <?php } ?>
                          </h4>
                          <div class="form-group col-md-12">
                            <label><?= $this->lang->line('icon') ? $this->lang->line('icon') : 'Icon' ?><span class="text-danger">*</span></label>
                            <button class="icon btn btn-block btn-default border iconpicker" data-icon="<?= isset($feature_icon->{$lan['language']}) ? htmlspecialchars($feature_icon->{$lan['language']}) : '' ?>" id="<?= htmlspecialchars($lan['language']) ?>_icon" name="<?= htmlspecialchars($lan['language']) ?>_icon" title="" data-original-title="icon">
                              <i class="<?= isset($feature_icon->{$lan['language']}) ? htmlspecialchars($feature_icon->{$lan['language']}) : '' ?>"></i>
                              <span class="caret"></span>
                              <input type="hidden" class="icon" name="<?= htmlspecialchars($lan['language']) ?>_icon">
                            </button>
                          </div>
                          <div class="form-group mt-3 col-md-12">
                            <label><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?><span class="text-danger">*</span></label>
                            <input type="text" name="<?= htmlspecialchars($lan['language']) ?>_title" class="form-control">
                          </div>
                          <div class="form-group mt-3 col-md-12">
                            <label><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                            <textarea type="text" name="<?= $lan['language'] ?>_description" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    <?php
                    } ?>
                  </div>
                </div>
                <div class="message mt-3"></div>
              </div>
              <div class="card-footer text-end">
                <button type="button" class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--**********************************
	Content body end
***********************************-->
    <?php $this->load->view('includes/footer'); ?>
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets/modules/bootstrap-iconpicker/bootstrap-iconpicker.min.js'); ?>"></script>
  <script>
    $(document).ready(function() {
      // Initialize icon picker for elements with the 'icon' class
      $('.icon').each(function() {
        var initialIcon = $(this).data('icon'); // Get the initial icon value from data-icon attribute
        $(this).iconpicker({
          cols: 10,
          icon: initialIcon, // Set the initial icon value
          iconset: 'fontawesome5',
          labelHeader: '{0} of {1} pages',
          labelFooter: '{0} - {1} of {2} icons',
          placement: 'inline', // Use custom CSS for positioning
          rows: 5,
          search: true,
          searchText: '',
          selectedClass: 'btn-success',
          unselectedClass: ''
        });
      });
    });

    $(document).on('click', '.savebtn', function(e) {
      var form = $('#feature-form');
      var formData = form.serialize();
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            $('.message').append('<div class="alert alert-success">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          } else {
            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });
  </script>


</body>

</html>