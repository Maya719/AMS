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

        <div class="row d-flex justify-content-end">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#holiday-add-modal" class="btn btn-block btn-primary">+ ADD</a>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="table-responsive">
                  <table id="holiday_list" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Holiday Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="customers">
                      <?php
                      foreach ($data as $value) {
                      ?>
                        <tr class="btn-reveal-trigger" height="20">
                          <td class="py-2 "> <?= $value["sn"] ?></td>
                          <td class="py-2 "> <?= $value["type"] ?></td>
                          <td class="py-2 "> <?= $value["starting_date"] ?></td>
                          <td class="py-2 "> <?= $value["ending_date"] ?></td>
                          <td class="py-2 "> <?= $value["remarks"] ?></td>
                          <td>
                            <div class="d-flex">
                              <span class="badge light badge-primary"><a href="javascript:void()" data-id="<?= $value["id"] ?>" data-bs-toggle="modal" data-bs-target="#holiday-edit-modal" class="text-primary btn-edit-holiday" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                              <span class="badge light badge-danger ms-2"><a href="javascript:void()" class="text-danger btn-delete-holiday" data-id="<?= $value["id"] ?>" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                            </div>
                          </td>
                        </tr>
                      <?php
                      } ?>
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
    <div class="modal fade" id="holiday-add-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('holiday/create') ?>" method="POST" class="modal-part" id="modal-add-holiday-part">
            <div class="modal-body">
              <div class="form-group mb-3">
                <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                <select name="type_add" id="type_add" class="form-control select2">
                  <option value="0"><?= $this->lang->line('national_day') ? $this->lang->line('national_day') : 'National Day' ?></option>
                  <option value="1"><?= $this->lang->line('rest_day') ? $this->lang->line('rest_day') : 'Rest Day' ?></option>
                  <option value="4"><?= $this->lang->line('religious_day') ? $this->lang->line('religious_day') : 'Religious Day' ?></option>
                  <option value="3"><?= $this->lang->line('unplanned') ? $this->lang->line('unplanned') : 'Unplanned' ?></option>
                </select>
              </div>
              <div class="row" id="dates">
                <div class="col-md-6 form-group mb-3">
                  <label><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                  <input type="text" id="starting_date_create" name="starting_date" class="form-control datepicker-default" required="">
                </div>
                <div class="col-md-6 form-group mb-3">
                  <label><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                  <input type="text" id="ending_date_create" name="ending_date" class="form-control datepicker-default" required="">
                </div>
              </div>
              <div class="form-group mb-3">
                <label><?= $this->lang->line('applyon') ? $this->lang->line('applyon') : 'Apply On' ?></label>
                <select name="applyforcreate" id="apply2" class="select2" style="width:100%;">
                  <option value="0"><?= $this->lang->line('all') ? $this->lang->line('all') : 'All Employee' ?></option>
                  <option value="1"><?= $this->lang->line('Department') ? $this->lang->line('Department') : 'Department' ?></option>
                  <option value="2"><?= $this->lang->line('Employee') ? $this->lang->line('Employee') : 'Selected Employee/s' ?></option>
                </select>
              </div>

              <div id="department2" class="form-group mb-3 hidden">
                <label><?= $this->lang->line('department') ? $this->lang->line('type') : 'Select Department/s' ?></label>
                <select name="department[]" class="select2" style="width:100%;" multiple="multiple">
                  <?php foreach ($departments as $department) { ?>
                    <option value="<?= $department['id'] ?>"><?= $department['department_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div id="users2" class="form-group mb-3 hidden">
                <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Select Employee/s' ?></label>
                <select name="users[]" class="form-control select2" multiple="multiple">
                  <?php foreach ($system_users as $system_user) {
                    if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                      <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label><?= $this->lang->line('remarks') ? $this->lang->line('remarks') : 'Remarks' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="remarks" class="form-control" required=""></textarea>
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
    <div class="modal fade" id="holiday-edit-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('holiday/edit') ?>" method="POST" class="modal-part" id="modal-edit-holiday-part">
            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id" value="">
              <div class="form-group mb-3">
                <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                <select name="type" id="type" class="form-control select2">
                  <option value="0"><?= $this->lang->line('national_day') ? $this->lang->line('national_day') : 'National Day' ?></option>
                  <option value="1"><?= $this->lang->line('rest_day') ? $this->lang->line('rest_day') : 'Rest Day' ?></option>
                  <option value="4"><?= $this->lang->line('religious_day') ? $this->lang->line('religious_day') : 'Religious Day' ?></option>
                  <option value="3"><?= $this->lang->line('unplanned') ? $this->lang->line('unplanned') : 'Unplanned' ?></option>
                </select>
              </div>
              <input type="hidden" name="leave_duration" id="leave_duration" value="">
              <div class="row" id="dates2">
                <div class="col-md-6 form-group mb-3">
                  <label><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                  <input type="text" id="starting_date2" name="starting_date" class="form-control datepicker-default" required="">
                </div>
                <div class="col-md-6 form-group mb-3">
                  <label><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                  <input type="text" id="ending_date" name="ending_date" class="form-control datepicker-default" required="">
                </div>
              </div>
              <div class="form-group mb-3">
                <label><?= $this->lang->line('applyfor') ? $this->lang->line('applyfor') : 'Apply for' ?></label>
                <select name="applyforedit" id="apply4" class="form-control select2">
                  <option value="0"><?= $this->lang->line('all') ? $this->lang->line('all') : 'All Users' ?></option>
                  <option value="1"><?= $this->lang->line('Department') ? $this->lang->line('Department') : 'Department' ?></option>
                  <option value="2"><?= $this->lang->line('users') ? $this->lang->line('users') : 'Selected User/s' ?></option>
                </select>
              </div>
              <div id="department" class="form-group mb-3 hidden">
                <label><?= $this->lang->line('department') ? $this->lang->line('type') : 'Select Department/s' ?></label>
                <select name="department[]" id="department3" class="form-control select2" multiple>
                  <?php foreach ($departments as $department) { ?>
                    <option value="<?= $department['id'] ?>"><?= $department['department_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div id="users" class="form-group mb-3 hidden">
                <label><?= $this->lang->line('department') ? $this->lang->line('type') : 'Select User/s' ?></label>
                <select name="users[]" id="users3" class="form-control select2" multiple>
                  <?php foreach ($system_users as $system_user) {
                    if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                      <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                  <?php }
                  } ?>
                </select>
              </div>

              <div class="form-group mb-3">
                <label><?= $this->lang->line('remarks') ? $this->lang->line('remarks') : 'Remarks' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="remarks" id="remarks" class="form-control" required=""></textarea>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-edit-holiday btn-block btn-primary">Save</button>
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
    var table3 = $('#holiday_list').DataTable({
      language: {
        paginate: {
          next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "searching": false,
      "dom": '<"top"i>rt<"bottom"lp><"clear">',
      "lengthMenu": [5, 10, 15],

    });
    $(document).ready(function() {
      $('#apply2').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue == '1') {
          $('#department2').removeClass('hidden');
        } else {
          $('#department2').addClass('hidden');
        }
        if (selectedValue == '2') {
          $('#users2').removeClass('hidden');
        } else {
          $('#users2').addClass('hidden');
        }
      });
    });
    $(".select2").select2();
  </script>
  <script>
    $("#holiday-add-modal").on('click', '.btn-create-holiday', function(e) {
      var modal = $('#holiday-add-modal');
      var form = $('#modal-add-holiday-part');
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
    
    $("#holiday-edit-modal").on('click', '.btn-edit-holiday', function(e) {
      var modal = $('#holiday-edit-modal');
      var form = $('#modal-edit-holiday-part');
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
    $(document).ready(function() {
      $('#apply4').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue == '1') {
          $('#department').removeClass('hidden');
        } else {
          $('#department').addClass('hidden');
        }
        if (selectedValue == '2') {
          $('#users').removeClass('hidden');
        } else {
          $('#users').addClass('hidden');
        }
      });
    });
    $(document).on('click', '.btn-edit-holiday', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      $.ajax({
        type: "POST",
        url: base_url + 'holiday/get_holiday_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result['error'] == false && result['data'] != '') {
            $("#update_id").val(result['data'].id);
            $("#holiday_duration").val(result['data'].leave_duration);

            var startingDate = moment(result['data'].starting_date, 'YYYY-MM-DD').format(date_format_js);
            var endingDate = moment(result['data'].ending_date, 'YYYY-MM-DD').format(date_format_js);

            $('#starting_date2').daterangepicker({
              locale: {
                format: date_format_js
              },
              singleDatePicker: true,
              startDate: startingDate,
            });

            var endingDatePicker = $('#ending_date').daterangepicker({
              locale: {
                format: date_format_js
              },
              singleDatePicker: true,
              startDate: startingDate,
              minDate: moment(startingDate, date_format_js).startOf('day')
            });

            $('#starting_date2').on('apply.daterangepicker', function(ev, picker) {
              endingDatePicker.data('daterangepicker').minDate = picker.startDate.startOf('day');

              if (endingDatePicker.data('daterangepicker').startDate.isBefore(picker.startDate)) {
                endingDatePicker.data('daterangepicker').setStartDate(picker.startDate);
              }
            });
            $("#remarks").val(result['data'].remarks);
            $("#remarks").trigger("change");
            $("#type").val(result['data'].type);
            $("#type").trigger("change");
            $("#apply4").val(result['data'].apply);
            $("#apply4").trigger("change");
            if (result['data'].apply == '1') {
              $('#department').removeClass('hidden');
              if (result['data'].department != '' && result['data'].department != null) {
                $("#department3").val(result['data'].department.split(','));
                $("#department3").trigger("change");
              }
            }
            if (result['data'].apply == '2') {
              $('#users').removeClass('hidden');
              if (result['data'].users != '' && result['data'].users != null) {
                $("#users3").val(result['data'].users.split(','));
                $("#users3").trigger("change");
              }
            }
            //  $("#users3").val(["CA", "HA"]).trigger("change");

            $("#holiday-edit-modal").trigger("click");

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
    $(document).on('click', '.btn-delete-holiday', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'holiday/delete/' + id,
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