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

      <div class="row d-none" id="payment-div">
        <div id="paypal-button" class="col-md-8 mx-auto paymet-box"></div>
        <?php if (get_stripe_secret_key() && get_stripe_publishable_key()) { ?>
          <button id="stripe-button" class="col-md-8 btn mx-auto paymet-box">
            <img src="<?= base_url('assets/img/stripe.png') ?>" width="14%" alt="Stripe">
          </button>
        <?php } ?>

        <?php if (get_myfatoorah_secret_key()) { ?>
          <button id="fatoorah-button" class="col-md-8 btn mx-auto paymet-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70%">
              <defs>
                <style>
                  .a {
                    fill: #4cb4e7
                  }
                </style>
              </defs>
              <path class="a" d="M.447 59.727l27.908-.212.038 5.083-27.908.212M.386 51.254l27.908-.212.038 5.083-27.908.212M.321 42.778l27.908-.212.039 5.083-27.908.212M.257 34.306l41.951-.318.039 5.083-41.951.318M.193 25.84l41.951-.318.038 5.083-41.951.318M.128 17.364l55.914-.424.038 5.083-55.914.424M.064 8.896l55.914-.424.038 5.083-55.914.424M0 .424L55.914 0l.039 5.083-55.914.424" />
              <path d="M56.167 33.916l4.926-.037.013 1.923a5.992 5.992 0 014.8-2.321 6.053 6.053 0 015.6 2.824 6.875 6.875 0 015.628-2.912c4.6-.034 6.9 2.708 6.936 7.393l.083 11.074-5.034.037-.079-10.421c-.017-2.43-.968-3.842-3.178-3.826-1.885.017-3.248 1.333-3.227 4.382l.075 9.914-5.034.037-.079-10.421c-.017-2.43-.968-3.842-3.178-3.825-1.881.017-3.248 1.333-3.223 4.382l.075 9.915-4.964.037zM91.856 51.001l-7.337-17.3 5.214-.04 4.538 11.148 4.079-11.214 5.142-.039-10.3 26.62-4.961.038z" />
              <g>
                <path d="M56.525 57.928l14.954-.114.036 4.829-9.921.075.045 5.954 9.921-.075.036 4.829-9.921.075.082 10.892-5.033.038zM87.476 75.085a4.68 4.68 0 00-4.673-4.83 4.891 4.891 0 104.673 4.83m-14.338.146c-.05-6.426 4.635-9.474 8.727-9.507a7.243 7.243 0 015.412 2.1l-.013-1.778 4.959-.037.137 18.151-4.959.038-.017-2.031a7.056 7.056 0 01-5.449 2.438c-3.838.029-8.748-2.986-8.8-9.374M94.105 65.993l3.078-.021-.042-5.823 4.96-.042.046 5.827 3.4-.029.033 4.469-3.4.025.042 5.773c.021 2.829.386 3.265 3.431 3.24l.033 4.648h-.723c-5.757.046-7.655-1.9-7.7-7.821l-.046-5.807-3.078.021zM120.351 74.872a4.547 4.547 0 10-4.523 4.751 4.645 4.645 0 004.523-4.751m-13.939.1a9.379 9.379 0 119.449 9.37 9.382 9.382 0 01-9.449-9.37" />
                <path d="M140.454 74.72a4.651 4.651 0 00-4.6-4.685 4.725 4.725 0 00.071 9.441 4.656 4.656 0 004.527-4.756m-13.943.108a9.379 9.379 0 119.453 9.366 9.38 9.38 0 01-9.453-9.366M146.896 65.594l4.926-.038.021 2.978a5.1 5.1 0 014.976-3.016l1.811-.017.033 4.831-2.965.021c-2.646.021-3.792 1.412-3.767 4.785l.067 8.569-4.964.038zM173.724 74.428a4.679 4.679 0 00-4.673-4.825 4.889 4.889 0 104.673 4.826m-14.338.146c-.05-6.426 4.636-9.474 8.727-9.5a7.228 7.228 0 015.412 2.1l-.016-1.782 4.964-.037.137 18.155-4.959.037-.017-2.035a7.045 7.045 0 01-5.449 2.438c-3.838.029-8.752-2.983-8.8-9.375M180.312 83.496l-.2-26.5 6.367-.05.083 10.891a6.63 6.63 0 016.094-3.531c3.555-.029 6.1 2.226 6.135 6.957l.091 12.1-6.368.046-.083-10.812c-.013-2.1-.843-3.123-2.692-3.107-1.882.013-3.157 1.163-3.14 3.543l.079 10.421z" />
              </g><text transform="translate(55.143 94.952)" font-size="9" font-family="Graphik-Medium,Graphik" font-weight="500" fill="#4cb4e7">
                <tspan x="0" y="0">More than just a payment solution</tspan>
              </text>
            </svg>
          </button>
        <?php } ?>
        <?php if (get_razorpay_key_id()) { ?>
          <button id="razorpay-button" class="col-md-8 btn mx-auto paymet-box">
            <img src="<?= base_url('assets/img/razorpay.png') ?>" width="27%" alt="Stripe">
          </button>
        <?php } ?>
        <?php if (get_paystack_public_key()) { ?>
          <button id="paystack-button" class="col-md-8 btn mx-auto paymet-box">
            <img src="<?= base_url('assets/img/paystack.png') ?>" width="24%" alt="Paystack">
          </button>
        <?php } ?>
        <?php if (get_offline_bank_transfer()) { ?>
          <div id="accordion" class="col-md-8 paymet-box mx-auto">
            <div class="accordion mb-0">
              <div class="accordion-header text-center" role="button" data-toggle="collapse" data-target="#panel-body-3">
                <h4><?= $this->lang->line('offline_bank_transfer') ? $this->lang->line('offline_bank_transfer') : 'Offline / Bank Transfer' ?></h4>
              </div>
              <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                <p class="mb-0"><?= get_bank_details() ?></p>

                <form action="<?= base_url('plans/create-offline-request/') ?>" method="POST" id="bank-transfer-form">
                  <div class="card-footer bg-whitesmoke">
                    <div class="form-group">
                      <label class="col-form-label"><?= $this->lang->line('upload_receipt') ? htmlspecialchars($this->lang->line('upload_receipt')) : 'Upload Receipt' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('supported_formats') ? htmlspecialchars($this->lang->line('supported_formats')) : 'Supported Formats: jpg, jpeg, png' ?>" data-original-title="<?= $this->lang->line('supported_formats') ? htmlspecialchars($this->lang->line('supported_formats')) : 'Supported Formats: jpg, jpeg, png' ?>"></i> </label>
                      <input type="file" name="receipt" class="form-control">
                      <input type="hidden" name="plan_id" id="plan_id">
                    </div>
                    <button class="btn btn-primary savebtn"><?= $this->lang->line('upload_and_send_for_confirmation') ? htmlspecialchars($this->lang->line('upload_and_send_for_confirmation')) : 'Upload and Send for Confirmation' ?></button>
                  </div>
                  <div class="result"></div>
                </form>

              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <p>Still unsure? <a href="<?= base_url('support') ?>">Contact our Support Team</a> for personalized advice.</p>
      <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group(3) || permissions('company_edit')) { ?>
        <div class="card-footer bg-whitesmoke text-md-right">
          <button class="btn btn-primary"><?= $this->lang->line('renew_now') ? $this->lang->line('renew_now') : 'Renew Now' ?></button>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="row hidden" id="upgrade-plan-div">
  <div class="card">
    <div class="card-body">
      <div class="comparisonTableContainer  " data-default-presets="%7B%22optionalSettings%22%3A%7B%22includeImageOrNot%22%3Afalse%2C%22includePriceOrNot%22%3Atrue%2C%22includeRecurrenceOrNot%22%3Afalse%2C%22includePriceToggleOrNot%22%3Afalse%2C%22data_price_1%22%3A%22Annual%20%28save%2030%25%29%22%2C%22data_price_2%22%3A%22Monthly%22%2C%22includeButtonOrNot%22%3Atrue%2C%22includeRecOrNot%22%3Atrue%2C%22recommendedText%22%3A%22Best%20Value%22%2C%22includeGroupsOrNot%22%3Afalse%2C%22featureMinWidth%22%3A%22200%22%2C%22tableBorderWidth%22%3A%221%22%7D%2C%22tableCaption%22%3A%22plan%22%2C%22fontAwesomeVersion%22%3A%226%22%2C%22colors%22%3A%7B%22colorCheckboxOptions%22%3A%7B%22includeAltOrNot%22%3Atrue%2C%22includeRecBorderOrNot%22%3Afalse%2C%22includeBorderOrNot%22%3Atrue%2C%22includeEmptyCellBorder%22%3Afalse%7D%2C%22primary_row_background%22%3A%22%23ffffff%22%2C%22alt_row_background%22%3A%22%23ededed%22%2C%22table_border_color%22%3A%22%23bdbdbd%22%2C%22feature_text_color%22%3A%22%23000000%22%2C%22feature_text_font_size%22%3A%221.2%22%2C%22check_color%22%3A%22%234ac263%22%2C%22x_color%22%3A%22%23808080%22%2C%22included_text_color%22%3A%22%23000000%22%2C%22included_text_font_size%22%3A%221.2%22%2C%22mobile_group_background%22%3A%22%23f0f0f0%22%2C%22mobile_group_text_color%22%3A%22%23000000%22%2C%22group_name_color%22%3A%22%23000000%22%2C%22group_name_font_size%22%3A%22.9%22%2C%22group_background%22%3A%22%239fd0d1%22%2C%22rec_background%22%3A%22%234ac263%22%2C%22rec_color%22%3A%22%23ffffff%22%2C%22rec_font_size%22%3A%221%22%2C%22rec_cell_background%22%3A%22%23eafbed%22%2C%22rec_button_background%22%3A%22%23f27e3d%22%2C%22rec_button_color%22%3A%22%23ffffff%22%2C%22rec_button_border%22%3A%22%23000000%22%2C%22column_header_background%22%3A%22%23ffffff%22%2C%22product_color%22%3A%22%23000000%22%2C%22product_font_size%22%3A%221.3%22%2C%22price_color%22%3A%22%23000000%22%2C%22price_font_size%22%3A%221.8%22%2C%22recurrence_color%22%3A%22%23000000%22%2C%22recurrence_font_size%22%3A%221.2%22%2C%22reg_button_background%22%3A%22%23ffffff%22%2C%22reg_button_color%22%3A%22%23000000%22%2C%22reg_button_font_size%22%3A%221.1%22%2C%22reg_button_border%22%3A%22%23000000%22%2C%22empty_cell_background%22%3A%22%23ffffff%22%2C%22empty_fill_color%22%3A%22%23f1e8ca%22%2C%22solid_fill_color%22%3A%22%23fdcc0d%22%2C%22table_data_width%22%3A%22100%25%20/%203%22%2C%22rec_banner_font_size%22%3A%22%22%7D%7D">
        <svg id="icons" style="width: 0; height: 0; position: absolute;" preserveAspectRatio="xMidYMid meet" version="1.0">
          <symbol id="solid_circular_checkmark" viewBox="0 0 810 809.999993">
            <defs>
              <clipPath id="d60240e9a4">
                <path d="M 405 0 C 181.324219 0 0 181.324219 0 405 C 0 628.675781 181.324219 810 405 810 C 628.675781 810 810 628.675781 810 405 C 810 181.324219 628.675781 0 405 0 " clip-rule="nonzero"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#d60240e9a4)">
              <rect class="checkmark" x="-81" width="972" fill="#00bf63" y="-80.999999" height="971.999992" fill-opacity="1"></rect>
            </g>
            <path stroke-linecap="round" transform="matrix(0.296252, -0.689179, 0.689036, 0.296191, 356.819225, 596.179142)" fill="none" stroke-linejoin="miter" d="M 42.003091 42.001279 L 561.874777 41.999519 " stroke="#ffffff" stroke-width="84" stroke-opacity="1" stroke-miterlimit="4"></path>
            <path stroke-linecap="round" transform="matrix(-0.529912, -0.529912, 0.53033, -0.53033, 395.300256, 629.91162)" fill="none" stroke-linejoin="miter" d="M 42.000014 41.997391 L 295.273739 42.001074 " stroke="#ffffff" stroke-width="84" stroke-opacity="1" stroke-miterlimit="4"></path>
          </symbol>
          <symbol id="solid_circular_xmark" viewBox="0 0 810 809.999993">
            <defs>
              <clipPath id="ff7b844a59">
                <path d="M 405 0 C 181.324219 0 0 181.324219 0 405 C 0 628.675781 181.324219 810 405 810 C 628.675781 810 810 628.675781 810 405 C 810 181.324219 628.675781 0 405 0 " clip-rule="nonzero"></path>
              </clipPath>
              <clipPath id="1b4ebe7b45">
                <path d="M 201 198 L 609 198 L 609 605.777344 L 201 605.777344 Z M 201 198 " clip-rule="nonzero"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#ff7b844a59)">
              <rect class="xmark" x="-81" width="972" fill="#ff5757" y="-80.999999" height="971.999992" fill-opacity="1"></rect>
            </g>
            <g clip-path="url(#1b4ebe7b45)">
              <path fill="#ffffff" d="M 449.664062 402.257812 L 599.5625 252.359375 C 611.84375 240.074219 611.84375 220.164062 599.5625 207.882812 C 587.28125 195.601562 567.367188 195.601562 555.085938 207.882812 L 405.1875 357.78125 L 255.289062 207.882812 C 243.007812 195.601562 223.09375 195.601562 210.8125 207.882812 C 198.535156 220.164062 198.53125 240.078125 210.8125 252.359375 L 360.714844 402.257812 L 210.8125 552.15625 C 198.53125 564.4375 198.53125 584.351562 210.8125 596.632812 C 216.953125 602.773438 225.003906 605.84375 233.050781 605.84375 C 241.101562 605.84375 249.148438 602.773438 255.289062 596.632812 L 405.1875 446.730469 L 555.085938 596.632812 C 561.226562 602.773438 569.273438 605.84375 577.324219 605.84375 C 585.375 605.84375 593.421875 602.773438 599.5625 596.632812 C 611.84375 584.347656 611.84375 564.4375 599.5625 552.15625 Z M 449.664062 402.257812 " fill-opacity="1" fill-rule="nonzero"></path>
            </g>
          </symbol>
          <symbol id="reg_circular_checkmark" viewBox="0 0 810 809.999993">
            <path fill="#39b54a" class="checkmark" d="M 631.597656 225.613281 C 615.882812 211.707031 591.863281 213.171875 577.953125 228.890625 L 337.023438 501.164062 L 229.847656 398.703125 C 214.675781 384.199219 190.617188 384.742188 176.113281 399.914062 C 161.609375 415.082031 162.15625 439.136719 177.324219 453.644531 L 313.050781 583.394531 C 320.132812 590.171875 329.546875 593.925781 339.308594 593.925781 C 339.835938 593.925781 340.363281 593.917969 340.894531 593.894531 C 351.21875 593.464844 360.921875 588.847656 367.769531 581.109375 L 634.875 279.261719 C 648.785156 263.542969 647.316406 239.527344 631.597656 225.613281 " fill-opacity="1" fill-rule="nonzero"></path>
            <path fill="#39b54a" class="checkmark" d="M 708.15625 533.050781 C 691.589844 572.222656 667.859375 607.410156 637.632812 637.632812 C 607.410156 667.859375 572.222656 691.589844 533.050781 708.160156 C 492.511719 725.300781 449.429688 733.992188 405 733.992188 C 360.570312 733.992188 317.488281 725.300781 276.949219 708.160156 C 237.78125 691.589844 202.589844 667.859375 172.367188 637.632812 C 142.140625 607.410156 118.410156 572.222656 101.84375 533.050781 C 84.699219 492.511719 76.003906 449.433594 76.003906 405 C 76.003906 360.570312 84.699219 317.488281 101.84375 276.949219 C 118.410156 237.78125 142.140625 202.589844 172.367188 172.367188 C 202.589844 142.140625 237.78125 118.410156 276.949219 101.84375 C 317.488281 84.699219 360.570312 76.007812 405 76.007812 C 449.429688 76.007812 492.511719 84.699219 533.050781 101.84375 C 572.222656 118.410156 607.410156 142.140625 637.632812 172.367188 C 667.859375 202.589844 691.589844 237.78125 708.15625 276.949219 C 725.300781 317.488281 733.992188 360.570312 733.992188 405 C 733.992188 449.433594 725.300781 492.511719 708.15625 533.050781 Z M 778.15625 247.34375 C 757.757812 199.109375 728.558594 155.804688 691.378906 118.621094 C 654.195312 81.441406 610.890625 52.242188 562.65625 31.84375 C 512.703125 10.714844 459.65625 0 405 0 C 350.339844 0 297.296875 10.714844 247.34375 31.84375 C 199.109375 52.242188 155.804688 81.441406 118.621094 118.621094 C 81.441406 155.804688 52.242188 199.109375 31.84375 247.34375 C 10.714844 297.296875 0 350.339844 0 405 C 0 459.660156 10.714844 512.703125 31.84375 562.65625 C 52.242188 610.890625 81.441406 654.195312 118.621094 691.378906 C 155.804688 728.558594 199.109375 757.757812 247.34375 778.15625 C 297.296875 799.285156 350.339844 810 405 810 C 459.65625 810 512.703125 799.285156 562.65625 778.15625 C 610.890625 757.757812 654.195312 728.558594 691.378906 691.378906 C 728.558594 654.195312 757.757812 610.890625 778.15625 562.65625 C 799.285156 512.703125 810 459.660156 810 405 C 810 350.339844 799.285156 297.296875 778.15625 247.34375 " fill-opacity="1" fill-rule="nonzero"></path>
          </symbol>
          <symbol id="reg_circular_xmark" viewBox="0 0 810 809.999993">
            <path class="xmark" fill="#dc433a" d="M 405 810 C 181.691406 810 0 628.308594 0 405 C 0 181.691406 181.691406 0 405 0 C 628.332031 0 810 181.691406 810 405 C 810 628.308594 628.332031 810 405 810 Z M 405 79.859375 C 225.738281 79.859375 79.859375 225.710938 79.859375 405 C 79.859375 584.289062 225.738281 730.140625 405 730.140625 C 584.289062 730.140625 730.164062 584.289062 730.164062 405 C 730.164062 225.710938 584.289062 79.859375 405 79.859375 Z M 405 79.859375 " fill-opacity="1" fill-rule="nonzero"></path>
            <path class="xmark" fill="#dc433a" d="M 553.785156 493.265625 L 465.523438 405 L 553.785156 316.734375 C 570.492188 300.027344 570.492188 272.945312 553.785156 256.214844 C 537.054688 239.507812 509.972656 239.507812 493.289062 256.214844 L 405 344.503906 L 316.761719 256.214844 C 300.054688 239.507812 272.96875 239.507812 256.238281 256.214844 C 239.507812 272.917969 239.53125 300.003906 256.238281 316.734375 L 344.503906 405 L 256.238281 493.265625 C 239.53125 509.972656 239.53125 537.054688 256.238281 553.785156 C 272.945312 570.519531 300.027344 570.492188 316.710938 553.761719 L 405 465.472656 L 493.289062 553.785156 C 509.996094 570.492188 537.082031 570.492188 553.8125 553.785156 C 570.542969 537.082031 570.519531 509.972656 553.785156 493.265625 Z M 553.785156 493.265625 " fill-opacity="1" fill-rule="nonzero"></path>
          </symbol>
          <symbol id="reg_checkmark" viewBox="0 0 810 809.999993">
            <defs>
              <clipPath id="109d770f44">
                <path d="M 4 5 L 805 5 L 805 809.25 L 4 809.25 Z M 4 5 " clip-rule="nonzero"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#109d770f44)">
              <path class="checkmark" fill="#2ecc71" d="M 294.875 809.257812 C 283.921875 809.257812 273.34375 804.925781 265.515625 797.097656 L 16.355469 548.09375 C 0.136719 531.878906 0.136719 505.605469 16.355469 489.390625 C 32.574219 473.1875 58.867188 473.1875 75.085938 489.390625 L 287.988281 702.179688 L 728.476562 24.667969 C 740.96875 5.449219 766.691406 -0.0078125 785.925781 12.472656 C 805.15625 24.964844 810.613281 50.675781 798.117188 69.890625 L 329.699219 790.363281 C 322.875 800.867188 311.671875 807.726562 299.214844 809.03125 C 297.765625 809.183594 296.316406 809.257812 294.875 809.257812 " fill-opacity="1" fill-rule="nonzero"></path>
            </g>
          </symbol>
          <symbol id="reg_xmark" viewBox="0 0 810 809.999993">
            <path class="xmark" fill="#ff8888" d="M 773.390625 806.980469 C 764.839844 806.980469 756.28125 803.699219 749.761719 797.179688 L 14.574219 61.96875 C 1.511719 48.90625 1.511719 27.785156 14.574219 14.722656 C 27.640625 1.652344 48.757812 1.652344 61.828125 14.722656 L 797.015625 749.933594 C 810.078125 762.996094 810.078125 784.117188 797.015625 797.179688 C 790.5 803.699219 781.949219 806.980469 773.390625 806.980469 Z M 773.390625 806.980469 " fill-opacity="1" fill-rule="nonzero"></path>
            <path class="xmark" fill="#ff8888" d="M 38.199219 806.980469 C 29.648438 806.980469 21.089844 803.699219 14.574219 797.179688 C 1.511719 784.117188 1.511719 762.996094 14.574219 749.933594 L 749.761719 14.722656 C 762.832031 1.652344 783.945312 1.652344 797.015625 14.722656 C 810.078125 27.785156 810.078125 48.90625 797.015625 61.96875 L 61.828125 797.179688 C 55.308594 803.699219 46.757812 806.980469 38.199219 806.980469 Z M 38.199219 806.980469 " fill-opacity="1" fill-rule="nonzero"></path>
          </symbol>
          <symbol id="solid_checkmark" viewBox="0 0 810 809.999993">
            <path class="checkmark" fill="#00bf63" d="M 774.292969 110.554688 L 769.28125 106.796875 C 752.992188 93.648438 732.945312 88.011719 714.152344 89.890625 C 694.105469 91.769531 675.941406 100.535156 662.785156 116.191406 L 493.644531 315.328125 L 393.410156 436.1875 L 320.117188 524.484375 L 270 471.257812 L 241.808594 441.824219 L 142.832031 338.5 C 128.421875 323.46875 109.628906 315.953125 89.582031 314.703125 C 70.789062 313.449219 50.742188 321.589844 36.335938 335.367188 L 31.324219 340.375 C 0.625 368.554688 0 417.402344 28.191406 447.460938 L 125.917969 550.160156 L 154.105469 580.84375 L 266.867188 699.199219 C 280.023438 712.351562 297.5625 721.117188 314.476562 721.742188 C 315.730469 721.742188 315.730469 721.742188 316.355469 721.742188 C 317.609375 721.742188 318.238281 721.742188 320.117188 721.742188 C 320.117188 721.742188 320.117188 721.742188 321.367188 721.742188 C 324.5 721.742188 327.007812 721.742188 330.765625 721.742188 C 350.8125 719.867188 368.980469 711.097656 382.132812 695.441406 L 550.023438 496.304688 L 615.800781 416.777344 L 783.6875 217.636719 C 810 185.699219 806.242188 138.109375 774.292969 110.554688 Z M 774.292969 110.554688 " fill-opacity="1" fill-rule="nonzero"></path>
          </symbol>
          <symbol id="solid_xmark" viewBox="0 0 810 809.999993">
            <defs>
              <clipPath id="725d5cd9f7">
                <path d="M 72 76 L 737 76 L 737 739.984375 L 72 739.984375 Z M 72 76 " clip-rule="nonzero"></path>
              </clipPath>
            </defs>
            <g clip-path="url(#725d5cd9f7)">
              <path class="xmark" fill="#ff5757" d="M 498.6875 408.511719 L 717.089844 190.058594 C 742.992188 164.175781 742.992188 122.179688 717.089844 96.273438 C 691.191406 70.390625 649.246094 70.390625 623.347656 96.273438 L 404.945312 314.726562 L 186.542969 96.292969 C 160.664062 70.390625 118.675781 70.390625 92.777344 96.292969 C 66.898438 122.179688 66.898438 164.175781 92.777344 190.082031 L 311.179688 408.511719 L 92.246094 627.496094 C 66.367188 653.378906 66.367188 695.378906 92.246094 721.261719 C 105.171875 734.214844 122.167969 740.691406 139.117188 740.691406 C 156.066406 740.691406 173.0625 734.214844 186.011719 721.261719 L 404.921875 502.300781 L 623.304688 720.730469 C 636.253906 733.683594 653.226562 740.160156 670.175781 740.160156 C 687.125 740.160156 704.097656 733.683594 717.046875 720.730469 C 742.945312 694.847656 742.945312 652.851562 717.046875 626.964844 Z M 498.6875 408.511719 " fill-opacity="1" fill-rule="nonzero"></path>
            </g>
          </symbol>
        </svg>
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
                  <a class="comp-table__productLink" href="/link-from-your-site">Upgrade Plan</a>
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
    const planIdInput = document.getElementById('duration');
    planIdInput.value = selectedValue;
    plan_id = $('#plan').val();
    price = $('#price').val();
    duration = $('#duration').val();
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
  document.getElementById('upgradebtn').addEventListener('click', function() {
    document.getElementById('upgrade-plan-div').classList.remove('hidden');
    document.getElementById('renew-plan-div').classList.add('hidden');
  });

  document.getElementById('renewbtn').addEventListener('click', function() {
    document.getElementById('renew-plan-div').classList.remove('hidden');
    document.getElementById('upgrade-plan-div').classList.add('hidden');
  });
</script>