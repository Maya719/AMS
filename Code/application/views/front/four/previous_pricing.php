<div class="col-lg-12">
                        <div class="tab-content wow fadeInUp" id="nav-tabContent" data-wow-delay=".3s" data-wow-duration="1s">
                            <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel" aria-labelledby="nav-monthly-tab">
                                <div class="row">
                                    <?php foreach ($plans as $key => $plan) {
                                    ?>
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <div class="tp-pricing-item mb-30">
                                                <div class="tp-pricing-top p-relative">
                                                    <div class="tp-pricing-plan text-center ">
                                                        <span style="font-size: 15px;" ><?= htmlspecialchars($plan['title']) ?></span>
                                                    </div>
                                                    <div class="tp-pricing-title-wrapper text-center ">
                                                        <h3 class="tp-price-title"><?= get_saas_currency('currency_symbol') ?><?= htmlspecialchars($plan['price']) ?></h3>
                                                        <p style="margin-top: -30px;" class="lowercase text-gray-500 text-xs">/
                                                            <?php
                                                            if ($plan['billing_type'] == 'One Time') {
                                                                echo $this->lang->line('one_time') ? htmlspecialchars($this->lang->line('one_time')) : 'One Time';
                                                            } elseif ($plan['billing_type'] == 'Monthly') {
                                                                echo $this->lang->line('monthly') ? htmlspecialchars($this->lang->line('monthly')) : 'Monthly';
                                                            } elseif ($plan["billing_type"] == 'three_days_trial_plan') {
                                                                echo $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'seven_days_trial_plan') {
                                                                echo $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'fifteen_days_trial_plan') {
                                                                echo $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'thirty_days_trial_plan') {
                                                                echo $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan';
                                                            } else {
                                                                echo $this->lang->line('yearly') ? htmlspecialchars($this->lang->line('yearly')) : 'Yearly';
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <div class="ms-3 flex justify-content-start mb-2">
                                                        <ul class="text-xl mb-3">
                                                            <li style="list-style: none; " class="d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?>
                                                                </span>
                                                                <span class="badge bg-secondary mx-3">
                                                                    <?= $plan['storage'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['storage'] . ' GB') ?>
                                                                </span>
                                                            </li>

                                                            <li style="list-style: none;" class="d-flex justify-content-between align-items-center">
                                                                <span>

                                                                    <?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?>
                                                                </span>
                                                                <span class="badge bg-secondary mx-3">
                                                                    <?= $plan['projects'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['projects']) ?>
                                                                </span>
                                                            </li>

                                                            <li style="list-style: none;" class="  d-flex justify-content-between align-items-center">
                                                                <span>

                                                                    <?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?>
                                                                </span>
                                                                <span class="badge bg-secondary mx-3"><?= $plan['tasks'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['tasks']) ?></span>
                                                            </li>

                                                            <li style="list-style: none;" class=" d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    Employees<br>
                                                                    <strong style="font-size: 13.5px;">Employee addition: $3</strong>
                                                                    <!-- <?= $this->lang->line('users') ? $this->lang->line('users') : 'Users' ?> -->
                                                                </span>
                                                                <span class="badge bg-secondary mx-3"><?= $plan['users'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['users']) ?></span>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="tp-pricing-content">
                                                    <div class="tp-pricing-content-feature">
                                                        <ul>
                                                            <!-- <li><i class="fa-light fa-circle-check"></i> Roof Cleaning</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Kitchen Cleaning</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Fully Profetional Cleaner</li>
                                                            <li><i class="fa-light fa-circle-check"></i> Living Room Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Bed Room Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Windows & Door Cleaning</li>
                                                            <li class="has-denied"><i class="fa-light fa-circle-xmark"></i> Bathroom Cleaning</li> -->
                                                            <?php $modules = '';
                                                            if ($plan["modules"] != '') {
                                                                foreach (json_decode($plan["modules"]) as $mod_key => $mod) {
                                                                    $mod_name = '';

                                                                    if ($mod_key == 'projects') {
                                                                        $mod_name = $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects';
                                                                    } elseif ($mod_key == 'tasks') {
                                                                        $mod_name = $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks';
                                                                    } elseif ($mod_key == 'kanban') {
                                                                        $mod_name = $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban';
                                                                    } elseif ($mod_key == 'scrum') {
                                                                        $mod_name = $this->lang->line('scrum') ? $this->lang->line('scrum') : 'Scrum';
                                                                    } elseif ($mod_key == 'team_members') {
                                                                        $mod_name = $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Team Members';
                                                                    } elseif ($mod_key == 'clients') {
                                                                        $mod_name = $this->lang->line('clients') ? $this->lang->line('clients') : 'Clients';
                                                                    } elseif ($mod_key == 'user_roles') {
                                                                        $mod_name = $this->lang->line('user_roles') ? $this->lang->line('user_roles') : 'Employee Roles';
                                                                    } elseif ($mod_key == 'departments') {
                                                                        $mod_name = $this->lang->line('departments') ? $this->lang->line('departments') : 'Departments';
                                                                    } elseif ($mod_key == 'expenses') {
                                                                        $mod_name = $this->lang->line('expenses') ? $this->lang->line('expenses') : 'Expenses';
                                                                    } elseif ($mod_key == 'calendar') {
                                                                        $mod_name = $this->lang->line('calendar') ? $this->lang->line('calendar') : 'Calendar';
                                                                    } elseif ($mod_key == 'leaves') {
                                                                        $mod_name = $this->lang->line('leaves') ? $this->lang->line('leaves') : 'Leaves';
                                                                    } elseif ($mod_key == 'leave_hierarchy') {
                                                                        $mod_name = $this->lang->line('leave_hierarchy') ? $this->lang->line('leave_hierarchy') : 'Leave Hierarchy';
                                                                    } elseif ($mod_key == 'leaves_types') {
                                                                        $mod_name = $this->lang->line('leaves_types') ? $this->lang->line('leaves_types') : 'Leaves Types';
                                                                    } elseif ($mod_key == 'biometric_missing') {
                                                                        $mod_name = $this->lang->line('biometric_missing') ? $this->lang->line('biometric_missing') : 'Biometric Missing';
                                                                    } elseif ($mod_key == 'todo') {
                                                                        $mod_name = $this->lang->line('todo') ? $this->lang->line('todo') : 'Todo';
                                                                    } elseif ($mod_key == 'notes') {
                                                                        $mod_name = $this->lang->line('notes') ? $this->lang->line('notes') : 'Notes';
                                                                    } elseif ($mod_key == 'chat') {
                                                                        $mod_name = $this->lang->line('chat') ? $this->lang->line('chat') : 'Chat';
                                                                    } elseif ($mod_key == 'biometric_machine') {
                                                                        $mod_name = $this->lang->line('biometric_machine') ? $this->lang->line('biometric_machine') : 'biometric Machines';
                                                                    } elseif ($mod_key == 'payment_gateway') {
                                                                        $mod_name = $this->lang->line('payment_gateway') ? $this->lang->line('payment_gateway') : 'Payment Gateway';
                                                                    } elseif ($mod_key == 'taxes') {
                                                                        $mod_name = $this->lang->line('taxes') ? $this->lang->line('taxes') : 'Taxes';
                                                                    } elseif ($mod_key == 'custom_currency') {
                                                                        $mod_name = $this->lang->line('custom_currency') ? $this->lang->line('custom_currency') : 'Custom Currency';
                                                                    } elseif ($mod_key == 'user_permissions') {
                                                                        $mod_name = $this->lang->line('user_permissions') ? $this->lang->line('user_permissions') : 'User Permissions';
                                                                    } elseif ($mod_key == 'notifications') {
                                                                        $mod_name = $this->lang->line('notifications') ? $this->lang->line('notifications') : 'Notifications';
                                                                    } elseif ($mod_key == 'languages') {
                                                                        $mod_name = $this->lang->line('languages') ? $this->lang->line('languages') : 'Languages';
                                                                    } elseif ($mod_key == 'meetings') {
                                                                        $mod_name = $this->lang->line('video_meetings') ? $this->lang->line('video_meetings') : 'Video Meetings';
                                                                    } elseif ($mod_key == 'estimates') {
                                                                        $mod_name = $this->lang->line('estimates') ? $this->lang->line('estimates') : 'Estimates';
                                                                    } elseif ($mod_key == 'reports') {
                                                                        $mod_name = $this->lang->line('reports') ? $this->lang->line('reports') : 'Reports';
                                                                    } elseif ($mod_key == 'attendance') {
                                                                        $mod_name = $this->lang->line('attendance') ? htmlspecialchars($this->lang->line('attendance')) : 'Attendance';
                                                                    } elseif ($mod_key == 'support') {
                                                                        $mod_name = $this->lang->line('support') ? htmlspecialchars($this->lang->line('support')) : 'Support';
                                                                    }
                                                                    if ($mod_name && $mod == 1) {
                                                                        echo '<li><i class="fa-light fa-circle-check"></i>' . $mod_name . '</li>';
                                                                    } elseif ($mod_name) {
                                                                        echo '<li class="has-denied"><i class="fa-light fa-circle-xmark"></i>' . $mod_name . '</li>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="tp-pricing-content-btn text-center">
                                                        <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>