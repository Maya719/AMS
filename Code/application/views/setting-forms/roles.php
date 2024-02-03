<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="leave_list" class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th data-field="sr_no" data-sortable="false" class="left-pad"><?= $this->lang->line('sr_no') ? $this->lang->line('sr_no') : 'S.no' ?></th>
                                <th data-field="id" data-sortable="false" data-visible="false" class="left-pad"><?= $this->lang->line('id') ? $this->lang->line('id') : 'ID' ?></th>
                                <th data-field="description" data-sortable="false" class="left-pad"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?></th>
                                <th data-field="descriptive_name" data-sortable="false" class="left-pad"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?></th>
                                <th data-field="permissions" data-sortable="false" data-formatter="permissionsFormatter" class="left-pad">
                                    <?= $this->lang->line('show_permissions') ? htmlspecialchars($this->lang->line('show_permissions')) : 'Show Permissions' ?>
                                </th>
                                <th data-field="users" data-sortable="false" class="left-pad" data-formatter="teamMembersFormatter" class="left-pad">
                                    <?= $this->lang->line('aasigned_users') ? htmlspecialchars($this->lang->line('aasigned_users')) : 'Assigned Users' ?>
                                </th>
                                <th data-field="change_permissions" data-sortable="false" class="left-pad"><?= $this->lang->line('change_permissions') ? $this->lang->line('change_permissions') : 'Change Permissions Of' ?></th>
                                <th data-field="action" data-sortable="false" class="left-pad"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>