<?php $this->load->view('includes/head'); ?>
</head>

<body class="sidebar-mini">
    <div id="app">
        <section class="section">
            
            <div class="container mt-5">
            <div class="row mt-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="alert alert-warning" role="alert">
                        If you skip the step you will receive free trial!
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="login-brand">
                            <a href="<?= base_url() ?>">
                                <img src="<?= base_url('assets/uploads/logos/' . full_logo()); ?>" alt="logo" width="40%">
                            </a>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header d-flex justify-content-center">
                                <h4><?= $this->lang->line('create_company') ? htmlspecialchars($this->lang->line('create_company')) : 'Create Company' ?></h4>
                            </div>

                            <div class="row">
                                <?php foreach ($plans as $plan) : ?>
                                    <?php
                                    if ($plan['billing_type'] != 'three_days_trial_plan' && $plan['billing_type'] != 'seven_days_trial_plan' && $plan['billing_type'] != 'fifteen_days_trial_plan' && $plan['billing_type'] != 'thirty_days_trial_plan') {
                                    ?>
                                        <div class="col-md-6">
                                            <div class="pricing card <?= $my_plan['plan_id'] == $plan['id'] ? 'pricing-highlight' : '' ?>">
                                                <div class="pricing-title">
                                                    <?= htmlspecialchars($plan['title']) ?>

                                                    <?php if ($my_plan['plan_id'] == $plan['id'] && !is_null($my_plan['end_date'])) { ?>
                                                        <i class="fas fa-question-circle text-success" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_is_your_current_active_plan_and_expiring_on_date') ? $this->lang->line('this_is_your_current_active_plan_and_expiring_on_date') : 'This is your current active plan and expiring on date' ?> <?= htmlspecialchars(format_date($my_plan["end_date"], system_date_format())) ?>."></i>
                                                    <?php } elseif ($my_plan['plan_id'] == $plan['id']) { ?>
                                                        <i class="fas fa-question-circle text-success" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_is_your_current_active_plan') ? $this->lang->line('this_is_your_current_active_plan') : 'This is your current active plan, No Expiry Date.' ?>"></i>
                                                    <?php } ?>

                                                </div>
                                                <div class="pricing-padding">
                                                    <div class="pricing-price">
                                                        <div><?= htmlspecialchars(get_saas_currency('currency_symbol')) ?> <?= htmlspecialchars($plan['price']) ?></div>
                                                        <div>
                                                            <?php
                                                            if ($plan["billing_type"] == 'One Time') {
                                                                echo $this->lang->line('one_time') ? $this->lang->line('one_time') : 'One Time';
                                                            } elseif ($plan["billing_type"] == 'Monthly') {
                                                                echo $this->lang->line('monthly') ? $this->lang->line('monthly') : 'Monthly';
                                                            } elseif ($plan["billing_type"] == 'three_days_trial_plan') {
                                                                echo $this->lang->line('three_days_trial_plan') ? htmlspecialchars($this->lang->line('three_days_trial_plan')) : '3 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'seven_days_trial_plan') {
                                                                echo $this->lang->line('seven_days_trial_plan') ? htmlspecialchars($this->lang->line('seven_days_trial_plan')) : '7 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'fifteen_days_trial_plan') {
                                                                echo $this->lang->line('fifteen_days_trial_plan') ? htmlspecialchars($this->lang->line('fifteen_days_trial_plan')) : '15 days trial plan';
                                                            } elseif ($plan["billing_type"] == 'thirty_days_trial_plan') {
                                                                echo $this->lang->line('thirty_days_trial_plan') ? htmlspecialchars($this->lang->line('thirty_days_trial_plan')) : '30 days trial plan';
                                                            } else {
                                                                echo $this->lang->line('yearly') ? $this->lang->line('yearly') : 'Yearly';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="pricing-details">
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label mr-1 font-weight-bold"><?= $this->lang->line('storage') ? $this->lang->line('storage') : 'Storage' ?></div>
                                                            <div class="badge badge-primary">
                                                                <?= $my_plan['plan_id'] == $plan['id'] ? formatBytes(check_my_storage(), 'bytes') . ' / ' : '' ?>
                                                                <?= $plan['storage'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['storage'] . 'GB') ?></div>
                                                        </div>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label mr-1 font-weight-bold"><?= $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects' ?></div>
                                                            <div class="badge badge-primary">
                                                                <?= $my_plan['plan_id'] == $plan['id'] ? get_count('id', 'projects', 'saas_id=' . $saas_id) . ' / ' : '' ?>
                                                                <?= $plan['projects'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['projects']) ?></div>
                                                        </div>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label mr-1 font-weight-bold"><?= $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks' ?></div>
                                                            <div class="badge badge-primary">
                                                                <?= $my_plan['plan_id'] == $plan['id'] ? get_count('id', 'tasks', 'saas_id=' . $saas_id) . ' / ' : '' ?>
                                                                <?= $plan['tasks'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['tasks']) ?></div>
                                                        </div>
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-label mr-1 font-weight-bold"><?= $this->lang->line('users') ? $this->lang->line('users') : 'Users' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('including_admins_clients_and_users') ? $this->lang->line('including_admins_clients_and_users') : 'Including Admins, Clients and Users.' ?>"></i></div>
                                                            <div class="badge badge-primary">
                                                                <?= $my_plan['plan_id'] == $plan['id'] ? get_count('id', 'users', 'saas_id=' . $saas_id) . ' / ' : '' ?>
                                                                <?= $plan['users'] < 0 ? $this->lang->line('unlimited') ? $this->lang->line('unlimited') : 'Unlimited' : htmlspecialchars($plan['users']) ?></div>
                                                        </div>
                                                        <?php
                                                        $modules = '';
                                                        if ($plan["modules"] != '') {
                                                            echo '<hr>';
                                                            foreach (json_decode($plan["modules"]) as $mod_key => $mod) {
                                                                $mod_name = '';
                                                                if ($mod_key == 'projects') {
                                                                    $mod_name = $this->lang->line('projects') ? $this->lang->line('projects') : 'Projects';
                                                                } elseif ($mod_key == 'tasks') {
                                                                    $mod_name = $this->lang->line('tasks') ? $this->lang->line('tasks') : 'Tasks';
                                                                } elseif ($mod_key == 'kanban') {
                                                                    $mod_name = $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban';
                                                                } elseif ($mod_key == 'agile') {
                                                                    $mod_name = $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile';
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
                                                                    $modules .= '<div class="pricing-item mb-1">
                                      <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                      <div class="pricing-item-label">' . $mod_name . '</div>
                                    </div>';
                                                                } elseif ($mod_name) {
                                                                    $modules .= '<div class="pricing-item mb-1">
                                      <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                      <div class="pricing-item-label">' . $mod_name . '</div>
                                    </div>';
                                                                }
                                                            }
                                                        }
                                                        echo $modules;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="pricing-cta">
                                                    <a href="javascript:void(0);" class="payment-button" data-saas="<?= htmlspecialchars($saas_id) ?>" data-amount="<?= htmlspecialchars($plan['price']) ?>" data-id="<?= htmlspecialchars($plan['id']) ?>"><?= $my_plan['plan_id'] == $plan['id'] ? ($this->lang->line('renew_plan') ? $this->lang->line('renew_plan') : 'Renew Plan.') : ($this->lang->line('subscribe') ? $this->lang->line('subscribe') : 'Upgrade') ?> <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                <?php endforeach ?>
                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                    <a href="<?=base_url('auth')?>" class="savebtn btn btn-primary btn-lg" tabindex="6">
                                        <?= $this->lang->line('skip') ? $this->lang->line('skip') : 'Skip' ?>
                                    </a>
                                </div>
                            <div class="simple-footer">
                                <?= htmlspecialchars(footer_text()) ?>
                            </div>
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
        </section>
    </div>

    <?php $this->load->view('includes/js'); ?>
    <script>
        paypal_client_id = "<?= get_payment_paypal() ?>";
        get_stripe_publishable_key = "<?= get_stripe_publishable_key() ?>";
        razorpay_key_id = "<?= get_razorpay_key_id() ?>";
        offline_bank_transfer = "<?= get_offline_bank_transfer() ?>";
        paystack_user_email_id = "<?= $user->email ?>";
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

</body>

</html>