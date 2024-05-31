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
                    <th scope="col"><?= $plan['title'] ?></th>
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
                    <th scope="row">
                        <?= $type === 'clients' ? 'Client Access' : ucwords($type) ?>
                    </th>
                    <?php foreach ($modules as $module) : ?>
                        <td>
                            <?= isset($module[$type]) && $module[$type] !== 0 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>'; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>



            <tr>
                <th colspan="<?= count($plans) + 1 ?>">
                    <h3>Attendance</h3>
                </th>
            </tr>

            <tr>
                <th>Biometric Machines</th>
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
                    <td data-label=<?= $plan['title'] ?>>
                        <a href="<?= base_url('auth/register') ?>?plan_id=<?= $plan['id'] ?>" class="tp-btn">Get Started Now <span><img width="28" height="28" src="<?= base_url('assets2/images/landing_page_images/arrow.gif') ?>" alt="->"></span></a>
                    </td>
                <?php
                }
                ?>

            </tr>




        </tbody>
    </table>







    <!-- ====================================== -->


    <!-- <tr>
                <th colspan="<?= count($plans) + 1 ?>">
                    <h3>Attendance</h3>
                </th>
            </tr>
            <?php $attendanceFeatures = ['biometric_machine', 'leaves_types', 'leave_hierarchy', 'leave_requests', 'biometric_missing_requests']; ?>
            <?php foreach ($attendanceFeatures as $feature) : ?>
                <tr>
                    <th scope="row"><?= ucwords(str_replace('_', ' ', $feature)) ?></th>
                    <?php foreach ($plans as $plan) : ?>
                        <td><?= $plan[$feature] == 0 ? 'No' : ($plan[$feature] == -1 ? 'Unlimited' : $plan[$feature]); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?> -->


</main>