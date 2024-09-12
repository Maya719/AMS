<?php $this->load->view('includes/header'); ?>
<link href="<?= base_url('assets2/vendor/introjs/modern.css') ?>" rel="stylesheet" type="text/css" />
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
                                <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('users') ?>">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-xl-2 col-sm-3">
                        <?php if (permissions('user_create') || $this->ion_auth->is_admin()) : ?>
                            <?php if ($add_user) : ?>
                                <a href="<?= base_url('users/create_user') ?>" class="btn btn-block btn-primary">+ ADD</a>
                            <?php else : ?>
                                <button type="button" class="btn btn-block btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    INVITE
                                </button>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-1">
                                <div class="table-responsive">
                                    <table id="employee_list" class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php foreach ($system_users as $index => $user) : ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                                                    <td><?= $user->email ?></td>
                                                    <td><?= $user->phone ?></td>
                                                    <td><?= ($user->active == 1) ? '<span class="badge light badge-primary">Active</span>' : '<span class="badge light badge-danger">Inactive</span>' ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="badge light badge-primary"><a href="javascript:void()" data-id="<?= $user->id ?>" class="text-primary user-edit" data-bs-toggle="modal" data-bs-target="#edit-user-model"><i class="fa fa-pencil color-muted"></i></a></span>
                                                            <span class="badge light badge-danger ms-2"><a href="javascript:void()" data-id="<?= $user->id ?>" class="text-danger user_delete_btn" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Invite User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('auth/invite') ?>" method="post" id="modal-invite-part">
                            <input type="hidden" name="group_id" value="<?= $group_id ?>">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-invite-user btn btn-primary">Invite</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-user-model" tabindex="-1" aria-labelledby="edit-user-modelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-user-modelLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('auth/edit-user') ?>" method="post" id="edit-user-part">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First name">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="text" name="password_confirm" class="form-control" id="password_confirm" placeholder="Confirm Password">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div id="statusDiv">
                        </div>
                        <button type="button" class="user_delete_btn btn btn-danger" id="deleteBTN">Delete</button>
                        <button type="button" class="save btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
  Content body end
***********************************-->
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script>
        var table3 = $('#employee_list').DataTable({
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

        $("#exampleModal").on('click', '.btn-invite-user', function(e) {
            var modal = $('#exampleModal');
            var form = $('#modal-invite-part');
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
        $(document).on('click', '.user-edit', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: base_url + 'users/get_user_by_id',
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $(".modal-body").append(ModelProgress);
                },
                success: function(result) {
                    console.log(result);
                    $("#update_id").val(result.id);
                    $("#email").val(result.email);
                    $("#first_name").val(result.first_name);
                    $("#last_name").val(result.last_name);
                    $("#phone").val(result.phone);
                    $('#deleteBTN').attr('data-id', result.id);
                    if (result.active == 1) {
                        $('#statusDiv').html('<button type="button" class="btn btn-danger" data-id="' + result.id + '" id="deactivateBTN">Deactivate</button>');
                    } else {
                        $('#statusDiv').html('<button type="button" class="btn btn-primary" data-id="' + result.id + '" id="user_active_btn">Activate</button>');
                    }
                },
                complete: function() {
                    $(".loader-progress").remove();
                }
            });
        });
        $("#edit-user-model").on('click', '.save', function(e) {
            var modal = $('#edit-user-model');
            var form = $('#edit-user-part');
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
        $(document).on('click', '.user_delete_btn', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            Swal.fire({
                title: are_you_sure,
                text: you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/delete_user',
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
        $(document).on('click', '#deactivateBTN', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);

            Swal.fire({
                title: are_you_sure,
                text: you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/deactivate',
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            if (result['error'] == false) {
                                location.reload();
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
                                })
                            }
                        }
                    });
                }
            });
        });
        $(document).on('click', '#user_active_btn', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);

            Swal.fire({
                title: are_you_sure,
                text: you_want_to_activate_this_user,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/activate',
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