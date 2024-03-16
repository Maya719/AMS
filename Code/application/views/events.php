<?php $this->load->view('includes/header'); ?>
<style>
    #attendance_list tbody td a {
        font-weight: bold;
        font-size: 10px;
    }

    .dataTables_wrapper .dataTables_scrollFoot {
        position: sticky;
        bottom: 0;
        background-color: white;
        /* Adjust as needed */
        z-index: 1000;
        /* Adjust as needed */
    }

    #attendance_list tbody td {
        padding: 1px 10px;
    }
</style>
<link href="<?= base_url('assets2/vendor/fullcalendar/css/main.min.css') ?>" rel="stylesheet" type="text/css" />

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
        <!--**********************************
	Content body start
***********************************-->
        <div class="content-body default-height">
            <!-- row -->
            <div class="container-fluid">
                <div class="row d-flex justify-content-end">
                    <div class="col-xl-2 col-sm-3 mt-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#add-event-modal" class="btn btn-block btn-primary">+ ADD</a>
                    </div>
                    <div class="col-xl-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar" class="fullcalendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- **************************** 
            Models
    *******************************-->
        <div class="modal fade" id="add-event-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('events/create') ?>" method="POST" class="modal-part" id="modal-add-event-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label"><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label"><?= $this->lang->line('start_date') ? $this->lang->line('date') : 'Start' ?><span class="text-danger">*</span></label>
                                <input type="text" name="start" id="startingDate" class="form-control" required="">
                            </div>

                            <div class="form-group mb-3">
                                <label class="col-form-label"><?= $this->lang->line('end_date') ? $this->lang->line('end_date') : 'End' ?><span class="text-danger">*</span></label>
                                <input type="text" name="end" id="endingDate" class="form-control" required="">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-create btn-block btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-event-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('events/edit') ?>" method="POST" class="modal-part" id="modal-edit-event-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                        <input type="hidden" name="update_id" id="update_id" class="form-control">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label"><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label"><?= $this->lang->line('start_date') ? $this->lang->line('date') : 'Start' ?><span class="text-danger">*</span></label>
                                <input type="text" name="start" id="start" class="form-control" required="">
                            </div>

                            <div class="form-group mb-3">
                                <label class="col-form-label"><?= $this->lang->line('end_date') ? $this->lang->line('end_date') : 'End' ?><span class="text-danger">*</span></label>
                                <input type="text" name="end" id="end" class="form-control" required="">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-edit btn-block btn-primary">Save</button>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-delete btn-block btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--**********************************
	Content body end
***********************************-->
        <?php $this->load->view('includes/footer'); ?>
        <?php $this->load->view('includes/scripts'); ?>
        <script>
            $("#add-event-modal").on('click', '.btn-create', function(e) {
                var modal = $('#add-event-modal');
                var form = $('#modal-add-event-part');
                var formData = form.serialize();
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $(".modal-body").append(ModelProgress);
                    },
                    success: function(result) {
                        if (result['error'] == false) {
                            location.reload();
                        } else {
                            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                        }
                    },
                    complete: function() {
                        $(".loader-progress").remove();
                    }
                });
                e.preventDefault();
            });
            $("#edit-event-modal").on('click', '.btn-edit', function(e) {
                var modal = $('#edit-event-modal');
                var form = $('#modal-edit-event-part');
                var formData = form.serialize();
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $(".modal-body").append(ModelProgress);
                    },
                    success: function(result) {
                        if (result['error'] == false) {
                            location.reload();
                        } else {
                            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                        }
                    },
                    complete: function() {
                        $(".loader-progress").remove();
                    }
                });
                e.preventDefault();
            });
            $("#edit-event-modal").on('click', '.btn-delete', function(e) {
                var id = $("#update_id").val();
                console.log(id);
                Swal.fire({
                    title: are_you_sure,
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'events/delete/' + id,
                            data: "id=" + id,
                            dataType: "json",
                            success: function(result) {
                                if (result['error'] == false) {
                                    console.log(result);
                                    location.reload();
                                } else {
                                    iziToast.error({
                                        title: result['message'],
                                        message: "",
                                        position: 'topRight'
                                    });
                                }
                            }
                        });
                    }
                });

                e.preventDefault();
            });
        </script>
        <script src="<?= base_url('assets2/vendor/fullcalendar/js/main.min.js') ?>"></script>
        <script src="<?= base_url('assets2/vendor/moment/moment.min.js') ?>"></script>
        <script src="<?= base_url('assets2/js/plugins-init/calendar.js') ?>"></script>

        <script>
            $(document).ready(function() {
                $('#startingDate').daterangepicker({
                    locale: {
                        format: date_format_js
                    },
                    singleDatePicker: true,
                });
                $('#endingDate').daterangepicker({
                    locale: {
                        format: date_format_js
                    },
                    singleDatePicker: true,
                    minDate: start
                });
                $('#startingDate').on('change', function() {
                    var start = $('#startingDate').val();
                    $('#endingDate').daterangepicker({
                        locale: {
                            format: date_format_js
                        },
                        singleDatePicker: true,
                        minDate: start
                    });
                });
            });
        </script>
</body>

</html>