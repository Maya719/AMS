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
          <?php
          if (permissions('user_create') || $this->ion_auth->is_admin()) {
          ?>
            <div class="col-xl-2 col-sm-3">
              <a href="<?= base_url('users/create_user') ?>" id="modal-add-leaves" class="btn btn-block btn-primary <?php echo $is_allowd_to_create_new ? "" : "disabled" ?>">+
                ADD</a>
            </div>
          <?php
          }
          ?>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4">
                <select class="form-select" id="active">
                  <option value="">All</option>
                  <option value="1" selected>Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              <div class="col-lg-4">
                <select class="form-select" id="department">
                  <option value="" selected>Department</option>
                  <?php foreach ($departments as $department) : ?>
                    <option value="<?= $department["id"] ?>"><?= $department["department_name"] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-lg-4">
                <select class="form-select" id="shift">
                  <option value="" selected>Shift</option>
                  <?php foreach ($shift_types as $shift_type) : ?>
                    <option value="<?= $shift_type["id"] ?>"><?= $shift_type["name"] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body p-1">
                <div class="table-responsive">
                  <table id="employee_list" class="table table-sm mb-0">
                    <thead>
                      <tr>

                      </tr>
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

    <!--**********************************
  Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    $(document).ready(function() {
      setFilter();
      $(document).on('change', '#active,#department,#shift', function() {
        setFilter();
      });

      function setFilter() {
        var status = $('#active').val();
        var department = $('#department').val();
        var shift = $('#shift').val();
        ajaxCall(status, department, shift);
      }

      function ajaxCall(status, department, shift) {
        showLoader();
        $.ajax({
          url: '<?= base_url('users/get_active_inactive') ?>',
          type: 'GET',
          data: {
            status: status,
            department: department,
            shift: shift,
          },
          success: function(response) {
            var tableData = JSON.parse(response);
            console.log(tableData);
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
        var table = $('#employee_list');
        if ($.fn.DataTable.isDataTable(table)) {
          table.DataTable().destroy();
        }
        emptyDataTable(table);
        var thead = table.find('thead');
        var theadRow = '<tr>';
        theadRow += '<th style="font-size: 15px;">ID</th>';
        theadRow += '<th style="font-size: 15px;">Employee Name</th>';
        theadRow += '<th style="font-size: 15px;">Email</th>';
        theadRow += '<th style="font-size: 15px;">Mobile</th>';
        theadRow += '<th style="font-size: 15px;">Desgnation</th>';
        theadRow += '<th style="font-size: 15px;">Shift</th>';
        theadRow += '<th style="font-size: 15px;">Department</th>';
        theadRow += '<th style="font-size: 15px;">Join Date</th>';
        theadRow += '<th style="font-size: 15px;">Status</th>';
        theadRow += '<th style="font-size: 15px;">Action</th>';
        theadRow += '</tr>';
        thead.html(theadRow);
        // Add table body
        var tbody = table.find('tbody');

        data.forEach(user => {
          var userRow = '<tr>';
          userRow += '<td style="font-size:13px;">' + user.employee_id + '</td>';
          userRow += '<td style="font-size:13px;">' + user.name + '</td>';
          userRow += '<td style="font-size:13px;">' + user.email + '</td>';
          userRow += '<td style="font-size:13px;">' + user.mobile + '</td>';
          userRow += '<td style="font-size:13px;">' + user.desgnation + '</td>';
          userRow += '<td style="font-size:13px;">' + user.shift_type + '</td>';
          userRow += '<td style="font-size:13px;">' + user.department + '</td>';
          userRow += '<td style="font-size:13px;">' + user.joining_date + '</td>';
          userRow += '<td style="font-size:13px;">' + user.status + '</td>';
          userRow += '<td>';
          userRow += '<div class="d-flex">';
          userRow += user.action;
          userRow += '</div>';
          userRow += '</td>';
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
          "pageLength": 10,
          "dom": '<"top"f>rt<"bottom"lp><"clear">'
        });

      }

      function emptyDataTable(table) {
        table.find('thead').empty();
        table.find('tbody').empty();
      }
    });
  </script>
</body>

</html>