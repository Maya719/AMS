<?php $this->load->view('includes/header'); ?>
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
          <div class="col-xl-12">
            <div class="card">
              <div class="card-body">
                <form action="<?= base_url('auth/edit-user') ?>" method="post" id="form-part" enctype="multipart/form-data">
                  <input type="hidden" name="update_id" value="<?= htmlspecialchars($profile_user['id']) ?>">
                  <input type="hidden" name="old_profile_pic" value="<?= htmlspecialchars($profile_user['profile']) ?>">
                  <input type="hidden" name="groups" value="<?= htmlspecialchars($profile_user['group_id']) ?>">
                  <input type="hidden" name="active" value="<?= htmlspecialchars($profile_user['active']) ?>">
                  <input type="hidden" name="device" value="<?= htmlspecialchars($profile_user['device']) ?>">
                  <input type="hidden" name="finger_config" value="<?= htmlspecialchars($profile_user['finger_config']) ?>">
                  <input type="hidden" name="short_name" value="<?= htmlspecialchars($profile_user['short_name']) ?>">
                  <input type="hidden" name="department" value="<?= htmlspecialchars($profile_user['department']) ?>">
                  <input type="hidden" name="role" value="<?= htmlspecialchars($profile_user['role']) ?>">
                  <input type="hidden" name="type" value="<?= htmlspecialchars($profile_user['shift_id']) ?>">
                  <input type="hidden" name="status" value="<?= htmlspecialchars($profile_user['status']) ?>">
                  <div id="DZ_W_TimeLine" class="widget-timeline dlab-scroll p-5">
                    <ul class="timeline">
                      <li>
                        <div class="timeline-badge dark">
                        </div>
                        <div class="title">
                          <h5 class="text-primary ms-5 mt-2">Information</h5>
                        </div>
                        <div class="row ms-5">
                          <div class="col-6 mb-3">
                            <label for="employee_id_create" class="form-label">Employee ID</label>
                            <input type="number" class="form-control" name="employee_id" value="<?= htmlspecialchars($profile_user['employee_id']) ?>" id="employee_id_create" readonly>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($profile_user['first_name']) ?>" id="exampleFormControlInput1">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput2" class="form-label">last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($profile_user['last_name']) ?>" id="exampleFormControlInput2">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput301" class="form-label">Father Name</label>
                            <input type="text" class="form-control" name="father_name" value="<?= htmlspecialchars($profile_user['father_name']) ?>" id="exampleFormControlInput301">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Blood Group</label>
                            <input type="text" class="form-control" name="blood_group" value="<?= htmlspecialchars($profile_user['blood_group']) ?>" id="exampleFormControlInput3">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput4" class="form-label">Date Of Birth</label>
                            <input type="text" class="form-control datepicker-default" name="date_of_birth" value="<?= htmlspecialchars($profile_user['date_of_birth']) ?>" id="exampleFormControlInput4">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput5" class="form-label">CNIC</label>
                            <input type="text" class="form-control" name="cnic" value="<?= htmlspecialchars($profile_user['cnic']) ?>" id="exampleFormControlInput5">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput6" class="form-label">Martial Status</label>
                            <select class="form-select" name="martial_status" id="exampleFormControlInput6" aria-label="Default select example">
                              <option selected value="">Martial Status</option>
                              <option value="single" <?= $profile_user['martial_status'] === 'single' ? 'selected' : '' ?>>Single</option>
                              <option value="married" <?= $profile_user['martial_status'] === 'married' ? 'selected' : '' ?>>Married</option>
                            </select>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput7" class="form-label">Gender</label>
                            <select class="form-select" name="gender" id="exampleFormControlInput7" aria-label="Default select example">
                              <option value="male" <?= $profile_user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                              <option value="female" <?= $profile_user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                              <option value="other" <?= $profile_user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput8" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($profile_user['phone']) ?>" id="exampleFormControlInput8">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput9" class="form-label">Emergency Person</label>
                            <input type="text" class="form-control" name="emg_person" value="<?= htmlspecialchars($profile_user['emg_person']) ?>" id="exampleFormControlInput9">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput10" class="form-label">Emergency Contact</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($profile_user['emg_number']) ?>" name="emg_number" id="exampleFormControlInput10">
                          </div>
                          <div class="col-12 mb-3">
                            <label><?= $this->lang->line('user_profile') ? $this->lang->line('user_profile') : 'User Profile' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('leave_empty_for_no_changes') ? $this->lang->line('leave_empty_for_no_changes') : "Leave empty for no changes." ?>"></i></label>
                            <input class="form-control" type="file" name="profile" id="formFile">
                          </div>
                          <div class="col-12 mb-3">
                            <label for="exampleFormControlInput11" class="form-label">Address</label>
                            <textarea type="text" class="form-control" name="address" id="exampleFormControlInput11"><?= htmlspecialchars($profile_user['address']) ?></textarea>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-badge dark">
                        </div>
                        <div class="title">
                          <h5 class="text-primary ms-5 mt-2">Account Setting</h5>
                        </div>
                        <div class="row ms-5">
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput12" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($profile_user['email']) ?>" id="exampleFormControlInput12" readonly disabled>
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput13" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleFormControlInput13">
                          </div>
                          <div class="col-6 mb-3">
                            <label for="exampleFormControlInput14" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirm" class="form-control" id="exampleFormControlInput14">
                          </div>
                        </div>
                      </li>
                    </ul>
                    <div class="row ms-3 mt-5 mb-3 justify-content-between">
                      <div class="col-5">
                        <button type="button" class="btn btn-edit-user btn-primary">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
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
  <script>
    $(document).on('click', '.btn-edit-user', function(e) {
      var form = $('#form-part')[0];
      var formData = new FormData(form);

      // Append additional data if needed
      formData.append('custom_data', 'value');

      console.log(formData);
      $('.btn-edit-user').html(`<div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div> Submit`)
      $.ajax({
        type: 'POST',
        url: form.action,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {}
        }
      });

      e.preventDefault();
    });
  </script>

</body>

</html>