<?php $this->load->view('includes/header'); ?>
<style>

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
      <!-- row -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#notes-modal" class="btn btn-block btn-primary">+ ADD</a>
          </div>
        </div>
        <div class="row mt-3">
          <?php if ($notes && !empty($notes)) {
            foreach ($notes as $note) { ?>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title description-wrapper"><?= htmlspecialchars($note['description']) ?></h4>
                  </div>
                  <div class="card-body">
                    <a href="javascript:void(0);" class="card-link text-muted btn_edit_notes" data-bs-toggle="modal" data-bs-target="#modal-edit-notes" data-edit="<?= htmlspecialchars($note['id']) ?>"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></a>
                    <a href="javascript:void(0);" class="card-link text-danger delete_notes" data-id="<?= htmlspecialchars($note['id']) ?>"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></a>
                  </div>
                </div>
              </div>
          <?php }
          } ?>
        </div>
      </div>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!-- ************************************* *****
    Model forms
  ****************************************************-->
    <div class="modal fade" id="notes-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('notes/create') ?>" method="POST" class="modal-part" id="modal-add-notes-part" data-title="<?= $this->lang->line('create_new_note') ? $this->lang->line('create_new_note') : 'Create New Note' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-12">
                  <label><?= $this->lang->line('note') ? $this->lang->line('note') : 'Note' ?><span class="text-danger">*</span></label>
                  <textarea type="text" name="description" class="form-control"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn create-note btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-edit-notes">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('notes/edit') ?>" method="POST" class="modal-part" id="modal-edit-notes-part" data-title="<?= $this->lang->line('edit_note') ? $this->lang->line('edit_note') : 'Edit Note' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id" value="">
              <div class="row">
                <div class="form-group col-md-12">
                  <label><?= $this->lang->line('note') ? $this->lang->line('note') : 'Note' ?><span class="text-danger">*</span></label>
                  <textarea type="text" name="description" id="description" class="form-control"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn edit-note btn-block btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    $("#notes-modal").on('click', '.create-note', function(e) {
      var modal = $('#notes-modal');
      var form = $('#modal-add-notes-part');
      var formData = form.serialize();
      console.log(formData);
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

    });
    $("#modal-edit-notes").on('click', '.edit-note', function(e) {
      var modal = $('#modal-edit-notes');
      var form = $('#modal-edit-notes-part');
      var formData = form.serialize();
      console.log(formData);
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

    });
    $(document).on('click', '.btn_edit_notes', function(e) {
      e.preventDefault();
      var id = $(this).data("edit");
      $.ajax({
        type: "POST",
        url: base_url + 'notes/get_notes',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            $("#update_id").val(result['data'][0].id);
            $("#description").val(result['data'][0].description);
          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    });
    $(document).on('click', '.delete_notes', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: you_want_to_delete_this_note,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
		        url: base_url+'notes/delete/'+id, 
            data: "id=" + id,
            dataType: "json",
            success: function(result) {
              if (result['error'] == false) {
                location.reload();
              } else {
                iziToast.error({
                  title: result['message'],
                  message: "",
                  position: 'topRight'
                });
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>