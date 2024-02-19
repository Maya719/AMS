<!-- Nestable -->
<?php
$current_group_ids = [];
foreach ($data as $key => $hie) {
    $stepCounter = $key + 1;
    $current_step_no = $hie["step_no"];
    $current_group_ids[] = $hie["group_id"];
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-danger col-md-12 center">
                    <b><?= $this->lang->line('note') ? $this->lang->line('note') : 'Note' ?></b> <?= $this->lang->line('Ensure_that_the_hierarchy_is_utilized_when_applying_for_leave._Nested_roles_should_first_approve_leave_requests_before_escalating_to_higher-level_roles') ? $this->lang->line('Ensure_that_the_hierarchy_is_utilized_when_applying_for_leave._Nested_roles_should_first_approve_leave_requests_before_escalating_to_higher-level_roles') : "Ensure that the hierarchy is utilized when applying for leave. Nested roles should first approve leave requests before escalating to higher-level roles." ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-content">
                            <div class="nestable">
                                <div class="dd" id="nestable">
                                    <ol class="dd-list">
                                        <?php
                                        foreach ($groups as $value) {
                                            if (!in_array($value->id, $current_group_ids)) {

                                        ?>
                                                <li class="dd-item" data-id="<?= htmlspecialchars($value->id) ?>">
                                                    <div class="dd-handle"><?= htmlspecialchars($value->description) ?></div>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-content">
                            <div class="nestable">
                                <div class="dd" id="nestable2">
                                    <?php
                                    foreach ($groups as $value) {
                                        if (in_array($value->id, $current_group_ids)) {

                                    ?>
                                            <li class="dd-item" data-id="<?= htmlspecialchars($value->id) ?>">
                                                <div class="dd-handle"><?= htmlspecialchars($value->description) ?></div>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<p>
    <?php
    var_dump($current_group_ids)
    ?>
</p>