<?php $this->load->view('includes/header'); ?>
<link href="<?= base_url('assets2/vendor/chartist/css/chartist.min.css') ?>" rel="stylesheet" type="text/css" />

<style>
    .hide {
        display: none;
    }

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
                        <li class="breadcrumb-item"><a class="text-primary" href="#" onclick="closeChildAndReloadMain();"><?= $main_page ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Leave</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <h5 class="card-title">Edit Leave Application</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('leaves/edit') ?>" method="POST" id="modal-edit-leaves-part" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="update_id" id="update_id" value="<?= $leave[0]["id"] ?>">
                                        <input type="hidden" name="leave_duration" id="leave_duration" value="<?= $leave[0]["leave_duration"] ?>">
                                        <input type="hidden" name="document" id="document" value="<?= $leave[0]["document"] ?>">
                                        <div class="row">
                                            <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                                                <div class="col-lg-6 form-group mb-3">
                                                    <label class="col-form-label"><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></label>
                                                    <select name="user_id" id="user_id" class="form-control select2">
                                                        <option value=""><?= $this->lang->line('select_employee') ? $this->lang->line('select_employee') : 'Select Employee' ?></option>
                                                        <?php foreach ($system_users as $system_user) {
                                                            if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                                <option value="<?= $system_user->id ?>" <?= $leave[0]["user_id"] == $system_user->id ? "selected" : "" ?>><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <div class="col-lg-6 form-group mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                                                <select class="form-control select2" name="type" id="type">
                                                    <?php foreach ($leaves_types as $leaves) { ?>
                                                        <option value="<?= $leaves['id'] ?>" <?= $leave[0]["type"] == $leaves['id'] ? "selected" : "" ?>><?= $leaves['name'] ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php if ($this->ion_auth->in_group(1) || permissions('leaves_view_all') || permissions('leaves_view_selected')) { ?>
                                                <div class="col-lg-12 form-group mb-3">
                                                    <label class="col-form-label"><?= $this->lang->line('paid_unpaid') ? $this->lang->line('paid_unpaid') : 'Paid / Unpaid Leave' ?></label>
                                                    <select name="paid" id="paid" class="form-control select2">
                                                        <option value="0" <?= $leave[0]["paid"] == 0 ? "selected" : "" ?>><?= $this->lang->line('paid') ? $this->lang->line('paid') : 'Paid Leave' ?></option>
                                                        <option value="1" <?= $leave[0]["paid"] == 1 ? "selected" : "" ?>><?= $this->lang->line('unpaid') ? $this->lang->line('unpaid') : 'Unpaid Leave' ?></option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            $leaveValue = showTypeDate($leave[0]["leave_duration"]);

                                            ?>
                                        </div>
                                        <div class="row ms-2">
                                            <div class="form-group form-check form-check-inline col-md-6 md-3 mb-3">
                                                <input class="form-check-input" type="checkbox" id="half_day" name="half_day" <?= $leaveValue === "Half" ? "checked" : ""; ?>>
                                                <label class="form-check-label text-danger" for="half_day"><?= $this->lang->line('half_day') ? $this->lang->line('half_day') : 'Half Day' ?></label>
                                            </div>

                                            <div class="form-group form-check form-check-inline col-md-5 mb-3">
                                                <input class="form-check-input" type="checkbox" id="short_leave" name="short_leave" <?= $leaveValue === "Short" ? "checked" : ""; ?>>
                                                <label class="form-check-label text-danger" for="short_leave"><?= $this->lang->line('short_leave') ? $this->lang->line('short_leave') : 'Short Leave' ?></label>
                                            </div>
                                        </div>
                                        <div id="date_fields">
                                            <div id="full_day_dates" class="<?= $leaveValue === "Full" ? "" : "hide"; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="starting_date" name="starting_date" class="form-control datepicker-default required" value="<?= $leave[0]["starting_date"] ?>">
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="ending_date" name="ending_date" class="form-control datepicker-default required" value="<?= $leave[0]["ending_date"] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="half_day_date" class="<?= $leaveValue === "Half" ? "" : "hide"; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="date_half2" name="date_half" class="form-control datepicker-default required" value="<?= $leave[0]["starting_date"] ?>">
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('time') ? $this->lang->line('time') : 'Time' ?><span class="text-danger">*</span></label>
                                                        <select name="half_day_period" id="half_day_period" class=" form-group form-control">
                                                            <option value="0" <?= $leave[0]["leave_duration"] == "First Time Half Day" ? "selected" : ""; ?>>First Time</option>
                                                            <option value="1" <?= $leave[0]["leave_duration"] == "Second Time Half Day" ? "selected" : ""; ?>>Second Time</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="short_leave_dates" class="<?= $leaveValue === "Short" ? "" : "hide"; ?>">
                                                <div class="row">
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="date5" name="date" class="form-control datepicker-default required" value="<?= $leave[0]["starting_date"] ?>">
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="starting_time" name="starting_time" class="form-control timepicker" value="<?= $leave[0]["starting_time"] ?>">
                                                    </div>
                                                    <div class="col-md-4 form-group mb-3">
                                                        <label class="col-form-label"><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                                                        <input type="text" id="ending_time" name="ending_time" class="form-control timepicker" value="<?= $leave[0]["ending_time"] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('Document') ? $this->lang->line('Document') : 'Document' ?> <?php if (!empty($leave[0]["document"])) : ?>
                                                        (<a href="<?= base_url('assets/uploads/f' . $this->session->userdata('saas_id') . '/leaves/' . $leave[0]["document"]) ?>" download="<?= $leave[0]["document"] ?>"><?= $leave[0]["document"] ?></a>)
                                                    <?php endif; ?></label>
                                                <input class="form-control" type="file" name="documents" id="formFile">
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="col-form-label"><?= $this->lang->line('leave_reason') ? $this->lang->line('leave_reason') : 'Leave Reason' ?><span class="text-danger">*</span></label>
                                            <textarea type="text" name="leave_reason" id="leave_reason" class="form-control" required=""><?= $leave[0]["leave_reason"] ?></textarea>
                                        </div>
                                        <?php if (permissions('leaves_status') || $this->ion_auth->is_admin()) {
                                        ?>
                                            <div class="form-group mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('status') ? $this->lang->line('status') : 'Status' ?></label>
                                                <select name="status" id="status" class="form-control" <?= $leave[0]["status"] == 1 ? "disabled" : "" ?><?= $leave[0]["status"] == 2 ? "disabled" : "" ?>>
                                                    <option value=""><?= $this->lang->line('select_status') ? $this->lang->line('select_status') : 'Select Status' ?></option>
                                                    <option value="0" <?= $leave[0]["status"] == 0 ? "selected" : "" ?>><?= $this->lang->line('pending') ? htmlspecialchars($this->lang->line('pending')) : 'Pending' ?></option>
                                                    <option value="1" <?= $leave[0]["status"] == 1 ? "selected" : "" ?>><?= $this->lang->line('approve') ? htmlspecialchars($this->lang->line('approve')) : 'Approve' ?></option>
                                                    <option value="2" <?= $leave[0]["status"] == 2 ? "selected" : "" ?>><?= $this->lang->line('reject') ? htmlspecialchars($this->lang->line('reject')) : 'Reject' ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3" id="remarksSection" style="display: none;">
                                                <label class="col-form-label"><?= $this->lang->line('remarks') ? $this->lang->line('remarks') : 'Your Remark' ?><span class="text-danger">*</span></label>
                                                <textarea type="text" name="remarks" id="remarks" class="form-control" required=""></textarea>
                                            </div>

                                        <?php } ?>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <div class="col-lg-6 d-flex">
                                            <?= $leave[0]["btnHTML"] ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row h-50">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Leave balance</h4>
                                    </div>
                                    <div class="card-body" style="height: 250px;">
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-0 pb-0 flex-wrap">
                                        <h5 class="card-title">Leaves Logs</h5>
                                    </div>
                                    <div class="card-body mt-1">
                                        <div id="DZ_W_TimeLine02" class="widget-timeline dlab-scroll style-1 ps ps--active-y p-3 height370">
                                            <ul class="timeline">
                                                <?php foreach ($leaves_logs as $leave_log) : ?>
                                                    <li>
                                                        <div class="timeline-badge <?= $leave_log["class"] ?>">
                                                        </div>
                                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                            <span><?= $leave_log["created"] ?></span>
                                                            <h6 class="mb-0"><?= $leave_log["status"] ?></h6>
                                                            <p class="mb-0"><?= $leave_log["remarks"] ?></p>
                                                        </a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
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
                    console.log(response);
                    var html = '';
                    response.leave_types.forEach((value, index) => {
                        html += '<tr>';
                        html += '<td>' + value + '</td>';
                        html += '<td>' + response.total_leaves[index] + '</td>';
                        html += '<td>' + response.consumed_leaves[index] + '</td>';
                        html += '<td>' + response.paidArray[index] + '</td>';
                        html += '<td>' + response.unpaidArray[index] + '</td>';
                        html += '</tr>';
                    });
                    console.log(html);
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
    </script>
    <script>
        $(document).ready(function() {
            function toggleRemarks() {
                var status = $('#status').val();
                if (status !== '') {
                    $('#remarksSection').show();
                } else {
                    $('#remarksSection').hide();
                }
            }
            $('#status').on('change', function() {
                toggleRemarks();
            });
        });
    </script>
    <?php
    function showTypeDate($duration)
    {
        if (strpos($duration, 'Full') !== false) {
            return 'Full';
        } elseif (strpos($duration, 'Short') !== false) {
            return 'Short';
        } elseif (strpos($duration, 'Half') !== false) {
            return 'Half';
        } else {
            return '';
        }
    }
    ?>
    <script>
        function closeChildAndReloadMain() {
            window.opener.postMessage('reloadMain', window.location.origin);
            window.close();
        }

        $(document).on('click', '.btn-edit-leave', function(e) {
            var form = $('#modal-edit-leaves-part')[0];
            if (!form || form.nodeName !== 'FORM') {
                console.error('Form element not found or not a form');
                return;
            }
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $(".btn-edit-leave").prop("disabled", true);
                },
                success: function(result) {
                    closeChildAndReloadMain();
                },
                complete: function() {
                    $(".btn-edit-leave").prop("disabled", false);
                }
            });

            e.preventDefault();
        });
    </script>

</body>

</html>