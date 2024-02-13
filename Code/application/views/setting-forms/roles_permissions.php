<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <form action="<?= base_url('settings/save-permissions-setting') ?>" method="POST" id="setting-form">
        <div class="card-body">
          <div class="alert alert-danger col-md-12 center">
            <b><?= $this->lang->line('note') ? $this->lang->line('note') : 'Note' ?></b> <?= $this->lang->line('admin_always_have_all_the_permission_here_you_can_set_permissions_for_other_roles') ? $this->lang->line('admin_always_have_all_the_permission_here_you_can_set_permissions_for_other_roles') : "Admin always have all the permission. Here you can set permissions for other roles." ?>
          </div>
          <div class="accordion accordion-solid-bg" id="accordion-eight">
            <?php if ($this->ion_auth->is_admin()) { ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?= $this->lang->line('general_permissions') ? $this->lang->line('general_permissions') : 'General permissions' ?> </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion-eight">
                  <div class="accordion-body">
                    <div class="form-group mt-2 col-md-12">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="team_members_and_client_can_chat" name="team_members_and_client_can_chat" value="<?= (isset($members_permissions->team_members_and_client_can_chat) && !empty($members_permissions->team_members_and_client_can_chat)) ? $members_permissions->team_members_and_client_can_chat : 0 ?>" <?= (isset($members_permissions->team_members_and_client_can_chat) && !empty($members_permissions->team_members_and_client_can_chat) && $members_permissions->team_members_and_client_can_chat == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="team_members_and_client_can_chat"><?= $this->lang->line('team_embers_and_client_can_chat') ? $this->lang->line('team_embers_and_client_can_chat') : 'Team Members and Client can chat?' ?></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
            <?php foreach ($roles as $role) : ?>
              <input type="hidden" name="<?= $role['name'] ?>" id="<?= $role['name'] ?>" value="<?php if (!$this->ion_auth->is_admin() && !change_permissions($role['id'])) : echo $role['id'];
                                                                                                endif; ?>">
              <?php if ($this->ion_auth->is_admin() || change_permissions($role['id'])) :
                $permissionsVariableName = $role['name'] . '_permissions';
                $permissions = $permissionsVariableName; ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="<?= $this->lang->line($role['description'] . '_permissions') ? $this->lang->line($role['description'] . '_permissions') : $role['description'] . ' Permissions' ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $role['name'] ?>-permissions" aria-expanded="false" aria-controls="collapseTwo">
                      <?= $this->lang->line($role['description'] . '_permissions') ? $this->lang->line($role['description'] . '_permissions') : $role['description'] . ' Permissions' ?>
                    </button>
                  </h2>
                  <div id="<?= $role['name'] ?>-permissions" class="accordion-collapse collapse" aria-labelledby="<?= $this->lang->line($role['description'] . '_permissions') ? $this->lang->line($role['description'] . '_permissions') : $role['description'] . ' Permissions' ?>" data-bs-parent="#accordion-eight">
                    <div class="accordion-body">
                      <?php if (isset($role['permissions'])) : ?>
                        <?php if (strpos($role['permissions'], 'attendance') !== false) : ?>
                          <div class="form-group col-md-12">
                            <label class="d-block"><?= $this->lang->line('attendance') ? $this->lang->line('attendance') : 'Attendance' ?></label>

                            <?php if (strpos($role['permissions'], 'attendance_view ') !== false) : ?>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_attendance_view" name="<?= $role['name'] ?>_attendance_view">
                                <label class="form-check-label" for="<?= $role['name'] ?>_attendance_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                              </div>
                            <?php endif; ?>
                            <?php if (strpos($role['permissions'], 'attendance_view_all ') !== false) : ?>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_attendance_view_all" name="<?= $role['name'] ?>_attendance_view_all">
                                <label class="form-check-label" for="<?= $role['name'] ?>_attendance_view_all"><?= $this->lang->line('view_all_attedance') ? $this->lang->line('view_all_attedance') : 'View All Attendance' ?></label>
                              </div>
                            <?php endif; ?>

                            <?php if (strpos($role['permissions'], 'attendance_view_selected ') !== false) : ?>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_attendance_view_selected" name="<?= $role['name'] ?>_attendance_view_selected">
                                <label class="form-check-label" for="<?= $role['name'] ?>_attendance_view_selected"><?= $this->lang->line('view_selected_user_attedance') ? $this->lang->line('view_selected_user_attedance') : 'View Selected User Attendance' ?></label>
                              </div>
                            <?php endif; ?>
                          </div>
                        <?php endif; ?>
                      <?php endif; ?>
                      <!-- leaves -->
                      <?php if (strpos($role['permissions'], 'leaves') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves' ?></label>

                          <?php if (strpos($role['permissions'], 'leaves_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_view" name="<?= $role['name'] ?>_leaves_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_create" name="<?= $role['name'] ?>_leaves_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_edit" name="<?= $role['name'] ?>_leaves_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_delete" name="<?= $role['name'] ?>_leaves_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_status ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_status" name="<?= $role['name'] ?>_leaves_status">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_status"><?= $this->lang->line('can_change_leaves_status') ? $this->lang->line('can_change_leaves_status') : 'Can change leaves status' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_view_all" name="<?= $role['name'] ?>_leaves_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_view_all"><?= $this->lang->line('view_all_leaves') ? $this->lang->line('view_all_leaves') : 'View All Leaves' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leaves_view_selected ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leaves_view_selected" name="<?= $role['name'] ?>_leaves_view_selected">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leaves_view_selected"><?= $this->lang->line('view_selected_user_leaves') ? $this->lang->line('view_selected_user_leaves') : 'View Selected User Leaves' ?></label>
                            </div>
                          <?php endif; ?>

                        </div>
                      <?php endif; ?>
                      <!-- Biometric -->
                      <?php if (strpos($role['permissions'], 'biometric_request') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('biometric_request') ? $this->lang->line('biometric_request') : 'Biometric Request' ?></label>

                          <?php if (strpos($role['permissions'], 'biometric_request_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_view" name="<?= $role['name'] ?>_biometric_request_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_create" name="<?= $role['name'] ?>_biometric_request_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_edit" name="<?= $role['name'] ?>_biometric_request_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_delete" name="<?= $role['name'] ?>_biometric_request_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_status ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_status" name="<?= $role['name'] ?>_biometric_request_status">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_status"><?= $this->lang->line('can_change_biometric_request_status') ? $this->lang->line('can_change_biometric_request_status') : 'Can change biometric request status' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_view_all" name="<?= $role['name'] ?>_biometric_request_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_view_all"><?= $this->lang->line('view_all_biometric_request') ? $this->lang->line('view_all_biometric_request') : 'View All Biomteric Request' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'biometric_request_view_selected ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_biometric_request_view_selected" name="<?= $role['name'] ?>_biometric_request_view_selected">
                              <label class="form-check-label" for="<?= $role['name'] ?>_biometric_request_view_selected"><?= $this->lang->line('view_selected_biometric_request') ? $this->lang->line('view_selected_biometric_request') : 'View selected Biomteric Request' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Project -->
                      <?php if (strpos($role['permissions'], 'project') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?></label>

                          <?php if (strpos($role['permissions'], 'project_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_view" name="<?= $role['name'] ?>_project_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_create" name="<?= $role['name'] ?>_project_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_edit" name="<?= $role['name'] ?>_project_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_delete" name="<?= $role['name'] ?>_project_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_budget ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_budget" name="<?= $role['name'] ?>_project_budget">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_budget"><?= $this->lang->line('show_project_budget') ? $this->lang->line('show_project_budget') : 'Show project budget' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_view_all" name="<?= $role['name'] ?>_project_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_view_all"><?= $this->lang->line('view_all_project') ? $this->lang->line('view_all_project') : 'View All Project' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'project_view_selected ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_project_view_selected" name="<?= $role['name'] ?>_project_view_selected">
                              <label class="form-check-label" for="<?= $role['name'] ?>_project_view_selected"><?= $this->lang->line('view_selected_user_project') ? $this->lang->line('view_selected_user_project') : 'View Selected User Project' ?></label>
                            </div>
                          <?php endif; ?>

                        </div>
                      <?php endif; ?>
                      <!-- Tasks -->
                      <?php if (strpos($role['permissions'], 'task') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?></label>

                          <?php if (strpos($role['permissions'], 'task_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_view" name="<?= $role['name'] ?>_task_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_create" name="<?= $role['name'] ?>_task_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_edit" name="<?= $role['name'] ?>_task_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_status ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_status" name="<?= $role['name'] ?>_task_status">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_status"><?= $this->lang->line('can_change_task_status') ? $this->lang->line('can_change_task_status') : 'Can change task status' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_view_all" name="<?= $role['name'] ?>_task_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_view_all"><?= $this->lang->line('view_all_task') ? $this->lang->line('view_all_task') : 'View All Tasks' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'task_view_selected ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_task_view_selected" name="<?= $role['name'] ?>_task_view_selected">
                              <label class="form-check-label" for="<?= $role['name'] ?>_task_view_selected"><?= $this->lang->line('view_selected_user_task') ? $this->lang->line('view_selected_user_task') : 'View Selected User Task' ?></label>
                            </div>
                          <?php endif; ?>

                        </div>
                      <?php endif; ?>
                      <!-- gantt -->
                      <?php if (strpos($role['permissions'], 'gantt') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('gantt') ? $this->lang->line('gantt') : 'Gantt' ?></label>

                          <?php if (strpos($role['permissions'], 'gantt_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_gantt_view" name="<?= $role['name'] ?>_gantt_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_gantt_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'gantt_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_gantt_edit" name="<?= $role['name'] ?>_gantt_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_gantt_edit"><?= $this->lang->line('drag_date') ? htmlspecialchars($this->lang->line('drag_date')) : 'Drag Date' ?> / <?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Team Memeber -->
                      <?php if (strpos($role['permissions'], 'user') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Team Members' ?>
                            <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= $this->lang->line('only_admin_have_permission_to_add_edit_and_delete_users_you_can_make_any_user_as_admin_they_will_get_all_this_permissions_by_default') ? $this->lang->line('only_admin_have_permission_to_add_edit_and_delete_users_you_can_make_any_user_as_admin_they_will_get_all_this_permissions_by_default') : "Only admin have permission to add, edit and delete users. You can make any user as admin they will get all this permissions by default." ?>"></i>
                          </label>

                          <?php if (strpos($role['permissions'], 'user_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_view" name="<?= $role['name'] ?>_user_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_view"><?= $this->lang->line('view') ? $this->lang->line('view') : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'user_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_create" name="<?= $role['name'] ?>_user_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'user_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_edit" name="<?= $role['name'] ?>_user_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'user_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_delete" name="<?= $role['name'] ?>_user_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'user_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_view_all" name="<?= $role['name'] ?>_user_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_view_all"><?= $this->lang->line('view_all_user') ? $this->lang->line('view_all_user') : 'View All user' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'user_view_selected ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_user_view_selected" name="<?= $role['name'] ?>_user_view_selected">
                              <label class="form-check-label" for="<?= $role['name'] ?>_user_view_selected"><?= $this->lang->line('view_selected_user') ? $this->lang->line('view_selected_user') : 'View Selected Users' ?></label>
                            </div>
                          <?php endif; ?>

                        </div>
                      <?php endif; ?>
                      <!-- reports -->
                      <?php if (strpos($role['permissions'], 'reports') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports' ?> </label>
                          <?php if (strpos($role['permissions'], 'reports_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_reports_view" name="<?= $role['name'] ?>_reports_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_reports_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Device Configuration -->
                      <?php if (strpos($role['permissions'], 'device') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('device') ? $this->lang->line('device') : 'Device Configuration' ?></label>

                          <?php if (strpos($role['permissions'], 'device_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_device_view" name="<?= $role['name'] ?>_device_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_device_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'device_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_device_create" name="<?= $role['name'] ?>_device_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_device_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'device_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_device_edit" name="<?= $role['name'] ?>_device_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_device_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'device_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_device_delete" name="<?= $role['name'] ?>_device_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_device_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Departments -->
                      <?php if (strpos($role['permissions'], 'departments') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments' ?></label>

                          <?php if (strpos($role['permissions'], 'departments_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_departments_view" name="<?= $role['name'] ?>_departments_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_departments_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'departments_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_departments_create" name="<?= $role['name'] ?>_departments_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_departments_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'departments_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_departments_edit" name="<?= $role['name'] ?>_departments_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_departments_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'departments_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_departments_delete" name="<?= $role['name'] ?>_departments_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_departments_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Plan Holiday -->
                      <?php if (strpos($role['permissions'], 'plan_holiday') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('plan_holiday') ? $this->lang->line('plan_holiday') : 'Plan Holiday' ?></label>

                          <?php if (strpos($role['permissions'], 'plan_holiday_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_plan_holiday_view" name="<?= $role['name'] ?>_plan_holiday_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_plan_holiday_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'plan_holiday_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_plan_holiday_create" name="<?= $role['name'] ?>_plan_holiday_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_plan_holiday_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'plan_holiday_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_plan_holiday_edit" name="<?= $role['name'] ?>_plan_holiday_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_plan_holiday_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'plan_holiday_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_plan_holiday_delete" name="<?= $role['name'] ?>_plan_holiday_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_plan_holiday_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Shift -->
                      <?php if (strpos($role['permissions'], 'shift') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?></label>

                          <?php if (strpos($role['permissions'], 'shift_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_shift_view" name="<?= $role['name'] ?>_shift_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_shift_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'shift_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_shift_create" name="<?= $role['name'] ?>_shift_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_shift_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'shift_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_shift_edit" name="<?= $role['name'] ?>_shift_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_shift_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'shift_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_shift_delete" name="<?= $role['name'] ?>_shift_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_shift_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Leave Type -->
                      <?php if (strpos($role['permissions'], 'leave_type') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave Type' ?></label>

                          <?php if (strpos($role['permissions'], 'leave_type_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leave_type_view" name="<?= $role['name'] ?>_leave_type_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leave_type_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leave_type_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leave_type_create" name="<?= $role['name'] ?>_leave_type_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leave_type_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leave_type_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leave_type_edit" name="<?= $role['name'] ?>_leave_type_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leave_type_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'leave_type_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_leave_type_delete" name="<?= $role['name'] ?>_leave_type_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_leave_type_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Time Schedule -->
                      <?php if (strpos($role['permissions'], 'time_schedule') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('time_schedule') ? $this->lang->line('time_schedule') : 'Time Schedule' ?></label>

                          <?php if (strpos($role['permissions'], 'time_schedule_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_time_schedule_view" name="<?= $role['name'] ?>_time_schedule_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_time_schedule_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'time_schedule_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_time_schedule_edit" name="<?= $role['name'] ?>_time_schedule_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_time_schedule_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- General Settings -->
                      <?php if (strpos($role['permissions'], 'general') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('general_settings') ? $this->lang->line('general_settings') : 'General Settings' ?>
                          </label>
                          <?php if (strpos($role['permissions'], 'general_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_general_view" name="<?= $role['name'] ?>_general_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_general_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'general_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_general_edit" name="<?= $role['name'] ?>_general_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_general_edit"><?= $this->lang->line('edit') ? htmlspecialchars($this->lang->line('edit')) : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Company Settings -->
                      <?php if (strpos($role['permissions'], 'company') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('company_settings') ? $this->lang->line('company_settings') : 'Company Settings' ?>
                          </label>
                          <?php if (strpos($role['permissions'], 'company_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_company_view" name="<?= $role['name'] ?>_company_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_company_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'company_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_company_edit" name="<?= $role['name'] ?>_company_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_company_edit"><?= $this->lang->line('edit') ? htmlspecialchars($this->lang->line('edit')) : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Support -->
                      <?php if (strpos($role['permissions'], 'support') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('support') ? $this->lang->line('support') : 'Support' ?> </label>

                          <?php if (strpos($role['permissions'], 'support_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_support_view" name="<?= $role['name'] ?>_support_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_support_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Video Meetings -->
                      <?php if (strpos($role['permissions'], 'meetings') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('video_meetings') ? $this->lang->line('video_meetings') : 'Video Meetings' ?></label>

                          <?php if (strpos($role['permissions'], 'meetings_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_meetings_view" name="<?= $role['name'] ?>_meetings_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_meetings_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'meetings_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_meetings_create" name="<?= $role['name'] ?>_meetings_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_meetings_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'meetings_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_meetings_edit" name="<?= $role['name'] ?>_meetings_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_meetings_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'meetings_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_meetings_delete" name="<?= $role['name'] ?>_meetings_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_meetings_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Leads -->
                      <?php if (strpos($role['permissions'], 'lead') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('leads') ? $this->lang->line('leads') : 'Leads' ?></label>

                          <?php if (strpos($role['permissions'], 'lead_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_lead_view" name="<?= $role['name'] ?>_lead_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_lead_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'lead_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_lead_create" name="<?= $role['name'] ?>_lead_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_lead_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'lead_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_lead_edit" name="<?= $role['name'] ?>_lead_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_lead_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'lead_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_lead_delete" name="<?= $role['name'] ?>_lead_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_lead_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Calendar -->
                      <?php if (strpos($role['permissions'], 'calendar') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar' ?> </label>

                          <?php if (strpos($role['permissions'], 'calendar_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_calendar_view" name="<?= $role['name'] ?>_calendar_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_calendar_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- ToDo -->
                      <?php if (strpos($role['permissions'], 'todo') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('todo') ? $this->lang->line('todo') : 'ToDo' ?>
                          </label>
                          <?php if (strpos($role['permissions'], 'todo_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_todo_view" name="<?= $role['name'] ?>_todo_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_todo_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Notes -->
                      <?php if (strpos($role['permissions'], 'notes') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes' ?>
                          </label>
                          <?php if (strpos($role['permissions'], 'notes_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_notes_view" name="<?= $role['name'] ?>_notes_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_notes_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Chat -->
                      <?php if (strpos($role['permissions'], 'chat') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat' ?>
                          </label>
                          <?php if (strpos($role['permissions'], 'chat_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_chat_view" name="<?= $role['name'] ?>_chat_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_chat_view"><?= $this->lang->line('view') ? htmlspecialchars($this->lang->line('view')) : 'View' ?></label>
                            </div>
                          <?php endif; ?>
                          <?php if (strpos($role['permissions'], 'chat_delete ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_chat_delete" name="<?= $role['name'] ?>_chat_delete">
                              <label class="form-check-label" for="<?= $role['name'] ?>_chat_delete"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Clients -->
                      <?php if (strpos($role['permissions'], 'client') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients' ?>
                            <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?= $this->lang->line('only_admin_have_permission_to_add_edit_and_delete_users_you_can_make_any_user_as_admin_they_will_get_all_this_permissions_by_default') ? $this->lang->line('only_admin_have_permission_to_add_edit_and_delete_users_you_can_make_any_user_as_admin_they_will_get_all_this_permissions_by_default') : "Only admin have permission to add, edit and delete users. You can make any user as admin they will get all this permissions by default." ?>"></i>
                          </label>

                          <?php if (strpos($role['permissions'], 'client_view ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_client_view" name="<?= $role['name'] ?>_client_view">
                              <label class="form-check-label" for="<?= $role['name'] ?>_client_view"><?= $this->lang->line('view') ? $this->lang->line('view') : 'View' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'client_create ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_client_create" name="<?= $role['name'] ?>_client_create">
                              <label class="form-check-label" for="<?= $role['name'] ?>_client_create"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></label>
                            </div>
                          <?php endif; ?>

                          <?php if (strpos($role['permissions'], 'client_edit ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_client_edit" name="<?= $role['name'] ?>_client_edit">
                              <label class="form-check-label" for="<?= $role['name'] ?>_client_edit"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <!-- Notifications -->
                      <?php if (strpos($role['permissions'], 'notification') !== false) : ?>
                        <div class="form-group col-md-12">
                          <label class="d-block"><?= $this->lang->line('notification') ? $this->lang->line('notification') : 'Notifications' ?>
                          </label>

                          <?php if (strpos($role['permissions'], 'notification_view_all ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_notification_view_all" name="<?= $role['name'] ?>_notification_view_all">
                              <label class="form-check-label" for="<?= $role['name'] ?>_notification_view_all"><?= $this->lang->line('view_all_notifications') ? htmlspecialchars($this->lang->line('view_all_notifications')) : 'View All Notifications' ?></label>
                            </div>
                          <?php endif; ?>
                          <?php if (strpos($role['permissions'], 'notification_view_pms ') !== false) : ?>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" id="<?= $role['name'] ?>_notification_view_pms" name="<?= $role['name'] ?>_notification_view_pms">
                              <label class="form-check-label" for="<?= $role['name'] ?>_notification_view_pms"><?= $this->lang->line('view_pms_notifications') ? htmlspecialchars($this->lang->line('view_pms_notifications')) : 'View PMS Notifications' ?></label>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <?php if ($this->ion_auth->is_admin() || change_permissions('') || $this->ion_auth->in_group(3)) { ?>
          <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
          </div>
        <?php } ?>
      </form>
    </div>
  </div>
</div>