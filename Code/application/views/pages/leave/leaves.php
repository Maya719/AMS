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
            <a href="<?= base_url('leaves/create_leave') ?>" class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <?php if ($this->ion_auth->is_admin() || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                      <div class="col-lg-3">
                        <select class="form-select select2" id="employee_id" onchange="setCookieFromSelect('employee_id')">
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
                      <select class="form-select select2" id="leave_type" onchange="setCookieFromSelect('leave_type')">
                        <option value=""><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave type' ?></option>
                        <?php foreach ($leaves_types as $leaves_type) : ?>
                          <option value="<?= $leaves_type["id"] ?>"><?= htmlspecialchars($leaves_type["name"]) ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <select class="form-select select2" id="status_name" onchange="setCookieFromSelect('status_name')">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <select class="form-select select2" id="dateFilter" onchange="setCookieFromSelect('dateFilter')">
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

    // Function to set a cookie
    function setCookie(name, value, days) {
      let expires = "";
      if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Function to get a cookie
    function getCookie(name) {
      let nameEQ = name + "=";
      let ca = document.cookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }

    // Function to set cookie from select field
    function setCookieFromSelect(selectId) {
      let select = document.getElementById(selectId);
      let selectedValue = select.options[select.selectedIndex].value;
      setCookie(selectId, selectedValue, 7);
    }

    function setSelectFromCookie(selectId) {
      let select = document.getElementById(selectId);
      let cookieValue = getCookie(selectId);
      if (cookieValue) {
        console.log(cookieValue);
        for (let i = 0; i < select.options.length; i++) {
          if (select.options[i].value === cookieValue) {
            select.selectedIndex = i;
            break;
          }
        }
      } else {}
    }

    function setCookieFromSelectForDataTable(currentPageLength) {
      setCookie('leave_list_length', currentPageLength, 7);
    }
    function setCookieFromPageForDataTable(pageNumber)
    {
      setCookie('page_no', pageNumber, 7);
    }
    document.addEventListener('DOMContentLoaded', (event) => {
      const selectIds = ['employee_id', 'leave_type', 'status_name', 'dateFilter'];
      selectIds.forEach(setSelectFromCookie);
      $('.select2').select2();
    });
    $('#leave_list').on('length.dt', function(e, settings, len) {
      var currentPageLength = len;
      setCookieFromSelectForDataTable(currentPageLength)
    });
    // Event listener for page change
    $('#leave_list').on('page.dt', function() {
      var table = $('#leave_list').DataTable(); 
      var pageNumber = table.page.info().page + 1; 
      setCookieFromPageForDataTable(pageNumber)
    });
  </script>

</body>

</html>