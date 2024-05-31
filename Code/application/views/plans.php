<?php $this->load->view('includes/header'); ?>
<style>
  /* 1.39 Pricing */
  .pricing {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    background-color: #fff;
    border-radius: 3px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    text-align: center;
  }

  .pricing.pricing-highlight .pricing-title {
    background-color: var(--theme-color);
    color: #fff;
  }

  .pricing.pricing-highlight .pricing-cta a {
    background-color: var(--theme-color);
    color: #fff;
  }

  .pricing.pricing-highlight .pricing-cta a:hover {
    background-color: #ad00ad !important;
  }

  .pricing .pricing-padding {
    padding: 40px;
  }

  .pricing .pricing-title {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    background-color: #f3f6f8;
    color: var(--theme-color);
    border-radius: 0 0 3px 3px;
    display: inline-block;
    padding: 5px 15px;
  }

  .pricing .pricing-price {
    margin-bottom: 45px;
  }

  .pricing .pricing-price div:first-child {
    font-weight: 600;
    font-size: 50px;
  }

  .pricing .pricing-details {
    text-align: left;
    display: inline-block;
  }

  .pricing .pricing-details .pricing-item {
    display: flex;
    margin-bottom: 15px;
  }

  .pricing .pricing-details .pricing-item .pricing-item-icon {
    width: 20px;
    height: 20px;
    line-height: 20px;
    border-radius: 50%;
    text-align: center;
    background-color: #63ed7a;
    color: #fff;
    margin-right: 10px;
  }

  .pricing .pricing-details .pricing-item .pricing-item-icon i {
    font-size: 11px;
  }

  .pricing .pricing-cta {
    margin-top: 20px;
  }

  .pricing .pricing-cta a {
    display: block;
    padding: 20px 40px;
    background-color: #f3f6f8;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    border-radius: 0 0 3px 3px;
  }

  .pricing .pricing-cta a .fas,
  .pricing .pricing-cta a .far,
  .pricing .pricing-cta a .fab,
  .pricing .pricing-cta a .fal,
  .pricing .pricing-cta a .ion {
    margin-left: 5px;
  }

  .pricing .pricing-cta a:hover {
    background-color: #e3eaef;
  }
</style>
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <?php $this->load->view('includes/sidebar'); ?>
    <div class="content-body default-height">
      <div class="container-fluid">
        <?php
        if (is_saas_admin()) { ?>
          <div class="row d-flex justify-content-end mb-3 ">
            <div class="col-xl-2 col-sm-3">
              <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#plan-add-modal" class="btn btn-block btn-primary">+ ADD</a>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="row align-items-center justify-content-center">
          <?php
          if (is_saas_admin()) { ?>
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example3" class="table table-sm mb-0">
                      <thead>
                        <tr>
                          <th><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?></th>
                          <th><?= $this->lang->line('price_usd') ? $this->lang->line('price_usd') . ' - ' . get_saas_currency('currency_code') : 'Price - ' . get_saas_currency('currency_code') ?></th>
                          <th><?= $this->lang->line('billing_type') ? $this->lang->line('billing_type') : 'Billing Type' ?></th>
                          <th><?= $this->lang->line('features') ? $this->lang->line('features') : 'Features' ?></th>
                          <th><?= $this->lang->line('modules') ? $this->lang->line('modules') : 'Modules' ?></th>
                          <th><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($plans as $plan) : ?>
                          <?php
                          if ($plan["billing_type"] == 'One Time') {
                            $billing_type = $this->lang->line('one_time') ? $this->lang->line('one_time') : 'One Time';
                          } elseif ($plan["billing_type"] == 'Monthly') {
                            $billing_type = $this->lang->line('monthly') ? $this->lang->line('monthly') : 'Monthly';
                          } elseif ($plan["billing_type"] == 'three_days_trial_plan') {
                            $billing_type = $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan';
                          } elseif ($plan["billing_type"] == 'seven_days_trial_plan') {
                            $billing_type = $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan';
                          } elseif ($plan["billing_type"] == 'fifteen_days_trial_plan') {
                            $billing_type = $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan';
                          } elseif ($plan["billing_type"] == 'thirty_days_trial_plan') {
                            $billing_type = $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan';
                          } else {
                            $billing_type = $this->lang->line('yearly') ? $this->lang->line('yearly') : 'Yearly';
                          }
                          $modules = '';
                          if ($plan["modules"] != '') {
                            foreach (json_decode($plan["modules"]) as $mod_key => $mod) {
                              $mod_name = '';
                              switch ($mod_key) {
                                case 'projects':
                                  $mod_name = $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects';
                                  break;
                                case 'kanban':
                                  $mod_name = $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban';
                                  break;
                                case 'agile':
                                  $mod_name = $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile';
                                  break;
                                case 'scrum':
                                  $mod_name = $this->lang->line('scrum') ? $this->lang->line('scrum') : 'Scrum';
                                  break;
                                case 'tasks':
                                  $mod_name = $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks';
                                  break;
                                case 'team_members':
                                  $mod_name = $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Team Members';
                                  break;
                                  // case 'user_permissions':
                                  //   $mod_name = $this->lang->line('employee_permissions') ? $this->lang->line('employee_permissions') : 'Employees Permissions';
                                  //   break;
                                  // case 'user_roles':
                                  //   $mod_name = $this->lang->line('user_roles') ? $this->lang->line('user_roles') : 'Employees Roles';
                                  //   break;
                                case 'clients':
                                  $mod_name = $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients';
                                  break;
                                case 'calendar':
                                  $mod_name = $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar';
                                  break;
                                case 'leaves':
                                  $mod_name = $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves';
                                  break;
                                case 'leaves_types':
                                  $mod_name = $this->lang->line('leaves_types') ? $this->lang->line('leaves_types') : 'Leaves Types';
                                  break;
                                case 'leave_hierarchy':
                                  $mod_name = $this->lang->line('leave_hierarchy') ? $this->lang->line('leave_hierarchy') : 'Leaves Hierarchy';
                                  break;
                                case 'biometric_missing':
                                  $mod_name = $this->lang->line('biometric_missing') ? $this->lang->line('biometric_missing') : 'biometric Missing';
                                  break;
                                  // case 'biometric_machine':
                                  //   $mod_name = $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'biometric Machines';
                                  //   break;
                                  // case 'departments':
                                  //   $mod_name = $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments';
                                  // break;
                                case 'holidays':
                                  $mod_name = $this->lang->line('holidays') ? $this->lang->line('holidays') : 'Holidays';
                                  break;
                                case 'todo':
                                  $mod_name = $this->lang->line('todo') ? $this->lang->line('todo') : 'Todo';
                                  break;
                                case 'shifts':
                                  $mod_name = $this->lang->line('shifts') ? $this->lang->line('shifts') : 'Shifts';
                                  break;
                                case 'notice_board':
                                  $mod_name = $this->lang->line('notice_board') ? $this->lang->line('notice_board') : 'Events Board';
                                  break;
                                case 'calendar':
                                  $mod_name = $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar';
                                  break;
                                case 'notes':
                                  $mod_name = $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes';
                                  break;
                                case 'chat':
                                  $mod_name = $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat';
                                  break;
                                case 'attendance':
                                  $mod_name = $this->lang->line('attendance') ? htmlspecialchars($this->lang->line('attendance')) : 'Attendance';
                                  break;
                                case 'attendance_leave_policy':
                                  $mod_name = $this->lang->line('attendance_leave_policy') ? htmlspecialchars($this->lang->line('attendance_leave_policy')) : 'Attendance & Leave policy';
                                  break;
                                case 'support':
                                  $mod_name = $this->lang->line('support') ? htmlspecialchars($this->lang->line('support')) : 'Support';
                                  break;
                                case 'notifications':
                                  $mod_name = $this->lang->line('notifications') ? $this->lang->line('notifications') : 'Notifications';
                                  break;
                                case 'languages':
                                  $mod_name = $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages';
                                  break;
                                  // case 'reports':
                                  //   $mod_name = $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports';
                                  //   break;
                                default:
                                  break;
                              }

                              if ($mod_name) {
                                if ($mod == 1) {
                                  $modules .= '<div class="pricing-item d-inline-flex mb-1 ms-2">
                                                      <div class="pricing-item-icon ms-1"><i class="fas fa-check"></i></div>
                                                      <div class="pricing-item-label">' . $mod_name . '</div>
                                                  </div>';
                                } else {
                                  $modules .= '<div class="pricing-item d-inline-flex mb-1 ms-2">
                                                      <div class="pricing-item-icon bg-danger text-white ms-1"><i class="fas fa-times"></i></div>
                                                      <div class="pricing-item-label">' . $mod_name . '</div>
                                                  </div>';
                                }
                              }
                            }
                          }
                          $tempModule = '<div class="pricing bg-transparent shadow-none m-1">
                            <div class="pricing-details">
                            ' . $modules . '
                            </div>
                          </div>';
                          $tempFeatures = '
					                  <strong>' . ($this->lang->line('storage') ? $this->lang->line('storage') : "Storage") . ': </strong>' . (($plan["storage"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["storage"] . 'GB') . '<br>
					                  <strong>' . ($this->lang->line('additional_storage') ? $this->lang->line('additional_storage') : "Additional Storage") . ': </strong>' . (($plan["additional_storage"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : ' $' . $plan["additional_storage"] . '/GB') . '<br>
					                  <strong>' . ($this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : "Biometric Machine") . ': </strong>' . (($plan["biometric_machine"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["biometric_machine"]) . '<br>
					                  <strong>' . ($this->lang->line('leave_requests') ? $this->lang->line('leave_requests') : "Leave Requests") . ': </strong>' . (($plan["leave_requests"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["leave_requests"]) . '<br>
					                  <strong>' . ($this->lang->line('office_shifts') ? $this->lang->line('office_shifts') : "Office Shifts") . ': </strong>' . (($plan["office_shifts"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["office_shifts"]) . '<br>
					                  
                            <strong>' . ($this->lang->line('email_push_notif') ?: "Email/Push Notifications") . ': </strong>' .
                            (($plan["email_push_notif"] < 0) ?
                              ($this->lang->line('limited') ?: 'Limited') : (($plan["email_push_notif"] == 1) ?
                                ($this->lang->line('yes') ?: 'Yes') : (($plan["email_push_notif"] == 0) ?
                                  ($this->lang->line('no') ?: 'No') : $plan["email_push_notif"])
                              )
                            ) . '<br>

                            <strong>' . ($this->lang->line('reports') ?: "Reports") . ': </strong>' .
                            (($plan["reports"] < 0) ?
                              ($this->lang->line('limited') ?: 'Limited') : (($plan["reports"] == 1) ?
                                ($this->lang->line('yes') ?: 'Yes') : (($plan["reports"] == 0) ?
                                  ($this->lang->line('no') ?: 'No') : $plan["reports"])
                              )
                            ) . '<br>

                            <strong>' . ($this->lang->line('departments') ? $this->lang->line('departments') : "Departments") . ': </strong>' . (($plan["departments"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["departments"]) . '<br>
                           
                            <strong>' . ($this->lang->line('projects') ? $this->lang->line('projects') : "Projects") . ': </strong>' . (($plan["projects"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["projects"]) . '<br>
                            <strong>' . ($this->lang->line('tasks') ? $this->lang->line('tasks') : "Tasks") . ': </strong>' . (($plan["tasks"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["tasks"]) . '<br>
                      
                            <strong>' . ($this->lang->line('roles_permissions') ? $this->lang->line('roles_permissions') : "Roles & Permissions") . ': </strong>' .
                            (($plan["roles_permissions"] < 0) ?
                              ($this->lang->line('unlimited') ?: 'Unlimited') : (($plan["roles_permissions"] == 4) ?
                                "Admin & Standard User" : (($plan["roles_permissions"] == 5) ?
                                  "5 including Admin & Clients" :
                                  $plan["roles_permissions"]
                                )
                              )
                            ) . '<br>
                          
                            <strong>' . ($this->lang->line('users') ? $this->lang->line('users') : "Users") . ': </strong>' . (($plan["users"] < 0) ? ($this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited') : $plan["users"]) . '<br>

                            <strong>' . ($this->lang->line('additional_users') ? $this->lang->line('additional_users') : "Additional Users") . ': </strong>' . (($plan["additional_users"] == 0) ? ('Nill') : ' $' . $plan["additional_users"] . '/user') . '<br>';




                          $tempAction = '<div class="d-flex">
					<span class="badge light badge-primary"><a href="#" data-id="' . $plan["id"] . '" class="text-primary btn-success modal-edit-plan mr-1" data-placement="top" title="' . ($this->lang->line('edit') ? htmlspecialchars($this->lang->line('edit')) : 'Edit') . '" data-bs-toggle="modal" data-bs-target="#plan-edit-modal"><i class="fas fa-pen"></i></a></span>
					<span class="badge light badge-danger ms-2">
          <a href="#" class="text-danger delete_plan" data-id="' . $plan["id"] . '" data-bs-toggle="tooltip"  data-placement="top" title="' . ($this->lang->line('delete') ? htmlspecialchars($this->lang->line('delete')) : 'Delete') . '"><i class="fas fa-trash"></i></a></span>
				</div>';
                          ?>
                          <tr>
                            <td><?= $plan["title"] ?></td>
                            <td><?= $plan["price"] ?></td>
                            <td><?= $billing_type ?></td>
                            <td><?= $tempFeatures ?></td>
                            <td><?= $tempModule ?></td>
                            <td><?= $tempAction ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <?php
          } else {
            unset($plans[0]);
            $my_plan = get_current_plan();
            if ($this->ion_auth->is_admin()) {
              if ($my_plan &&  !is_null($my_plan['end_date']) && (($my_plan['expired'] == 0 || $my_plan['end_date'] <= date('Y-m-d', date(strtotime("+" . alert_days() . " day", strtotime(date('Y-m-d')))))) || ($my_plan['billing_type'] == 'three_days_trial_plan' || $my_plan['billing_type'] == 'seven_days_trial_plan' || $my_plan['billing_type'] == 'fifteen_days_trial_plan' || $my_plan['billing_type'] == 'thirty_days_trial_plan'))) {
            ?>
                <div class="col-md-12 mb-4">
                  <div class="hero text-white bg-danger">
                    <div class="hero-inner">
                      <h2><?= $this->lang->line('alert') ? $this->lang->line('alert') : 'Alert...' ?></h2>

                      <?php
                      $plan_ending_date = '<br>' . ($this->lang->line('ending_date') ? htmlspecialchars($this->lang->line('ending_date')) : 'Ending Date') . ': ' . format_date($my_plan["end_date"], system_date_format());
                      if ($my_plan['expired'] == 0) { ?>
                        <p class="lead"><?= $this->lang->line('your_subscription_plan_has_been_expired_on_date') ? $this->lang->line('your_subscription_plan_has_been_expired_on_date') : 'Your subscription plan has been expired on date' ?> <?= htmlspecialchars(format_date($my_plan["end_date"], system_date_format())) ?> <?= $this->lang->line('renew_it_now') ? $this->lang->line('renew_it_now') : 'Renew it now.' ?></p>
                      <?php } elseif ($my_plan["billing_type"] == 'three_days_trial_plan') {
                        echo $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan';
                        echo $plan_ending_date;
                      } elseif ($my_plan["billing_type"] == 'seven_days_trial_plan') {
                        echo $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan';
                        echo $plan_ending_date;
                      } elseif ($my_plan["billing_type"] == 'fifteen_days_trial_plan') {
                        echo $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan';
                        echo $plan_ending_date;
                      } elseif ($my_plan["billing_type"] == 'thirty_days_trial_plan') {
                        echo $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan';
                        echo $plan_ending_date;
                      } elseif ($my_plan['end_date'] <= date('Y-m-d', date(strtotime("+" . alert_days() . " day", strtotime(date('Y-m-d')))))) { ?>
                        <p class="lead"><?= $this->lang->line('your_current_subscription_plan_is_expiring_on_date') ? $this->lang->line('your_current_subscription_plan_is_expiring_on_date') : 'Your current subscription plan is expiring on date' ?> <?= htmlspecialchars(format_date($my_plan["end_date"], system_date_format())) ?>.</p>
                      <?php } ?>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
            <main>
              <?php

              $modules = array();
              for ($i = 1; $i < 3; $i++) {
                $modules[$i] = json_decode($plans[$i]['modules'], true);
              }
              ?>
              <table class="table table-striped resp-pricing-table">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <?php foreach ($plans as $plan) : ?>
                      <th scope="col"><?= $plan['title'] ?>
                        <?php if ($my_plan['plan_id'] == $plan['id'] && !is_null($my_plan['end_date'])) { ?>
                          <i class="fas fa-question-circle text-success fs-5" data-bs-container="body" data-bs-toggle="popover" title="Current Plan" data-bs-placement="top" data-bs-content="<?= $this->lang->line('this_is_your_current_active_plan_and_expiring_on_date') ? $this->lang->line('this_is_your_current_active_plan_and_expiring_on_date') : 'This is your current active plan and expiring on date' ?> <?= htmlspecialchars(format_date($my_plan["end_date"], system_date_format())) ?>."></i>
                        <?php } elseif ($my_plan['plan_id'] == $plan['id']) { ?>
                          <i class="fas fa-question-circle text-success fs-5" data-bs-container="body" data-bs-toggle="popover" title="Current Plan" data-bs-placement="top" data-bs-content="<?= $this->lang->line('this_is_your_current_active_plan') ? $this->lang->line('this_is_your_current_active_plan') : 'This is your current active plan, No Expiry Date.' ?>"></i>
                        <?php } ?>
                      </th>
                    <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>

                  <?php $attributes = ['price', 'users', 'additional_users', 'projects', 'tasks', 'storage', 'additional_storage']; ?>
                  <?php foreach ($attributes as $attribute) : ?>
                    <tr>
                      <th scope="row">
                        <h4><?= ucwords(str_replace('_', ' ', $attribute)) ?></h4>
                      </th>
                      <?php foreach ($plans as $plan) : ?>
                        <td>
                          <?php
                          if ($attribute === 'price') {
                            echo '$' . $plan[$attribute] . ' / month';
                          } elseif ($attribute === 'additional_users') {
                            echo $plan[$attribute] == 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : ($plan[$attribute] == -1 ? 'Unlimited' : '$' . $plan[$attribute] . ' / user');
                          } elseif ($attribute === 'additional_storage') {
                            echo $plan[$attribute] == 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : ($plan[$attribute] == -1 ? 'Unlimited' : '$' . $plan[$attribute] . ' / GB');
                          } elseif ($attribute === 'tasks') {
                            echo $plan[$attribute] == -1 ? 'Unlimited' : $plan[$attribute] . ' / projects';
                          } elseif ($attribute === 'storage') {
                            echo $plan[$attribute] == -1 ? 'Unlimited' : $plan[$attribute] . ' GB';
                          } else {
                            echo $plan[$attribute] == -1 ? 'Unlimited' : $plan[$attribute];
                          }
                          ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>

                  <tr>
                    <th colspan="<?= count($plans) + 1 ?>">
                      <h3>Project Types</h3>
                    </th>
                  </tr>

                  <?php $projectTypes = ['kanban', 'scrum', 'clients']; ?>
                  <?php foreach ($projectTypes as $type) : ?>
                    <tr>
                      <th scope="row"><?= ucwords($type) ?></th>
                      <?php foreach ($modules as $module) : ?>
                        <td><?= isset($module[$type]) && $module[$type] !== 0 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>'; ?></td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>

                  <tr>
                    <th colspan="<?= count($plans) + 1 ?>">
                      <h3>Attendance</h3>
                    </th>
                  </tr>

                  <tr>
                    <th>Biometric Machine</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td><?= $plan['biometric_machine'] == 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : ($plan['biometric_machine'] == -1 ? 'Unlimited' : $plan['biometric_machine']); ?></td>
                    <?php endforeach; ?>
                  </tr>
                  <tr>
                    <th>Leave Types</th>
                    <?php for ($i = 0; $i < count($modules); $i++) : ?>
                      <td>
                        <?= isset($modules[$i]['leaves_types']) && $modules[$i]['leaves_types'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endfor; ?>
                  </tr>
                  <tr>
                    <th>Leave Hierarchy</th>
                    <?php for ($i = 0; $i < count($modules); $i++) : ?>
                      <td>
                        <?= isset($modules[$i]['leave_hierarchy']) && $modules[$i]['leave_hierarchy'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endfor; ?>
                  </tr>

                  <tr>
                    <th>Leaves Requests</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td>
                        <?= $plan['leave_requests']  == -1 ? 'Unlimited'  : $plan['leave_requests'] . '<span> /user</span>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>


                  <tr>
                    <th>Missing Biometric Requests</th>
                    <?php foreach ($modules as $module) : ?>
                      <td><?= isset($module['biometric_missing']) && $module['biometric_missing'] !== 0 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>'; ?></td>
                    <?php endforeach; ?>
                  </tr>


                  <tr>
                    <th>Roles & Permissions</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td>
                        <?= $plan['roles_permissions']  == -1 ? 'Unlimited'  : ($plan['roles_permissions'] == 4 ? 'Admin and Standard Users' : ($plan['roles_permissions'] == 5 ? '5 including admin & client' : '-')); ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Office Shifts</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td>
                        <?= $plan['office_shifts']  == -1 ? 'Unlimited'  : $plan['office_shifts']; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Events Board</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['notice_board']) && $module['notice_board'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Plan Holidays</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['holidays']) && $module['holidays'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Attendance & Leave policy</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['attendance_leave_policy']) && $module['attendance_leave_policy'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Departments</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td>
                        <?= $plan['departments']  == -1 ? 'Unlimited'  : $plan['departments']; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Email/Push Notifications</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td><?= $plan['email_push_notif']  == -1 ? 'Limited'  : ($plan['email_push_notif'] == 1 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : $plan['email_push_notif']); ?></td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Reports</th>
                    <?php foreach ($plans as $plan) : ?>
                      <td><?= $plan['reports']  == -1 ? 'Limited'  : ($plan['reports'] == 1 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : $plan['reports']); ?></td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Support</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['support']) && $module['support'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>To Do</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['todo']) && $module['todo'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Chat</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['chat']) && $module['chat'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <th>Notes</th>
                    <?php foreach ($modules as $module) : ?>
                      <td>
                        <?= isset($module['notes']) && $module['notes'] === 0 ? '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>

                  <tr>
                    <td data-label="Actions">Actions</td>
                    <?php
                    foreach ($plans as $key => $plan) {
                    ?>
                      <td data-label=<?= $plan['title'] ?> class="pricing-cta">
                        <a href="#" class="btn btn-warning btn-block btn-lg payment-button text-dark" data-amount="<?= htmlspecialchars($plan['price']) ?>" data-id="<?= htmlspecialchars($plan['id']) ?>"><?= $my_plan['plan_id'] == $plan['id'] ? ($this->lang->line('renew_plan') ? $this->lang->line('renew_plan') : 'Renew Plan.') : ($this->lang->line('subscribe') ? $this->lang->line('subscribe') : 'Upgrade') ?> <span><img width="28" height="28" src=<?= base_url('assets2/images/landing_page_images/arrow.gif') ?> alt="->"></span></a>
                      </td>
                    <?php
                    }
                    ?>
                  </tr>
                </tbody>
              </table>
            </main>
          <?php
          } ?>
        </div>
        <div class="row d-none" id="payment-div">
          <div id="paypal-button" class="col-md-8 mx-auto paymet-box"></div>
          <?php if (get_stripe_secret_key() && get_stripe_publishable_key()) { ?>
            <button id="stripe-button" class="col-md-8 btn mx-auto paymet-box">
              <img src="<?= base_url('assets/img/stripe.png') ?>" width="14%" alt="Stripe">
            </button>
          <?php } ?>

          <?php if (get_myfatoorah_secret_key() && get_myfatoorah_publishable_key()) { ?>
            <button id="fatoorah-button" class="col-md-8 btn mx-auto paymet-box">
              <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70%"><defs><style>.a{fill:#4cb4e7}</style></defs><path class="a" d="M.447 59.727l27.908-.212.038 5.083-27.908.212M.386 51.254l27.908-.212.038 5.083-27.908.212M.321 42.778l27.908-.212.039 5.083-27.908.212M.257 34.306l41.951-.318.039 5.083-41.951.318M.193 25.84l41.951-.318.038 5.083-41.951.318M.128 17.364l55.914-.424.038 5.083-55.914.424M.064 8.896l55.914-.424.038 5.083-55.914.424M0 .424L55.914 0l.039 5.083-55.914.424"/><path d="M56.167 33.916l4.926-.037.013 1.923a5.992 5.992 0 014.8-2.321 6.053 6.053 0 015.6 2.824 6.875 6.875 0 015.628-2.912c4.6-.034 6.9 2.708 6.936 7.393l.083 11.074-5.034.037-.079-10.421c-.017-2.43-.968-3.842-3.178-3.826-1.885.017-3.248 1.333-3.227 4.382l.075 9.914-5.034.037-.079-10.421c-.017-2.43-.968-3.842-3.178-3.825-1.881.017-3.248 1.333-3.223 4.382l.075 9.915-4.964.037zM91.856 51.001l-7.337-17.3 5.214-.04 4.538 11.148 4.079-11.214 5.142-.039-10.3 26.62-4.961.038z"/><g><path d="M56.525 57.928l14.954-.114.036 4.829-9.921.075.045 5.954 9.921-.075.036 4.829-9.921.075.082 10.892-5.033.038zM87.476 75.085a4.68 4.68 0 00-4.673-4.83 4.891 4.891 0 104.673 4.83m-14.338.146c-.05-6.426 4.635-9.474 8.727-9.507a7.243 7.243 0 015.412 2.1l-.013-1.778 4.959-.037.137 18.151-4.959.038-.017-2.031a7.056 7.056 0 01-5.449 2.438c-3.838.029-8.748-2.986-8.8-9.374M94.105 65.993l3.078-.021-.042-5.823 4.96-.042.046 5.827 3.4-.029.033 4.469-3.4.025.042 5.773c.021 2.829.386 3.265 3.431 3.24l.033 4.648h-.723c-5.757.046-7.655-1.9-7.7-7.821l-.046-5.807-3.078.021zM120.351 74.872a4.547 4.547 0 10-4.523 4.751 4.645 4.645 0 004.523-4.751m-13.939.1a9.379 9.379 0 119.449 9.37 9.382 9.382 0 01-9.449-9.37"/><path d="M140.454 74.72a4.651 4.651 0 00-4.6-4.685 4.725 4.725 0 00.071 9.441 4.656 4.656 0 004.527-4.756m-13.943.108a9.379 9.379 0 119.453 9.366 9.38 9.38 0 01-9.453-9.366M146.896 65.594l4.926-.038.021 2.978a5.1 5.1 0 014.976-3.016l1.811-.017.033 4.831-2.965.021c-2.646.021-3.792 1.412-3.767 4.785l.067 8.569-4.964.038zM173.724 74.428a4.679 4.679 0 00-4.673-4.825 4.889 4.889 0 104.673 4.826m-14.338.146c-.05-6.426 4.636-9.474 8.727-9.5a7.228 7.228 0 015.412 2.1l-.016-1.782 4.964-.037.137 18.155-4.959.037-.017-2.035a7.045 7.045 0 01-5.449 2.438c-3.838.029-8.752-2.983-8.8-9.375M180.312 83.496l-.2-26.5 6.367-.05.083 10.891a6.63 6.63 0 016.094-3.531c3.555-.029 6.1 2.226 6.135 6.957l.091 12.1-6.368.046-.083-10.812c-.013-2.1-.843-3.123-2.692-3.107-1.882.013-3.157 1.163-3.14 3.543l.079 10.421z"/></g><text transform="translate(55.143 94.952)" font-size="9" font-family="Graphik-Medium,Graphik" font-weight="500" fill="#4cb4e7"><tspan x="0" y="0">More than just a payment solution</tspan></text></svg>
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
      </div>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!-- ************************************* *****
    Model forms
  ****************************************************-->
    <div class="modal fade" id="plan-add-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('plans/create') ?>" method="POST" class="modal-part" id="modal-add-plan-part" data-title="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>" data-btn="<?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-12 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?><span class="text-danger">*</span></label>
                  <input type="text" name="title" class="form-control" required="">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('price_usd') ? $this->lang->line('price_usd') . ' - ' . get_saas_currency('currency_code') : 'Price - ' . get_saas_currency('currency_code') ?><span class="text-danger">*</span></label>
                  <input type="number" name="price" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('billing_type') ? $this->lang->line('billing_type') : 'Billing Type' ?><span class="text-danger">*</span></label>
                  <select name="billing_type" class="form-control select2">
                    <option value="Monthly"><?= $this->lang->line('monthly') ? $this->lang->line('monthly') : 'Monthly' ?></option>
                    <option value="Yearly"><?= $this->lang->line('yearly') ? $this->lang->line('yearly') : 'Yearly' ?></option>
                    <option value="One Time"><?= $this->lang->line('one_time') ? $this->lang->line('one_time') : 'One Time' ?></option>
                    <option value="three_days_trial_plan"><?= $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan' ?></option>
                    <option value="seven_days_trial_plan"><?= $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan' ?></option>
                    <option value="fifteen_days_trial_plan"><?= $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan' ?></option>
                    <option value="thirty_days_trial_plan"><?= $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan' ?></option>
                  </select>
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?> (GB)<span class="text-danger">*</span></label>
                  <input type="number" name="storage" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?><span class="text-danger">*</span></label>
                  <input type="number" name="projects" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?><span class="text-danger">*</span></label>
                  <input type="number" name="tasks" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?><span class="text-danger">*</span></label>
                  <input type="number" name="users" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'Biometric Machine' ?><span class="text-danger">*</span></label>
                  <input type="number" name="biometric_machine" id="biometric_machine" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('leave_requests') ? $this->lang->line('leave_requests') : 'Leave Requests' ?><span class="text-danger">*</span></label>
                  <input type="number" name="leave_requests" id="leave_requests" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('office_shifts') ? $this->lang->line('office_shifts') : 'Office Shifts' ?><span class="text-danger">*</span></label>
                  <input type="number" name="office_shifts" id="office_shifts" class="form-control">
                </div>


                <div class="form-group col-md-12 mb-3">
                  <small class="form-text text-muted">
                    <?= $this->lang->line('set_value_in_minus_to_make_it_unlimited') ? $this->lang->line('set_value_in_minus_to_make_it_unlimited') : 'Set value in minus (-1) to make it Unlimited.' ?>
                  </small>
                </div>
                <div class="form-group col-md-12 mb-3">
                  <h6><?= $this->lang->line('modules') ? $this->lang->line('modules') : 'Modules' ?></h6>
                </div>
                <div class="form-group col-md-12 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="select_all" name="select_all">
                    <label class="form-check-label" for="select_all"><?= $this->lang->line('select_all') ? $this->lang->line('select_all') : 'Select All' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="projects_module" name="projects_module">
                    <label class="form-check-label" for="projects_module"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="kanban" name="kanban">
                    <label class="form-check-label" for="kanban"><?= $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="agile" name="agile">
                    <label class="form-check-label" for="agile"><?= $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="scrum" name="scrum">
                    <label class="form-check-label" for="scrum"><?= $this->lang->line('scrum') ? $this->lang->line('scrum') : 'Scrum' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="tasks_module" name="tasks_module">
                    <label class="form-check-label" for="tasks_module"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="gantt" name="gantt">
                    <label class="form-check-label" for="gantt"><?= $this->lang->line('gantt') ? $this->lang->line('gantt') : 'Gantt' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="timesheet" name="timesheet">
                    <label class="form-check-label" for="timesheet"><?= $this->lang->line('timesheet') ? $this->lang->line('timesheet') : 'Timesheet' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="attendance" name="attendance">
                    <label class="form-check-label" for="attendance"><?= $this->lang->line('attendance') ? htmlspecialchars($this->lang->line('attendance')) : 'Attendance' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="employees" name="team_members">
                    <label class="form-check-label" for="employees"><?= $this->lang->line('employees') ? $this->lang->line('employees') : 'Employees' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="user_roles" name="user_roles">
                    <label class="form-check-label" for="user_roles"><?= $this->lang->line('user_roles') ? $this->lang->line('user_roles') : 'Employees Roles' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="user_permissions" name="user_permissions">
                    <label class="form-check-label" for="user_permissions"><?= $this->lang->line('user_permissions') ? $this->lang->line('user_permissions') : 'Employees Permissions' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="departments" name="departments">
                    <label class="form-check-label" for="departments"><?= $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="shifts" name="shifts">
                    <label class="form-check-label" for="shifts"><?= $this->lang->line('shifts') ? $this->lang->line('shifts') : 'Shifts' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="clients" name="clients">
                    <label class="form-check-label" for="clients"><?= $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="invoices" name="invoices">
                    <label class="form-check-label" for="invoices"><?= $this->lang->line('invoices') ? $this->lang->line('invoices') : 'Invoices' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="payments" name="payments">
                    <label class="form-check-label" for="payments"><?= $this->lang->line('payments') ? $this->lang->line('payments') : 'Payments' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="expenses" name="expenses">
                    <label class="form-check-label" for="expenses"><?= $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="calendar" name="calendar">
                    <label class="form-check-label" for="calendar"><?= $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leaves" name="leaves">
                    <label class="form-check-label" for="leaves"><?= $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leaves_types" name="leaves_types">
                    <label class="form-check-label" for="leaves_types"><?= $this->lang->line('leaves_types') ? $this->lang->line('leaves_types') : 'Leaves Types' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leave_hierarchy" name="leave_hierarchy">
                    <label class="form-check-label" for="leave_hierarchy"><?= $this->lang->line('leave_hierarchy') ? $this->lang->line('leave_hierarchy') : 'Leave Hierarchy' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="biometric_missing" name="biometric_missing">
                    <label class="form-check-label" for="biometric_missing"><?= $this->lang->line('biometric_missing') ? $this->lang->line('biometric_missing') : 'biometric Missing' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="biometric_machine" name="biometric_machine">
                    <label class="form-check-label" for="biometric_machine"><?= $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'biometric Machines' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="holidays" name="holidays">
                    <label class="form-check-label" for="holidays"><?= $this->lang->line('holidays') ? $this->lang->line('holidays') : 'Holidays' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="todo" name="todo">
                    <label class="form-check-label" for="todo"><?= $this->lang->line('todo') ? $this->lang->line('todo') : 'Todo' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notes" name="notes">
                    <label class="form-check-label" for="notes"><?= $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notice_board" name="notice_board">
                    <label class="form-check-label" for="notice_board"><?= $this->lang->line('notice_board') ? $this->lang->line('notice_board') : 'Events Board' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chat" name="chat">
                    <label class="form-check-label" for="chat"><?= $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leads" name="leads">
                    <label class="form-check-label" for="leads"><?= $this->lang->line('leads') ? $this->lang->line('leads') : 'Leads' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="payment_gateway" name="payment_gateway">
                    <label class="form-check-label" for="payment_gateway"><?= $this->lang->line('payment_gateway') ? $this->lang->line('payment_gateway') : 'Payment Gateway' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="taxes" name="taxes">
                    <label class="form-check-label" for="taxes"><?= $this->lang->line('taxes') ? $this->lang->line('taxes') : 'Taxes' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="custom_currency" name="custom_currency">
                    <label class="form-check-label" for="custom_currency"><?= $this->lang->line('custom_currency') ? $this->lang->line('custom_currency') : 'Custom Currency' ?></label>
                  </div>
                </div> -->

                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notifications" name="notifications">
                    <label class="form-check-label" for="notifications"><?= $this->lang->line('notifications') ? $this->lang->line('notifications') : 'Notifications' ?></label>
                  </div>
                </div>

                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="languages" name="languages">
                    <label class="form-check-label" for="languages"><?= $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="meetings" name="meetings">
                    <label class="form-check-label" for="meetings"><?= $this->lang->line('video_meetings') ? $this->lang->line('video_meetings') : 'Video Meetings' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="estimates" name="estimates">
                    <label class="form-check-label" for="estimates"><?= $this->lang->line('estimates') ? $this->lang->line('estimates') : 'Estimates' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="reports" name="reports">
                    <label class="form-check-label" for="reports"><?= $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="support" name="support">
                    <label class="form-check-label" for="support"><?= $this->lang->line('support') ? htmlspecialchars($this->lang->line('support')) : 'Support' ?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-create-plan btn-block btn-primary">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="plan-edit-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="<?= base_url('plans/edit') ?>" method="POST" class="modal-part" id="modal-edit-plan-part" data-title="<?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?>" data-btn="<?= $this->lang->line('update') ? $this->lang->line('update') : 'Update' ?>">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-12 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?><span class="text-danger">*</span></label>
                  <input type="hidden" name="update_id" id="update_id">
                  <input type="text" name="title" id="title" class="form-control" required="">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('price_usd') ? $this->lang->line('price_usd') . ' - ' . get_saas_currency('currency_code') : 'Price - ' . get_saas_currency('currency_code') ?><span class="text-danger">*</span></label>
                  <input type="number" name="price" id="price" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('billing_type') ? $this->lang->line('billing_type') : 'Billing Type' ?><span class="text-danger">*</span></label>
                  <select name="billing_type" id="billing_type" class="form-control select2">
                    <option value="Monthly"><?= $this->lang->line('monthly') ? $this->lang->line('monthly') : 'Monthly' ?></option>
                    <option value="Yearly"><?= $this->lang->line('yearly') ? $this->lang->line('yearly') : 'Yearly' ?></option>
                    <option value="One Time"><?= $this->lang->line('one_time') ? $this->lang->line('one_time') : 'One Time' ?></option>
                    <option value="three_days_trial_plan"><?= $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan' ?></option>
                    <option value="seven_days_trial_plan"><?= $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan' ?></option>
                    <option value="fifteen_days_trial_plan"><?= $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan' ?></option>
                    <option value="thirty_days_trial_plan"><?= $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan' ?></option>
                  </select>
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?> (GB)<span class="text-danger">*</span></label>
                  <input type="number" name="storage" id="storage" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('additional_storage') ? $this->lang->line('additional_storage') : 'Additional Storage Charges' ?> $ /(GB) <span class="text-danger">*</span> </label>
                  <input type="number" name="additional_storage" id="additional_storage" class="form-control" placeholder="Additional Storage Charges $ per GB">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?><span class="text-danger">*</span></label>
                  <input type="number" name="projects" id="projects" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?><span class="text-danger">*</span></label>
                  <input type="number" name="tasks" id="tasks" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('users') ? $this->lang->line('users') : 'Users' ?><span class="text-danger">*</span></label>
                  <input type="number" name="users" id="users" class="form-control">
                </div>
                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('additional_users') ? $this->lang->line('additional_users') : 'Additional Users Charges' ?> $ /(user) <span class="text-danger">*</span> </label>
                  <input type="number" name="additional_users" id="additional_users" class="form-control" placeholder="Additional User Charges $ per user">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label">
                    <?= $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'Biometric Machine' ?><span class="text-danger">*</span>
                  </label>
                  <input type="number" name="biometric_machine" id="biometric_machine_2" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('leave_requests') ? $this->lang->line('leave_requests') : 'Leave Requests' ?><span class="text-danger">*</span></label>
                  <input type="number" name="leave_requests" id="leave_requests_2" class="form-control">
                </div>


                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('office_shifts') ? $this->lang->line('office_shifts') : 'Office Shifts' ?><span class="text-danger">*</span></label>
                  <input type="number" name="office_shifts" id="office_shifts_2" class="form-control">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments' ?><span class="text-danger">*</span></label>
                  <input type="number" name="departments" id="departments_2" class="form-control">
                </div>


                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('email_push_notif') ? $this->lang->line('email_push_notif') : 'Email/Push Notifications' ?><span class="text-danger">*</span></label>
                  <input type="number" name="email_push_notif" id="email_push_notif" class="form-control" placeholder="enter -1 for Limited">
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports' ?><span class="text-danger">*</span></label>
                  <input type="number" name="reports" id="reports_2" class="form-control" placeholder="enter -1 for Limited">
                </div>


                <div class="form-group col-md-6 mb-3">
                  <label class="col-form-label"><?= $this->lang->line('roles_permissions') ? $this->lang->line('roles_permissions') : 'Roles & Permissions' ?><span class="text-danger">*</span></label>
                  <select name="roles_permissions" id="roles_permissions" class="form-control select2">
                    <option value="4"><?= 'Admin and Standard Users' ?></option>
                    <option value="5"><?= '5 including admin & client' ?></option>
                    <option value="-1"><?= 'Unlimited' ?></option>
                  </select>
                </div>




                <div class="form-group col-md-12 mb-3">
                  <small class="form-text text-muted">
                    <?= $this->lang->line('set_value_in_minus_to_make_it_unlimited') ? $this->lang->line('set_value_in_minus_to_make_it_unlimited') : 'Set value in minus (-1) to make it Unlimited.' ?>
                  </small>
                </div>

                <!-- Modules -->

                <div class="form-group col-md-12 mb-3">
                  <h6><?= $this->lang->line('modules') ? $this->lang->line('modules') : 'Modules' ?></h6>
                </div>
                <div class="form-group col-md-12 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="select_all_update" name="select_all">
                    <label class="form-check-label" for="select_all_update"><?= $this->lang->line('select_all') ? $this->lang->line('select_all') : 'Select All' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="projects_module_update" name="projects_module">
                    <label class="form-check-label" for="projects_module_update"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="kanban_update" name="kanban">
                    <label class="form-check-label" for="kanban_update"><?= $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="agile_update" name="agile">
                    <label class="form-check-label" for="agile_update"><?= $this->lang->line('Agile') ? $this->lang->line('Agile') : 'Agile' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="scrum_update" name="scrum">
                    <label class="form-check-label" for="scrum_update"><?= $this->lang->line('Scrum') ? $this->lang->line('Scrum') : 'Scrum' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="agile_update" name="agile">
                    <label class="form-check-label" for="agile_update"><?= $this->lang->line('Agile') ? $this->lang->line('Agile') : 'Agile' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="tasks_module_update" name="tasks_module">
                    <label class="form-check-label" for="tasks_module_update"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="gantt_update" name="gantt">
                    <label class="form-check-label" for="gantt_update"><?= $this->lang->line('gantt') ? $this->lang->line('gantt') : 'Gantt' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="timesheet_update" name="timesheet">
                    <label class="form-check-label" for="timesheet_update"><?= $this->lang->line('timesheet') ? $this->lang->line('timesheet') : 'Timesheet' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="attendance_update" name="attendance">
                    <label class="form-check-label" for="attendance_update"><?= $this->lang->line('attendance') ? htmlspecialchars($this->lang->line('attendance')) : 'Attendance' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="team_members_update" name="team_members">
                    <label class="form-check-label" for="team_members_update"><?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Employees' ?></label>
                  </div>
                </div>


                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="attendance_leave_policy_update" name="attendance_leave_policy">
                    <label class="form-check-label" for="attendance_leave_policy"><?= $this->lang->line('attendance_leave_policy') ? $this->lang->line('attendance_leave_policy') : 'Attendance/Leave Policy ' ?></label>
                  </div>
                </div>


                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="user_roles_update" name="user_roles">
                    <label class="form-check-label" for="user_roles_update"><?= $this->lang->line('user_roles') ? $this->lang->line('user_roles') : 'Employee Roles' ?></label>
                  </div>
                </div> -->

                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="user_permissions_update" name="user_permissions">
                    <label class="form-check-label" for="user_permissions_update"><?= $this->lang->line('user_permissions') ? $this->lang->line('user_permissions') : 'Employee Permissions' ?></label>
                  </div>
                </div> -->


                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="departments_update" name="departments">
                    <label class="form-check-label" for="departments_update"><?= $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="shifts_update" name="shifts">
                    <label class="form-check-label" for="shifts_update"><?= $this->lang->line('shifts') ? $this->lang->line('shifts') : 'Shifts' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="clients_update" name="clients">
                    <label class="form-check-label" for="clients_update"><?= $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4  mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="invoices_update" name="invoices">
                    <label class="form-check-label" for="invoices_update"><?= $this->lang->line('invoices') ? $this->lang->line('invoices') : 'Invoices' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="payments_update" name="payments">
                    <label class="form-check-label" for="payments_update"><?= $this->lang->line('payments') ? $this->lang->line('payments') : 'Payments' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="expenses_update" name="expenses">
                    <label class="form-check-label" for="expenses_update"><?= $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="calendar_update" name="calendar">
                    <label class="form-check-label" for="calendar_update"><?= $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leaves_update" name="leaves">
                    <label class="form-check-label" for="leaves_update"><?= $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leaves_types_update" name="leaves_types">
                    <label class="form-check-label" for="leaves_types_update"><?= $this->lang->line('leaves_type') ? $this->lang->line('leaves_types') : 'Leaves Type' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leave_hierarchy_update" name="leave_hierarchy">
                    <label class="form-check-label" for="leave_hierarchy_update"><?= $this->lang->line('leave_hierarchy') ? $this->lang->line('leave_hierarchy') : 'Leave Hierarchy' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="biometric_missing_update" name="biometric_missing">
                    <label class="form-check-label" for="biometric_missing_update"><?= $this->lang->line('biometric_missing') ? $this->lang->line('biometric_missing') : 'Biometric Missing' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="biometric_machine_update" name="biometric_machine">
                    <label class="form-check-label" for="biometric_machine_update"><?= $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'Biometric Machine' ?></label>
                  </div>
                </div> -->
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="holidays_update" name="holidays">
                    <label class="form-check-label" for="holidays_update"><?= $this->lang->line('holidays') ? $this->lang->line('holidays') : 'Holidays' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="todo_update" name="todo">
                    <label class="form-check-label" for="todo_update"><?= $this->lang->line('todo') ? $this->lang->line('todo') : 'Todo' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notes_update" name="notes">
                    <label class="form-check-label" for="notes_update"><?= $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notice_board_update" name="notice_board">
                    <label class="form-check-label" for="notice_board_update"><?= $this->lang->line('notice_board') ? htmlspecialchars($this->lang->line('notice_board')) : 'Events Board' ?></label>
                  </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chat_update" name="chat">
                    <label class="form-check-label" for="chat_update"><?= $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="leads_update" name="leads">
                    <label class="form-check-label" for="leads_update"><?= $this->lang->line('leads') ? $this->lang->line('leads') : 'Leads' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="payment_gateway_update" name="payment_gateway">
                    <label class="form-check-label" for="payment_gateway_update"><?= $this->lang->line('payment_gateway') ? $this->lang->line('payment_gateway') : 'Payment Gateway' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="taxes_update" name="taxes">
                    <label class="form-check-label" for="taxes_update"><?= $this->lang->line('taxes') ? $this->lang->line('taxes') : 'Taxes' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="custom_currency_update" name="custom_currency">
                    <label class="form-check-label" for="custom_currency_update"><?= $this->lang->line('custom_currency') ? $this->lang->line('custom_currency') : 'Custom Currency' ?></label>
                  </div>
                </div> -->

                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="notifications_update" name="notifications">
                    <label class="form-check-label" for="notifications_update"><?= $this->lang->line('notifications') ? $this->lang->line('notifications') : 'Notifications' ?></label>
                  </div>
                </div>
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="languages_update" name="languages">
                    <label class="form-check-label" for="languages_update"><?= $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="meetings_update" name="meetings">
                    <label class="form-check-label" for="meetings_update"><?= $this->lang->line('video_meetings') ? $this->lang->line('video_meetings') : 'Video Meetings' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="estimates_update" name="estimates">
                    <label class="form-check-label" for="estimates_update"><?= $this->lang->line('estimates') ? $this->lang->line('estimates') : 'Estimates' ?></label>
                  </div>
                </div> -->
                <!-- <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="reports_update" name="reports">
                    <label class="form-check-label" for="reports_update"><?= $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports' ?></label>
                  </div>
                </div> -->

                <div class="form-group col-md-4 mb-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="support_update" name="support">
                    <label class="form-check-label" for="support_update"><?= $this->lang->line('support') ? htmlspecialchars($this->lang->line('support')) : 'Support' ?></label>
                  </div>
                </div>


              </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="col-lg-4">
                <button type="button" class="btn btn-edit-plan btn-block btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    paypal_client_id = "<?= get_payment_paypal() ?>";
    get_stripe_publishable_key = "<?= get_stripe_publishable_key() ?>";
    get_myfatoorah_secret_key = "<?= get_myfatoorah_secret_key() ?>";
    razorpay_key_id = "<?= get_razorpay_key_id() ?>";
    offline_bank_transfer = "<?= get_offline_bank_transfer() ?>";
    paystack_user_email_id = "<?= $this->session->userdata('email') ?>";
    paystack_public_key = "<?= get_paystack_public_key() ?>";
  </script>

  <?php if (get_payment_paypal()) { ?>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= get_payment_paypal() ?>&currency=<?= get_saas_currency('currency_code') ?>"></script>
  <?php } ?>

  <?php if (get_stripe_publishable_key()) { ?>
    <script src="https://js.stripe.com/v3/"></script>
  <?php } ?>

  <script src="https://js.paystack.co/v1/inline.js"></script>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <script src="<?= base_url('assets/js/page/payment.js'); ?>"></script>

  <script>
    var table3 = $('#example3').DataTable({
      "paging": true,
      "searching": true,
      "language": {
        "paginate": {
          "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "lengthChange": true,
      "lengthMenu": [10, 20, 50, 500],
      "order": false,
      "pageLength": 10,
      "dom": '<"top"f>rt<"bottom"lp><"clear">'

    });

    $("#plan-add-modal").on('click', '.btn-create-plan', function(e) {
      var modal = $('#plan-add-modal');
      var form = $('#modal-add-plan-part');
      var formData = form.serialize();
      console.log(formData);

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        beforeSend: function() {
          $(".modal-body").append(ModelProgress);
        },
        success: function(result) {
          if (result['error'] == false) {
            location.reload();
          } else {
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.modal-edit-plan', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      $.ajax({
        type: "POST",
        url: base_url + 'plans/ajax_get_plan_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result['error'] == false) {
            $('input:checkbox').prop("checked", false);
            if (result['data'][0].modules != '') {


              $.each(JSON.parse(result['data'][0].modules), function(key, val) {
                if (val == 1) {
                  // console.log(key, val);
                  $('#' + key + '_update').prop("checked", true).val(val);
                  $('#' + key + '_module_update').prop("checked", true).val(val);
                }
              });
            }

            $("#update_id").val(result['data'][0].id);
            $("#title").val(result['data'][0].title);
            $("#price").val(result['data'][0].price);
            $("#billing_type").val(result['data'][0].billing_type);
            $("#billing_type").trigger("change");
            $("#projects").val(result['data'][0].projects);
            $("#tasks").val(result['data'][0].tasks);
            $("#biometric_machine_2").val(result['data'][0].biometric_machine);
            $("#leave_requests_2").val(result['data'][0].leave_requests);
            $("#office_shifts_2").val(result['data'][0].leave_requests);
            $("#departments_2").val(result['data'][0].departments);
            $("#email_push_notif").val(result['data'][0].email_push_notif);
            $("#reports_2").val(result['data'][0].reports);
            $("#storage").val(result['data'][0].storage);
            $("#additional_storage").val(result['data'][0].additional_storage);
            $("#roles_permissions").val(result['data'][0].roles_permissions);
            $("#roles_permissions").trigger("change");
            $("#users").val(result['data'][0].users);
            $("#additional_users").val(result['data'][0].additional_users);
            $("#modal-edit-plan").trigger("click");
          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    });

    $("#plan-edit-modal").on('click', '.btn-edit-plan', function(e) {
      var modal = $('#plan-edit-modal');
      var form = $('#modal-edit-plan-part');
      var formData = form.serialize();
      console.log(formData);

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        beforeSend: function() {
          $(".modal-body").append(ModelProgress);
        },
        success: function(result) {
          if (result['error'] == false) {

            location.reload();
          } else {

            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.delete_plan', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      if (id == 1) {
        swal({
          title: wait,
          text: default_plan_can_not_be_deleted,
          icon: 'info',
          dangerMode: true,
        });
      } else {

        Swal.fire({
          title: are_you_sure,
          text: you_want_to_delete_this_plan_all_users_under_this_plan_will_be_added_to_the_default_plan,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "POST",
              url: base_url + 'plans/delete/' + id,
              data: "id=" + id,
              dataType: "json",
              success: function(result) {
                if (result['error'] == false) {
                  location.reload();
                } else {
                  iziToast.error({
                    title: result['message'],
                    message: "",
                    position: 'topRight'
                  });
                }
              }
            });
          }
        });
      }
    });
  </script>
  <script>
    $(document).on('click', '#select_all', function() {
      if ($(this).is(':checked')) {
        $('input:checkbox').prop("checked", true).val(1);
      } else {
        $('input:checkbox').prop("checked", false);
      }
    });
    $(document).on('click', '#select_all_update', function() {
      if ($(this).is(':checked')) {
        $('input:checkbox').prop("checked", true).val(1);
      } else {
        $('input:checkbox').prop("checked", false);
      }
    });
  </script>
</body>

</html>