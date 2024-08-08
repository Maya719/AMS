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
          <div class="col-xl-10 col-sm-9 mt-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-xl-2 col-sm-3">
            <a href="#" data-bs-toggle="modal" data-bs-target="#add-biometic-modal" class="btn  btn-block btn-primary">+
              ADD</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <div class="col-lg-4">
                      <select class="form-select select2" id="employee_id">
                        <option value="">
                          <?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></option>
                        <?php foreach ($system_users as $system_user) {
                          if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == '1' && $system_user->finger_config == '1') { ?>
                            <option value="<?= $system_user->employee_id ?>">
                              <?= htmlspecialchars($system_user->first_name) ?>
                              <?= htmlspecialchars($system_user->last_name) ?></option>
                        <?php }
                        } ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <select class="form-select select2" id="status">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <select class="form-select select2" id="dateFilter">
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
                  <table id="biom_list" class="table table-sm mb-0">
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
    <div class="modal fade" id="add-biometic-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('biometric_missing/create') ?>" method="POST" class="modal-part" id="modal-add-biometric-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">

            <div class="modal-body">
              <?php if ($this->ion_auth->is_admin() || permissions('biometric_request_view_all') || permissions('biometric_request_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'users' ?></label>
                  <select name="user_id" id="user_id_add" class="form-control select2">
                    <option value="">
                      <?= $this->lang->line('select_users') ? $this->lang->line('select_users') : 'Select Users' ?>
                    </option>
                    <?php foreach ($system_users as $system_user) {
                      if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?>
                          <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
              <?php } ?>

              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                <input type="text" name="date" class="form-control datepicker-default" required="">
              </div>

              <div class="form-group clockpicker mb-3">
                <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                <input class="form-control" name="time" id="timepicker">
              </div>

              <div class="form-group">
                <label class="col-form-label"><?= $this->lang->line('reason') ? $this->lang->line('reason') : 'Missing Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="reason" class="form-control" required=""></textarea>
              </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-biometric btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-biometic-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('biometric_missing/edit') ?>" method="POST" class="modal-part" id="modal-edit-biometric-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">

            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id">
              <?php if ($this->ion_auth->is_admin() || permissions('biometric_request_view_all') || permissions('biometric_request_view_selected')) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'users' ?></label>
                  <select name="user_id" id="edit_user" class="form-control select2">
                    <option value="">
                      <?= $this->lang->line('select_users') ? $this->lang->line('select_users') : 'Select Users' ?>
                    </option>
                    <?php foreach ($system_users as $system_user) {
                      if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?>
                          <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
              <?php } ?>

              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                <input type="text" name="date" id="date" class="form-control datepicker-default" required="">
              </div>

              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                <input class="form-control" name="time" id="timepicker2">
              </div>

              <div class="form-group mb-3">
                <label class="col-form-label"><?= $this->lang->line('reason') ? $this->lang->line('reason') : 'Missing Reason' ?><span class="text-danger">*</span></label>
                <textarea type="text" name="reason" id="reason" class="form-control" required=""></textarea>
              </div>

              <?php if ($this->ion_auth->is_admin() || permissions('biometric_request_status')) { ?>
                <div class="form-group">
                  <label class="col-form-label"><?= $this->lang->line('status') ? $this->lang->line('status') : 'Status' ?></label>
                  <select name="status" id="Edit_Status" class="form-control select2">
                    <option value="0">
                      <?= $this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending' ?>
                    </option>
                    <option value="1">
                      <?= $this->lang->line('approved') ? htmlspecialchars($this->lang->line('approved')) : 'Approved' ?>
                    </option>
                    <option value="2">
                      <?= $this->lang->line('rejected') ? htmlspecialchars($this->lang->line('rejected')) : 'Rejected' ?>
                    </option>
                  </select>
                </div>
              <?php } ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-edit-biometric btn-block btn-primary">Save</button>
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
      $(document).on('change', '#status, #employee_id,#dateFilter, #from,#too', function() {
        setFilter();
      });

      function setFilter() {
        var employee_id = $('#employee_id').val();
        var filterOption = $('#dateFilter').val();
        var status = $('#status').val();


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
            toDate = today;
            break;
          case "lmonth":
            fromDate = new Date(year, month - 1, 1);
            toDate = new Date(year, month, 0);
            break;
          case "tyear":
            fromDate = new Date(year, 0, 1);
            toDate = today;
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
        ajaxCall(employee_id, status, formattedFromDate, formattedToDate);
      }

      function ajaxCall(employee_id, status, from, too) {
        $.ajax({
          url: '<?= base_url('biometric_missing/get_biometric') ?>',
          type: 'GET',
          data: {
            user_id: employee_id,
            status: status,
            from: from,
            too: too
          },
          beforeSend: function() {
            showLoader();
          },
          success: function(response) {
            var tableData = JSON.parse(response);
            console.log(response);
            showTable(tableData);
          },
          complete: function() {
            hideLoader();
          },
          error: function(error) {
            console.error(error);
          }
        });
      }

      function showTable(data) {
        var table = $('#biom_list');
        if ($.fn.DataTable.isDataTable(table)) {
          table.DataTable().destroy();
        }
        emptyDataTable(table);
        var thead = table.find('thead');
        var theadRow = '<tr>';
        theadRow += '<th>ID</th>';
        theadRow += '<th>Employee Name</th>';
        theadRow += '<th>Reason</th>';
        theadRow += '<th>Date</th>';
        theadRow += '<th>Time</th>';
        theadRow += '<th>Status</th>';
        theadRow += '<th>Created</th>';
        <?php
        if (permissions('biometric_request_edit') || permissions('biometric_request_delete') || $this->ion_auth->is_admin()) {
        ?>
          theadRow += '<th>Action</th>';
        <?php
        }
        ?>
        theadRow += '</tr>';
        thead.html(theadRow);
        // Add table body
        var tbody = table.find('tbody');
        data.forEach(user => {
          var date = moment(user.date, 'YYYY-MM-DD').format(date_format_js);
          var created = moment(user.created, 'YYYY-MM-DD').format(date_format_js);
          var userRow = '<tr>';
          userRow += '<td>' + user.user_id + '</td>';
          userRow += '<td>' + user.user + '</td>';
          userRow += '<td>' + user.reason + '</td>';
          userRow += '<td>' + date + '</td>';
          userRow += '<td>' + user.time + '</td>';
          userRow += '<td>' + user.status + '</td>';
          userRow += '<td>' + created + '</td>';
          <?php
          if (permissions('biometric_request_edit') || permissions('biometric_request_delete') || $this->ion_auth->is_admin()) {
          ?>
            userRow += '<td>';
            userRow += '<div class="d-flex">';
            if (user.btn) {
              <?php
              if (permissions('biometric_request_edit') || $this->ion_auth->is_admin()) {
              ?>
                userRow += '<a href="#" class="text-primary edit-bio" data-id="' + user.id + '" data-bs-toggle="modal" data-bs-target="#edit-biometic-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a>';
              <?php
              }
              if (permissions('biometric_request_delete') || $this->ion_auth->is_admin()) {
              ?>
                userRow += '<a href="#" class="text-danger delete-bio ms-2" data-bs-toggle="tooltip" data-id="' + user.id + '" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a>';
              <?php
              }
              ?>
            } else {
              <?php
              if (permissions('biometric_request_edit') || $this->ion_auth->is_admin()) {
              ?>
                userRow += '<a href="#" class="text-muted" disabled><i class="fa fa-pencil"></i></a>';
              <?php
              }
              if (permissions('biometric_request_delete') || $this->ion_auth->is_admin()) {
              ?>
                userRow += '<a href="#" class="text-danger delete-bio ms-2" data-bs-toggle="tooltip" data-id="' + user.id + '" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a>';
              <?php
              }
              ?>
            }
            userRow += '</div>';
            userRow += '</td>';
          <?php
          }
          ?>
          userRow += '</tr>';
          tbody.append(userRow);
        });
        table.DataTable({
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
          "dom": '<"top"f>rt<"bottom"lp><"clear">',
          "order": [
            [6, "desc"]
          ]
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
    });
    var time24 = false;
    $('#timepicker').timepicker({
      format: 'HH:mm',
      showMeridian: true,
      time24Hour: time24
    });
  </script>
  <script>
    $("#add-biometic-modal").on('click', '.btn-create-biometric', function(e) {
      var modal = $('#add-biometic-modal');
      var form = $('#modal-add-biometric-part');
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
          console.log(result);
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
    $("#edit-biometic-modal").on('click', '.btn-edit-biometric', function(e) {
      var modal = $('#edit-biometic-modal');
      var form = $('#modal-edit-biometric-part');
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
    $(document).on('click', '.edit-bio', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'biometric_missing/get_biometric_by_id',
        data: "id=" + id,
        dataType: "json",
        beforeSend: function() {
          $(".modal-body").append(ModelProgress);
        },
        success: function(result) {
          if (result['error'] == false && result['data'] != '') {
            var date = moment(result['data'][0].date, 'YYYY-MM-DD').format(date_format_js);
            console.log(result);
            $("#update_id").val(result['data'][0].id);
            $("#employee_id").val(result['data'][0].employee_id);
            var user = result.data[0].user;
            console.log(user);
            $("#edit_user").val(user).trigger('change');
            $('#date').daterangepicker({
              locale: {
                format: date_format_js
              },
              singleDatePicker: true,
              startDate: date,
            });
            var time = moment(result['data'][0].time, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            // Initialize the timepicker
            $('#timepicker2').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            // Set the time in the timepicker
            $('#timepicker2').timepicker('setTime', time);
            $("#reason").val(result['data'][0].reason);
            var status = result.data[0].status;
            $('#Edit_Status').val(status).trigger('change');
          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });
    })
    $(document).on('click', '.delete-bio', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
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
            url: base_url + 'biometric_missing/delete/' + id,
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

    $('.select2').select2()
  </script>
  <script>
    $(document).ready(function() {
      function handleFilter(id) {
        const value = sessionStorage.getItem(id);
        if (value !== null) {
          $(`#${id}`).val(value).trigger('change');
        }

        $(`#${id}`).change(function() {
          sessionStorage.setItem(id, $(this).val());
          console.log(`${id.charAt(0).toUpperCase() + id.slice(1)} set to:`, $(this).val());
        });
      }
      handleFilter('employee_id');
      handleFilter('status');
    });
  </script>
</body>

</html>