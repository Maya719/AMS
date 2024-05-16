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



          <div class="col-md-12" id="home-card">
            <div class="card card-primary">
              <form action="<?= base_url('front/edit-pages') ?>" method="POST" id="home-form">
                <div class="card-body">
                  <input type="hidden" name="update_id" id="update_id" value="<?= $data[0]['id'] ?>">
                  <textarea name="content"><?= $data[0]['content'] ?></textarea>
                  <div class="result"></div>
                </div>
                <div class="card-footer text-end">
                  <button type="button" class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
                </div>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      height: 700,
      plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap  emoticons code',
      menubar: 'edit view insert format tools table tc help',
      toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
      setup: function(editor) {
        editor.on("change keyup", function(e) {
          tinyMCE.triggerSave();
        });
      },
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
    $(document).on('click', '.savebtn', function(e) {
      var modal = $('.result');
      var form = $('#home-form');
      var formData = form.serialize();
      console.log("form data is : ", formData);

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        beforeSend: function() {
          $(".modal-body").append(ModelProgress);
        },
        success: function(result) {

          if (result['error'] == false) {
            location.reload();
          } else {
            modal.append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });

      e.preventDefault();
    });
  </script>
</body>

</html>