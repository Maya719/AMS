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
            <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#leave-modal" class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <?php if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                      <div class="col-lg-3 mb-3">
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
                    <div class="col-lg-3 mb-3">
                      <select class="form-select" id="leave_type">
                        <option value=""><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave type' ?></option>
                        <?php foreach ($leaves_types as $leaves_type) : ?>
                          <option value="<?= $leaves_type["id"] ?>"><?= htmlspecialchars($leaves_type["name"]) ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                      <select class="form-select" id="status_name">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-3 mb-3">
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
              <div class="card-body">
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
                  <label class="required"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Users' ?></label>
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
                <label class="required"><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
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
                  <label><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
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
                    <label><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_date_create" name="starting_date" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_date_create" name="ending_date" class="form-control datepicker-default required">
                  </div>
                </div>

                <div id="half_day_date" class="row" style="display: none;">
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date_half" name="date_half" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                    <select name="half_day_period" class=" form-group form-control">
                      <option value="0">First Time</option>
                      <option value="1">Second Time</option>
                    </select>
                  </div>
                </div>
                <div id="short_leave_dates" class="row" style="display: none;">
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date" name="date" class="form-control datepicker-default required">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                    <input type="text" name="starting_time" id="starting_time_create" class="form-control timepicker">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                    <input type="text" name="ending_time" id="ending_time_create" class="form-control timepicker">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="mb-3">
                  <label><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?> <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('if_any_leave_document') ? $this->lang->line('if_any_leave_document') : "If any Document according to leave/s." ?>"></i></label>
                  <input class="form-control" type="file" id="formFile">
                </div>
              </div>
              <div class="form-group mb-3">
                <label><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="leave_reason" class="form-control"></textarea>
              </div>

              <div id="leaves_count" class="row text-center">
                <div class="col-md-4 form-group mb-3">
                  <label><?= $this->lang->line('total_leaves') ? $this->lang->line('total_leaves') : 'Total Leaves' ?><i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('the_total_leaves_are_in_year_and_are_from_1st_Jan_to_31st_Dec_of_this_year') ? $this->lang->line('the_total_leaves_are_in_year_and_are_from_1st_Jan_to_31st_Dec_of_this_year') : "The Total leaves are in year and are from 1st Jan to 31st Dec of this year." ?>"></i></label>
                  <input type="number" style="border: none;" id="total_leaves" name="total_leaves" class="form-control text-center" readonly>
                </div>
                <div class="col-md-4 form-group mb-3">
                  <label><?= $this->lang->line('consumed_leaves') ? $this->lang->line('consumed_leaves') : 'Consumed Leaves' ?></label>
                  <input type="number" style="border: none;" id="consumed_leaves" name="consumed_leaves" class="form-control text-center" readonly>
                </div>
                <div class="col-md-4 form-group mb-3">
                  <label><?= $this->lang->line('remaining_leaves') ? $this->lang->line('remaining_leaves') : 'Remaining Leaves' ?></label>
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
                  <label><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></label>
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
                <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                <select class="form-control select2" name="type" id="type">
                  <?php foreach ($leaves_types as $leaves) { ?>
                    <option value="<?= $leaves['id'] ?>"><?= $leaves['name'] ?></option>
                  <?php
                  } ?>
                </select>
              </div>

              <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                  <select name="paid" id="paid" class="form-control select2">
                    <option value="0"><?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?></option>
                    <option value="1"><?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?></option>
                  </select>
                </div>
              <?php } ?>


              <input type="hidden" name="leave_duration" id="leave_duration" value="">

              <div class="form-group mb-3">
                <label><?= $this->lang->line('leave') ? $this->lang->line('leave') : 'Leave' ?><span class="text-danger">*</span></label>
                <input type="text" name="leave" id="leave" class="form-control" required="" readonly></input>
              </div>

              <div id="date_fields">
                <div id="full_day_dates_edit" class="row">
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_date" name="starting_date" class="form-control" required="">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_date" name="ending_date" class="form-control" required="">
                  </div>
                </div>

                <div id="half_day_date_edit" class="row" style="display: none;">
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date_half2" name="date_half" class="form-control datepicker-default" required="">
                  </div>
                  <div class="col-md-6 form-group mb-3">
                    <label><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                    <select name="half_day_period" id="half_day_period" class=" form-group form-control select2">
                      <option value="0">First Time</option>
                      <option value="1">Second Time</option>
                    </select>
                  </div>
                </div>
                <div id="short_leave_dates_edit" class="row" style="display: none;">
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                    <input type="text" id="date" name="date" class="form-control" required="">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                    <input type="text" id="starting_time" name="starting_time" class="form-control timepicker" required="">
                  </div>
                  <div class="col-md-4 form-group mb-3">
                    <label><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                    <input type="text" id="ending_time" name="ending_time" class="form-control timepicker" required="">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="mb-3">
                  <label><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?> <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('if_any_leave_document') ? $this->lang->line('if_any_leave_document') : "If any Document according to leave/s." ?>"></i></label>
                  <input class="form-control" type="file" id="formFile">
                </div>
              </div>
              <div class="form-group mb-3">
                <label><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="leave_reason" id="leave_reason" class="form-control" required=""></textarea>
              </div>

              <?php if ($this->ion_auth->in_group(1) || permissions('leaves_status')) {
              ?>
                <div class="form-group mb-3">
                  <label><?= $this->lang->line('status') ? $this->lang->line('status') : 'Status' ?></label>
                  <select name="status" id="status" class="form-control">
                    <option value=""><?= $this->lang->line('select_status') ? $this->lang->line('select_status') : 'Select Status' ?></option>
                    <option value="0"><?= $this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending' ?></option>
                    <option value="1"><?= $this->lang->line('approved') ? htmlspecialchars($this->lang->line('approved')) : 'Approved' ?></option>
                    <option value="2"><?= $this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected' ?></option>
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
  <script>
    $(document).ready(function() {
      setFilter();
      $(document).on('change', '#leave_type, #status_name, #employee_id,#dateFilter, #from,#too', function() {
        setFilter();
      });

      function setFilter() {
        var employee_id = $('#employee_id').val();
        var leave_type = $('#leave_type').val();
        var filterOption = $('#dateFilter').val();
        var status = $('#status_name').val();

        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth();
        const day = today.getDate();

        let fromDate, toDate;

        switch (filterOption) {
          case "today":
            fromDate = new Date(year, month, day);
            toDate = new Date(year, month, day);
            break;
          case "ystdy":
            fromDate = new Date(year, month, day - 1);
            toDate = new Date(year, month, day - 1);
            break;
          case "tweek":
            fromDate = new Date(year, month, day - today.getDay());
            toDate = new Date(year, month, day);
            break;
          case "lweek":
            fromDate = new Date(year, month, day - today.getDay() - 7);
            toDate = new Date(year, month, day - today.getDay() - 1);
            break;
          case "tmonth":
            fromDate = new Date(year, month, 1);
            toDate = new Date(year, month + 1, 0);
            break;
          case "lmonth":
            fromDate = new Date(year, month - 1, 1);
            toDate = new Date(year, month, 0);
            break;
          case "tyear":
            fromDate = new Date(year, 0, 1);
            toDate = new Date(year, 11, 31);
            break;
          case "lyear":
            fromDate = new Date(year - 1, 0, 1);
            toDate = new Date(year - 1, 11, 31);
            break;
          default:
            console.error("Invalid filter option:", filterOption);
            return null;
        }

        // Format dates as strings
        var formattedFromDate = formatDate(fromDate, "Y-m-d");
        var formattedToDate = formatDate(toDate, "Y-m-d");
        ajaxCall(employee_id, leave_type, status, formattedFromDate, formattedToDate);
      }

      function ajaxCall(employee_id, leave_type, status, from, too) {
        $.ajax({
          url: '<?= base_url('leaves/get_leaves') ?>',
          type: 'GET',
          data: {
            user_id: employee_id,
            leave_type: leave_type,
            status: status,
            from: from,
            too: too
          },
          success: function(response) {
            var tableData = JSON.parse(response);
            console.log(tableData);
            showTable(tableData);
          },
          complete: function() {},
          error: function(error) {
            console.error(error);
          }
        });
      }

      function showTable(data) {
        var table = $('#leave_list');
        if ($.fn.DataTable.isDataTable(table)) {
          table.DataTable().destroy();
        }
        emptyDataTable(table);
        var thead = table.find('thead');
        var theadRow = '<tr>';
        theadRow += '<th style="font-size: 15px;">ID</th>';
        theadRow += '<th style="font-size: 15px;">Employee Name</th>';
        theadRow += '<th style="font-size: 15px;">Type</th>';
        theadRow += '<th style="font-size: 15px;">Reason</th>';
        theadRow += '<th style="font-size: 15px;">Duration</th>';
        theadRow += '<th style="font-size: 15px;">Starting Time</th>';
        theadRow += '<th style="font-size: 15px;">Ending Time</th>';
        theadRow += '<th style="font-size: 15px;">Paid</th>';
        theadRow += '<th style="font-size: 15px;">Status</th>';
        theadRow += '<th style="font-size: 15px;">Action</th>';
        theadRow += '</tr>';
        thead.html(theadRow);

        // Add table body
        var tbody = table.find('tbody');

        data.forEach(user => {
          var userRow = '<tr>';
          userRow += '<td style="font-size:13px;">' + user.user_id + '</td>';
          userRow += '<td style="font-size:13px;">' + user.user + '</td>';
          userRow += '<td style="font-size:13px;">' + user.name + '</td>';
          userRow += '<td style="font-size:13px;">' + user.leave_reason + '</td>';
          userRow += '<td style="font-size:13px;">' + user.leave_duration + '</td>';
          userRow += '<td style="font-size:13px;">' + user.starting_date + ' ' + user.starting_time + '</td>';
          userRow += '<td style="font-size:13px;">' + user.ending_date + ' ' + user.ending_time + '</td>';
          userRow += '<td style="font-size:13px;">' + user.paid + '</td>';
          userRow += '<td style="font-size:13px;">' + user.status + '</td>';
          userRow += '<td>';
          userRow += '<div class="d-flex">';
          if (user.btn) {
            userRow += '<span class="badge light badge-primary"><a href="javascript:void()" data-id="' + user.id + '" data-bs-toggle="modal" data-bs-target="#edit-leave-modal" class="text-primary edit-leaves" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>';
            userRow += '<span class="badge light badge-danger ms-2"><a data-id="' + user.id + '" href="javascript:void()" class="text-danger delete_leaves" data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>';
          } else {
            userRow += '<span class="badge light badge-light"><a href="javascript:void()" data-id="' + user.id + '" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Disabled" disabled><i class="fa fa-pencil color-muted"></i></a></span>';
            userRow += '<span class="badge light badge-light ms-2"><a data-id="' + user.id + '" href="javascript:void()" class="text-danger" data-bs-toggle="tooltip" data-placement="top" title="Disabled"><i class="fas fa-trash"></i></a></span>';
          }

          userRow += '</div>';
          userRow += '</td>';
          userRow += '</tr>';
          tbody.append(userRow);
        });
        table.DataTable({
          "paging": true,
          "searching": false,
          "language": {
            "paginate": {
              "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
              "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
          },
          "info": false,
          "dom": '<"top"i>rt<"bottom"lp><"clear">',
          "lengthMenu": [5, 10, 20],
          "pageLength": 5
        });
      }

      function emptyDataTable(table) {
        table.find('thead').empty();
        table.find('tbody').empty();
      }

      function formatDate(date, format) {
        const options = {
          year: 'numeric',
          month: '2-digit',
          day: '2-digit'
        };
        const formattedDate = date.toLocaleDateString('en-US', options);
        return format
          .replace("Y", date.getFullYear())
          .replace("m", formattedDate.slice(0, 2))
          .replace("d", formattedDate.slice(3, 5));
      }
      $('#half_day').change(function() {
        if ($(this).is(':checked')) {
          $('#full_day_dates').hide();
          $('#short_leave').prop('checked', false);
          $('#short_leave_dates').hide();
          $('#half_day_date').show();
        } else {
          $('#full_day_dates').show();
          $('#half_day_date').hide();
        }
      });

      $('#short_leave').change(function() {
        if ($(this).is(':checked')) {
          $('#full_day_dates').hide();
          $('#half_day').prop('checked', false);
          $('#half_day_date').hide();
          $('#short_leave_dates').show();
        } else {
          $('#full_day_dates').show();
          $('#short_leave_dates').hide();
        }
      });

    });
  </script>

  <script>
    $(document).ready(function() {
      $('select[name="user_id_add"]').on('change', function() {
        updateLeaveCounts();
      });

      $('select[name="type_add"]').on('change', function() {
        updateLeaveCounts();
      });

      $('.btn-create').on('click', function() {
        updateLeaveCounts();
      });

      function updateLeaveCounts() {
        var type = $('select[name="type_add"]').val();
        var user_id = $('select[name="user_id_add"]').val();
        $.ajax({
          url: '<?= base_url('leaves/get_leaves_count') ?>',
          method: 'POST',
          dataType: 'json',
          data: {
            user_id: user_id,
            type: type
          },
          success: function(response) {
            var totalLeaves = response.total_leaves;
            var consumedLeaves = response.consumed_leaves;
            var remainingLeaves = response.remaining_leaves;
            var query = response.query;

            $('#total_leaves').val(totalLeaves);
            $('#consumed_leaves').val(consumedLeaves);
            if (remainingLeaves == 0) {
              $('#paidUnpaid').prop('disabled', true);
              $('#paidUnpaid').val('1');
              $("#paidUnpaid").trigger("change");
            } else {
              $('#paidUnpaid').prop('disabled', false);
              $('#paidUnpaid').val('0');
              $("#paidUnpaid").trigger("change");
            }
            $('#remaining_leaves').val(remainingLeaves);
          },
        });
      }
    });
    // leaves
    $("#leave-modal").on('click', '.btn-create-leave', function(e) {
      var modal = $('#leave-modal');
      var form = $('#modal-add-leaves-part');
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

    $(document).on('click', '.delete_leaves', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'leaves/delete/' + id,
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
    $(document).on('click', '.edit-leaves', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'leaves/get_leaves_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result['error'] == false && result['data'] != '') {
            $("#update_id").val(result['data'][0].id);
            $("#user_id").val(result['data'][0].user_id);
            $("#user_id").trigger("change");
            $("#leave_duration").val(result['data'][0].leave_duration);

            var startingDate = moment(result['data'][0].starting_date, 'YYYY-MM-DD').format(date_format_js);
            var endingDate = moment(result['data'][0].ending_date, 'YYYY-MM-DD').format(date_format_js);
            var startingTime = moment(result['data'][0].starting_time, 'HH:mm:ss').format(time_format_js);
            var endingTime = moment(result['data'][0].ending_time, 'HH:mm:ss').format(time_format_js);

            if (result['data'][0].leave_duration.includes('Full')) {

              $('#starting_date').daterangepicker({
                locale: {
                  format: date_format_js
                },
                singleDatePicker: true,
                startDate: startingDate,
              });

              $('#ending_date').daterangepicker({
                locale: {
                  format: date_format_js
                },
                singleDatePicker: true,
                startDate: endingDate,
                minDate: startingDate

              });

              $('#full_day_dates_edit').show();
              $('#short_leave_dates_edit').hide();
              $('#half_day_date_edit').hide();
              $("#leave").val('Full Day Leave');
            } else if (result['data'][0].leave_duration.includes('Short')) {
              $('#date').daterangepicker({
                locale: {
                  format: date_format_js
                },
                singleDatePicker: true,
                startDate: startingDate,
              });

              var time24 = true;
              $('#starting_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                time24Hour: time24
              });
              $('#starting_time').timepicker('setTime', startingTime);

              $('#ending_time').timepicker({
                format: 'HH:mm',
                showMeridian: false,
                time24Hour: time24

              });
              $('#ending_time').timepicker('setTime', endingTime);

              $('#full_day_dates_edit').hide();
              $('#short_leave_dates_edit').show();
              $('#half_day_date_edit').hide();
              $("#leave").val('Short Leave');
            } else if (result['data'][0].leave_duration.includes('Half')) {
              console.log(endingDate);
              $('#date_half2').daterangepicker({
                locale: {
                  format: date_format_js
                },
                singleDatePicker: true,
                startDate: endingDate,
              });

              if (result['data'][0].leave_duration.includes('First')) {
                var half_day_periods = "0";
              } else {
                var half_day_periods = "1";
              }
              $("#leave").val('Half Day Leave');
              $("#half_day_period").val(half_day_periods);
              $("#half_day_period").trigger('change');
              $('#full_day_dates_edit').hide();
              $('#short_leave_dates_edit').hide();
              $('#half_day_date_edit').show();
            }

            $("#leave_reason").val(result['data'][0].leave_reason);
            $("#leave_reason").trigger("change");
            $("#status").val(result['data'][0].status);
            $("#status").trigger("change");
            $("#type").val(result['data'][0].type);
            $("#type").trigger("change");
            $("#paid").val(result['data'][0].paid);
            $("#paid").trigger("change");
            $("#modal-edit-leaves").trigger("click");

          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    })
    $("#edit-leave-modal").on('click', '.btn-edit-leave', function(e) {
      var modal = $('#edit-leave-modal');
      var form = $('#modal-edit-leaves-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });
  </script>
  <script>
    $(document).on('change', '#starting_date_create', function(e) {
      closeEnddate();
    });
    $(document).ready(function() {
      closeEnddate();

    });

    function closeEnddate() {
      var starting_date_create = $('#starting_date_create').val();
      $('#ending_date_create').daterangepicker({
        locale: {
          format: date_format_js
        },
        singleDatePicker: true,
        minDate: moment(starting_date_create, date_format_js).toDate()
      });
    }


    $(document).on('change', '#starting_date', function(e) {
      closeEnddate2();
    });

    function closeEnddate2() {
      var starting_date_create = $('#starting_date').val();
      $('#ending_date').daterangepicker({
        locale: {
          format: date_format_js
        },
        singleDatePicker: true,
        minDate: moment(starting_date_create, date_format_js).toDate()
      });
    }
  </script>
</body>

</html>