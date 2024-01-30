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
  <?php $this->load->view('includes/sidebar'); ?>
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <div class="content-body default-height">
      <!-- row -->
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="<?=base_url('users/create_user')?>" id="modal-add-leaves" class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <!-- <div class="col-lg-6 mb-3">
                      <select class="form-select" id="employee_id">
                        <option value=""><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></option>
                        <?php foreach ($system_users as $system_user) {
                          if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                            <option value="<?= $system_user->employee_id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                        <?php }
                        } ?>
                      </select>
                    </div> -->
                    
                    <div class="col-lg-12 mb-3">
                      <select class="form-select" id="active">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="employee_list" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        
                      </tr>
                    </thead>
                    <tbody id="customers">
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">1</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Aman</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">01/15/2023</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">2</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Alyan</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">3</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Shoaib</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">4</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Sameer</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">5</a></td>
                        <td>
                          <a href=""><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Saqib</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">6</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Nabil</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">7</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Sheeza Bibi</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">8</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Zeshan</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
                      <tr class="btn-reveal-trigger" height="20">
                        <td class="py-2"> <a href="edit-user.html">9</a></td>
                        <td>
                          <a href="edit-user.html"><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""><span class="ms-3"><strong>Mehmood</strong></span></a>
                        </td>
                        <td class="py-2 "><a href="edit-user.html">example@abc.com</a></td>
                        <td class="py-2 "> <a href="edit-user.html">030101010100</a></td>
                        <td class="py-2 "> <a href="edit-user.html">Employee</a></td>
                        <td class="py-2 text-warning"> <a href="edit-user.html"></a></td>
                        <td class="py-2 "> <a href="edit-user.html">Regular</a></td>
                        <td class="py-2 "> <a href="edit-user.html">19</a></td>
                        <td><span>
                            <span class="badge light badge-primary"><a href="edit-user.html" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                        </td>
                      </tr>
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
      $(document).on('change', '#active', function() {
        setFilter();
      });
      function setFilter() {
        var status = $('#active').val();
        ajaxCall(status);
      }
      function ajaxCall(status) {
        $.ajax({
          url: '<?= base_url('users/get_active_inactive') ?>',
          type: 'GET',
          data: {
            status: status,
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
        theadRow += '<th style="font-size: 15px;">Role</th>';
        theadRow += '<th style="font-size: 15px;">Status</th>';
        theadRow += '<th style="font-size: 15px;">Shift</th>';
        theadRow += '<th style="font-size: 15px;">Join Date</th>';
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
          userRow += '<td style="font-size:13px;">' + user.role + '</td>';
          userRow += '<td style="font-size:13px;">' + user.status + '</td>';
          userRow += '<td style="font-size:13px;">' + user.shift_type + '</td>';
          userRow += '<td style="font-size:13px;">' + user.joining_date + '</td>';
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
    });
  </script>
</body>

</html>