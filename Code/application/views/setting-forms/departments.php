<div class="row d-flex justify-content-end">
  <div class="col-xl-2 col-sm-3 mt-2">
    <a href="#" data-bs-toggle="modal" data-bs-target="#add-department-modal" class="btn btn-block btn-primary">+ ADD</a>
  </div>
  <div class="card mt-3 p-0">
    <div class="card-body p-1">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="table" class="table table-sm mb-0">
            <thead>
              <tr>
                <th data-field="s_no" data-sortable="false"><?= $this->lang->line('sr_no') ? $this->lang->line('s_no') : '#' ?></th>
                <th data-field="department_name" data-sortable="true"><?= $this->lang->line('department_name') ? $this->lang->line('department_name') : 'Department Name' ?></th>
                <th data-field="action" data-sortable="false"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              ?>
              <?php foreach ($departments as $department) : ?>
                <tr>
                  <td><?= $count ?></td>
                  <td><?= $department["department_name"] ?></td>
                  <td>
                    <div class="d-flex">
                      <span class="badge light badge-primary"><a href="#" class="text-primary edit-department" data-id="<?= $department["id"] ?>" data-bs-toggle="modal" data-bs-target="#edit-department-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                      <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-department" data-bs-toggle="tooltip" data-id="<?= $department["id"] ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
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

<div class="modal fade" id="add-department-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('department/create') ?>" method="POST" class="modal-part" id="modal-add-department-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
        <div class="modal-body">
          <div class="form-group">
            <label><?= $this->lang->line('department_name') ? $this->lang->line('department_name') : 'Department Name' ?><span class="text-danger">*</span></label>
            <input type="text" name="department_name" class="form-control" required="">
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
            <label><?= $this->lang->line('department_name') ? $this->lang->line('department_name') : 'Department Name' ?><span class="text-danger">*</span></label>
            <input type="text" name="department_name" id="department_name" class="form-control" required="">
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