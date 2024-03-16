<div class="row d-flex justify-content-end">
  <div class="col-xl-2 col-sm-3 mt-2">
    <a href="#" data-bs-toggle="modal" data-bs-target="#add-device-modal" class="btn btn-block btn-primary">+ ADD</a>
  </div>
  <div class="card mt-3 p-0">
    <div class="card-body p-0">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="table" class="table table-sm mb-0">
            <thead>
              <tr>
                <th data-field="device_name" data-sortable="true"><?= $this->lang->line('device_name') ? $this->lang->line('device_name') : 'Device Name' ?></th>
                <th data-field="device_ip" data-sortable="true"><?= $this->lang->line('device_ip') ? $this->lang->line('device_ip') : 'Device IP Address' ?></th>
                <th data-field="port" data-sortable="true"><?= $this->lang->line('port') ? $this->lang->line('port') : 'Device External Port' ?></th>
                <th data-field="action" data-sortable="false"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($devices as $device) : ?>
                <tr>
                  <td><?= $device["device_name"] ?></td>
                  <td><?= $device["device_ip"] ?></td>
                  <td><?= $device["port"] ?></td>
                  <td>
                    <div class="d-flex">
                      <span class="badge light badge-primary"><a href="#" class="text-primary edit-device" data-id="<?= $device["id"] ?>" data-bs-toggle="modal" data-bs-target="#edit-device-modal" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                      <span class="badge light badge-danger ms-2"><a href="#" class="text-danger delete-device" data-bs-toggle="tooltip" data-id="<?= $device["id"] ?>" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>
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


<div class="modal fade" id="add-device-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('device_config/create') ?>" method="POST" class="modal-part" id="modal-add-device-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
        <div class="modal-body">
          <div class="row" id="dates">
            <div class="form-group col-md-12 mb-3">
              <label class="col-form-label"><?= $this->lang->line('device_name') ? $this->lang->line('device_name') : 'Device name' ?><span class="text-danger">*</span></label>
              <input type="text" name="device_name" class="form-control" required="">
            </div>
            <div class="form-group col-md-12 mb-3">
              <label class="col-form-label"><?= $this->lang->line('device_ip') ? $this->lang->line('device_ip') : 'Device Ip Address' ?><span class="text-danger">*</span></label>
              <input type="text" name="device_ip" class="form-control" required="">
            </div>
            <div class="form-group col-md-12">
              <label class="col-form-label"><?= $this->lang->line('port') ? $this->lang->line('port') : 'Device External Port' ?><span class="text-danger">*</span></label>
              <input type="text" name="port" class="form-control" required="">
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

<div class="modal fade" id="edit-device-modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?=base_url('device_config/edit')?>" method="POST" class="modal-part" id="modal-edit-device-part" data-title="<?=$this->lang->line('edit')?$this->lang->line('edit'):'Edit'?>" data-btn="<?=$this->lang->line('update')?$this->lang->line('update'):'Update'?>">
        <div class="modal-body">
          <input type="hidden" name="update_id" id="update_id" value="">
          <div class="row" id="dates">
            <div class="form-group col-md-12">
              <label class="col-form-label"><?= $this->lang->line('device_name') ? $this->lang->line('device_name') : 'Device name' ?><span class="text-danger">*</span></label>
              <input type="text" name="device_name" id="device_name" class="form-control" required="">
            </div>
            <div class="form-group col-md-12">
              <label class="col-form-label"><?= $this->lang->line('device_ip') ? $this->lang->line('device_ip') : 'Device Ip Address' ?><span class="text-danger">*</span></label>
              <input type="text" name="device_ip" id="device_ip" class="form-control" required="">
            </div>
            <div class="form-group col-md-12">
              <label class="col-form-label"><?= $this->lang->line('port') ? $this->lang->line('port') : 'Device External Port' ?><span class="text-danger">*</span></label>
              <input type="text" name="port" id="port" class="form-control" required="">
            </div>
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