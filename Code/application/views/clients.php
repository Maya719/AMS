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
    <?php $this->load->view('includes/sidebar'); ?>
    <div class="content-body default-height">
      <!-- row -->
      <div class="container-fluid">

        <?php
        if (permissions('client_create') || $this->ion_auth->is_admin()) {
        ?>
          <div class="row d-flex justify-content-end">
            <div class="col-xl-2 col-sm-3 mt-2 ">
              <a href="javascript:void(0);" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#client-add-modal" class="btn btn-block btn-primary">+ ADD</a>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="table-responsive">
                  <table id="employee_list" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Projects</th>
                        <?php if (permissions('client_edit') || permissions('client_delete') || $this->ion_auth->is_admin()) : ?>
                          <th>Action</th>
                        <?php endif ?>
                      </tr>
                    </thead>
                    <tbody id="customers">
                      <?php foreach ($system_users as $system_user) : ?>
                        <tr>
                          <td><?= $system_user["first_name"] . ' ' . $system_user["last_name"] ?></td>
                          <td><?= $system_user["email"] ?></td>
                          <td><?= $system_user["phone"] ?></td>
                          <?php
                          if ($system_user["active"] == 1) { ?>
                            <td><span class="badge light badge-success">Active</span></td>
                          <?php  } else {
                          ?>
                            <td><span class="badge light badge-danger">Inactive</span></td>
                          <?php
                          }
                          ?>
                          <td><span class="badge light badge-dark"><?= $system_user["projects_count"] ?></span></td>
                          <?php if (permissions('client_edit') || permissions('client_delete') || $this->ion_auth->is_admin()) : ?>
                            <td>
                              <div class="d-flex">
                                <?php if (permissions('client_edit') || $this->ion_auth->is_admin()) : ?>
                                  <span class="badge light badge-primary"><a href="javascript:void()" data-edit="<?= $system_user["id"] ?>" data-bs-toggle="modal" data-bs-target="#client-edit-modal" class="text-primary modal-edit-user" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                <?php endif ?>
                                <?php if (permissions('client_delete') || $this->ion_auth->is_admin()) : ?>
                                  <span class="badge light badge-danger ms-2"><a href="javascript:void()" class="text-danger btn-delete-client" data-edit="<?= $system_user["id"] ?>" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                                <?php endif ?>
                              </div>
                            </td>
                          <?php endif ?>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
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
    <div class="modal fade" id="client-add-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('auth/create-user') ?>" method="POST" class="modal-part" id="modal-add-client-part">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <input type="hidden" name="groups" value="4">
                  <label class="col-form-label"><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?><span class="text-danger">*</span></label>
                  <input type="text" name="first_name" class="form-control" required="">
                </div>
                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?><span class="text-danger">*</span></label>
                  <input type="text" name="last_name" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('company_name') ? $this->lang->line('company_name') : 'Company Name' ?></label>
                  <input type="text" name="company" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?><span class="text-danger">*</span> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_email_will_not_be_updated_latter') ? $this->lang->line('this_email_will_not_be_updated_latter') : 'This email will not be updated latter.' ?>"></i></label>
                  <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?></label>
                  <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?><span class="text-danger">*</span></label>
                  <input type="text" name="password" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('confirm_password') ? $this->lang->line('confirm_password') : 'Confirm Password' ?><span class="text-danger">*</span></label>
                  <input type="text" name="password_confirm" class="form-control">
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-holiday btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="client-edit-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('auth/edit-user') ?>" method="POST" class="modal-part" id="modal-edit-client-part">
            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id" value="">
              <input type="hidden" name="old_profile_pic" id="old_profile_pic" value="">
              <div class="row">

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?><span class="text-danger">*</span></label>
                  <input type="text" id="first_name" name="first_name" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?><span class="text-danger">*</span></label>
                  <input type="text" id="last_name" name="last_name" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('company_name') ? $this->lang->line('company_name') : 'Company Name' ?></label>
                  <input type="text" id="company22" name="company" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?></label>
                  <input type="text" id="phone22" name="phone" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') ? $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') : 'Leave Password and Confirm Password empty for no change in Password.' ?>"></i></label>
                  <input type="text" name="password" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('confirm_password') ? $this->lang->line('confirm_password') : 'Confirm Password' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') ? $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') : 'Leave Password and Confirm Password empty for no change in Password.' ?>"></i></label>
                  <input type="text" name="password_confirm" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="col-form-label"><?= $this->lang->line('role') ? $this->lang->line('role') : 'Role' ?><span class="text-danger">*</span></label>
                  <select name="groups" id="groups" class="form-control select2">
                    <?php foreach ($user_groups as $user_group) { ?>
                      <option value="<?= htmlspecialchars($user_group->id) ?>"><?= ucfirst(htmlspecialchars($user_group->name)) ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <button type="button" class="btn btn-edit-client btn-primary">Save</button>
              <button type="button" id="user_login_btn" class="btn btn-warning">Login</button>
              <button type="button" id="user_delete_btn" class="btn btn-danger btn-delete-client">Delete Account</button>
              <div class="" id="footerBTN">
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
    var table3 = $('#employee_list').DataTable({
      "paging": true,
      "searching": true,
      "language": {
        "paginate": {
          "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "lengthChange": true,
      "lengthMenu": [10, 20, 50, 500],
      "order": false,
      "pageLength": 10,
      "dom": '<"top"f>rt<"bottom"lp><"clear">'
    });


    $("#client-add-modal").on('click', '.btn-create-holiday', function(e) {
      var modal = $('#client-add-modal');
      var form = $('#modal-add-client-part');
      var formData = form.serialize();
      console.log(formData);

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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });

      e.preventDefault();
    });
    $("#client-edit-modal").on('click', '.btn-edit-client', function(e) {
      var modal = $('#client-edit-modal');
      var form = $('#modal-edit-client-part');
      var formData = form.serialize();
      console.log(formData);
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });

      e.preventDefault();
    });
    $(document).on('click', '.modal-edit-user', function(e) {
      e.preventDefault();

      let save_button = $(this);
      save_button.addClass('btn-progress');

      var id = $(this).data("edit");
      $.ajax({
        type: "POST",
        url: base_url + 'users/ajax_get_user_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          $("#update_id").val(result['data'].id);
          $("#company22").val(result['data'].company);
          $("#old_profile_pic").val(result['data'].profile);
          $("#first_name").val(result['data'].first_name);
          $("#father_name").val(result['data'].father_name);
          $("#last_name").val(result['data'].last_name);
          $("#groups").val(result['data'].group_id);
          $("#phone22").val(result['data'].phone == 0 ? '' : result['data'].phone);
          if (result['data'].active == 0) {
            $("#footerBTN").html('<button type="button" id="user_active_btn" class="btn btn-primary">Activite Account</button>');
          } else {
            $("#footerBTN").html('<button type="button" id="user_deactive_btn" class="btn btn-danger">deactivite Account</button>');
          }
          console.log(result);
        }
      });
    });
    $(document).on('click', '#user_deactive_btn', function(e) {
      e.preventDefault();
      var id = $("#update_id").val();
      Swal.fire({
        title: are_you_sure,
        text: you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation,
        icon: 'warning',
        showCancelButton: true,
        dangerMode: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'auth/deactivate',
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
    $(document).on('click', '.btn-delete-client', function(e) {
      e.preventDefault();
      if ($(this).data("edit")) {
        var id = $(this).data("edit");
      } else {
        var id = $("#update_id").val();
      }
      Swal.fire({
        title: are_you_sure,
        text: you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted,
        icon: 'warning',
        showCancelButton: true,
        dangerMode: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'auth/delete_user',
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
    $(document).on('click', '#user_active_btn', function(e) {
      e.preventDefault();
      var id = $("#update_id").val();
      Swal.fire({
        title: are_you_sure,
        text: you_want_to_activate_this_user,
        icon: 'warning',
        showCancelButton: true,
        dangerMode: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'auth/activate',
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
    $(document).on('click', '#user_login_btn', function(e) {
      e.preventDefault();
      var id = $("#update_id").val();
      Swal.fire({
        title: are_you_sure,
        text: you_will_be_logged_out_from_the_current_account,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'auth/login_as_admin',
            data: "id=" + id,
            dataType: "json",
            success: function(result) {
              if (result['error'] == false) {
                location.reload();
              } else {
                modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>