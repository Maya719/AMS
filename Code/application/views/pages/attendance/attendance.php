<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets2/vendor/range-picker/daterangepicker.css') ?>" />
<style>
    #attendance_list tbody td a {
        font-weight: bold;
        font-size: 10px;
    }

    .dataTables_wrapper .dataTables_scrollFoot {
        position: sticky;
        bottom: 0;
        background-color: white;
        z-index: 1000;
    }

    #attendance_list tbody td {
        padding: 1px 5px;
    }

    .daterangepicker .ranges li.active {
        background-color:
            <?= theme_color() ?>;
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
    <div id="main-wrapper">

        <?php $this->load->view('includes/sidebar'); ?>
        <div class="content-body default-height">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <input type="hidden" id="att_startDate">
                                        <input type="hidden" id="att_endDate">
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="att_status">
                                                <option value="1">
                                                    <?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?>
                                                </option>
                                                <option value="2">
                                                    <?= $this->lang->line('inactive') ? $this->lang->line('inactive') : 'Inactive' ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="att_employee_id">
                                                <option value="">
                                                    <?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="att_shift_id">
                                                <option value="">
                                                    <?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?>
                                                </option>
                                                <?php foreach ($shifts as $shift) : ?>
                                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="att_department_id">
                                                <option value="">
                                                    <?= $this->lang->line('department') ? $this->lang->line('department') : 'Department' ?>
                                                </option>
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= $department["id"] ?>">
                                                        <?= $department["department_name"] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" id="config-demo" class="form-control">
                                        </div>
                                    </div>
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
                                    <table id="attendance_list" class="table table-sm mb-0">
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
        <?php $this->load->view('includes/footer'); ?>
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets2/vendor/range-picker/daterangepicker.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets2/js/attendance/attendance.js') ?>"></script>
    <script>
        $('.select2').select2();
        // let childWindow;

        function openChildWindow(id) {
            // var screenWidth = window.screen.width;
            // var screenHeight = window.screen.height;
            // sessionStorage.setItem("window", true);
            // window.open('' + base_url + 'attendance/user_attendance/' + id + '', 'childWindow', 'width=' + screenWidth + ',height=' + screenHeight + '');
        }
    </script>

</body>

</html>