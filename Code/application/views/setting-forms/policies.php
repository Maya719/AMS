<div class="row">
    <form action="<?= base_url('settings/save_grace_minutes_setting') ?>" method="POST" id="setting-form">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Attendance Policy</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" id="enableGraceMinutes" name="enableGraceMinutes" class="form-check-input" value="1" <?= isset($value->apply) && $value->apply == '1' ? 'checked' : '' ?>>Grace Min
                                </label>
                            </div>
                            <div class="card-body row" id="show_div">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label"><?= $this->lang->line('days_counter') ? $this->lang->line('days_counter') : 'Days Counter' ?><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('m') ? $this->lang->line('m') : 'The number of late days of which Half Day will be marked.' ?>"></i></label>
                                    <input type="number" name="days_counter" id="days_counter" value="<?= isset($value->days_counter) ? $value->days_counter : '' ?>" class="form-control" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label"><?= $this->lang->line('grace_minutes') ? $this->lang->line('grace_minutes') : 'Late Minutes' ?><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('m') ? $this->lang->line('m') : 'The allowed late minutes for being late.' ?>"></i></label>
                                    <input type="number" name="grace_minutes" id="grace_minutes" value="<?= isset($value->grace_minutes) ? $value->grace_minutes : '' ?>" class="form-control" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-0">
                    <div class="card">
                        <div class="card-header">
                            <h5>Leaves Policy</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="enebleSandwich" id="enebleSandwich" value="1" <?= isset($value->sandwich) && $value->sandwich == '1' ? 'checked' : '' ?>>Sandwich Rule
                                </label>
                            </div>
                            <div class="card-body row mb-3" id="show_div2">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label"><?= $this->lang->line('apply') ? $this->lang->line('apply') : 'Apply ' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('m') ? $this->lang->line('m') : 'Allow the sandwich will apply with?' ?>"></i></label>
                                    <select name="period" class="form-control">
                                        <option value="1" <?= isset($value->period) && $value->period == '1' ? 'selected' : '' ?>><?= $this->lang->line('before') ? htmlspecialchars($this->lang->line('before')) : 'Before' ?></option>
                                        <option value="2" <?= isset($value->period) && $value->period == '2' ? 'selected' : '' ?>><?= $this->lang->line('after') ? htmlspecialchars($this->lang->line('after')) : 'After' ?></option>
                                        <option value="3" <?= isset($value->period) && $value->period == '3' ? 'selected' : '' ?>><?= $this->lang->line('after_before') ? htmlspecialchars($this->lang->line('after_before')) : 'After and Before' ?></option>
                                        <option value="3" <?= isset($value->period) && $value->period == '4' ? 'selected' : '' ?>><?= $this->lang->line('after_or_before') ? htmlspecialchars($this->lang->line('after_or_before')) : 'After or Before' ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="message"></div>
            </div>
            <div class="card-footer text-end">
                <button type="button" class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
            </div>
        </div>
    </form>
</div>