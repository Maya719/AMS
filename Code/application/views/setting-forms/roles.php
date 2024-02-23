<div class="row d-flex justify-content-end">
    <div class="col-xl-2 col-sm-3 mt-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#add-role-modal" class="btn btn-block btn-primary">+ ADD</a>
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

<div class="modal fade" id="add-role-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('settings/roles_create') ?>" method="POST" class="modal-part" id="modal-add-role-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required="">
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                        <input type="text" name="descriptive_name" class="form-control" required="">
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('show_permissions') ? $this->lang->line('show_permissions') : 'Show Permissions' ?><span class="text-danger">*</span></label>
                        <input type="checkbox" id="selectAllUsers"> Select All
                        <select name="permissions[]" id='users' multiple='multiple'>
                            <?php foreach ($permissions_list as $permission) { ?>
                                <option value="<?= $permission['id'] ?>"><?= $permission['description'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group mt-3">
                            <label><?= $this->lang->line('department') ? $this->lang->line('department') : 'Department' ?></label>
                            <select name="departments" class="form-control select2" multiple="" id="departments">
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?= $department["id"] ?>"><?= $department["department_name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
    
                        <div class="col-lg-6 form-group mt-3">
                            <label><?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?></label>
                            <select name="shifts" class="form-control select2" multiple="" id="shifts">
                                <?php foreach ($shifts as $shift) { ?>
                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?></label>
                        <input type="checkbox" id="selectAllUsers_create"> Select All
                        <select name="users[]" id='users_create' multiple='multiple'>
                            <?php foreach ($system_users as $system_user) {
                                if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('change_permissions_of') ? $this->lang->line('change_permissions_of') : 'Change Permissions Of' ?></label>
                        <select name="change_permissions_of[]" class="form-control select2" multiple="">
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?= $group->id ?>"><?= $group->description ?></option>
                            <?php } ?>
                        </select>
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

<div class="modal fade" id="edit-role-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('settings/roles_edit') ?>" method="POST" class="modal-part" id="modal-edit-roles-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
                <input type="hidden" name="update_id" id="update_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="description" id="description" class="form-control" required="">
                    </div>

                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                        <input type="text" name="descriptive_name" id="descriptive_name" class="form-control" required="">
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('show_permissions') ? $this->lang->line('show_permissions') : 'Show Permissions' ?><span class="text-danger">*</span></label>
                        <input type="checkbox" id="selectAllPermissions"> Select All
                        <select name="permissions[]" id='permissions' multiple='multiple'>
                            <?php foreach ($permissions_list as $permission) { ?>
                                <option value="<?= $permission['id'] ?>"><?= $permission['description'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group mt-3">
                            <label><?= $this->lang->line('department') ? $this->lang->line('department') : 'Department' ?></label>
                            <select name="departments" class="form-control select2" multiple="" id="departmentsEdit">
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?= $department["id"] ?>"><?= $department["department_name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
    
                        <div class="col-lg-6 form-group mt-3">
                            <label><?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?></label>
                            <select name="shifts" class="form-control select2" multiple="" id="shiftsEdit">
                                <?php foreach ($shifts as $shift) { ?>
                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-3" id="users_roles_div">
                        <label><?= $this->lang->line('selected_users') ? $this->lang->line('selected_users') : 'Selected Users' ?><span class="text-danger">*</span></label>
                        <input type="checkbox" id="selectAllUsers4"> Select All
                        <select name="users[]" id="assigned_users" class="form-control" multiple="">
                            <?php foreach ($system_users as $system_user) {
                                if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                    <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('change_permissions_of') ? $this->lang->line('change_permissions_of') : 'Change Permissions Of' ?><span class="text-danger">*</span></label>
                        <select name="change_permissions_of[]" id="change_permissions_of" class="form-control select2" multiple="">
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?= $group->id ?>"><?= $group->description ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-edit btn-block btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>