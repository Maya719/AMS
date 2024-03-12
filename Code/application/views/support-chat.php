<?php $this->load->view('includes/header'); ?>
<style>
  .hidden {
    display: none;
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
            <div class="card card-primary" id="support-form-card">
              <div class="card-header">
                <h4><?= $support_data[0]['ticket_id'] ?> - <?= $support_data[0]['subject'] ?></h4>
              </div>
              <div class="card-body">
                <div class="tickets">
                  <div class="ticket-content">

                    <?php if ($support_messages) {
                      foreach ($support_messages as $support_message) { ?>
                        <div class="ticket-header">
                          <div class="ticket-detail">
                            <div class="ticket-title">
                              <h4><?= $support_message['user'] ?></h4>
                            </div>
                            <div class="ticket-info">
                              <div class="text-primary font-weight-600"><?= time_elapsed_string($support_message['created']) ?></div>
                            </div>
                          </div>
                        </div>
                        <div class="ticket-description">
                          <p><?= $support_message['message'] ?></p>
                          <div class="ticket-divider"></div>
                        </div>
                      <?php }
                    } else {
                      if ($this->ion_auth->is_admin()) { ?>

                        <div class="ticket-description">
                          <p><?= $this->lang->line('please_explain_your_problem_in_detail_we_will_get_back_to_you_ASAP') ? htmlspecialchars($this->lang->line('please_explain_your_problem_in_detail_we_will_get_back_to_you_ASAP')) : 'Please explain your problem in detail. We will get back to you ASAP.' ?></p>
                          <div class="ticket-divider"></div>
                        </div>

                      <?php } else { ?>

                        <div class="ticket-description">
                          <p><?= $this->lang->line('we_couldnt_find_any_data') ? htmlspecialchars($this->lang->line('we_couldnt_find_any_data')) : "We couldn't find any data" ?>
                          <div class="ticket-divider"></div>
                        </div>

                    <?php }
                    } ?>


                    <div class="ticket-form">
                      <form action="<?= base_url('support/create_support_message') ?>" method="POST" id="support-form">
                        <input type="hidden" name="to_id" value="<?= $ticket_id ?>">
                        <textarea name="message"></textarea>
                        <div class="form-group text-right mt-5">
                          <button class="btn btn-primary btn-lg savebtn">
                            <?= $this->lang->line('send') ? htmlspecialchars($this->lang->line('send')) : 'Send' ?>
                          </button>
                        </div>
                        <div class="result"></div>
                      </form>
                    </div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!-- ************************************* *****
    Model forms
  ****************************************************-->

    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      height: 240,
      plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
      menubar: 'edit view insert format tools table tc help',
      toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
      setup: function(editor) {
        editor.on("change keyup", function(e) {
          tinyMCE.triggerSave();
        });
      },
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
    $("#support-form").submit(function(e) {
      e.preventDefault();
      let save_button = $(this).find('.savebtn'),
        output_status = $(this).find('.result'),
        card = $('#support-form-card');

      output_status.html('');

      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {
            output_status.prepend('<div class="alert alert-danger">' + result['message'] + '</div>');
          }
          output_status.find('.alert').delay(4000).fadeOut();
          card_progress.dismiss(function() {
            $('html, body').animate({
              scrollTop: output_status.offset().top
            }, 1000);
          });
        }
      });
    });
  </script>
</body>

</html>