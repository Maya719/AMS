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
                                            <?php if ($this->ion_auth->in_group(1) || is_assign_users()) { ?>
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
                                            <div class="col-lg-12 form-group mb-3" id="paid_unpaid_div">
                                                <label class="col-form-label"><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                                                <select name="paid" id="paidUnpaid" class="form-control select2">
                                                    <option value="0">
                                                        <?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?>
                                                    </option>
                                                    <option value="1">
                                                        <?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12 form-group mb-3" id="paid_unpaid_inputs" style="display: none;">
                                                <label class="col-form-label"><?= $this->lang->line('paid_days') ? $this->lang->line('paid_days') : 'Paid Days' ?></label>
                                                <input type="number" name="paid_days" id="paid_days" class="form-control">
                                                <label class="col-form-label"><?= $this->lang->line('unpaid_days') ? $this->lang->line('unpaid_days') : 'Unpaid Days' ?></label>
                                                <input type="number" name="unpaid_days" id="unpaid_days" class="form-control">
                                            </div>
                                            <div id="alart"></div>
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
                                            <button type="submit" class="btn btn-create-leave btn-block btn-primary mx-2">Create</button>
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
                                        <h4 class="card-title">Leave balance </h4>
                                    </div>
                                    <div class="card-body" style="min-height: 250px;">
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0" id="typesTable">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>Total</th>
                                                        <th>Consumed</th>
                                                        <th>Balance</th>
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
                url: base_url + 'leaves/get_leaves_balance',
                type: 'POST',
                dataType: 'json',
                data: {
                    user_id: employee_id,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    console.log(response);
                    var html = '';
                    let emptyCell = '<td class=""></td>';
                    if (response.leave_types) {
                        response.leave_types.forEach((value, index) => {
                            html += '<tr>';
                            html += '<td class="">' + value + '</td>';
                            html += '<td class="">' + response.total_leaves[index] + '</td>';
                            html += '<td class="">' + response.paidArray[index] + '</td>';
                            html += '<td class="">' + (response.total_leaves[index] - response.paidArray[index]) + '</td>';
                            html += '</tr>';
                        });
                        html += '<tr class="section-header">';
                        html += `<td colspan="4" class="" 
                        style="height:0px; padding:0px; margin:0px; border:1px solid black"></td>`;
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td class="fw-bold">Unpaid</td>';
                        html += '<td class=" fw-bold">Days</td>' + emptyCell + emptyCell;
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td>Approved</td>';
                        html += '<td class="">' + response.unpaidArray.reduce((accumulator, currentValue) => accumulator + currentValue, 0) + '</td>' + emptyCell + emptyCell;
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td>Absents</td>';
                        html += '<td class="">'+response.absents+'</td>' + emptyCell + emptyCell;
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td>Late Minutes</td>';
                        html += '<td id="late_minutes" class="">' + response.late_min + '</td > ' + emptyCell + emptyCell;
                        html += '</tr>';
                    } else {
                        html += '<tr>';
                        html += '<td colspan="5" class="">No Leave Type</td>';
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

        $('.select2').select2();
        $(document).ready(function() {
            function validatePaidUnpaidDays(diffDays) {
                var paidDays = parseInt($('#paid_days').val()) || 0;
                var unpaidDays = parseInt($('#unpaid_days').val()) || 0;
                var totalDays = paidDays + unpaidDays;
                if (totalDays !== diffDays) {
                    $('#alart').html('<p class="text-danger">Sum of Paid and Unpaid days must be equal to the duration of the leave. Total Duration is ' + diffDays + '</p>');
                    $(".btn-create-leave").prop("disabled", true).html('Error');
                    return false;
                } else {
                    $('#alart').html('');
                    $(".btn-create-leave").prop("disabled", false).html('Create');
                }
                return true;
            }

            $('#starting_date_create, #ending_date_create').on('change', function() {
                var startDate = new Date($('#starting_date_create').val());
                var endDate = new Date($('#ending_date_create').val());

                if (startDate && endDate && (endDate >= startDate)) {
                    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                    validatePaidUnpaidDays(diffDays);
                    if (diffDays > 1) {
                        $('#paid_unpaid_div').hide();
                        $('#paid_unpaid_inputs').show();

                        $('#paid_days, #unpaid_days').on('input', function() {
                            validatePaidUnpaidDays(diffDays);
                        });
                    } else {
                        $('#alart').html('');
                        $('#paid_unpaid_div').show();
                        $('#paid_unpaid_inputs').hide();
                        $(".btn-create-leave").prop("disabled", false).html('Create');
                    }
                } else {
                    $('#paid_unpaid_div').show();
                    $('#paid_unpaid_inputs').hide();
                }
            });

            $('#half_day, #short_leave').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#alart').html('');
                    $('#paid_unpaid_div').val(0);
                    $('#paid_unpaid_div').show();
                    $('#paid_unpaid_inputs').val(0);
                    $('#paid_unpaid_inputs').hide();
                    $(".btn-create-leave").prop("disabled", false).html('Create');
                } else {
                    var startDate = new Date($('#starting_date_create').val());
                    var endDate = new Date($('#ending_date_create').val());
                    if (startDate && endDate && (endDate >= startDate)) {
                        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                        console.log(diffDays);
                        if (diffDays > 1) {
                            $('#paid_unpaid_div').hide();
                            $('#paid_unpaid_inputs').show();
                            $('#alart').html('<p class="text-danger">The sum of Paid and Unpaid days must be equal to the duration of the leave.</p>');
                            $('#paid_days, #unpaid_days').on('input', function() {
                                validatePaidUnpaidDays(diffDays);
                            });
                        } else {
                            $('#alart').html('');
                            $('#paid_unpaid_div').show();
                            $('#paid_unpaid_inputs').hide();
                            $(".btn-create-leave").prop("disabled", false).html('Create');
                        }
                    } else {
                        $('#paid_unpaid_div').show();
                        $('#paid_unpaid_inputs').hide();
                    }
                }
            });
        });
        $(document).on('click', '.btn-create-leave', function(e) {
            e.preventDefault();

            var form = $('#modal-create-leaves-part')[0]; // Get the native DOM element
            var formData = new FormData(form); // Create FormData object

            console.log(formData);

            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $(".btn-create-leave").prop("disabled", true).html('Creating...');
                },
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {
                        // console.log(result);
                        window.location.href = base_url + 'leaves';
                    } else {
                        toastr.error(result['message'], "Error", {
                            positionClass: "toast-top-right",
                            timeOut: 5e3,
                            closeButton: !0,
                            debug: !1,
                            newestOnTop: !0,
                            progressBar: !0,
                            preventDuplicates: !0,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                            tapToDismiss: !1
                        });
                    }

                },
                complete: function() {
                    $(".btn-create-leave").prop("disabled", false).html('Create');
                }
            });
        });
    </script>
</body>

</html>