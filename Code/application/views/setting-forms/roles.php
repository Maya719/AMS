<div class="row">
    <div class="col-xl-2 col-sm-3 mt-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#add-department-modal" class="btn btn-block btn-primary">+ ADD</a>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="leave_list" class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th data-field="description" data-sortable="false" class="left-pad"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?></th>
                                <th data-field="descriptive_name" data-sortable="false" class="left-pad"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?></th>
                                <th data-field="action" data-sortable="false" class="left-pad"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($groups as $group) : ?>
                                <tr>
                                    <td><?= $group->name ?></td>
                                    <td><?= $group->description ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="badge light badge-primary"><a href="#" class="text-primary edit-department" data-id="<?= $group->id ?>" data-bs-toggle="modal" data-bs-target="#edit-department-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                            <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-department" data-bs-toggle="tooltip" data-id="<?= $group->id ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
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

<div class="modal fade" id="add-department-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('settings/roles_create') ?>" method="POST" class="modal-part" id="modal-add-leaves-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required="">
                    </div>
                    <div class="form-group mt-3">
                        <label><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                        <input type="text" name="descriptive_name" class="form-control" required="">
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

<div class="modal fade" id="edit-department-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('department/edit') ?>" method="POST" class="modal-part" id="modal-edit-department-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
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