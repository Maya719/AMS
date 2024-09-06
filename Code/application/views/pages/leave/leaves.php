<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets2/vendor/range-picker/daterangepicker.css') ?>" />
<style>
  .daterangepicker .ranges li.active {
    background-color: <?= theme_color() ?>;
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
            <a href="<?= base_url('leaves/create_leave') ?>" class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <?php if ($this->ion_auth->is_admin() || is_assign_users() || is_all_users()) { ?>
                      <div class="col-lg-2">
                        <select class="form-select select2" id="le_status">
                          <option value="1">Active</option>
                          <option value="2">Inactive</option>
                        </select>
                      </div>
                      <div class="col-lg-2">
                        <select class="form-select select2" id="le_employee_id">
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
                    <div class="col-lg-2">
                      <select class="form-select select2" id="le_leave_type">
                        <option value=""><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave type' ?></option>
                        <?php foreach ($leaves_types as $leaves_type) : ?>
                          <option value="<?= $leaves_type["id"] ?>"><?= htmlspecialchars($leaves_type["name"]) ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select class="form-select select2" id="le_status_name">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" id="config-demo" class="form-control">
                    </div>
                    <input type="hidden" id="le_startDate">
                    <input type="hidden" id="le_endDate">
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

    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets2/js/leaves/leaves.js') ?>"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets2/vendor/range-picker/daterangepicker.js') ?>"></script>
  <script>
    $(document).ready(function() {
      const startDate = sessionStorage.getItem('le_startDate') || moment().startOf('month').format('YYYY-MM-DD');
      const endDate = sessionStorage.getItem('le_endDate') || moment().format('YYYY-MM-DD');
      $('#le_startDate').val(startDate);
      $('#le_endDate').val(endDate);
      sessionStorage.setItem('le_startDate', startDate);
      sessionStorage.setItem('le_endDate', endDate);

      store_session("le_status");
      store_session("le_leave_type");
      store_session("le_status_name");
      store_session("le_employee_id");

      set_session("le_status");
      set_session("le_leave_type");
      set_session("le_status_name");
      set_session("le_employee_id");
      setTimeout(function() {
          setFilter();
      }, 500);
      $(document).on('change', '#le_leave_type, #le_status_name, #le_employee_id,#le_status', function() {
        setFilter();
      });
    });

    function set_session(id) {
      const value = sessionStorage.getItem(id);
      console.log(id + ':' + value);
      if (value !== null) {
        $(`#${id}`).val(value).trigger('change');
      }
    }

    function store_session(id) {
      $(`#${id}`).change(function() {
        console.log(id + ' change ');
        sessionStorage.setItem(id, $(this).val());
      });
    }

    $('.select2').select2();

    let childWindow;

    function openChildWindow(id) {
      var screenWidth = window.screen.width;
      var screenHeight = window.screen.height;
      var newWindowWidth = screenWidth / 2;
      var newWindowHeight = screenHeight;
      window.open('' + base_url + 'leaves/manage/' + id + '', 'childWindow', 'width=' + newWindowWidth + ',height=' + newWindowHeight + '');
    }

    window.addEventListener('message', function(event) {
      if (event.data === 'reloadMain') {
        this.location.reload();
      }
    });

    $(document).on('change', '#le_employee_id', function() {
      store_session("le_employee_id");
    });
    $(document).on('change', '#le_status', function() {
      console.log("status changing");
      appendStateEmp();
    });

    function appendStateEmp() {
      var status = $('#le_status').val();
      $.ajax({
        url: '<?= base_url('attendance/get_users_by_status') ?>',
        type: 'POST',
        data: {
          status: status,
        },
        success: function(response) {
          var tableData = JSON.parse(response);
          const value = sessionStorage.getItem("le_employee_id");
          $('#le_employee_id').empty();
          $('#le_employee_id').append('<option value="">Employee</option>');
          tableData.forEach(function(department) {
            if (value == department.id) {
              $('#le_employee_id').append('<option value="' + department.id + '" selected>' + department.first_name + ' ' + department.last_name + '</option>');
            } else {
              $('#le_employee_id').append('<option value="' + department.id + '">' + department.first_name + ' ' + department.last_name + '</option>');
            }
          });
        },
        complete: function() {},
        error: function(error) {
          console.error(error);
        }

      });
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#config-text').keyup(function() {
        eval($(this).val());
      });

      $('.configurator input').change(function() {
        updateConfig();
      });

      $('.demo i').click(function() {
        $(this).parent().find('input').click();
      });

      updateConfig();

      $('#config-demo').click(function() {
        $(this).data('daterangepicker').show();
      });

      function updateConfig() {
        // Retrieve dates from sessionStorage or use defaults
        const storedStartDate = sessionStorage.getItem('le_startDate');
        const storedEndDate = sessionStorage.getItem('le_endDate');

        const startDate = storedStartDate ? moment(storedStartDate) : moment().startOf('month');
        const endDate = storedEndDate ? moment(storedEndDate) : moment();
        var options = {
          startDate: startDate,
          endDate: endDate,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
        };

        $('#config-demo').daterangepicker(options, function(start, end, label) {
          const formattedStartDate = start.format('YYYY-MM-DD');
          const formattedEndDate = end.format('YYYY-MM-DD');
          $('#le_startDate').val(formattedStartDate);
          $('#le_endDate').val(formattedEndDate);
          sessionStorage.setItem('le_startDate', formattedStartDate);
          sessionStorage.setItem('le_endDate', formattedEndDate);
          setFilter();
        });

        $('#config-text').val("$('#demo').daterangepicker(" + JSON.stringify(options, null, '    ') + ", function(start, end, label) {\n  console.log(\"New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')\");\n});");
      }
    });
  </script>
</body>

</html>