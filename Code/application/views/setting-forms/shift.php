<div class="row d-flex justify-content-end">
    <div class="col-xl-2 col-sm-3 mt-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#add-shift-modal" class="btn btn-block btn-primary">+ ADD</a>
    </div>
    <div class="card mt-3 p-0">
        <div class="card-body p-1">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table" class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th data-field="sr_no" data-sortable="false" class="left-pad"><?= $this->lang->line('sr_no') ? $this->lang->line('sr_no') : '#' ?></th>
                                <th data-field="name" data-sortable="false" class="left-pad"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?></th>
                                <th data-field="starting_time" data-sortable="false" class="left-pad"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?></th>
                                <th data-field="ending_time" data-sortable="false" class="left-pad"><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?></th>
                                <th data-field="break_start" data-sortable="false" class="left-pad" data-visible="true"><?= $this->lang->line('break_start') ? $this->lang->line('break_start') : 'Break Start' ?></th>
                                <th data-field="break_end" data-sortable="false" class="left-pad"><?= $this->lang->line('break_end') ? $this->lang->line('break_end') : 'Break End' ?></th>
                                <th data-field="half_day_check_in" data-sortable="false" class="left-pad"><?= $this->lang->line('half_day_check_in') ? $this->lang->line('half_day_check_in') : 'Half Day Check In' ?></th>
                                <th data-field="half_day_check_out" data-sortable="false" class="left-pad"><?= $this->lang->line('half_day_check_out') ? $this->lang->line('half_day_check_out') : 'Half Day Check Out' ?></th>
                                <th data-field="action" data-sortable="false" class="left-pad"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            ?>
                            <?php foreach ($shift_types as $shift_type) : ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= $shift_type["name"] ?></td>
                                    <td><?= $shift_type["starting_time"] ?></td>
                                    <td><?= $shift_type["ending_time"] ?></td>
                                    <td><?= $shift_type["break_start"] ?></td>
                                    <td><?= $shift_type["break_end"] ?></td>
                                    <td><?= $shift_type["half_day_check_in"] ?></td>
                                    <td><?= $shift_type["half_day_check_out"] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="badge light badge-primary"><a href="#" class="text-primary edit-shift" data-id="<?= $shift_type["id"] ?>" data-bs-toggle="modal" data-bs-target="#edit-shift-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                            <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-shift" data-bs-toggle="tooltip" data-id="<?= $shift_type["id"] ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $count++;
                                ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-shift-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('shift/create') ?>" method="POST" class="modal-part" id="modal-add-leaves-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                            <input type="text" name="starting_time" class="form-control timepicker" required="" value="9:00 AM">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                            <input type="text" name="ending_time" class="form-control timepicker" required="" value="6:00 PM">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label><?= $this->lang->line('break_start') ? $this->lang->line('break_start') : 'Break Start' ?><span class="text-danger">*</span></label>
                            <input type="text" name="break_start" class="form-control timepicker" required="" value="1:15 PM">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label><?= $this->lang->line('break_end') ? $this->lang->line('break_end') : 'Break End' ?><span class="text-danger">*</span></label>
                            <input type="text" name="break_end" class="form-control timepicker" required="" value="2:15 PM">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('half_day_check_in') ? $this->lang->line('half_day_check_in') : 'Half Day Check In' ?><span class="text-danger">*</span></label>
                            <input type="text" name="half_day_check_in" class="form-control timepicker" required="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('half_day_check_out') ? $this->lang->line('half_day_check_out') : 'Half Day Check Out' ?><span class="text-danger">*</span></label>
                            <input type="text" name="half_day_check_out" class="form-control timepicker" required="">
                        </div>
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
<div class="modal fade" id="edit-shift-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('shift/edit') ?>" method="POST" class="modal-part" id="modal-edit-shift-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
                <input type="hidden" name="update_id" id="update_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Type' ?></label>
                        <select name="type" class="form-control select2" id="type">
                            <?php foreach ($shift_types as $shift_type) { ?>
                                <option value="<?= $shift_type['id'] ?>"><?= $shift_type['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                            <input type="text" name="starting_time" id="starting_time" class="form-control timepicker" required="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('ending_time') ? $this->lang->line('ending_time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                            <input type="text" name="ending_time" id="ending_time" class="form-control timepicker" required="" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('break_start') ? $this->lang->line('break_start') : 'Break Start' ?><span class="text-danger">*</span></label>
                            <input type="text" name="break_start" id="break_start" class="form-control timepicker" required="" >
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('break_end') ? $this->lang->line('break_end') : 'Break End' ?><span class="text-danger">*</span></label>
                            <input type="text" name="break_end" id="break_end" class="form-control timepicker" required="" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('half_day_check_in') ? $this->lang->line('half_day_check_in') : 'Half Day Check In' ?><span class="text-danger">*</span></label>
                            <input type="text" name="half_day_check_in" id="half_day_check_in" class="form-control timepicker" required="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?= $this->lang->line('half_day_check_out') ? $this->lang->line('half_day_check_out') : 'Half Day Check Out' ?><span class="text-danger">*</span></label>
                            <input type="text" name="half_day_check_out" id="half_day_check_out" class="form-control timepicker" required="">
                        </div>
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