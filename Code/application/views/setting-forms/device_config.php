<div class="row">
  <div class="card">
    <div class="card-body">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="leave_list" class="table table-sm mb-0">
            <thead>
              <tr>
                <th data-field="s_no" data-sortable="false"><?= $this->lang->line('sr_no') ? $this->lang->line('s_no') : '#' ?></th>
                <th data-field="device_name" data-sortable="true"><?= $this->lang->line('device_name') ? $this->lang->line('device_name') : 'Device Name' ?></th>
                <th data-field="device_ip" data-sortable="true"><?= $this->lang->line('device_ip') ? $this->lang->line('device_ip') : 'Device IP Address' ?></th>
                <th data-field="port" data-sortable="true"><?= $this->lang->line('port') ? $this->lang->line('port') : 'Device External Port' ?></th>
                <th data-field="users" data-sortable="false" class="left-pad" data-formatter="teamMembersFormatter">
                  <?= $this->lang->line('team_member') ? htmlspecialchars($this->lang->line('team_member')) : 'Team Member' ?>
                </th>
                <th data-field="action" data-sortable="false"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>