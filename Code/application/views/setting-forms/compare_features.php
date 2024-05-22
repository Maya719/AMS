<main>

    <h3 class="tp-section__title text-center my-5">Compare Features</h3>
    <?php $features = json_decode($plans[0]["modules"], true); ?>
    <table class="table table-bordered resp-pricing-table table-striped">
        <thead>
            <tr>
                <th>Features</th>
                <?php foreach ($plans as $plan) : ?>
                    <th><?= htmlspecialchars($plan['title']) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php

            function convertToLowerCamelCase($text)
            {
                if (strpos($text, '_') === false) {
                    return ucfirst($text);
                } else {
                    $words = explode('_', $text);
                    $formatted_words = array_map('ucfirst', $words);
                    return implode(' ', $formatted_words);
                }
            }




            // dynamic featuresName (modules name) array

            $modules_name = $features;
            $featureNames = array_merge(
                array_slice($modules_name, 0, 5, true),
                ['project_management_system' => 'Project Management System'],
                array_slice($modules_name, 5, null, true)
            );
            $featureNames = array_merge(
                array_slice($featureNames, 0, 10, true),
                ['attendance_management_system' => 'Attendance Management System'],
                array_slice($featureNames, 10, null, true)
            );
            foreach ($featureNames as $keys => $val) {

                if ($keys != 'select_all') {
                    $formatted_key = convertToLowerCamelCase($keys);
                    $featureNames[$keys] = $formatted_key;
                }
            }

            // echo json_encode($featureNames);





            // $featureNames = [
            //     'projects' => 'Projects',
            //     'attendance' => 'Attendance',
            //     'tasks' => 'Tasks',
            //     'team_members' => 'Team Members',
            //     'user_roles' => 'Employee Roles',
            //     'departments' => 'Departments',
            //     'project_management_system' => 'Project Management System',
            //     'clients' => 'Clients',
            //     'leaves' => 'Leaves',
            //     'leaves_types' => 'Leave Types',
            //     'leave_hierarchy' => 'Leave Hierarchy',
            //     'biometric_missing' => 'Biometric Missing',
            //     'attendance_management_system' => 'Attendance Management System',
            //     'biometric_machine' => 'Biometric Machines',
            //     'holidays' => 'Holidays',
            //     'todo' => 'Todo',
            //     'notice_board' => 'Notice Board',
            //     'shifts' => 'Shifts',
            //     'notes' => 'Notes',
            //     'chat' => 'Chat',
            //     'user_permissions' => 'User Permissions',
            //     'notifications' => 'Notifications',
            //     'reports' => 'Reports',
            //     'support' => 'Support',
            // ];


            $ams_modules = ['attendance_management_system','attendance', 'leaves', 'leaves_types', 'leave_hierarchy', 'biometric_missing', 'shifts', 'biometric_machine', 'holidays'];
            $pms_modules = ['project_management_system','projects', 'tasks', 'team_members', 'departments'];
            $other_modules = ['user_roles', 'clients', 'todo', 'notice_board', 'notes', 'chat', 'user_permissions', 'notifications', 'reports', 'support'];



         
            $order = array_merge($other_modules, $pms_modules, $ams_modules);

            foreach ($order as $module) {
                if (isset($featureNames[$module])) {
                    if ($module == 'project_management_system' || $module == 'attendance_management_system') {
                        echo '<tr><td colspan="' . (count($plans) + 1) . '"><h3>' . htmlspecialchars($featureNames[$module]) . '</h3></td></tr>';
                    } else {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($featureNames[$module]) . '</td>';

                        foreach ($plans as $plan) {
                            $abs = json_decode($plan['modules'], true);
                            $featureValue = isset($abs[$module]) ? ($abs[$module] == 1 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>') : '';
                            echo '<td>' . $featureValue . '</td>';
                        }
                        echo '</tr>';
                    }
                 
                    unset($featureNames[$module]);
                }
            }

   
            foreach ($featureNames as $module => $displayName) {
                if ($module != 'select_all') {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($displayName) . '</td>';

                    foreach ($plans as $plan) {
                        $abs = json_decode($plan['modules'], true);
                        $featureValue = isset($abs[$module]) ? ($abs[$module] == 1 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>') : '';
                        echo '<td>' . $featureValue . '</td>';
                    }
                    echo '</tr>';
                }
            }






            // ===========================

            // foreach ($featureNames as $feature => $displayName) {
            //     if ($feature == 'project_management_system') {
            //         echo '<tr><td  colspan="' . (count($plans) + 1) . '"> <h3>' . htmlspecialchars($displayName) . '</h3></td></tr>';
            //     } elseif ($feature == 'attendance_management_system') {
            //         echo '<tr><td colspan="' . (count($plans) + 1) . '"> <h3>' . htmlspecialchars($displayName) . '</h3></td></tr>';
            //     } elseif($feature!='select_all') {
            //         echo '<tr>';
            //         echo '<td>' . htmlspecialchars($displayName) . '</td>';

            //         foreach ($plans as $plan) {
            //             $abs = json_decode($plan['modules'], true);
            //             $featureValue = isset($abs[$feature]) ? ($abs[$feature] == 1 ? '<i class="fas fa-check-circle text-success fs-4"></i>' : '<i class="fa-solid fa-circle-xmark text-danger fs-4"></i>') : '';
            //             echo '<td>' . $featureValue . '</td>';
            //         }
            //         echo '</tr>';
            //     }
            // }
            ?>

        </tbody>
    </table>
</main>