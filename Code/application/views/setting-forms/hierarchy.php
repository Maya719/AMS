<form action="<?= base_url('settings/save-hierarchy-setting') ?>" method="POST" id="setting-form2">
    <div class="card-body">
        <div class="alert alert-danger col-md-12 center">
            <b><?=$this->lang->line('note')?$this->lang->line('note'):'Note'?></b> <?=$this->lang->line('the_top_value_will_be_the_highest_role_to_approve_leaves')?$this->lang->line('the_top_value_will_be_the_highest_role_to_approve_leaves'):"The top value will be the highest role to approve leaves. Keep the roles in ascending order."?>
        </div>
        <div class="more-steps">
        <?php
        $count = count($data);
        foreach ($data as $key => $hie) {
            $stepCounter = $key + 1;
            $selected_group_ids = [];
            $current_step_no = $hie["step_no"];
            $current_group_ids = $hie["group_id"];
            ?>
            <div class="step-container">
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="step[<?=$stepCounter?>][]" id="step_<?= $stepCounter ?>" class="form-control select2" multiple>
                            <?php
                            foreach ($groups as $value) {
                                if (!in_array($value->id, $selected_group_ids)) {
                                    ?>
                                    <option value="<?= htmlspecialchars($value->id) ?>" <?= in_array($value->id, $current_group_ids) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($value->description) ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn text-danger remove-step" type="button"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <?php if ($key < $count - 1) { ?>
                    <div class="row arrow">
                        <div class="col-md-6 text-center mb-3">
                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row">
        <button class="btn btn-primary" id="add-more-steps" type="button">
            <?= $this->lang->line('new_step') ? $this->lang->line('new_step') : 'New Step' ?>
        </button>
    </div>
    </div>
    <?php if ($this->ion_auth->is_admin() || permissions('general_edit')) { ?>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary savebtn">
                <?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?>
            </button>
        </div>
    <?php } ?>
    <div class="result"></div>
</form>
