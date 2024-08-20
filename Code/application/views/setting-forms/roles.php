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
                                                            <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-role" data-bs-toggle="tooltip" data-id="<?= $group->id ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
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
                                        <label class="col-form-label"><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?></label>
                                        <input type="checkbox" id="selectAllUsers"> Select All
                                        <select name="users[]" id="change_permissions_of" class="form-control select2" multiple="">
                                            <?php foreach ($system_users as $system_user) {
                                                if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                            <?php }
                                            } ?>
                                        </select>
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
                                        <label class="col-form-label"><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?></label>
                                        <input type="checkbox" id="selectAllUsersEdit"> Select All
                                        <select name="users[]" id="selectedUsersSelect" class="form-control select2" multiple="">
                                            <?php foreach ($system_users as $system_user) {
                                                if ($system_user->active == '1' && $system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                            <?php }
                                            } ?>
                                        </select>
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
                        console.log(result["data"]);
                        $("#update_id").val(result['data'].id);
                        $("#description").val(result['data'].description);
                        $("#description").trigger("change");
                        $("#descriptive_name").val(result['data'].descriptive_name);
                        $("#descriptive_name").trigger("change");
                        $("input[type='checkbox']").prop('checked', false);
                        $.each(result.data.permissions, function(permission, isChecked) {
                            if (isChecked == '1') {
                                $("input[name='" + permission + "']").prop('checked', true);
                            }
                        });

                        var assignedUsers = JSON.parse(result.data.assigned_users);
                        console.log(assignedUsers);
                        $("#selectedUsersSelect").val(assignedUsers).trigger('change');
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

            // Handle Select All checkbox
            $("#selectAllUsersEdit").on('change', function() {
                var selectAll = $(this).is(':checked');

                if (selectAll) {
                    // Select all options
                    var allOptionValues = $("#selectedUsersSelect").find('option').map(function() {
                        return $(this).val();
                    }).get();
                    $("#selectedUsersSelect").val(allOptionValues).trigger('change');
                } else {
                    // Deselect all options
                    $("#selectedUsersSelect").val([]).trigger('change');
                }
            });

            // Update "Select All" checkbox based on individual selections
            $("#selectedUsersSelect").on('select2:select', function() {
                var selectedCount = $(this).find('option:selected').length;
                var totalOptions = $(this).find('option').length;

                if (selectedCount === totalOptions) {
                    $("#selectAllUsersEdit").prop('checked', true);
                } else {
                    $("#selectAllUsersEdit").prop('checked', false);
                }
            });

            $("#selectedUsersSelect").on('select2:unselect', function() {
                var selectedCount = $(this).find('option:selected').length;
                var totalOptions = $(this).find('option').length;

                if (selectedCount < totalOptions) {
                    $("#selectAllUsersEdit").prop('checked', false);
                }
            });
        });
        $(document).ready(function() {
            // Initialize Select2
            $("#change_permissions_of").select2({
                width: '100%'
            });

            // Handle Select All checkbox
            $("#selectAllUsers").on('change', function() {
                var selectAll = $(this).is(':checked');

                if (selectAll) {
                    // Select all options
                    var allOptionValues = $("#change_permissions_of").find('option').map(function() {
                        return $(this).val();
                    }).get();
                    $("#change_permissions_of").val(allOptionValues).trigger('change');
                } else {
                    // Deselect all options
                    $("#change_permissions_of").val([]).trigger('change');
                }
            });

            // Update "Select All" checkbox based on individual selections
            $("#change_permissions_of").on('select2:select', function() {
                var selectedCount = $(this).find('option:selected').length;
                var totalOptions = $(this).find('option').length;

                if (selectedCount === totalOptions) {
                    $("#selectAllUsers").prop('checked', true);
                } else {
                    $("#selectAllUsers").prop('checked', false);
                }
            });

            $("#change_permissions_of").on('select2:unselect', function() {
                var selectedCount = $(this).find('option:selected').length;
                var totalOptions = $(this).find('option').length;

                if (selectedCount < totalOptions) {
                    $("#selectAllUsers").prop('checked', false);
                }
            });
        });
    </script>
</body>

</html>