<?php $this->load->view('includes/head'); ?>
<style>
  table th,
  table td {
    width: 50px;
    padding: 5px;
    border: 0.5px solid black;
  }

  .GFG {
    color: green;
  }

  .OK {
    font-size: 18px;
  }

  .draggable {
    position: absolute;
    cursor: move;
  }
</style>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../node_modules/table-dragger/dist/table-dragger.min.js"></script>
<link rel="stylesheet" type="text/css" href="dragtable.css" />
</head>
<body class="sidebar-mini">
  <?php
  $id = $_GET['id'];
  ?>
  <div id="app">
    <div class="main-wrapper">
      <?php $this->load->view('includes/navbar'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>
              <?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Employees' ?>
              <?php if (my_plan_features('users')) {
                if ($this->ion_auth->is_admin() || permissions('user_create')) { ?>
                  <a href="<?=base_url('users/create_user')?>"  class="btn btn-sm btn-icon icon-left btn-primary"><i
                      class="fas fa-plus"></i> <?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></a>
                <?php }
              } ?>

            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a
                  href="<?= base_url() ?>"><?= $this->lang->line('dashboard') ? $this->lang->line('dashboard') : 'Dashboard' ?></a>
              </div>
              <div class="breadcrumb-item">
                <?= $this->lang->line('employees') ? $this->lang->line('employees') : 'Employees' ?></div>
            </div>
          </div>
          <?php
          $user_id = $_GET['user'];
          ?>
          <div class="row">
            <div class="form-group col-md-6">
              <select class="form-control select2" id="active_users" onchange="refreshTable()">
                <option value="1"><?= $this->lang->line('select_active') ? $this->lang->line('select_active') : 'Active' ?>
                </option>
                <option value="2"><?= $this->lang->line('select_active') ? $this->lang->line('select_active') : 'Inactive' ?>
                </option>
                <option value="3"><?= $this->lang->line('select_all') ? $this->lang->line('select_all') : 'Select All' ?>
                </option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-control select2" id="department_users" onchange="refreshTable()">
                <option value="">
                  <?= $this->lang->line('select_department') ? $this->lang->line('select_department') : 'Select Department' ?>
                </option>
                <?php foreach ($departments as $department) { ?>
                  <option value="<?= $department['id'] ?>">
                    <?= $department['department_name'] ?>
                  </option>
                <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="GFG" class="table table-striped table-bordered sortable" id="user-list"
                      data-toggle="table" data-toolbar="#toolbar" data-url="<?= base_url('users/get_active_inactive') ?>"
                      data-search="true" data-show-columns="true" data-pagination="true" data-filter-control="true"
                      data-filter-show-clear="true" data-mobile-responsive="true" data-minimum-count-columns="2"
                      data-page-size="10" data-page-list="[10, 25, 50, 100]" data-row-style="rowStyle"
                      data-query-params="queryParams">
                      <thead>
                        <tr>
                          <th class="handle" data-field="s_no" data-sortable="false">
                            <?= $this->lang->line('s_no') ? $this->lang->line('s_no') : '#' ?>
                          </th>
                          <th class="handle" data-field="employee_id" data-sortable="true">
                            <?= $this->lang->line('employee_id') ? $this->lang->line('employee_id') : 'Emp ID' ?>
                          </th>
                          <!--<th data-field="id" data-sortable="true" data-visible="false"><?= $this->lang->line('id') ? htmlspecialchars($this->lang->line('id')) : 'Employee ID' ?></th>-->
                          <th class="handle" data-field="name" data-sortable="true">
                            <?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?>
                          </th>
                          <th class="handle" data-field="email" data-sortable="false">
                            <?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?>
                          </th>
                          <th class="handle" data-field="mobile" data-sortable="false">
                            <?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?>
                          </th>
                          <th class="handle" data-field="role" data-sortable="false">
                            <?= $this->lang->line('role') ? $this->lang->line('role') : 'Role' ?>
                          </th>
                          <th class="handle" data-field="status" data-sortable="false" data-visible="true">
                            <?= $this->lang->line('status') ? htmlspecialchars($this->lang->line('status')) : 'Status' ?></th>
                          <th class="handle" data-field="projects_count" data-sortable="true">
                            <?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?>
                          </th>
                          <th data-field="tasks_count" data-sortable="true">
                            <?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?>
                          </th>
                          <th data-field="shift_type" data-sortable="false" data-visible="true">
                            <?= $this->lang->line('shift_type') ? htmlspecialchars($this->lang->line('shift_type')) : 'Shift' ?>
                          </th>
                          <?php if ($this->ion_auth->is_admin() || permissions('user_view_all') || permissions('user_view_selected') || $this->ion_auth->in_group(3)) { ?>
                            <th data-field="cnic" data-sortable="false" data-visible="false">
                              <?= $this->lang->line('cnic') ? htmlspecialchars($this->lang->line('cnic')) : 'CNIC' ?></th>
                            <th data-field="father_name" data-sortable="false" data-visible="false">
                              <?= $this->lang->line('father_name') ? htmlspecialchars($this->lang->line('father_name')) : 'Father Name' ?>
                            </th>
                            <th data-field="department" data-sortable="false" data-visible="false">
                              <?= $this->lang->line('department') ? htmlspecialchars($this->lang->line('department')) : 'Department' ?>
                            </th>
                            <th data-field="joining_date" data-sortable="false" data-visible="false">
                              <?= $this->lang->line('joining_date') ? htmlspecialchars($this->lang->line('joining_date')) : 'Joining Date' ?>
                            </th>
                            <th data-field="gender" data-sortable="false" data-visible="false">
                              <?= $this->lang->line('gender') ? htmlspecialchars($this->lang->line('gender')) : 'Gender' ?></th>
                          <?php } ?>
                          <?php if ($this->ion_auth->is_admin() || permissions('user_edit') || permissions('user_delete') || $this->ion_auth->in_group(3)) { ?>
                            <th data-field="action" data-sortable="false" data-visible="true">
                              <?= $this->lang->line('action') ? htmlspecialchars($this->lang->line('action')) : 'Action' ?></th>
                          <?php } ?>
                        </tr>
                  </div>
                  </thead>
                  </table>
                </div>
              </div>
            </div>
          </div><!--end of the table format  -->
      </div>
    </div>
    </section>
  </div>

  <?php $this->load->view('includes/footer'); ?>
  </div>
  </div>

  <?php $this->load->view('includes/js'); ?>
  <script>
    function queryParams(p) {
      return {
        "active_users": $('#active_users').val(),
        "department_users": $('#department_users').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
      };
    }

    $(document).ready(function () {
      function getEmployeeId() {

        $.ajax({
          url: '<?= base_url('users/get_employee_id') ?>',
          method: 'POST', // or 'POST' depending on your server-side implementation
          dataType: 'json',
          success: function (response) {
            // Retrieve the calculated values from the JSON response
            var employee_id = response.max_employee_id;
            employee_id++;
            // Update the input fields in the form

            $('#employee_id_create').val(employee_id);
          },
        });
      }
      getEmployeeId();
    });
  </script>
  <script>
    function refreshTable() {
      $('#GFG').bootstrapTable('refresh');
    }
  </script>
</body>

</html>