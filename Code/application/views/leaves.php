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

        <div class="row d-flex justify-content-end">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="<?=base_url('leaves/create_leave')?>" class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <?php if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                      <div class="col-lg-3">
                        <select class="form-select" id="employee_id">
                          <option value=""><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></option>
                          <?php foreach ($system_users as $system_user) {
                            if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == '1' && $system_user->finger_config == '1') { ?>
                              <option value="<?= $system_user->employee_id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>
                    <?php
                    } ?>
                    <div class="col-lg-3">
                      <select class="form-select" id="leave_type">
                        <option value=""><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave type' ?></option>
                        <?php foreach ($leaves_types as $leaves_type) : ?>
                          <option value="<?= $leaves_type["id"] ?>"><?= htmlspecialchars($leaves_type["name"]) ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <select class="form-select" id="status_name">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <select class="form-select" id="dateFilter">
                        <option value="tmonth" selected>This Month</option>
                        <option value="lmonth">Last Month</option>
                        <option value="tyear">This Year</option>
                        <option value="lyear">last Year</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="table-responsive">
                  <table id="leave_list" class="table table-sm mb-0">
                    <thead>
                    </thead>
                    <tbody id="customers">
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
    <div class="modal fade" id="leave-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('leaves/create') ?>" method="POST" class="modal-part" id="modal-add-leaves-part">
            <div class="modal-body">
              <?php if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label required"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Users' ?></label>
                  <select name="user_id_add" id="user_id_add" class="form-control">
                    <option value=""><?= $this->lang->line('select_employee') ? $this->lang->line('select_employee') : 'Select Employee' ?></option>
                    <?php foreach ($system_users as $system_user) {
                      if ($system_user->saas_id == $this->session->userdata('saas_id') && ($system_user->finger_config == '1')) { ?>
                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
              <?php } ?>

              <div class="form-group mb-3">
                <label class="col-form-label required"><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                <select class="form-control" name="type_add" id="type_add">
                  <option value=""><?= $this->lang->line('select_type') ? $this->lang->line('select_type') : 'Select Type' ?></option>
                  <?php foreach ($leaves_types as $leaves) { ?>
                    <option value="<?= $leaves['id'] ?>"><?= $leaves['name'] ?></option>
                  <?php
                  } ?>
                </select>
              </div>

              <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                  <select name="paid" id="paidUnpaid" class="form-control">
                    <option value="0"><?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?></option>
                    <option value="1"><?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?></option>
                  </select>
                </div>
              <?php } ?>

              <div class="form-group form-check form-check-inline col-md-6 md-3 mb-3">
                <input class="form-check-input" type="checkbox" id="half_day" name="half_day">
                <label class="form-check-label text-danger" for="half_day"><?= $this->lang->line('half_day') ? $this->lang->line('half_day') : 'Half Day' ?></label>
              </div>

              <div class="form-group form-check form-check-inline col-md-5 mb-3">
                <input class="form-check-input" type="checkbox" id="short_leave" name="short_leave">
                <label class="form-check-label text-danger" for="short_leave"><?= $this->lang->line('short_leave') ? $this->lang->line('short_leave') : 'Short Leave' ?></label>
              </div>

              <div id="date_fields">
                <div id="full_day_dates" class="row">
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_date_create" name="starting_date" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_date_create" name="ending_date" class="form-control datepicker-default required">
                  </div>
                </div>

                <div id="half_day_date" class="row" style="display: none;">
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date_half" name="date_half" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                    <select name="half_day_period" class=" form-group form-control">
                      <option value="0">First Time</option>
                      <option value="1">Second Time</option>
                    </select>
                  </div>
                </div>
                <div id="short_leave_dates" class="row" style="display: none;">
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date" name="date" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                    <input type="text" name="starting_time" id="starting_time_create" class="form-control timepicker">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                    <input type="text" name="ending_time" id="ending_time_create" class="form-control timepicker">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="mb-3">
                  <label class="col-form-label"><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?> <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('if_any_leave_document') ? $this->lang->line('if_any_leave_document') : "If any Document according to leave/s." ?>"></i></label>
                  <input class="form-control" type="file" id="formFile">
                </div>
              </div>
              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="leave_reason" class="form-control"></textarea>
              </div>

              <div id="leaves_count" class="row text-center">
                <div class="col-md-4 form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('total_leaves') ? $this->lang->line('total_leaves') : 'Total Leaves' ?><i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('the_total_leaves_are_in_year_and_are_from_1st_Jan_to_31st_Dec_of_this_year') ? $this->lang->line('the_total_leaves_are_in_year_and_are_from_1st_Jan_to_31st_Dec_of_this_year') : "The Total leaves are in year and are from 1st Jan to 31st Dec of this year." ?>"></i></label>
                  <input type="number" style="border: none;" id="total_leaves" name="total_leaves" class="form-control text-center" readonly>
                </div>
                <div class="col-md-4 form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('consumed_leaves') ? $this->lang->line('consumed_leaves') : 'Consumed Leaves' ?></label>
                  <input type="number" style="border: none;" id="consumed_leaves" name="consumed_leaves" class="form-control text-center" readonly>
                </div>
                <div class="col-md-4 form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('remaining_leaves') ? $this->lang->line('remaining_leaves') : 'Remaining Leaves' ?></label>
                  <input style="border: none;" type="number" id="remaining_leaves" name="remaining_leaves" class="form-control text-center" readonly>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-leave btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-leave-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('leaves/edit') ?>" method="POST" class="modal-part" id="modal-edit-leaves-part">
            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id" value="">

              <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></label>
                  <select name="user_id" id="user_id" class="form-control select2">
                    <option value=""><?= $this->lang->line('select_employee') ? $this->lang->line('select_employee') : 'Select Employee' ?></option>
                    <?php foreach ($system_users as $system_user) {
                      if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
              <?php } ?>


              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                <select class="form-control select2" name="type" id="type">
                  <?php foreach ($leaves_types as $leaves) { ?>
                    <option value="<?= $leaves['id'] ?>"><?= $leaves['name'] ?></option>
                  <?php
                  } ?>
                </select>
              </div>

              <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                  <select name="paid" id="paid" class="form-control select2">
                    <option value="0"><?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?></option>
                    <option value="1"><?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?></option>
                  </select>
                </div>
              <?php } ?>


              <input type="hidden" name="leave_duration" id="leave_duration" value="">

              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('leave') ? $this->lang->line('leave') : 'Leave' ?><span class="text-danger">*</span></label>
                <input type="text" name="leave" id="leave" class="form-control" required="" readonly></input>
              </div>

              <div id="date_fields">
                <div id="full_day_dates_edit" class="row">
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_date" name="starting_date" class="form-control" required="">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_date" name="ending_date" class="form-control" required="">
                  </div>
                </div>

                <div id="half_day_date_edit" class="row" style="display: none;">
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date_half2" name="date_half" class="form-control datepicker-default" required="">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                    <select name="half_day_period" id="half_day_period" class=" form-group form-control select2">
                      <option value="0">First Time</option>
                      <option value="1">Second Time</option>
                    </select>
                  </div>
                </div>
                <div id="short_leave_dates_edit" class="row" style="display: none;">
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date5" name="date" class="form-control datepicker-default" required="">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_time" name="starting_time" class="form-control timepicker" required="">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label class="col-form-label"><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_time" name="ending_time" class="form-control timepicker" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="mb-3">
                  <label class="col-form-label"><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?> <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('if_any_leave_document') ? $this->lang->line('if_any_leave_document') : "If any Document according to leave/s." ?>"></i></label>
                  <input class="form-control" type="file" id="formFile">
                </div>
              </div>
              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="leave_reason" id="leave_reason" class="form-control" required=""></textarea>
              </div>
              <?php if ($this->ion_auth->is_admin() || permissions('leaves_status')) {
              ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('status') ? $this->lang->line('status') : 'Status' ?></label>
                  <select name="status" id="status" class="form-control">
                    <option value=""><?= $this->lang->line('select_status') ? $this->lang->line('select_status') : 'Select Status' ?></option>
                    <option value="0"><?= $this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending' ?></option>
                    <option value="1"><?= $this->lang->line('approve') ? htmlspecialchars($this->lang->line('approve')) : 'Approve' ?></option>
                    <option value="2"><?= $this->lang->line('reject') ? htmlspecialchars($this->lang->line('reject')) : 'Reject' ?></option>
                  </select>
                </div>
              <?php } ?>

            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-edit-leave btn-block btn-primary">Save</button>
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
  <script src="<?= base_url('assets2/js/leaves/leaves.js') ?>"></script>
  <script>
    $(document).ready(function() {
      setFilter();
      $(document).on('change', '#leave_type, #status_name, #employee_id,#dateFilter, #from,#too', function() {
        setFilter();
      });
    });
  </script>
</body>

</html>