<?php $this->load->view('includes/head'); ?>
</head>

<body class="sidebar-mini">
    <div id="app">
        <section class="section">

            <div class="container mt-5">
                <div class="row mt-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="alert alert-warning" role="alert">
                            If you skip the step you will receive free trial!.
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

                            <main>
                                <?php
                                $modules = array();
                                for ($i = 0; $i < 3; $i++) {
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
                                                            echo $plan[$attribute] == 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : ($plan[$attribute] == -1 ? 'Unlimited' : '$' . $plan[$attribute] . ' / user');
                                                        } elseif ($attribute === 'additional_storage') {
                                                            echo $plan[$attribute] == 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : ($plan[$attribute] == -1 ? 'Unlimited' : '$' . $plan[$attribute] . ' / GB');
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
                                                    <td><?= isset($module[$type]) && $module[$type] !== 0 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>'; ?></td>
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
                                                <td><?= $plan['biometric_machine'] == 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : ($plan['biometric_machine'] == -1 ? 'Unlimited' : $plan['biometric_machine']); ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <th>Leave Types</th>
                                            <?php for ($i = 0; $i < count($modules); $i++) : ?>
                                                <td>
                                                    <?= isset($modules[$i]['leaves_types']) && $modules[$i]['leaves_types'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr>
                                            <th>Leave Hierarchy</th>
                                            <?php for ($i = 0; $i < count($modules); $i++) : ?>
                                                <td>
                                                    <?= isset($modules[$i]['leave_hierarchy']) && $modules[$i]['leave_hierarchy'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
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
                                                <td><?= isset($module['biometric_missing']) && $module['biometric_missing'] !== 0 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>'; ?></td>
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
                                                    <?= isset($module['notice_board']) && $module['notice_board'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <th>Plan Holidays</th>
                                            <?php foreach ($modules as $module) : ?>
                                                <td>
                                                    <?= isset($module['holidays']) && $module['holidays'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <th>Attendance & Leave policy</th>
                                            <?php foreach ($modules as $module) : ?>
                                                <td>
                                                    <?= isset($module['attendance_leave_policy']) && $module['attendance_leave_policy'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
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
                                                    <?= isset($module['support']) && $module['support'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <th>To Do</th>
                                            <?php foreach ($modules as $module) : ?>
                                                <td>
                                                    <?= isset($module['todo']) && $module['todo'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <th>Chat</th>
                                            <?php foreach ($modules as $module) : ?>
                                                <td>
                                                    <?= isset($module['chat']) && $module['chat'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <th>Notes</th>
                                            <?php foreach ($modules as $module) : ?>
                                                <td>
                                                    <?= isset($module['notes']) && $module['notes'] === 0 ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM7.75736 7.05025C8.14788 6.65973 8.78105 6.65973 9.17157 7.05025L12 9.87868L14.8284 7.05025C15.219 6.65973 15.8521 6.65973 16.2426 7.05025L16.9497 7.75736C17.3403 8.14788 17.3403 8.78105 16.9497 9.17157L14.1213 12L16.9497 14.8284C17.3403 15.219 17.3403 15.8521 16.9497 16.2426L16.2426 16.9497C15.8521 17.3403 15.219 17.3403 14.8284 16.9497L12 14.1213L9.17157 16.9497C8.78105 17.3403 8.14788 17.3403 7.75736 16.9497L7.05025 16.2426C6.65973 15.8521 6.65973 15.219 7.05025 14.8284L9.87868 12L7.05025 9.17157C6.65973 8.78105 6.65973 8.14788 7.05025 7.75736L7.75736 7.05025Z" fill="#ff0505"/>
</svg>' : '<i class="fas fa-check-circle text-success fs-4"></i>'; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <td data-label="Actions">Actions</td>
                                            <?php
                                            foreach ($plans as $key => $plan) {
                                            ?>
                                                <td data-label=<?= $plan['title'] ?> class="pricing-cta">
                                                    <a href="javascript:void(0);" class="btn btn-warning btn-block btn-lg payment-button text-dark" class="payment-button" data-saas="<?= htmlspecialchars($saas_id) ?>" data-amount="<?= htmlspecialchars($plan['price']) ?>" data-id="<?= htmlspecialchars($plan['id']) ?>"><?= $my_plan['plan_id'] == $plan['id'] ? ($this->lang->line('renew_plan') ? $this->lang->line('renew_plan') : 'Renew Plan.') : ($this->lang->line('subscribe') ? $this->lang->line('subscribe') : 'Upgrade') ?> <span><img width="28" height="28" src=<?= base_url('assets2/images/landing_page_images/arrow.gif') ?> alt="->"></span></a>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </main>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <a href="<?= base_url('auth') ?>" class="savebtn btn btn-primary btn-lg" tabindex="6">
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
                    <?php if (get_myfatoorah_publishable_key()) { ?>
                        <button id="fatoorah-button" class="col-md-8 btn mx-auto paymet-box">
                            <img src="<?= base_url('assets/img/fatoorah.png') ?>" width="14%" alt="My Fatoorah">
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