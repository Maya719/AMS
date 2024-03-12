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
        <div class="row d-flex justify-content-end">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#saas-add-modal" class="btn btn-block btn-primary">+ ADD</a>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Mobile</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($saas_users as $saas_user) : ?>
                        <tr>
                          <td><?= $saas_user["first_name"] . ' ' . $saas_user["last_name"] ?></td>
                          <td><a href="javascript:void(0);"><?= $saas_user["email"] ?></a></td>
                          <td><?= $saas_user["status"] ?></td>
                          <td><a href="javascript:void(0);"><strong><?= $saas_user["phone"] ?></strong></a></td>
                          <td>
                            <a href="#" class="btn btn-primary btn-edit-saas shadow btn-xs sharp me-1" data-id="<?= $saas_user["id"] ?>" data-bs-toggle="modal" data-bs-target="#saas-edit-modal"><i class="fas fa-pencil-alt"></i></a>
                          </td>
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
    <div class="modal fade" id="saas-add-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('auth/create-saas-admin') ?>" method="POST" class="modal-part" id="modal-add-user-part" data-title="<?= $this->lang->line('create_new_user') ? $this->lang->line('create_new_user') : 'Create New User' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?><span class="text-danger">*</span></label>
                  <input type="text" name="first_name" class="form-control" required="">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?><span class="text-danger">*</span></label>
                  <input type="text" name="last_name" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?><span class="text-danger">*</span> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_email_will_not_be_updated_latter') ? $this->lang->line('this_email_will_not_be_updated_latter') : 'This email will not be updated latter.' ?>"></i></label>
                  <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?></label>
                  <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?><span class="text-danger">*</span></label>
                  <input type="text" name="password" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label><?= $this->lang->line('confirm_password') ? $this->lang->line('confirm_password') : 'Confirm Password' ?><span class="text-danger">*</span></label>
                  <input type="text" name="password_confirm" class="form-control">
                </div>
                <input type="hidden" name="groups" value="3">
                <input type="hidden" name="create_saas_admin" value="1">
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-saas btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="saas-edit-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('auth/edit-user') ?>" method="POST" class="modal-part" id="modal-edit-saas-part" data-title="<?= $this->lang->line('edit_user') ? $this->lang->line('edit_user') : 'Edit User' ?>" data-btn_login="<?= $this->lang->line('login') ? $this->lang->line('login') : 'Login' ?>" data-btn_delete="<?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?>" data-btn_update="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>" data-btn_active="<?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?>" data-btn_deactive="<?= $this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive' ?>">
            <div class="modal-body">
              <form action="<?= base_url('auth/edit-user') ?>" method="POST" class="modal-part" id="modal-edit-user-part" data-title="<?= $this->lang->line('edit_user') ? $this->lang->line('edit_user') : 'Edit User' ?>" data-btn_login="<?= $this->lang->line('login') ? $this->lang->line('login') : 'Login' ?>" data-btn_delete="<?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?>" data-btn_update="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>" data-btn_active="<?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?>" data-btn_deactive="<?= $this->lang->line('deactive') ? $this->lang->line('deactive') : 'Deactive' ?>">
                <input type="hidden" name="update_id" id="update_id" value="">
                <input type="hidden" name="groups" value="3">
                <input type="hidden" name="old_profile_pic" id="old_profile_pic" value="">
                <div class="row">
                  <div class="form-group col-md-6 mb-3">
                    <label><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?><span class="text-danger">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control" required="">
                  </div>
                  <div class="form-group col-md-6 mb-3">
                    <label><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?><span class="text-danger">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control">
                  </div>
                  <div class="form-group col-md-6 mb-3">
                    <label><?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?></label>
                    <input type="text" id="phone" name="phone" class="form-control">
                  </div>
                  <div class="form-group col-md-6 mb-3">
                    <label><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') ? $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') : 'Leave Password and Confirm Password empty for no change in Password.' ?>"></i></label>
                    <input type="text" name="password" class="form-control">
                  </div>
                  <div class="form-group col-md-6 mb-3">
                    <label><?= $this->lang->line('confirm_password') ? $this->lang->line('confirm_password') : 'Confirm Password' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') ? $this->lang->line('leave_password_and_confirm_password_empty_for_no_change_in_password') : 'Leave Password and Confirm Password empty for no change in Password.' ?>"></i></label>
                    <input type="text" name="password_confirm" class="form-control">
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <div class="col-lg-12 d-flex justify-content-end" id="loffy-btn">

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
  <script src="<?= base_url('assets/js/page/saas-users.js') ?>"></script>
  <script>
    var table3 = $('#example3').DataTable({
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
  </script>
</body>

</html>