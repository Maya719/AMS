<?php $this->load->view('includes/header'); ?>
<link href="<?= base_url('assets2/vendor/introjs/modern.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .hidden {
        display: none;
    }

    .image-option img {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        vertical-align: middle;
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
        <!--**********************************
    Sidebar start
***********************************-->
        <?php $this->load->view('includes/sidebar'); ?>
        <!--**********************************
    Sidebar end
***********************************-->
        <div class="content-body default-height">
            <div class="container-fluid">
                <div class="row d-flex justify-content-end">
                    <div class="col-xl-2 col-sm-3 mt-2">
                        <a href="#" id="role-model-btn" data-bs-toggle="modal" data-bs-target="#add-role-modal" class="btn btn-block btn-primary">+ ADD</a>
                    </div>
                    <div class="card mt-3 p-0">
                        <div class="card-body p-1">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="table" class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th data-field="sr" data-sortable="false" class="left-pad"><?= $this->lang->line('sr') ? $this->lang->line('sr') : '#' ?></th>
                                                <th data-field="description" data-sortable="false" class="left-pad"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?></th>
                                                <th data-field="descriptive_name" data-sortable="false" class="left-pad"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?></th>
                                                <th data-field="action" data-sortable="false" class="left-pad"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            ?>
                                            <?php foreach ($groups as $group) : ?>
                                                <tr>
                                                    <td><?= $count ?></td>
                                                    <td><?= $group->name ?></td>
                                                    <td><?= $group->description ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="badge light badge-primary"><a href="#" class="text-primary edit-role" data-id="<?= $group->id ?>" data-bs-toggle="modal" data-bs-target="#edit-role-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                                            <?php if ($group->name !== 'employee' && $group->name !== 'client' && $group->name !== 'hr_manager' && $group->name !== 'ceo' && $group->name !== 'partners') : ?>
                                                                <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-role" data-bs-toggle="tooltip" data-id="<?= $group->id ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
                                                            <?php endif ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                $count++
                                                ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="add-role-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('permissions/create') ?>" method="POST" class="modal-part" id="modal-add-role-part">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">name</label>
                                            <input type="text" class="form-control" name="description" id="exampleFormControlInput1">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                                            <input type="type" class="form-control" name="descriptive_name" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Attendance</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="attendance_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="offclock_view">
                                                <label class="form-check-label" for="">Off Clock</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Leaves</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_status">
                                                <label class="form-check-label" for="">approval</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_status_edit">
                                                <label class="form-check-label" for="">edit approval</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_cancel">
                                                <label class="form-check-label" for="">Approve Cancelation</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Leaves Type</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leave_type_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leave_type_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leave_type_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leave_type_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Biomatric Request</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_status">
                                                <label class="form-check-label" for="">approval</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Project</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Tasks</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_status">
                                                <label class="form-check-label" for="">status change</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Employees</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Departments</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="departments_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="departments_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="departments_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="departments_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Plan Holiday</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Shifts</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="shift_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="shift_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="shift_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="shift_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Notes</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="notes_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">TODO</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="todo_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Client</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_view">
                                                <label class="form-check-label" for="">View</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_create">
                                                <label class="form-check-label" for="">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_delete">
                                                <label class="form-check-label" for="">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Chat</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="chat_view">
                                                <label class="form-check-label" for="">View</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="chat_delete">
                                                <label class="form-check-label" for="">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="team_members_and_client_can_chat">
                                                <label class="form-check-label" for="">Employee and client can chat</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <select class="form-control select2" name="all_selected_edit" id="all_selected">
                                            <option value="all">ALL</option>
                                            <option value="selected">Select Users</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3 hidden" id="selected_div">
                                        <label class="col-form-label"><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?></label>
                                        <select name="users[]" id="change_permissions_of" class="form-control select2" multiple="">
                                            <?php foreach ($system_users as $system_user) {
                                                if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div id="roller2">
                                        <div class="form-group mt-3">
                                            <label for="show_with" class="form-label">Show in Employee Management</label>
                                            <select class="form-control select2" name="show_with" id="show_with2">
                                                <option value="1">With Employee</option>
                                                <option value="2">Individual</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3 hidden" id="icon-select-div2">
                                            <label for="imageSelector2" class="form-label">Icon</label>
                                            <select class="form-control" id="imageSelector2" name="icon">
                                                <option value="assets2/images/avatar/ceo.png" data-image="<?= base_url('assets2/images/avatar/ceo.png') ?>">CEO</option>
                                                <option value="assets2/images/avatar/ceo.png" data-image="<?= base_url('assets2/images/avatar/ceo.png') ?>">CEO 2</option>
                                                <option value="assets2/images/avatar/employee.png" data-image="<?= base_url('assets2/images/avatar/employee.png') ?>">EMPLOYEE</option>
                                                <option value="assets2/images/avatar/employee2.png" data-image="<?= base_url('assets2/images/avatar/employee2.png') ?>">EMPLOYEE 2</option>
                                                <option value="assets2/images/avatar/hr.png" data-image="<?= base_url('assets2/images/avatar/hr.png') ?>">GIRL</option>
                                                <option value="assets2/images/avatar/girl.png" data-image="<?= base_url('assets2/images/avatar/girl.png') ?>">GIRL 2</option>
                                                <option value="assets2/images/avatar/worker.png" data-image="<?= base_url('assets2/images/avatar/worker.png') ?>">WORKER</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-create">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="edit-role-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('permissions/edit') ?>" method="POST" class="modal-part" id="modal-edit-role-part">
                                    <input type="hidden" name="update_id" id="update_id">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="description" class="form-label">name</label>
                                            <input type="text" class="form-control" name="description" id="description">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="descriptive_name" class="form-label">Description</label>
                                            <input type="type" class="form-control" name="descriptive_name" id="descriptive_name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Attendance</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="attendance_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="offclock_view">
                                                <label class="form-check-label" for="">Off Clock</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Leaves</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_status">
                                                <label class="form-check-label" for="">approval</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_status_edit">
                                                <label class="form-check-label" for="">edit approval</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="leaves_cancel">
                                                <label class="form-check-label" for="">Approve Cancelation</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Biomatric Request</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="biometric_request_status">
                                                <label class="form-check-label" for="">approval</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Project</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="project_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Tasks</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="task_status">
                                                <label class="form-check-label" for="">status change</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Employees</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="user_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Plan Holiday</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_create">
                                                <label class="form-check-label" for="">create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="plan_holiday_delete">
                                                <label class="form-check-label" for="">delete</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Notes</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="notes_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">TODO</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="todo_view">
                                                <label class="form-check-label" for="">view</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Client</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_view">
                                                <label class="form-check-label" for="">View</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_create">
                                                <label class="form-check-label" for="">Create</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_edit">
                                                <label class="form-check-label" for="">edit</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="client_delete">
                                                <label class="form-check-label" for="">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="">Chat</label>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="chat_view">
                                                <label class="form-check-label" for="">View</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="chat_delete">
                                                <label class="form-check-label" for="">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="" name="team_members_and_client_can_chat">
                                                <label class="form-check-label" for="">Employee and client can chat</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <select class="form-control select2" name="all_selected_edit" id="all_selected_edit">
                                            <option value="all">ALL</option>
                                            <option value="selected">Select Users</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3" id="selected_div_edit">
                                        <label class="col-form-label"><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?></label>
                                        <select name="users[]" id="selectedUsersSelect" class="form-control select2" multiple="">
                                            <?php foreach ($system_users as $system_user) {
                                                if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div id="roller">
                                        <div class="form-group mt-3">
                                            <label for="show_with" class="form-label">Show in Employee Management</label>
                                            <select class="form-control select2" name="show_with" id="show_with">
                                                <option value="1">With Employee</option>
                                                <option value="2">Individual</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3 hidden" id="icon-select-div">
                                            <label for="imageSelector" class="form-label">Icon</label>
                                            <select class="form-control" id="imageSelector" name="icon">
                                                <option value="assets2/images/avatar/ceo.png" data-image="<?= base_url('assets2/images/avatar/ceo.png') ?>">CEO</option>
                                                <option value="assets2/images/avatar/ceo.png" data-image="<?= base_url('assets2/images/avatar/ceo.png') ?>">CEO 2</option>
                                                <option value="assets2/images/avatar/employee.png" data-image="<?= base_url('assets2/images/avatar/employee.png') ?>">EMPLOYEE</option>
                                                <option value="assets2/images/avatar/employee2.png" data-image="<?= base_url('assets2/images/avatar/employee2.png') ?>">EMPLOYEE 2</option>
                                                <option value="assets2/images/avatar/hr.png" data-image="<?= base_url('assets2/images/avatar/hr.png') ?>">GIRL</option>
                                                <option value="assets2/images/avatar/girl.png" data-image="<?= base_url('assets2/images/avatar/girl.png') ?>">GIRL 2</option>
                                                <option value="assets2/images/avatar/worker.png" data-image="<?= base_url('assets2/images/avatar/worker.png') ?>">WORKER</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-edit">Save Changes</button>
                            </div>
                        </div>
                    </div>
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
        $('#table').DataTable({
            "paging": true,
            "searching": false,
            "language": {
                "paginate": {
                    "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            "info": false,
            "dom": '<"top"i>rt<"bottom"lp><"clear">',
            "lengthMenu": [10, 20, 50, 500],
            "pageLength": 10
        });
        /*
         *
         *roles
         * 
         */
        $("#add-role-modal").on('click', '.btn-create', function(e) {
            var modal = $('#add-role-modal');
            var form = $('#modal-add-role-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    if (result['error'] == false) {
                        location.reload();
                    } else {
                        modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                }
            });

            e.preventDefault();
        });

        $("#edit-role-modal").on('click', '.btn-edit', function(e) {
            var modal = $('#edit-role-modal');
            var form = $('#modal-edit-role-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    if (result['error'] == false) {
                        location.reload();
                    } else {
                        modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                }
            });

            e.preventDefault();
        });
        $(document).on('click', '.edit-role', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            $.ajax({
                type: "POST",
                url: base_url + 'permissions/get_roles_by_id',
                data: "id=" + id,
                dataType: "json",
                success: function(result) {
                    if (result['error'] == false) {
                        console.log(result);
                        $("#update_id").val(result['data'].id);
                        $("#description").val(result['data'].description);
                        console.log(result['data'].description);
                        $("#description").trigger("change");
                        if (result['data'].name == 'employee' || result['data'].name == 'ceo' || result['data'].name == 'partners' || result['data'].name == 'client' || result['data'].name == 'hr_manager') {
                            $("#roller").addClass('hidden');
                            $("#imageSelector").val('').trigger('change');
                            $('#description').prop('readonly', true)
                            $('#descriptive_name').prop('readonly', true)
                        } else {
                            $("#imageSelector").val(result['data'].icon).trigger('change');
                            $("#roller").removeClass('hidden');
                        }
                        $("#descriptive_name").val(result['data'].descriptive_name);
                        $("#descriptive_name").trigger("change");
                        $("input[type='checkbox']").prop('checked', false);
                        $.each(result.data.permissions, function(permission, isChecked) {
                            if (isChecked == '1') {
                                $("input[name='" + permission + "']").prop('checked', true);
                            }
                        });
                        console.log(result['data'].show_with);
                        if (result['data'].show_with == "2") {
                            $("#show_with").val('2').trigger('change');
                            $("#icon-select-div").removeClass('hidden');
                        } else {
                            $("#show_with").val('1').trigger('change');
                            $("#icon-select-div").addClass('hidden');
                        }
                        var assignedUsers = JSON.parse(result['data'].assigned_users);
                        if (assignedUsers.length > 0) {
                            console.log(assignedUsers);
                            $("#all_selected_edit").val('selected').trigger('change');
                            $("#selectedUsersSelect").val(assignedUsers).trigger('change');
                        } else {
                            $("#all_selected_edit").val('all').trigger('change');
                            $("#selected_div_edit").addClass('hidden');
                        }

                        $("#modal-edit-roles").trigger("click");
                    } else {
                        iziToast.error({
                            title: something_wrong_try_again,
                            message: "",
                            position: 'topRight'
                        });
                    }
                }
            });
        });


        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
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
                        url: base_url + 'settings/roles_delete/' + id,
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            if (result['error'] == false) {
                                location.reload()
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
        $("#add-leave-type-modal").on('click', '.btn-create', function(e) {
            var modal = $('#add-leave-type-modal');
            var form = $('#modal-add-leaves-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    if (result['error'] == false) {
                        location.reload();
                    } else {
                        modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                }
            });

            e.preventDefault();
        });
        $(".select2").select2();
        $("#selectedUsersSelect").select2();
        $(document).ready(function() {
            // Initialize Select2
            $("#selectedUsersSelect").select2({
                width: '100%'
            });

        });
        $(document).ready(function() {
            // Initialize Select2
            $("#change_permissions_of").select2({
                width: '100%'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#show_with').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === '2') {
                    $('#icon-select-div').removeClass('hidden');
                } else {

                    $('#icon-select-div').addClass('hidden');
                }
            });
            $('#show_with2').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === '2') {
                    $('#icon-select-div2').removeClass('hidden');
                } else {

                    $('#icon-select-div2').addClass('hidden');
                }
            });
            $('#all_selected').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'selected') {
                    $('#selected_div').removeClass('hidden');
                } else {
                    $('#change_permissions_of').select2();
                    var preSelectedValues = [];
                    $('#change_permissions_of').val(preSelectedValues).trigger('change');
                    $('#selected_div').addClass('hidden');
                }
            });
            $('#all_selected_edit').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'selected') {
                    $('#selected_div_edit').removeClass('hidden');
                } else {
                    $('#selectedUsersSelect').select2();
                    var preSelectedValues = [];
                    $('#selectedUsersSelect').val(preSelectedValues).trigger('change');
                    $('#selected_div_edit').addClass('hidden');
                }
            });
        });
    </script>

    <script>
        // Function to format dropdown options with image
        function formatImage(option) {
            if (!option.id) {
                return option.text;
            }

            // Create image HTML
            var imageUrl = $(option.element).data('image');
            var optionTemplate = $(
                '<span class="image-option"><img src="' + imageUrl + '" alt="' + option.text + '"/> ' + option.text + '</span>'
            );

            return optionTemplate;
        }

        $('#imageSelector').select2({
            templateResult: formatImage, // Render images in dropdown options
            templateSelection: formatImage, // Show selected image
            minimumResultsForSearch: -1 // Hide search box (optional)
        });
        $('#imageSelector2').select2({
            templateResult: formatImage, // Render images in dropdown options
            templateSelection: formatImage, // Show selected image
            minimumResultsForSearch: -1 // Hide search box (optional)
        });
    </script>
</body>

</html>