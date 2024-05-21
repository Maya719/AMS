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
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
    Sidebar start
***********************************-->
        <?php $this->load->view('includes/sidebar'); ?>
        <!--**********************************
    Sidebar end
***********************************--> <!--**********************************
    Content body start
***********************************-->
        <div class="content-body default-height">
            <!-- row -->
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-xl-12">
                        <?php if ($is_allowd_to_create_new) { ?>
                            <form action="<?= base_url('auth/create-user') ?>" method="post" id="form-part">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <div class="custom-tab-1">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1"><i class="la la-user me-2"></i> Information</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" id="colStep1" href="#profile1"><i class="la la-fingerprint me-2"></i> Attendance Configuration</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#contact1"><i class="la la-file-contract me-2"></i> Important Documents</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" id="colStep2" href="#message1"><i class="la la-home me-2"></i> Account Setting</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="home1" role="tabpanel">
                                                    <div class="pt-4">
                                                        <div class="row ms-5">
                                                            <div class="col-6 mb-3" id="stepInput15">
                                                                <label for="employee_id_create" class="col-form-label">Employee ID</label>
                                                                <input type="number" class="form-control" name="employee_id" id="employee_id_create" readonly>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput1" class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="first_name" id="exampleFormControlInput1">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput2" class="col-form-label">last Name <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="last_name" id="exampleFormControlInput2">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput301" class="col-form-label">Father Name</label>
                                                                <input type="text" class="form-control" name="father_name" id="exampleFormControlInput301">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput3" class="col-form-label">Blood Group</label>
                                                                <input type="text" class="form-control" name="blood_group" id="exampleFormControlInput3">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput4" class="col-form-label">Date Of Birth <span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" name="date_of_birth" id="exampleFormControlInput4">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput5" class="col-form-label">CNIC</label>
                                                                <input type="text" class="form-control" name="cnic" id="exampleFormControlInput5">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput6" class="col-form-label">Martial Status</label>
                                                                <select class="form-select select2" name="martial_status" id="exampleFormControlInput6" aria-label="Default select example">
                                                                    <option value="" selected>Martial Status</option>
                                                                    <option value="single">Single</option>
                                                                    <option value="married">Married</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput7" class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                                <select class="form-select select2" name="gender" id="exampleFormControlInput7" aria-label="Default select example">
                                                                    <option selected>Gender</option>
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput8" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="phone" id="exampleFormControlInput8">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput9" class="col-form-label">Emergency Person</label>
                                                                <input type="text" class="form-control" name="emg_person" id="exampleFormControlInput9">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput10" class="col-form-label">Emergency Contact</label>
                                                                <input type="text" class="form-control" name="emg_number" id="exampleFormControlInput10">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput14" class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                                <input type="Date" class="form-control" name="join_date" id="exampleFormControlInput14">
                                                            </div>
                                                            <div class="col-6 mb-3" id="stepInput16">
                                                                <label for="exampleFormControlInput15" class="col-form-label">Probation</label>
                                                                <select class="form-select select2" name="probation_period" id="exampleFormControlInput15" aria-label="Default select example">
                                                                    <option selected>Probation</option>
                                                                    <option value="1">1 Month</option>
                                                                    <option value="2">2 months</option>
                                                                    <option value="3">3 Months</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-6 mb-3" id="stepInput17">
                                                                <label for="exampleFormControlInput16" class="col-form-label">Designation</label>
                                                                <input type="text" class="form-control" name="desgnation" id="exampleFormControlInput16">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput15" class="col-form-label">Department</label>
                                                                <select class="form-select select2" name="department" id="exampleFormControlInput15" aria-label="Default select example">
                                                                    <option selected value="">Department</option>
                                                                    <?php foreach ($departments as $department) : ?>
                                                                        <option value="<?= $department["id"] ?>">
                                                                            <?= $department["department_name"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="exampleFormControlInput11" class="col-form-label">Address</label>
                                                                <textarea type="text" class="form-control" name="address" id="exampleFormControlInput11"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile1">
                                                    <div class="pt-4">
                                                        <div class="row ms-5">
                                                            <div class="ms-3 col-12 mb-2 form-check" id="stepInput18">
                                                                <input class="form-check-input" type="checkbox" name="finger_config" id="flexCheckDefault" checked>
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Biometric
                                                                </label>
                                                                <a type="button" class="text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Enable Punch will checked for those emplyee who will punch in/out and it will recorded." title="Help"><i class="fas fa-circle-question"></i></a>
                                                            </div>
                                                            <div class="col-6 mb-3" id="stepInput19">
                                                                <label for="exampleFormControlInput2" class="col-form-label">Shift <span class="text-danger">*</span></label>
                                                                <select class="form-select enable-disable-select select2" name="type" aria-label="Default select example">
                                                                    <option selected value="">Shift</option>
                                                                    <?php foreach ($shift_types as $shift_type) : ?>
                                                                        <option value="<?= $shift_type["id"] ?>">
                                                                            <?= $shift_type["name"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-6 mb-3" id="stepInput20">
                                                                <label for="exampleFormControlInput3" class="col-form-label">Device <span class="text-danger">*</span></label>
                                                                <select class="form-select enable-disable-select select2" name="device" aria-label="Default select example">
                                                                    <option selected value="">Device</option>
                                                                    <?php foreach ($devices as $device) : ?>
                                                                        <option value="<?= $device["id"] ?>">
                                                                            <?= $device["device_name"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="contact1">
                                                    <div class="pt-4">
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
                                                                <button type="button" class="btn btn-primary add-btn">+
                                                                    Add</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="message1">
                                                    <div class="pt-4">
                                                        <div class="row ms-3">
                                                            <div class="col-6 mb-3" id="stepInput21">
                                                                <label for="exampleFormControlInput12" class="col-form-label">Email <span class="text-danger">*</span></label>
                                                                <input type="email" name="email" class="form-control" id="exampleFormControlInput12">
                                                            </div>
                                                            <div class="col-6 mb-3" id="stepInput22">
                                                                <label for="exampleFormControlInput13" class="col-form-label">Password <span class="text-danger">*</span></label>
                                                                <input type="password" name="password" class="form-control" id="exampleFormControlInput13">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label for="exampleFormControlInput14" class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                                                <input type="password" name="password_confirm" class="form-control" id="exampleFormControlInput14">
                                                            </div>

                                                            <div class="col-6 mb-3" id="stepInput23">
                                                                <label for="exampleFormControlInput15" class="col-form-label">Role <span class="text-danger">*</span></label>
                                                                <select class="form-select select2" name="groups" id="exampleFormControlInput15" aria-label="Default select example">
                                                                    <option selected>Role</option>
                                                                    <?php foreach ($user_groups as $user_group) : ?>
                                                                        <?php if ($user_group->id !== '3' && $user_group->id !== '4') : ?>
                                                                            <option value="<?= $user_group->id ?>">
                                                                                <?= $user_group->description ?>
                                                                            </option>
                                                                        <?php endif ?>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row card-footer">
                                        <div class="col-5">
                                            <button type="button" id="stepAddBtn" class="btn btn-create btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="d-flex justify-content-center align-items-center">
                                <p>User limit has exceted in your plan</p>
                            </div>
                        <?php } ?>
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

        });
        $(document).ready(function() {
            function toggleElements() {
                var isChecked = $("#flexCheckDefault").prop("checked");
                $(".enable-disable-select").prop("disabled", !isChecked);
            }

            $("#flexCheckDefault").change(function() {
                toggleElements();
            });

            setTimeout(function() {
                toggleElements();
            }, 100);
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
                beforeSend: function() {
                    $('.btn-create').prop('disabled', true).html('Submiting...');
                },
                success: function(result) {
                    if (result['error'] == false) {
                        location.href = base_url + 'users';
                    } else {
                        $(document).find('.card-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                },
                complete: function() {
                    $('.btn-create').prop('disabled', false).html('Submit');
                },
            });

            e.preventDefault();
        });

        $('.select2').select2()

        $(document).ready(function() {
            introJs().setOption("disableInteraction", true);
            if (localStorage.getItem('tourStep') == 8) {
                console.log(localStorage.getItem('tourStep'));
                setTimeout(function() {
                    startThriteenTutorial();
                }, 1500);
            }

            function startThriteenTutorial() {
                introJs().setOptions({
                    steps: [{
                        element: '#stepInput15',
                        intro: "The employee id is auto generated unique key which will assign to user to synchronais the attendance From Biomatric Device",
                        position: 'right',
                    }, {
                        element: '#stepInput16',
                        intro: "The <strong>Probation</strong> period is necessary for leave settings. Select from 0, 1, 2, or 3 months.",
                        position: 'right',
                    }, {
                        element: '#stepInput17',
                        intro: "Enter the designation for the employee, such as <strong>Senior</strong>, <strong>Junior</strong>, <strong>Intern</strong>, etc",
                        position: 'right',
                    }, {
                        element: '#colStep1',
                        intro: "Shift the screen to <strong>Attendance Configuration</strong> to set the user shift and biomatric enable.",
                        position: 'right',
                    }],
                    showBullets: false,
                    tooltipClass: 'customTooltip'
                }).start().oncomplete(function() {
                    // localStorage.setItem('tourStep', '8');
                    // window.location.href = base_url + 'users/create_user';
                    document.getElementById('colStep1').click();
                    setTimeout(function() {
                        startFourteenTutorial();
                    }, 1500);
                }).onexit(function() {
                    document.getElementById('colStep1').click();
                    setTimeout(function() {
                        startFourteenTutorial();
                    }, 1500);
                    // localStorage.setItem('tourStep', '8');
                    // window.location.href = base_url + 'users/create_user';
                });
            }

            function startFourteenTutorial() {
                introJs().setOptions({
                    steps: [{
                        element: '#stepInput18',
                        intro: "The employee id is auto generated unique key which will assign to user to synchronais the attendance From Biomatric Device",
                        position: 'right',
                    }, {
                        element: '#stepInput19',
                        intro: "The <strong>Probation</strong> period is necessary for leave settings. Select from 0, 1, 2, or 3 months.",
                        position: 'right',
                    }, {
                        element: '#stepInput20',
                        intro: "The <strong>Probation</strong> period is necessary for leave settings. Select from 0, 1, 2, or 3 months.",
                        position: 'right',
                    }, {
                        element: '#colStep2',
                        intro: "Enter the designation for the employee, such as <strong>Senior</strong>, <strong>Junior</strong>, <strong>Intern</strong>, etc",
                        position: 'right',
                    }],
                    showBullets: false,
                    tooltipClass: 'customTooltip'
                }).start().oncomplete(function() {
                    document.getElementById('colStep2').click();
                    setTimeout(function() {
                        startFifteenTutorial();
                    }, 1500);
                }).onexit(function() {
                    document.getElementById('colStep2').click();
                    setTimeout(function() {
                        startFifteenTutorial();
                    }, 1500);
                });
            }

            function startFifteenTutorial() {
                introJs().setOptions({
                    steps: [{
                        element: '#stepInput21',
                        intro: "Enter the employee's email address. This will be used for system access after the employee is created.",
                        position: 'right',
                    }, {
                        element: '#stepInput22',
                        intro: "The <strong>Probation</strong> period is necessary for leave settings. Select from 0, 1, 2, or 3 months.",
                        position: 'right',
                    }, {
                        element: '#stepInput23',
                        intro: "The <strong>Probation</strong> period is necessary for leave settings. Select from 0, 1, 2, or 3 months.",
                        position: 'right',
                    }, {
                        element: '#stepAddBtn',
                        intro: "Enter the designation for the employee, such as <strong>Senior</strong>, <strong>Junior</strong>, <strong>Intern</strong>, etc",
                        position: 'right',
                    }],
                    showBullets: false,
                    tooltipClass: 'customTooltip'
                }).start().oncomplete(function() {
                    localStorage.setItem('tourStep', '0');
                    localStorage.removeItem('tourStep');
                    window.location.href = base_url + 'home';
                }).onexit(function() {
                   localStorage.setItem('tourStep', '0');
                    window.location.href = base_url + 'home';
                });
            }
        });
    </script>
</body>

</html>