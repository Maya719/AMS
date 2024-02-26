<div class="row d-flex justify-content-end">
    <div class="col-xl-2 col-sm-3 mt-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#add-leave-type-modal" class="btn btn-block btn-primary">+ ADD</a>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body p-1">
                <div class="table-responsive">
                    <table id="table" class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Duration</th>
                                <th>Leave Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="customers">
                            <?php foreach ($leaves_type as $type) : ?>
                                <tr>
                                    <td><?= $type["name"] ?></td>
                                    <?php
                                    if ($type["duration"] == '3_months') {
                                        $count = '3 Months';
                                    }
                                    if ($type["duration"] == 'year') {
                                        $count = 'Annual';
                                    }
                                    if ($type["duration"] == '4_months') {
                                        $count = '4 Months';
                                    }
                                    if ($type["duration"] == '6_months') {
                                        $count = '6 Months';
                                    }
                                    ?>
                                    <td><?= $count ?></td>
                                    <td><?= $type["leave_counts"] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="badge light badge-primary"><a href="#" class="text-primary edit-leave-type" data-id="<?=$type["id"]?>" data-bs-toggle="modal" data-bs-target="#edit-leave-type-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                            <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-leave-type" data-bs-toggle="tooltip" data-id="<?=$type["id"]?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
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

<div class="modal fade" id="add-leave-type-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('settings/leaves_type_create') ?>" method="POST" class="modal-part" id="modal-add-leaves-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="">
                    </div>
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?><span class="text-danger">*</span></label>
                        <select name="duration" class="form-control select2">
                            <option value="year">Annually</option>
                            <option value="3_months">For 3 Months</option>
                            <option value="4_months">For 4 Months</option>
                            <option value="6_months">For 6 Months</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= $this->lang->line('count') ? $this->lang->line('count') : 'Leaves Count' ?><span class="text-danger">*</span></label>
                        <input type="number" name="count" class="form-control" required="">
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

<div class="modal fade" id="edit-leave-type-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('settings/leaves_type_edit') ?>" method="POST" class="modal-part" id="modal-edit-leaves-type-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required="">
                    </div>
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?><span class="text-danger">*</span></label>
                        <select name="duration" id="duration" class="form-control select2">
                            <option value="year">Annually</option>
                            <option value="3_months">For 3 Months</option>
                            <option value="4_months">For 4 Months</option>
                            <option value="6_months">For 6 Months</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= $this->lang->line('count') ? $this->lang->line('count') : 'Leaves Count' ?><span class="text-danger">*</span></label>
                        <input type="number" id="count" name="count" class="form-control" required="">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-create btn-block btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>