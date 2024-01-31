<?php $this->load->view('includes/header'); ?>
<style>

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
    <?php $this->load->view('includes/sidebar'); ?>
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <div class="content-body default-height">
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url('auth/edit-user') ?>" method="post" id="form-part">
                                    <input type="hidden" name="update_id" id="update_id" value="<?= $data->id ?>">
                                    <div id="DZ_W_TimeLine" class="widget-timeline dlab-scroll p-5">
                                        <ul class="timeline">
                                            <li>
                                                <div class="timeline-badge dark">
                                                </div>
                                                <div class="title">
                                                    <h5 class="text-primary ms-5 mt-2">Information</h5>
                                                </div>
                                                <div class="row ms-5">
                                                    <div class="col-6 mb-3">
                                                        <label for="employee_id_create" class="form-label">Employee ID</label>
                                                        <input type="number" class="form-control" name="employee_id" value="<?= $data->employee_id ?>" id="employee_id_create" readonly>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" value="<?= $data->first_name ?>" id="exampleFormControlInput1">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput2" class="form-label">last Name</label>
                                                        <input type="text" class="form-control" name="last_name" value="<?= $data->last_name ?>" id="exampleFormControlInput2">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput301" class="form-label">Father Name</label>
                                                        <input type="text" class="form-control" name="father_name" value="<?= $data->father_name ?>" id="exampleFormControlInput301">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput3" class="form-label">Blood Group</label>
                                                        <input type="text" class="form-control" name="blood_group" value="<?= $data->blood_group ?>" id="exampleFormControlInput3">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput4" class="form-label">Date Of Birth</label>
                                                        <input type="date" class="form-control" name="date_of_birth" value="<?= $data->DOB ?>" id="exampleFormControlInput4">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput5" class="form-label">CNIC</label>
                                                        <input type="text" class="form-control" name="cnic" value="<?= $data->cnic ?>" id="exampleFormControlInput5">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput6" class="form-label">Martial Status</label>
                                                        <select class="form-select" name="martial_status" id="exampleFormControlInput6" aria-label="Default select example">
                                                            <option selected value="">Martial Status</option>
                                                            <option value="single" <?= ($data->martial_status === 'single') ? 'selected' : '' ?>>Single</option>
                                                            <option value="married" <?= $data->martial_status === 'married' ? 'selected' : '' ?>>Married</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput7" class="form-label">Gender</label>
                                                        <select class="form-select" name="gender" id="exampleFormControlInput7" aria-label="Default select example">
                                                            <option value="male" <?= $data->gender === 'male' ? 'selected' : '' ?>>Male</option>
                                                            <option value="female" <?= $data->gender === 'female' ? 'selected' : '' ?>>Female</option>
                                                            <option value="other" <?= $data->gender === 'other' ? 'selected' : '' ?>>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput8" class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control" name="phone" value="<?= $data->phone ?>" id="exampleFormControlInput8">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput9" class="form-label">Emergency Person</label>
                                                        <input type="text" class="form-control" name="emg_person" value="<?= $data->emg_person ?>" id="exampleFormControlInput9">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput10" class="form-label">Emergency Contact</label>
                                                        <input type="text" class="form-control" value="<?= $data->emg_number ?>" name="emg_number" id="exampleFormControlInput10">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput14" class="form-label">Joining Date</label>
                                                        <input type="Date" class="form-control" name="join_date" value="<?= $data->join_date ?>" id="exampleFormControlInput14">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput15" class="form-label">Probation</label>
                                                        <select name="probation_period" class="form-control select3">
                                                            <?php
                                                            $join_date = new DateTime($data->join_date);
                                                            $probation = new DateTime($data->probation);
                                                            $yearDifference = $probation->format('Y') - $join_date->format('Y');
                                                            $monthDifference = $probation->format('n') - $join_date->format('n');
                                                            $totalMonthsDifference = ($yearDifference * 12) + $monthDifference;

                                                            for ($i = 0; $i <= 3; $i++) {
                                                                $selected = ($i === $totalMonthsDifference) ? 'selected' : '';
                                                                echo '<option value="' . $i . '" ' . $selected . '>' . $i . ' Month' . ($i !== 1 ? 's' : '') . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput16" class="form-label">Designation</label>
                                                        <input type="text" name="desgnation" class="form-control" value="<?= $data->desgnation ?>" id="exampleFormControlInput16">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput15" class="form-label">Department</label>
                                                        <select name="department" class="form-control select3">
                                                            <?php foreach ($departments as $department) { ?>
                                                                <option value="<?= $department['id'] ?>" <?= ($data->department == $department['id']) ? 'selected' : '' ?>>
                                                                    <?= $department['department_name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="exampleFormControlInput11" class="form-label">Address</label>
                                                        <textarea type="text" class="form-control" name="address" id="exampleFormControlInput11"><?= $data->address ?></textarea>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge dark">
                                                </div>
                                                <div class="title">
                                                    <h5 class="text-primary ms-5 mt-2">Attendance Configuration</h5>
                                                </div>
                                                <div class="row ms-5">
                                                    <div class="ms-3 col-12 mb-2 form-check">
                                                        <input class="form-check-input" type="checkbox" name="finger_config" id="flexCheckDefault" <?= $data->finger_config == 1 ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Biometric
                                                        </label>
                                                        <a type="button" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Enable Punch will checked for those emplyee who will punch in/out and it will recorded." title="Help"><i class="fas fa-circle-question"></i></a>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="shifts_select" class="form-label">Shift</label>
                                                        <select class="form-select enable-disable-select" name="type" aria-label="Default select example">
                                                            <?php foreach ($shift_types as $shift_type) { ?>
                                                                <option value="<?= $shift_type['id'] ?>" <?= ($data->shift_id == $shift_type['id']) ? 'selected' : '' ?>>
                                                                    <?= $shift_type['name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="devices_select" class="form-label">Device</label>
                                                        <select class="form-select enable-disable-select" name="device" aria-label="Default select example">
                                                            <?php foreach ($devices as $device) { ?>
                                                                <option value="<?= $device['id'] ?>" <?= ($data->device_id == $device['id']) ? 'selected' : '' ?>>
                                                                    <?= $device['device_name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge dark">
                                                </div>
                                                <div class="title">
                                                    <h5 class="text-primary ms-5 mt-2">Important Documents</h5>
                                                </div>
                                                <div class="row ms-5" id="inputs">
                                                    <div class="col-10 mb-3">
                                                        <input class="form-control" type="file" name="files[]" id="formFile">
                                                    </div>
                                                    <div class="col-2 mb-3">
                                                        <a class="btn text-primary fw-600 remove-btn">Remove</a>
                                                    </div>
                                                </div>
                                                <div class="row ms-5">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary add-btn">+ Add</button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge dark">
                                                </div>
                                                <div class="title">
                                                    <h5 class="text-primary ms-5 mt-2">Account Setting</h5>
                                                </div>
                                                <div class="row ms-5">
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput12" class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control" value="<?= $data->email ?>" id="exampleFormControlInput12">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput13" class="form-label">Password</label>
                                                        <input type="password" name="password" class="form-control" id="exampleFormControlInput13">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput14" class="form-label">Confirm Password</label>
                                                        <input type="password" name="password_confirm" class="form-control" id="exampleFormControlInput14">
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput15" class="form-label">Role</label>
                                                        <select name="groups" class="form-control">
                                                            <?php foreach ($user_groups as $user_group) {
                                                                if ($user_group->id == 3 || $user_group->id == 4) {
                                                                    continue;
                                                                }
                                                            ?>
                                                                <option value="<?= htmlspecialchars($user_group->id) ?>" <?= ($role == $user_group->id) ? 'selected' : '' ?>>
                                                                    <?= ucfirst(htmlspecialchars($user_group->description)) ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="row ms-3 mt-5 mb-3 justify-content-between">
                                            <div class="col-5">
                                                <button type="submit" class="btn btn-edit-user btn-primary">Submit</button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="button" id="user_delete_btn" class="btn btn-danger">Delete Account</button>
                                                <?php
                                                if ($data->active == '0') { ?>
                                                    <button type="button" id="user_active_btn" class="btn btn-primary">Activite Account</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button type="button" id="user_deactive_btn" class="btn btn-danger">Deativate Account</button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *******************************************
  Footer -->
        <?php $this->load->view('includes/footer'); ?>
        <!-- ************************************* *****
    Model forms
  ****************************************************-->

        <!--**********************************
	Content body end
***********************************-->
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script>
        $(document).ready(function() {
            $(".add-btn").click(function() {
                var newRow = $("#inputs").first().clone();
                newRow.find('input[type="file"]').val('');
                $("#inputs:last").after(newRow);
            });

            $(document).on("click", ".remove-btn", function() {
                $(this).closest("#inputs").remove();
            });
            $("#flexCheckDefault").change(function() {
                var isChecked = $(this).prop("checked");
                $(".enable-disable-select").prop("disabled", !isChecked);
            });
        });
        $(document).on('click', '#user_deactive_btn', function(e) {
            e.preventDefault();
            var id = $("#update_id").val();
            Swal.fire({
                title: are_you_sure,
                text: you_want_to_deactivate_this_user_this_user_will_be_not_able_to_login_after_deactivation,
                icon: 'warning',
                showCancelButton: true,
                dangerMode: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/deactivate',
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
        });

        $(document).on('click', '#user_active_btn', function(e) {
            e.preventDefault();
            var id = $("#update_id").val();
            Swal.fire({
                title: are_you_sure,
                text: you_want_to_activate_this_user,
                icon: 'warning',
                showCancelButton: true,
                dangerMode: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/activate',
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
        });
        $(document).on('click', '#user_delete_btn', function(e) {
            e.preventDefault();
            var id = $("#update_id").val();
            Swal.fire({
                title: are_you_sure,
                text: you_want_to_delete_this_user_all_related_data_with_this_user_also_will_be_deleted,
                icon: 'warning',
                showCancelButton: true,
                dangerMode: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'auth/delete_user',
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            if (result['error'] == false) {
                                location.href = base_url + 'users';
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
        });
        $(document).on('click', '.btn-edit-user', function(e) {
            var form = $('#form-part');
            var formData = form.serialize();
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    if (result['error'] == false) {
                        location.reload();
                    } else {
                        $(document).find('.card-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                }
            });

            e.preventDefault();
        });
    </script>
</body>

</html>