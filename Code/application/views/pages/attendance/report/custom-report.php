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
                        <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-12 col-xl-6 col-sm-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <h5 class="card-title">Create Report</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('sheet/create') ?>" method="POST" id="modal-create-leaves-part" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 form-group mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Share with' ?></label>
                                                <input type="email" name="user_id" id="user_id" class="form-control" require>
                                            </div>
                                            <!-- <div class="col-lg-12 form-group mb-3">
                                                <label class="col-form-label"><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?></label>
                                                <select name="paid" class="form-control select2">
                                                    <option value="0">
                                                        <?= $this->lang->line('this_month') ? $this->lang->line('this_month') : 'This Month' ?>
                                                    </option>
                                                    <option value="1">
                                                        <?= $this->lang->line('this_year') ? $this->lang->line('this_year') : 'This Year' ?>
                                                    </option>
                                                </select>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <div class="col-lg-3 d-flex">
                                            <button type="submit" class="btn btn-create-leave btn-block btn-primary mx-2">Update Sheet</button>
                                        </div>
                                    </div>
                                </form>
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
        $('.select2').select2();
        $(document).on('click', '.btn-create-leave', function(e) {
            e.preventDefault();
            var form = $('#modal-create-leaves-part')[0];
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
                    $(".btn-create-leave").prop("disabled", true).html('Updating...');
                },
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {
                        console.log(result);
                        toastr.success(result['message'], "Success", {
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
                    $(".btn-create-leave").prop("disabled", false).html('Update Sheet');
                }
            });
        });
    </script>
</body>

</html>