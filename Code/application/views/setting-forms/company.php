<div class="row">
  <div class="card">
    <form action="<?= base_url('settings/save-company-setting') ?>" method="POST" id="setting-form">
      <div class="card-body row">

        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('company_name') ? $this->lang->line('company_name') : 'Company Name' ?><span class="text-danger">*</span><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_details_will_be_used_as_billing_details') ? $this->lang->line('this_details_will_be_used_as_billing_details') : "This details will be used as billing details." ?>"></i></label>
          <input type="text" name="company_name" value="<?= isset($company_details->company_name) ? htmlspecialchars($company_details->company_name) : '' ?>" class="form-control" required="">
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('address') ? $this->lang->line('address') : 'Address' ?></label>
          <input type="text" name="address" value="<?= isset($company_details->address) ? htmlspecialchars($company_details->address) : '' ?>" class="form-control">
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('city') ? $this->lang->line('city') : 'City' ?></label>
          <input type="text" name="city" value="<?= isset($company_details->city) ? htmlspecialchars($company_details->city) : '' ?>" class="form-control">
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('state') ? $this->lang->line('state') : 'State' ?></label>
          <input type="text" name="state" value="<?= isset($company_details->state) ? htmlspecialchars($company_details->state) : '' ?>" class="form-control">
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('country') ? $this->lang->line('country') : 'Country' ?></label>
          <input type="text" name="country" value="<?= isset($company_details->country) ? htmlspecialchars($company_details->country) : '' ?>" class="form-control">
        </div>
        <div class="form-group col-md-6 mb-3">
          <label class="col-form-label"><?= $this->lang->line('zip_code') ? $this->lang->line('zip_code') : 'Zip Code' ?></label>
          <input type="text" name="zip_code" value="<?= isset($company_details->zip_code) ? htmlspecialchars($company_details->zip_code) : '' ?>" class="form-control">
        </div>
      </div>
      <div class="message"></div>
      <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3) || permissions('company_edit')) { ?>
        <div class="card-footer bg-whitesmoke text-md-right">
          <button class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
        </div>
      <?php } ?>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var inputFields = document.querySelectorAll('input[name="company_name"], input[name="address"], input[name="city"], input[name="state"], input[name="country"], input[name="zip_code"]');
    var saveBtn = document.querySelector('.savebtn');
    var initialValues = Array.from(inputFields, input => input.value);

    function checkChanges() {
      var changed = false;
      inputFields.forEach(function(input, index) {
        if (input.value !== initialValues[index]) {
          changed = true;
        }
      });
      if (changed) {
        saveBtn.classList.remove('btn-primary');
        saveBtn.classList.add('btn-success');
      } else {
        saveBtn.classList.remove('btn-success');
        saveBtn.classList.add('btn-primary');
      }
    }

    inputFields.forEach(function(input) {
      input.addEventListener('input', checkChanges);
    });

    // Initial check
    checkChanges();
  });
</script>
