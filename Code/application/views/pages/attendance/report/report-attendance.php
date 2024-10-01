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
                        <a href="<?= base_url('reports/custom-report-attendance') ?>" class="btn btn-block btn-primary">Sheet Report</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <input type="hidden" id="repo_att_startDate">
                                        <input type="hidden" id="repo_att_endDate">
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="repo_att_status">
                                                <option value="1">
                                                    <?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?>
                                                </option>
                                                <option value="2">
                                                    <?= $this->lang->line('inactive') ? $this->lang->line('inactive') : 'Inactive' ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="repo_att_employee_id">
                                                <option value="">
                                                    <?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="repo_att_shift_id">
                                                <option value="">
                                                    <?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?>
                                                </option>
                                                <?php foreach ($shifts as $shift) : ?>
                                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="repo_att_department_id">
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
                                            <input type="text" id="repo_att_config-demo" class="form-control">
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
        <!-- *******************************************
        Footer -->
        <?php $this->load->view('includes/footer'); ?>
        <!-- ******************************************
            Model forms
        ****************************************************-->

        <!--**********************************
            Content body end
        ***********************************-->
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script type="text/javascript" src="<?= base_url('assets2/js/attendance/report_attendance.js') ?>"></script>
    <script>
        $('.select2').select2();
    </script>
</body>

</html>