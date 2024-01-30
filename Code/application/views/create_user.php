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
                                <form action="<?= base_url('auth/create-user') ?>" method="post" id="form-part">
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
                                                        <input type="number" class="form-control" name="employee_id" id="employee_id_create" readonly>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" id="exampleFormControlInput1">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput2" class="form-label">last Name</label>
                                                        <input type="text" class="form-control" name="last_name" id="exampleFormControlInput2">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput301" class="form-label">Father Name</label>
                                                        <input type="text" class="form-control" name="father_name" id="exampleFormControlInput301">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput3" class="form-label">Blood Group</label>
                                                        <input type="text" class="form-control" id="exampleFormControlInput3">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput4" class="form-label">Date Of Birth</label>
                                                        <input type="date" class="form-control" name="date_of_birth" id="exampleFormControlInput4">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput5" class="form-label">CNIC</label>
                                                        <input type="text" class="form-control" name="cnic" id="exampleFormControlInput5">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput6" class="form-label">Martial Status</label>
                                                        <select class="form-select" name="martial_status" id="exampleFormControlInput6" aria-label="Default select example">
                                                            <option selected>Martial Status</option>
                                                            <option value="1">Single</option>
                                                            <option value="2">Married</option>
                                                            <option value="3">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput7" class="form-label">Gender</label>
                                                        <select class="form-select" name="gender" id="exampleFormControlInput7" aria-label="Default select example">
                                                            <option selected>Gender</option>
                                                            <option value="1">Male</option>
                                                            <option value="2">Female</option>
                                                            <option value="3">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput8" class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control" name="phone" id="exampleFormControlInput8">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput9" class="form-label">Emergency Person</label>
                                                        <input type="text" class="form-control" name="emg_person" id="exampleFormControlInput9">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput10" class="form-label">Emergency Contact</label>
                                                        <input type="text" class="form-control" name="emg_number" id="exampleFormControlInput10">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput14" class="form-label">Joining Date</label>
                                                        <input type="Date" class="form-control" name="join_date" id="exampleFormControlInput14">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput15" class="form-label">Probation</label>
                                                        <select class="form-select" name="probation_period" id="exampleFormControlInput15" aria-label="Default select example">
                                                            <option selected>Probation</option>
                                                            <option value="1">1 Month</option>
                                                            <option value="2">2 months</option>
                                                            <option value="3">3 Months</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput16" class="form-label">Designation</label>
                                                        <input type="Date" class="form-control" name="desgnation" id="exampleFormControlInput16">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput15" class="form-label">Department</label>
                                                        <select class="form-select" name="department" id="exampleFormControlInput15" aria-label="Default select example">
                                                            <option selected>Department</option>
                                                            <?php foreach ($departments as $department) : ?>
                                                                <option value="<?=$department["id"]?>"><?=$department["department_name"]?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="exampleFormControlInput11" class="form-label">Address</label>
                                                        <textarea type="text" class="form-control" name="address" id="exampleFormControlInput11"></textarea>
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
                                                        <input class="form-check-input" type="checkbox" value="" name="finger_config" id="flexCheckDefault" checked>
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Biometric
                                                        </label>
                                                        <a type="button" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Enable Punch will checked for those emplyee who will punch in/out and it will recorded." title="Help"><i class="fas fa-circle-question"></i></a>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput2" class="form-label">Shift</label>
                                                        <select class="form-select enable-disable-select" aria-label="Default select example">
                                                            <option selected>Shift</option>
                                                            <?php foreach ($shift_types as $shift_type) : ?>
                                                                <option value="<?= $shift_type["id"] ?>"><?= $shift_type["name"] ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput3" class="form-label">Device</label>
                                                        <select class="form-select enable-disable-select" aria-label="Default select example">
                                                            <option selected>Device</option>
                                                            <?php foreach ($devices as $device) : ?>
                                                                <option value="<?= $device["id"] ?>"><?= $device["device_name"] ?></option>
                                                            <?php endforeach ?>
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
                                                <div class="row ms-3" id="inputs">
                                                    <div class="col-10 mb-3">
                                                        <input class="form-control" type="file" name="files[]" id="formFile">
                                                    </div>
                                                    <div class="col-2 mb-3">
                                                        <a class="btn text-primary fw-600 remove-btn">Remove</a>
                                                    </div>
                                                </div>
                                                <div class="row ms-3">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary add-btn">+ Add</button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge dark">
                                                </div>
                                                <div class="title">
                                                    <h5 class="text-primary ms-5 mt-2">Portal Setting</h5>
                                                </div>
                                                <div class="row ms-3">
                                                    <div class="col-6 mb-3">
                                                        <label for="exampleFormControlInput12" class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control" id="exampleFormControlInput12">
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
                                                        <select class="form-select" name="groups" id="exampleFormControlInput15" aria-label="Default select example">
                                                            <option selected>Role</option>
                                                            <?php foreach ($user_groups as $user_group) : ?>
                                                                <option value="<?= $user_group->id ?>"><?= $user_group->description ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="row ms-3 mt-5 mb-3 justify-content-between">
                                            <div class="col-5">
                                                <button type="button" class="btn btn-create btn-primary">Submit</button>
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
        $(document).ready(function() {
            function getEmployeeId() {

                $.ajax({
                    url: '<?= base_url('users/get_employee_id') ?>',
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        var employee_id = response.max_employee_id;
                        employee_id++;

                        $('#employee_id_create').val(employee_id);
                    },
                });
            }
            getEmployeeId();
        });
        $(document).on('click', '.btn-create', function(e) {
            var form = $('#form-part');
            var formData = form.serialize();
            console.log(formData);

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