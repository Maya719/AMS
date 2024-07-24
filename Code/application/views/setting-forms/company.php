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
<?php $my_plan = get_current_plan();
if ($my_plan && !is_null($my_plan['end_date']) && $my_plan['end_date'] < date('Y-m-d') && $my_plan['expired'] == 1) {
  var_dump($my_plan);
}
?>
<div class="row">
  <div class="card">
    <div class="card-body">
      <?php $my_plan = get_current_plan();
      if ($my_plan &&  !is_null($my_plan['end_date']) && (($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d', date(strtotime("+" . alert_days() . " day", strtotime(date('Y-m-d')))))) || ($my_plan['billing_type'] == 'three_days_trial_plan' || $my_plan['billing_type'] == 'seven_days_trial_plan' || $my_plan['billing_type'] == 'fifteen_days_trial_plan' || $my_plan['billing_type'] == 'thirty_days_trial_plan'))) {
      ?>
        <div class="alert alert-warning" role="alert">
          Renew Plan! Your plan will expire soon...
        </div>
      <?php
      }
      ?>
      <form action="">
        <div class="justify-content-center align-items-left">
          <h4>Upgrade Your Plan</h4>
          <p>Choose your desired renewal period for your current plan:</p>
          <h5>Current Plan</h5>
          <p>Premium</p>
        </div>
        <div class="plan-container">
          <div class="plan-card" data-value="1" onclick="selectPlan(this)">
            <h5>1 Month</h5>
            <div class="duration-price">
              <span>1 Month</span>
              <span>$3.99</span>
            </div>
          </div>

          <div class="plan-card" data-value="6" onclick="selectPlan(this)">
            <h5>6 Months</h5>
            <div class="duration-price">
              <span>6 Months</span>
              <span>$20.99 (30% off!)</span>
            </div>
          </div>

          <div class="plan-card" data-value="12" onclick="selectPlan(this)">
            <h5>1 Year</h5>
            <div class="duration-price">
              <span>$3.99/month</span>
              <span>1 Year</span>
            </div>
          </div>
        </div>
        <p>Still unsure? <a href="<?= base_url('support') ?>">Contact our Support Team</a> for personalized advice.</p>
        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3) || permissions('company_edit')) { ?>
          <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary"><?= $this->lang->line('renew_now') ? $this->lang->line('renew_now') : 'Renew Now' ?></button>
          </div>
        <?php } ?>
      </form>
    </div>
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
<script>
  function selectPlan(card) {
    // Remove the "selected" class from all cards
    const cards = document.querySelectorAll('.plan-card');
    cards.forEach(card => card.classList.remove('selected'));

    // Add the "selected" class to the clicked card
    card.classList.add('selected');
  }
</script>
<style>
  h4,
  h5,
  p {
    text-align: center;
  }

  .plan-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }

  .plan-card {
    width: 50%;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    margin: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
  }

  .plan-card:hover {
    transform: scale(1.02);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  }

  .plan-card.selected {
    background-color: #e0e0e0;
    /* Highlight selected card */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }

  .plan-card {
    display: flex;
    justify-content: space-between;
    /* Align items horizontally */
    align-items: center;
    /* Align items vertically */
  }

  .plan-card h5 {
    margin-bottom: 10px;
  }

  .duration-price {
    display: inline-flex;
    /* Display duration and price inline */
    text-align: left;
  }

  .duration-price span {
    margin-right: 10px;
    /* Add spacing between duration and price */
  }

  .plan-card {
    width: 50%;

    /* Default width */
    @media (max-width: 768px) {
      /* For screens smaller than 768px */
      width: 100%;
      /* Make cards full width on smaller screens */
    }
  }
</style>
</style>