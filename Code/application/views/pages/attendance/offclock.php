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
        z-index: 1000;
    }

    #attendance_list tbody td {
        padding: 1px 5px;
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
        <div class="content-body default-height ">
            <!-- row -->
            <div class="container-fluid ">
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
                        <a href="#" id="modal-add-offclock" data-bs-toggle="modal" data-bs-target="#offclock-add-modal" class="btn btn-block btn-primary">+ ADD</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-1">
                                <div class="table-responsive">
                                    <table id="offclock_list" class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php
                                            foreach ($offclock as $index => $value) {
                                            ?>
                                                <tr class="btn-reveal-trigger" height="20">
                                                    <td><?= $index + 1; ?></td>
                                                    <td><?= $value->full_name ?></td>
                                                    <td><?= format_date($value->date, system_date_format()); ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="badge light badge-primary"><a href="javascript:void()" data-id="<?= $value->id ?>" data-bs-toggle="modal" data-bs-target="#offclock-edit-modal" class="text-primary offclock-edit" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                                            <span class="badge light badge-danger ms-2"><a href="javascript:void()" class="text-danger btn-delete-offclock" data-id="<?= $value->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="offclock-add-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('attendance/create_offclock') ?>" method="POST" class="modal-part" id="modal-add-offclock-part">
                        <div class="modal-body">
                            <div class="row" id="dates">
                                <div class="col-md-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                    <input type="text" id="date_create" name="date" class="form-control datepicker-default" required="">
                                </div>
                            </div>
                            <div id="users2" class="form-group mb-3 hidden">
                                <label class="col-form-label">Select Employee/s' <span class="text-danger">*</span></label>
                                <select name="users[]" class="form-control select2" multiple="multiple">
                                    <?php foreach ($system_users as $system_user) {
                                        if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                            <option value="<?= $system_user->employee_id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-create-offclock btn-block btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="offclock-edit-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('attendance/edit-offclock') ?>" method="POST" class="modal-part" id="modal-edit-offclock-part">
                        <div class="modal-body">
                            <input type="hidden" name="update_id" id="update_id" value="">
                            <div class="row" id="dates">
                                <div class="col-md-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?><span class="text-danger">*</span></label>
                                    <input type="text" id="starting_date2" name="date" class="form-control datepicker-default" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Select Employee <span class="text-danger">*</span></label>
                                <select name="users" class="form-control select2" id="edit_user">
                                    <?php foreach ($system_users as $system_user) {
                                        if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                            <option value="<?= $system_user->employee_id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-edit-offclock btn-block btn-primary">Save</button>
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
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script>
        var table3 = $('#offclock_list').DataTable({
            "paging": true,
            "searching": true,
            "language": {
                "paginate": {
                    "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            "info": false,
            "lengthChange": true,
            "lengthMenu": [10, 20, 50, 500],
            "order": false,
            "pageLength": 10,
            "dom": '<"top"f>rt<"bottom"lp><"clear">'
        });
        $(".select2").select2();
        $("#offclock-add-modal").on('click', '.btn-create-offclock', function(e) {
            var modal = $('#offclock-add-modal');
            var form = $('#modal-add-offclock-part');
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
                    console.log(result);
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
        $(document).on('click', '.offclock-edit', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            $.ajax({
                type: "POST",
                url: base_url + 'attendance/get_offclock_by_id',
                data: "id=" + id,
                dataType: "json",
                beforeSend: function() {
                    $(".modal-body").append(ModelProgress);
                },
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false && result['data'] != '') {
                        $("#update_id").val(result['data'][0].id);
                        var startingDate = moment(result['data'][0].date, 'YYYY-MM-DD').format(date_format_js);
                        console.log(result['data'][0].date);
                        $('#starting_date2').daterangepicker({
                            locale: {
                                format: date_format_js
                            },
                            singleDatePicker: true,
                            startDate: startingDate,
                        });
                        $("#edit_user").val(result['data'][0].user_id).trigger('change');
                    } else {

                    }
                },
                complete: function() {
                    $(".loader-progress").remove();
                }
            });
        });
        $("#offclock-edit-modal").on('click', '.btn-edit-offclock', function(e) {
            var modal = $('#offclock-edit-modal');
            var form = $('#modal-edit-offclock-part');
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
        $(document).on('click', '.btn-delete-offclock', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: 'Are you sure?',
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
            url: base_url + 'attendance/delete_offclock/' + id,
            data: "id=" + id,
            dataType: "json",
            success: function(result) {
              if (result['error'] == false) {
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
    });
    </script>
</body>

</html>