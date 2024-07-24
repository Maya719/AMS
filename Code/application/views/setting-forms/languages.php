  <div class="card">
    <form action="<?= base_url('languages/create') ?>" method="POST" id="language-form" enctype="multipart/form-data">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <input type="text" name="language_lang" id="language" class="form-control m-1" placeholder="<?= $this->lang->line('language_name') ? $this->lang->line('language_name') : 'Language name' ?>" required>
          </div>
          <div class="col-md-2">
            <input type="text" name="short_code_lang" id="short_code" class="form-control m-1" placeholder="<?= $this->lang->line('short_code') ? $this->lang->line('short_code') : 'Short Code' ?>" required>
          </div>
          <div class="col-md-2">
            <select name="active_lang" class="form-control m-1 ">
              <option value="0">NO RTL</option>
              <option value="1">RTL</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary savebtn m-1"><?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?></button>
          </div>
          <div class="col-md-12 mt-3">
            <div class="table-responsive">
              <table id="holiday_list" class="table table-sm mb-0">
                <thead>
                  <tr>
                    <th data-field="language" data-sortable="true"><?= $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages' ?></th>
                    <th data-field="short_code" data-sortable="true"><?= $this->lang->line('short_code') ? $this->lang->line('short_code') : 'Short Code' ?></th>
                    <th data-field="active" data-sortable="true"><?= $this->lang->line('is_rtl') ? htmlspecialchars($this->lang->line('is_rtl')) : 'Is RTL' ?></th>
                    <th data-field="status" data-sortable="true"><?= $this->lang->line('status') ? htmlspecialchars($this->lang->line('status')) : 'Status' ?></th>
                    <th data-field="action" data-sortable="false"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="result"></div>
    </form>
  </div>