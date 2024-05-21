<?php $this->load->view('includes/header'); ?>
<link href="<?= base_url('assets2/vendor/chartist/css/chartist.min.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .table th,
    .table td {
        padding: 5px;
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('leaves') ?>"><?= $main_page ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Leave</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-12 col-xl-6 col-sm-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <h5 class="card-title">Create Leave Application</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('leaves/create') ?>" method="POST" id="modal-create-leaves-part" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                                                <div class="col-lg-6 form-group mb-3">
                                                    <label class="col-form-label"><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></label>
                                                    <select name="user_id_add" id="user_id" class="form-control select2">
                                                        <option value="">
                                                            <?= $this->lang->line('select_employee') ? $this->lang->line('select_employee') : 'Select Employee' ?>
                                                        </option>
                                                        <?php foreach ($system_users as $system_user) {
                                                            if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == 1 && $system_user->finger_config == 1) { ?>
                                                                <option value="<?= $system_user->id ?>">
                                                                    <?= htmlspecialchars($system_user->first_name) ?>
                                                                    <?= htmlspecialchars($system_user->last_name) ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="col-lg-6 form-group mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                                                <select class="form-control select2" name="type_add" id="type">
                                                    <?php foreach ($leaves_types as $leaves) { ?>
                                                        <option value="<?= $leaves['id'] ?>"><?= $leaves['name'] ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                                                <div class="col-lg-12 form-group mb-3">
                                                    <label class="col-form-label"><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                                                    <select name="paid" id="paid" class="form-control select2">
                                                        <option value="0">
                                                            <?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?>
                                                        </option>
                                                        <option value="1">
                                                            <?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group form-check form-check-inline col-md-6 md-3 mb-3">
                                                <input class="form-check-input" type="checkbox" id="half_day" name="half_day">
                                                <label class="form-check-label text-danger" for="half_day"><?= $this->lang->line('half_day') ? $this->lang->line('half_day') : 'Half Day' ?></label>
                                            </div>

                                            <div class="form-group form-check form-check-inline col-md-5 mb-3">
                                                <input class="form-check-input" type="checkbox" id="short_leave" name="short_leave">
                                                <label class="form-check-label text-danger" for="short_leave"><?= $this->lang->line('short_leave') ? $this->lang->line('short_leave') : 'Short Leave' ?></label>
                                            </div>

                                            <div id="date_fields">
                                                <div id="full_day_dates" class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="starting_date_create" name="starting_date" class="form-control datepicker-default required">
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="ending_date_create" name="ending_date" class="form-control datepicker-default required">
                                                    </div>
                                                </div>

                                                <div id="half_day_date" class="row" style="display: none;">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="date_half" name="date_half" class="form-control datepicker-default required">
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                                                        <select name="half_day_period" class=" form-group form-control select2">
                                                            <option value="0">First Time</option>
                                                            <option value="1">Second Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="short_leave_dates" class="row" style="display: none;">
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="date" name="date" class="form-control datepicker-default required">
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                                                        <input type="text" name="starting_time" id="starting_time_create" class="form-control timepicker">
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                                                        <input type="text" name="ending_time" id="ending_time_create" class="form-control timepicker">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?>
                                                    <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $this->lang->line('if_any_leave_document') ? $this->lang->line('if_any_leave_document') : "If any Document according to leave/s." ?>"></i></label>
                                                <input class="form-control" type="file" name="documents" id="formFile">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="col-form-label"><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                                            <textarea type="text" name="leave_reason" id="leave_reason" class="form-control" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <div class="col-lg-3 d-flex">
                                            <button type="button" class="btn btn-create-leave btn-block btn-primary mx-2">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-4 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Leave balance</h4>
                                    </div>
                                    <div class="card-body" style="min-height: 250px;">
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0" id="typesTable">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>Total</th>
                                                        <th>Consume</th>
                                                        <th>Paid</th>
                                                        <th>Unpaid</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <script src="<?= base_url('assets2/vendor/chartist/js/chartist.min.js') ?>"></script>
    <script src="<?= base_url('assets2/vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') ?>"></script>
    <script>
        var multiLineChart = function() {
            var employee_id = $('#user_id').val();
            $.ajax({
                url: base_url + 'leaves/get_leaves_count',
                type: 'POST',
                dataType: 'json',
                data: {
                    user_id: employee_id,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    // console.log(response);
                    var html = '';
                    if (response.leave_types) {
                        response.leave_types.forEach((value, index) => {
                            html += '<tr>';
                            html += '<td>' + value + '</td>';
                            html += '<td>' + response.total_leaves[index] + '</td>';
                            html += '<td>' + response.consumed_leaves[index] + '</td>';
                            html += '<td>' + response.paidArray[index] + '</td>';
                            html += '<td>' + response.unpaidArray[index] + '</td>';
                            html += '</tr>';
                        });
                    } else {
                        html += '<tr>';
                        html += '<td colspan="5" class="text-center">No Leave Type</td>';
                        html += '</tr>';
                    }

                    // console.log(html);
                    $("#table_body").html(html);

                },
                complete: function() {
                    hideLoader();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            multiLineChart();
        });
        $('#user_id').on('change', function() {
            multiLineChart();
        });

        $('.select2').select2()
    </script>
</body>

</html>