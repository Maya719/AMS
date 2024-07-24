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
          <div class="col-xl-2 col-sm-3">
            <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#support-modal" class="btn btn-block btn-primary mb-2">+ ADD</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                    <select class="form-control select2" id="support_filter_status">
                      <option value=""><?= $this->lang->line('select_status') ? htmlspecialchars($this->lang->line('select_status')) : 'Select Status' ?></option>
                      <?php if ($this->ion_auth->in_group(3)) { ?>
                        <option value="1"><?= $this->lang->line('received') ? htmlspecialchars($this->lang->line('received')) : 'Received' ?></option>
                      <?php } else { ?>
                        <option value="1"><?= $this->lang->line('sent') ? htmlspecialchars($this->lang->line('sent')) : 'Sent' ?></option>
                      <?php } ?>
                      <option value="2"><?= $this->lang->line('opened_and_resolving') ? htmlspecialchars($this->lang->line('opened_and_resolving')) : 'Opened and Resolving' ?></option>
                      <option value="3"><?= $this->lang->line('resolved_and_closed') ? htmlspecialchars($this->lang->line('resolved_and_closed')) : 'Resolved and Closed' ?></option>
                    </select>
                  </div>
                  <?php if (is_saas_admin()) { ?>
                    <div class="col-lg-3">
                      <select class="form-control select2" id="support_filter_user">
                        <option value=""><?= $this->lang->line('select_users') ? $this->lang->line('select_users') : 'Select Users' ?></option>
                        <?php foreach ($system_users as $system_user) { ?>
                          <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  <?php } ?>
                  <div class="form-group col-md-3">
                    <input type="text" name="from" id="from" class="form-control datepicker-default" placeholder="From Date">
                  </div>
                  <div class="form-group col-md-3">
                    <input type="text" name="too" id="too" class="form-control datepicker-default" placeholder="To Date">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="table-responsive">
                  <table id="supports_list" class="table table-sm mb-0">
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
    <div class="modal fade" id="support-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('support/create') ?>" method="POST" class="modal-part" id="modal-add-support-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
            <div class="modal-body">
              <?php if (is_saas_admin()) { ?>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('select_users') ? $this->lang->line('select_users') : 'Select Users' ?></label>
                  <select name="user_id" class="form-control select2">
                    <?php foreach ($system_users as $system_user) { ?>
                      <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label class="col-form-label"><?= $this->lang->line('status') ? htmlspecialchars($this->lang->line('status')) : 'Status' ?></label>
                  <select name="status" class="form-control select2">
                    <option value="1"><?= $this->lang->line('received') ? htmlspecialchars($this->lang->line('received')) : 'Received' ?></option>
                    <option value="2"><?= $this->lang->line('opened_and_resolving') ? htmlspecialchars($this->lang->line('opened_and_resolving')) : 'Opened and Resolving' ?></option>
                    <option value="3"><?= $this->lang->line('resolved_and_closed') ? htmlspecialchars($this->lang->line('resolved_and_closed')) : 'Resolved and Closed' ?></option>
                  </select>
                </div>
              <?php } ?>
              <div class="form-group">
                <label class="col-form-label"><?= $this->lang->line('ticket') ? htmlspecialchars($this->lang->line('ticket')) : 'Ticket' ?> <?= $this->lang->line('subject') ? htmlspecialchars($this->lang->line('subject')) : 'Subject' ?></label>
                <input type="text" name="subject" class="form-control">
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-support btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-support-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('support/edit') ?>" method="POST" class="modal-part" id="modal-edit-support-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
            <div class="modal-body">
              <input type="hidden" name="update_id" id="update_id">
              <?php if (is_saas_admin()) { ?>
                <div class="form-group mt-3">
                  <label class="col-form-label"><?= $this->lang->line('select_users') ? $this->lang->line('select_users') : 'Select Users' ?></label>
                  <select name="user_id" id="user_id" class="form-control select2">
                    <?php foreach ($system_users as $system_user) { ?>
                      <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group mt-3">
                  <label class="col-form-label"><?= $this->lang->line('status') ? htmlspecialchars($this->lang->line('status')) : 'Status' ?></label>
                  <select name="status" id="status" class="form-control select2">
                    <option value="1"><?= $this->lang->line('received') ? htmlspecialchars($this->lang->line('received')) : 'Received' ?></option>
                    <option value="2"><?= $this->lang->line('opened_and_resolving') ? htmlspecialchars($this->lang->line('opened_and_resolving')) : 'Opened and Resolving' ?></option>
                    <option value="3"><?= $this->lang->line('resolved_and_closed') ? htmlspecialchars($this->lang->line('resolved_and_closed')) : 'Resolved and Closed' ?></option>
                  </select>
                </div>
              <?php } ?>
              <div class="form-group mt-3">
                <label class="col-form-label"><?= $this->lang->line('ticket') ? htmlspecialchars($this->lang->line('ticket')) : 'Ticket' ?> <?= $this->lang->line('subject') ? htmlspecialchars($this->lang->line('subject')) : 'Subject' ?></label>
                <input type="text" name="subject" id="subject" class="form-control">
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-edit-support btn-block btn-primary">Save</button>
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
      $(document).on('change', '#support_filter_status, #support_filter_user, #from,#too', function() {
        setFilter();
      });

      function setFilter() {
        var too = $('#too').val();
        var from = $('#from').val();
        var user_id = $('#support_filter_user').val();
        var status = $('#support_filter_status').val();
        ajaxCall(status, user_id, from, too);
      }
    });

    function ajaxCall(status, user_id, from, too) {
      $.ajax({
        url: base_url + 'support/get_support',
        type: 'GET',
        data: {
          user_id: user_id,
          status: status,
          from: from,
          too: too
        },
        beforeSend: function() {
          showLoader();
        },
        success: function(response) {
          var tableData = JSON.parse(response);
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
      console.log(data);
      var table = $('#supports_list');
      if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
      }
      emptyDataTable(table);
      var thead = table.find('thead');
      var theadRow = '<tr>';
      theadRow += '<th>TicketID</th>';
      <?php if (is_saas_admin()) { ?>
        theadRow += '<th>Users</th>';
      <?php } ?>
      theadRow += '<th>Ticket</th>';
      theadRow += '<th>Created</th>';
      theadRow += '<th>Status</th>';
      theadRow += '<th>Action</th>';
      theadRow += '</tr>';

      thead.html(theadRow);
      var tbody = table.find('tbody');
      data.rows.forEach(user => {
        var userRow = '<tr>';
        userRow += '<td style="font-size:13px;">#00000' + user.id + '</td>';
        <?php if (is_saas_admin()) { ?>
          userRow += '<td>' + user.user + '</td>';
        <?php } ?>
        userRow += '<td style="font-size:13px;">' + user.subject + '</td>';
        userRow += '<td style="font-size:13px;">' + user.created + '</td>';
        userRow += '<td style="font-size:13px;">' + user.status + '</td>';
        userRow += '<td>' + user.action + '</td>';
        userRow += '</tr>';
        tbody.append(userRow);
      });

      $('#supports_list').DataTable({
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
        "pageLength": 10,
        "dom": '<"top"f>rt<"bottom"lp><"clear">',
      });

    }

    function emptyDataTable(table) {
      table.find('thead').empty();
      table.find('tbody').empty();
    }

    $("#support-modal").on('click', '.btn-create-support', function(e) {
      var modal = $('#support-modal');
      var form = $('#modal-add-support-part');
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

    $("#edit-support-modal").on('click', '.btn-edit-support', function(e) {
      var modal = $('#edit-support-modal');
      var form = $('#modal-edit-support-part');
      var formData = form.serialize();
      console.log(formData.subject);

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

    $(document).on('click', '.delete_support', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'support/delete/' + id,
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

    $(document).on('click', '.modal-edit-support', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      $.ajax({
        type: "POST",
        url: base_url + 'support/get_support_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result['error'] == false && result['data'] != '') {

            $("#update_id").val(result['data'][0].id);

            $("#user_id").val(result['data'][0].user_id);

            $("#status").val(result['data'][0].status);

            $("#subject").val(result['data'][0].subject);

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

    $('.select2').select2()

  </script>
</body>

</html>