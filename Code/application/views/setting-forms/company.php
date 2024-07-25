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

<?php
if ($this->ion_auth->is_admin()) {
  $my_plan = get_current_plan();
?>
  <input type="hidden" id="duration">
  <input type="hidden" id="plan" value="<?= $my_plan["plan_id"] ?>">
  <input type="hidden" id="price" value="<?= $my_plan["price"] ?>">
  <div class="row">
    <div class="card">
      <div class="card-header">
        <h6>Current Plan Details</h6>
      </div>
      <div class="card-body">
        <div class="plan-details">
          <?php
          if ($my_plan &&  !is_null($my_plan['end_date']) && (($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d', date(strtotime("+" . alert_days() . " day", strtotime(date('Y-m-d')))))) || ($my_plan['billing_type'] == 'three_days_trial_plan' || $my_plan['billing_type'] == 'seven_days_trial_plan' || $my_plan['billing_type'] == 'fifteen_days_trial_plan' || $my_plan['billing_type'] == 'thirty_days_trial_plan'))) {
          ?>
            <div class="alert alert-warning" role="alert">
              Your plan will will expire in <?= alert_days(); ?> days!
            </div><?php
                } ?>
          <div class="plan-info">
            <div class="plan-item">
              <span class="label">Plan:</span>
              <span class="value"><?= $my_plan["title"] ?> </span>
              <?php if ($recomended_plans) : ?>
                <button id="upgradebtn" style="color: <?= theme_color() ?>; font-size:16px; border:none; background-color:#fff;">
                  Upgrade Plan
                </button>
              <?php else : ?>
                <button id="upgradebtn" style="color: <?= theme_color() ?>; font-size:16px; border:none; background-color:#fff; display:none">
                  Upgrade Plan
                </button>
              <?php endif ?>

            </div>
            <div class="plan-item">
              <span class="label">Next Billing Date:</span>
              <span class="value"><?= $my_plan['end_date'] ?> </span>
              <?php
              if ($my_plan &&  !is_null($my_plan['end_date']) && (($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d', date(strtotime("+" . alert_days() . " day", strtotime(date('Y-m-d')))))) || ($my_plan['billing_type'] == 'three_days_trial_plan' || $my_plan['billing_type'] == 'seven_days_trial_plan' || $my_plan['billing_type'] == 'fifteen_days_trial_plan' || $my_plan['billing_type'] == 'thirty_days_trial_plan'))) {
              ?>
                <button id="renewbtn" style="color: <?= theme_color() ?>;font-size:16px; border:none; background-color:#fff;">Renew Plan</button>
              <?php
              } else {
              ?>
                <button id="renewbtn" style="color: <?= theme_color() ?>;font-size:16px; border:none; background-color:#fff; display:none;">Renew Plan</button>
              <?php } ?>
            </div>
            <div class="plan-item">
              <span class="label">Billing Cycle:</span>
              <span class="value">Monthly</span>
            </div>
            <div class="plan-item">
              <span class="label">Per Month Price:</span>
              <span class="value"><?= get_saas_currency('currency_code') . ' ' . $my_plan['price'] ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row hidden" id="renew-plan-div">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-center ">
          <div class="plan-head">
            <h4>Renew Your Plan</h4>
            <p>Choose your desired renewal period for your current plan
              <i class="fas fa-circle-check text-success fs-5" data-bs-container="body" data-bs-toggle="popover" title="Current Plan" data-bs-placement="top" data-bs-content="<?= $this->lang->line('this_is_your_current_active_plan') ? $this->lang->line('this_is_your_current_active_plan') : 'Your Current Plan is: ' . $my_plan["title"] . '' ?>"></i>
            </p>
          </div>
        </div>
        <div class="plan-container">
          <div class="plan-card" data-value="1" onclick="selectPlan(this)">
            <h5>1 Month</h5>
            <div class="duration-price">
              <span><?= get_saas_currency('currency_code') . ' ' . $my_plan["price"] ?>/month</span>
            </div>
          </div>

          <div class="plan-card" data-value="6" onclick="selectPlan(this)">
            <h5>6 Months</h5>
            <div class="duration-price">
              <span><?= get_saas_currency('currency_code') . ' ' . $my_plan["price"] ?>/month</span>
            </div>
          </div>

          <div class="plan-card" data-value="12" onclick="selectPlan(this)">
            <h5>1 Year</h5>
            <div class="duration-price">
              <span><?= get_saas_currency('currency_code') . ' ' . $my_plan["price"] ?>/month</span>
            </div>
          </div>
        </div>
        <p>Still unsure? <a href="<?= base_url('support') ?>">Contact our Support Team</a> for personalized advice.</p>
      </div>
    </div>
  </div>
  <div class="row hidden" id="upgrade-plan-div">
    <div class="card">
      <div class="card-body">
        <div class="comparisonTableContainer  " data-default-presets="%7B%22optionalSettings%22%3A%7B%22includeImageOrNot%22%3Afalse%2C%22includePriceOrNot%22%3Atrue%2C%22includeRecurrenceOrNot%22%3Afalse%2C%22includePriceToggleOrNot%22%3Afalse%2C%22data_price_1%22%3A%22Annual%20%28save%2030%25%29%22%2C%22data_price_2%22%3A%22Monthly%22%2C%22includeButtonOrNot%22%3Atrue%2C%22includeRecOrNot%22%3Atrue%2C%22recommendedText%22%3A%22Best%20Value%22%2C%22includeGroupsOrNot%22%3Afalse%2C%22featureMinWidth%22%3A%22200%22%2C%22tableBorderWidth%22%3A%221%22%7D%2C%22tableCaption%22%3A%22plan%22%2C%22fontAwesomeVersion%22%3A%226%22%2C%22colors%22%3A%7B%22colorCheckboxOptions%22%3A%7B%22includeAltOrNot%22%3Atrue%2C%22includeRecBorderOrNot%22%3Afalse%2C%22includeBorderOrNot%22%3Atrue%2C%22includeEmptyCellBorder%22%3Afalse%7D%2C%22primary_row_background%22%3A%22%23ffffff%22%2C%22alt_row_background%22%3A%22%23ededed%22%2C%22table_border_color%22%3A%22%23bdbdbd%22%2C%22feature_text_color%22%3A%22%23000000%22%2C%22feature_text_font_size%22%3A%221.2%22%2C%22check_color%22%3A%22%234ac263%22%2C%22x_color%22%3A%22%23808080%22%2C%22included_text_color%22%3A%22%23000000%22%2C%22included_text_font_size%22%3A%221.2%22%2C%22mobile_group_background%22%3A%22%23f0f0f0%22%2C%22mobile_group_text_color%22%3A%22%23000000%22%2C%22group_name_color%22%3A%22%23000000%22%2C%22group_name_font_size%22%3A%22.9%22%2C%22group_background%22%3A%22%239fd0d1%22%2C%22rec_background%22%3A%22%234ac263%22%2C%22rec_color%22%3A%22%23ffffff%22%2C%22rec_font_size%22%3A%221%22%2C%22rec_cell_background%22%3A%22%23eafbed%22%2C%22rec_button_background%22%3A%22%23f27e3d%22%2C%22rec_button_color%22%3A%22%23ffffff%22%2C%22rec_button_border%22%3A%22%23000000%22%2C%22column_header_background%22%3A%22%23ffffff%22%2C%22product_color%22%3A%22%23000000%22%2C%22product_font_size%22%3A%221.3%22%2C%22price_color%22%3A%22%23000000%22%2C%22price_font_size%22%3A%221.8%22%2C%22recurrence_color%22%3A%22%23000000%22%2C%22recurrence_font_size%22%3A%221.2%22%2C%22reg_button_background%22%3A%22%23ffffff%22%2C%22reg_button_color%22%3A%22%23000000%22%2C%22reg_button_font_size%22%3A%221.1%22%2C%22reg_button_border%22%3A%22%23000000%22%2C%22empty_cell_background%22%3A%22%23ffffff%22%2C%22empty_fill_color%22%3A%22%23f1e8ca%22%2C%22solid_fill_color%22%3A%22%23fdcc0d%22%2C%22table_data_width%22%3A%22100%25%20/%203%22%2C%22rec_banner_font_size%22%3A%22%22%7D%7D">
          <table class="comp-table">
            <caption>plan</caption>
            <thead class="comp-table__tableHead">
              <tr class="comp-table__columnHeaders comp-table__tableRow">
                <th title="Empty placeholder cell" class="comp-table__emptyCell comp-table__tableData comp-table__columnHeader"></th>
                <th scope="col" class=" comp-table__tableData comp-table__columnHeader">
                  <div class="comp-table__buyProduct">
                    <span class="comp-table__productName"><?= $my_plan['title'] ?></span>
                    <span class="comp-table__price" data-price-1="$1,000" data-price-2="$500"><?= get_saas_currency('currency_code') . ' ' . $my_plan['price'] ?>/Month</span>
                  </div>
                </th>
                <th scope="col" class="comp-table__recommended comp-table__tableData comp-table__columnHeader">
                  <p class="comp-table__recommendedText">Recomended Plan</p>
                  <div class="comp-table__buyProduct">
                    <span class="comp-table__productName"><?= $recomended_plans['title'] ?></span>
                    <span class="comp-table__price" data-price-1="$1,000" data-price-2="$500"><?= get_saas_currency('currency_code') . ' ' . $recomended_plans['price'] ?>/Month</span>
                    <a class="comp-table__productLink" id="upgrade-button" data-id="<?= $recomended_plans['id'] ?>" href="javascript:void(0);">Upgrade Plan</a>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="comp-table__tableBody">
              <tr class="comp-table__tableRow comp-table__tableBodyRow">
                <th class="comp-table__tableData comp-table__rowheader" scope="row">Users</th>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-check text-success"></i>
                </td>
                <td class="comp-table__tableData comp-table__tableDataCell comp-table__recommended" data-icon-cell="1">
                  <i class="fa-solid fa-arrow-trend-up text-success"></i>
                </td>
              </tr>
              <tr class="comp-table__tableRow comp-table__tableBodyRow">
                <th class="comp-table__tableData comp-table__rowheader" scope="row">Projects</th>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-check text-success"></i>
                </td>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-arrow-trend-up text-success"></i>
                </td>
              </tr>
              <tr class="comp-table__tableRow comp-table__tableBodyRow">
                <th class="comp-table__tableData comp-table__rowheader" scope="row">Office Shifts</th>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-check text-success"></i>
                </td>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-arrow-trend-up text-success"></i>
                </td>
              </tr>
              <tr class="comp-table__tableRow comp-table__tableBodyRow">
                <th class="comp-table__tableData comp-table__rowheader" scope="row">Storage</th>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-check text-success"></i>
                </td>
                <td class="comp-table__tableData comp-table__tableDataCell " data-icon-cell="1">
                  <i class="fa-solid fa-arrow-trend-up text-success"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row d-none" id="payment-div">
    <div class="card">
      <div class="card-body">
        <!-- <?php //if (get_stripe_secret_key() && get_stripe_publishable_key()) { 
              ?> -->
        <button id="stripe-button" class="plan-card" style="border: none; cursor:pointer;"><img src="<?= base_url('assets/img/stripe.png') ?>" width="14%" alt="Stripe"></button>
        <!-- <?php // } 
              ?> -->
        <!-- <?php // if (get_myfatoorah_secret_key()) { 
              ?> -->
        <button id="fatoorah-button" class="plan-card" style="border: none; cursor:pointer;">
          <img src="<?= base_url('assets2/images/trusted_partners/myfatoorah.jpg') ?>" width="14%" alt="Stripe">
        </button>
        <!-- <?php // } 
              ?> -->
      </div>
    </div>

    <input type="hidden" id="option">
    <input type="hidden" id="duration">
    <input type="hidden" id="plan" value="<?= $my_plan["plan_id"] ?>">
    <input type="hidden" id="upgradePlan" value="<?= $recomended_plans["id"] ?>">
  </div>
<?php
}
?>

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
    const cards = document.querySelectorAll('.plan-card');
    cards.forEach(card => card.classList.remove('selected'));
    card.classList.add('selected');
    var selectedValue = card.getAttribute('data-value');
    var duration = document.getElementById('duration');
    duration.value = selectedValue;
    var option = document.getElementById('option');
    option.value = 'renew';
    $('#payment-div').removeClass('d-none');

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

  .plan-card2 {
    width: 50%;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    margin: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
  }

  .plan-card2:hover {
    transform: scale(1.02);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  }

  .plan-card.selected {
    background-color: #e0e0e0;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }

  .plan-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .duration-price {
    display: inline-flex;
    text-align: left;
  }

  .duration-price span {
    margin-right: 10px;
  }

  .plan-card {
    width: 50%;

    @media (max-width: 768px) {
      width: 100%;
    }
  }

  .hidden {
    display: none;
  }

  .label {
    font-weight: bold;
    display: inline-block;
  }

  /*************** Pricing Comparison Table CSS ***************/
  /* Customize the font family and table height below */
  .comparisonTableContainer {
    font-family: system-ui;
    max-width: 1280px !important;
    margin: auto;
    position: relative;
    overflow-anchor: none;
  }

  /* Start: Generated CSS */
  .horizontal-scroller {
    position: fixed;
    bottom: 0;
    height: 30px;
    overflow: auto;
    overflow-y: hidden;
  }

  .horizontal-scroller-content {
    height: 30px;
  }

  .comp-table__tableHead.stickyHeader {
    position: fixed;
    z-index: 999;
    overflow-x: scroll;
    top: 0px;
  }

  .comp-table__stickyRowGroupPH.stickyHeader {
    position: fixed;
    z-index: 9;
  }

  .comp-table__stickyRowGroupPH:not(.stickyHeader) {
    padding: 0;
    height: 0;
  }

  .comp-table__columnGroupSection.stickyHeader .comp-table__tableData {
    border-top: none
  }

  .comp-table__tableHead.stickyHeader.atBottom {
    position: absolute;
    z-index: 999;
    bottom: 0px;
    left: 0px !important;
    top: initial !important;
    width: initial !important;
    overflow-x: clip;
  }

  .comparisonTableContainer use:nth-child(2) {
    transform: translate(20px);
  }

  .comparisonTableContainer use:nth-child(3) {
    transform: translate(40px);
  }

  .comparisonTableContainer use:nth-child(4) {
    transform: translate(60px);
  }

  .comparisonTableContainer use:nth-child(5) {
    transform: translate(80px);
  }

  .comparisonTableContainer .rating {
    height: 20px;
    width: 100px;
  }

  .comparisonTableContainer #stars-empty-star {
    fill: #f1e8ca;
  }

  .comparisonTableContainer #stars-full-star,
  .comparisonTableContainer #stars-half-star {
    fill: #fdcc0d;
  }

  @media (max-width:769px) {

    .comp-table__columnGroup .comp-table__tableData,
    .comp-table__columnHeader:nth-child(2),
    .comp-table__tableBodyRow .comp-table__tableData:nth-child(2) {
      border-left: 1px solid #bdbdbd !important
    }

    .comp-table__emptyCell,
    .comp-table__rowheader {
      display: none
    }

    .comp-table__productImage {
      height: auto;
      max-width: 100%
    }

    .comp-table__columnGroupSection .comp-table__tableData {
      font-size: 1rem !important
    }

    .comp-table__recommendedText {
      /*font-size:.8rem!important*/
    }

    .comparisonTableContainer .comp-table .comp-table__tableData:not([scope="colgroup"]) {
      min-width: 100px;
      max-width: 100px
    }

    .comparisonTableContainer.moreThan4 .comp-table .comp-table__tableData:not([scope="colgroup"]) {
      min-width: 100px;
      max-width: 100px
    }

    .comparisonTableContainer.moreThan4 .comp-table__tableData[scope="colgroup"] {
      text-align: left
    }

    .comp-table__productImageContainer {
      width: 80px;
      height: auto
    }

    .comparisonTableContainer use:nth-child(2) {
      transform: translate(15px);
    }

    .comparisonTableContainer use:nth-child(3) {
      transform: translate(30px);
    }

    .comparisonTableContainer use:nth-child(4) {
      transform: translate(45px);
    }

    .comparisonTableContainer use:nth-child(5) {
      transform: translate(60px);
    }

    .comparisonTableContainer .rating {
      height: 13px;
    }
  }

  .comparisonTableContainer .comp-table__tableData[scope="colgroup"] span,
  .comp-table__stickyRowGroupPH span {
    padding-left: 10px;
  }

  .comp-table__stickyRowGroupPH .comp-table__tableData {
    padding-left: 0;
  }

  .comparisonTableContainer.moreThan4 .comp-table__tableData[scope="colgroup"],
  .comparisonTableContainer.moreThan4 .comp-table__stickyRowGroupPH .comp-table__tableData {
    padding-left: 0
  }

  @media (max-width:769px) and (min-width:400px) {

    .comp-table__price,
    .comp-table__productLink,
    .comp-table__productName,
    .comp-table__tableData,
    .comp-table__recurrence {
      font-size: 1rem !important
    }
  }

  @media (max-width:400px) {

    .comp-table__price,
    .comp-table__productLink,
    .comp-table__productName,
    .comp-table__tableData,
    .comp-table__recurrence {
      font-size: .9rem !important
    }

    [scope="colgroup"] span {
      max-width: 278px;
      display: block
    }
  }

  .comp-table {
    width: 100%;
    margin: auto;
    border-bottom: 1px solid #bdbdbd;
    table-layout: auto;
    border-collapse: separate;
    border-spacing: 0
  }

  .comparisonTableContainer {
    overflow: auto
  }

  .comparisonTableContainer .comp-table__tableData:not([scope="colgroup"]) {
    min-width: 150px;
    max-width: 150px
  }

  .comparisonTableContainer .comp-table__rowheader {
    width: 200px !important;
    min-width: 200px !important;
    max-width: 200px !important;
    font-size: 1.2rem;
    border-left: 1px solid #bdbdbd;
  }

  #solid_circular_checkmark .checkmark,
  #reg_circular_checkmark .checkmark,
  #reg_checkmark .checkmark,
  #solid_checkmark .checkmark {
    fill: #4ac263;
  }

  #solid_circular_xmark .xmark,
  #reg_circular_xmark .xmark,
  #reg_xmark .xmark,
  #solid_xmark .xmark {
    fill: #808080;
  }

  .comp-table__tableData {
    border-right: 1px solid #bdbdbd;
    border-top: 1px solid #bdbdbd
  }

  .comp-table caption {
    position: absolute;
    opacity: 0;
    top: auto;
    width: 1px;
    height: 1px;
    overflow: hidden
  }

  .comp-table__rowheader {
    /*width:20%;*/
    text-align: left;
    padding: 10px;
    font-weight: 700;
    color: #000000;
    left: 0;
    position: sticky;
    position: -webkit-sticky
  }

  .comp-table__tableData {
    padding: 12px 5px;
    background: #ffffff;
    border-color: #bdbdbd;
    line-height: 1.4
  }

  [scope="colgroup"] span {
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    left: 0;
  }

  .comp-table__columnGroup,
  .comp-table__columnHeader,
  .comp-table__tableDataCell {
    text-align: center;
    background-clip: padding-box !important
  }

  .comp-table__columnHeader {
    font-weight: 700;
    background: #ffffff;
    padding-top: 55px;
    padding-bottom: 10px;
    position: relative;
  }

  .includeGroups .comp-table__columnHeader:not(.comp-table__emptyCell) {
    border-bottom: 1px solid #bdbdbd;
  }

  .comp-table__emptyCell {
    border-top: 1px solid #ffffff;
    border-left: 1px solid #ffffff;
    background: #ffffff;
    position: sticky;
    left: 0;
    z-index: 99;
    padding-left: 20px;
  }

  .comp-table__tableDataCell {
    color: #000000;
    font-size: 1.2rem;
    padding: 12px 5px
  }

  .comp-table__tableDataCell svg {
    margin: auto;
    display: block;
  }

  .comp-table__tableDataCell>* {
    min-height: 28px;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .comp-table__columnHeader:not(.comp-table__recommended) .comp-table__recommendedText {
    display: none
  }

  .comp-table__recommendedText {
    background: #4ac263;
    color: #ffffff;
    position: absolute;
    top: 0;
    left: 0;
  }

  @media (min-width:769px) {

    .comp-table__tableBodyRow:nth-child(2n),
    .comp-table__tableBodyRow:nth-child(2n) .comp-table__tableData {
      background: #ffffff
    }

    .comp-table__tableBodyRow:nth-child(4n),
    .comp-table__tableBodyRow:nth-child(4n) .comp-table__tableData {
      background: #ededed
    }

    .comp-table__columnGroup {
      display: none
    }

    .comp-table__productImage {
      max-width: 120px !important;
      height: auto
    }

    .comp-table__rowheader {
      padding-left: 20px !important
    }

    .comp-table__columnGroupSection .comp-table__tableData {
      text-align: left
    }

    .comp-table__productImageContainer {
      width: 140px;
      height: auto
    }
  }

  .comp-table__columnGroup .comp-table__tableData {
    background: #f0f0f0;
    color: #000000;
    font-weight: 700;
    border-top: 4px solid #bdbdbd
  }

  .comp-table__buyProduct {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: end;
    grid-gap: 10px;
    height: auto;
    position: relative
  }

  .comp-table__productLink:hover {
    filter: brightness(.9)
  }

  .comp-table__productLink {
    border: 2px solid #000000;
    background: #ffffff;
    color: #000000;
    padding: 12px 2px;
    border-radius: 5px;
    width: 95%;
    font-size: 1.1rem;
    line-height: 1.2;
    pointer-events: all !important
  }

  .comp-table__recommended .comp-table__productLink {
    border: 2px solid transparent;
    background: <?= theme_color() ?>;
    color: #ffffff;
  }

  .comp-table__price {
    font-size: 1.8rem;
    margin-top: 10px;
    margin-bottom: 10px;
    color: #000000;
    word-break: break-word;
    line-height: 1.2
  }

  .comp-table__productName {
    line-height: 1.2;
    color: #000000;
    /*height:23px;*/
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem
  }

  .comp-table__recurrence {
    font-weight: 600;
    font-size: 1.2rem;
    margin-top: -10px;
    margin-bottom: 20px;
    color: #000000;
    line-height: 1rem
  }

  .comp-table__columnGroupSection .comp-table__tableData {
    font-size: .9rem;
    text-transform: uppercase;
    color: #000000;
    background: #9fd0d1;
    padding: 15px 0px;
    border-right: none;
    text-align: left
  }

  .comp-table__columnGroupSection.first .comp-table__tableData {
    border-top: none;
  }

  .comp-table__recommended {
    background: #eafbed !important
  }

  .comp-table__productImageContainer {
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    margin-bottom: 10px
  }

  .comp-table__tableHead::-webkit-scrollbar {
    height: 0px;
  }

  /*************** Pricing Comparison Table CSS ***************/
</style>
<script>
  // Event listener for the 'upgradebtn' button
  document.getElementById('upgradebtn').addEventListener('click', function() {
    $('#payment-div').addClass('d-none');
    document.getElementById('upgrade-plan-div').classList.remove('hidden');
    document.getElementById('renew-plan-div').classList.add('hidden');
  });

  // Event listener for the 'upgrade-button' button
  document.getElementById('upgrade-button').addEventListener('click', function() {
    $('#payment-div').removeClass('d-none');
    var option = document.getElementById('option');
    option.value = 'upgrade';
  });

  // Event listener for the 'renewbtn' button
  document.getElementById('renewbtn').addEventListener('click', function() {
    $('#payment-div').addClass('d-none');
    document.getElementById('renew-plan-div').classList.remove('hidden');
    document.getElementById('upgrade-plan-div').classList.add('hidden');
  });
</script>