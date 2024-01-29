<?php $this->load->view('includes/head'); ?>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" />
<link rel="stylesheet" type="text/css" href="dragtable.css" />
<style>

.wizard,
.tabcontrol
{
    display: block;
    width: 100%;
    overflow: hidden;
}

.wizard a,
.tabcontrol a
{
    outline: 0;
}

.wizard ul,
.tabcontrol ul
{
    list-style: none !important;
    padding: 0;
    margin: 0;
}

.wizard ul > li,
.tabcontrol ul > li
{
    display: block;
    padding: 0;
}
.content.clearfix {
	clear:none!important;
}
/* Accessibility */
.wizard > .steps .current-info,
.tabcontrol > .steps .current-info
{
    position: absolute;
    left: -999em;
}

.wizard > .content > .title,
.tabcontrol > .content > .title
{
    position: absolute;
    left: -999em;
}



/*
    Wizard
*/

.wizard > .steps
{
    position: relative;
    display: block;
    width: 100%;
}

.wizard.vertical > .steps
{
    display: inline;
    float: left;
    width: 20%;
}

.wizard > .steps .number
{
    font-size: 1.429em;
}

.wizard > .steps > ul > li
{
    width: 20%;
}

.wizard > .steps > ul > li,
.wizard > .actions > ul > li
{
    float: left;
}

.wizard.vertical > .steps > ul > li
{
    float: none;
    width: 100%;
}

.wizard > .steps a,
.wizard > .steps a:hover,
.wizard > .steps a:active
{
    display: block;
    width: auto;
    margin: 0 0.5em 0.5em;
    padding: 1em 1em;
    text-decoration: none;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}

.wizard > .steps .disabled a,
.wizard > .steps .disabled a:hover,
.wizard > .steps .disabled a:active
{
    background: #eee;
    color: #aaa;
    cursor: default;
}

.wizard > .steps .current a,
.wizard > .steps .current a:hover,
.wizard > .steps .current a:active
{
    background: <?=theme_color()?>;
    color: #fff;
    cursor: default;
}

.wizard > .steps .done a,
.wizard > .steps .done a:hover,
.wizard > .steps .done a:active
{
    background: #9dc8e2;
    color: #fff;
}

.wizard > .steps .error a,
.wizard > .steps .error a:hover,
.wizard > .steps .error a:active
{
    background: <?=theme_color()?>;
    color: #fff;
}

.wizard > .content
{
    background: #fff;
    display: block;
    margin: 0.5em;
    min-height: 53em;
    overflow: hidden;
    position: relative;
    width: auto;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}

.wizard.vertical > .content
{
    display: inline;
    float: left;
    margin: 0 2.5% 0.5em 2.5%;
    width: 65%;
}

.wizard > .content > .body
{
    float: left;
    position: absolute;
    width: 95%;
    height: 95%;
    padding: 2.5%;
}

.wizard > .content > .body ul
{
    list-style: disc !important;
}

.wizard > .content > .body ul > li
{
    display: list-item;
}

.wizard > .content > .body > iframe
{
    border: 0 none;
    width: 100%;
    height: 100%;
}

.wizard > .content > .body input
{
    display: block;
    border: 1px solid #ccc;
}

.wizard > .content > .body input[type="checkbox"]
{
    display: inline-block;
}

.wizard > .content > .body input.error
{
    background: rgb(251, 227, 228);
    border: 1px solid #fbc2c4;
    color: #8a1f11;
}

.wizard > .content > .body label
{
    display: inline-block;
    margin-bottom: 0.5em;
}

.wizard > .content > .body label.error
{
    color: #8a1f11;
    display: inline-block;
    margin-left: 1.5em;
}

.wizard > .actions
{
    position: relative;
    display: block;
    text-align: right;
    width: 100%;
}

.wizard.vertical > .actions
{
    display: inline;
    float: right;
    margin: 0 2.5%;
    width: 95%;
}

.wizard > .actions > ul
{
    display: inline-block;
    text-align: right;
}

.wizard > .actions > ul > li
{
    margin: 0 0.5em;
}

.wizard.vertical > .actions > ul > li
{
    margin: 0 0 0 1em;
}

.wizard > .actions a,
.wizard > .actions a:hover,
.wizard > .actions a:active
{
    background: <?=theme_color()?>;
    color: #fff;
    display: block;
    padding: 0.5em 1em;
    text-decoration: none;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}

.wizard > .actions .disabled a,
.wizard > .actions .disabled a:hover,
.wizard > .actions .disabled a:active
{
    background: #eee;
    color: #aaa;
}

.wizard > .loading
{
}

.wizard > .loading .spinner
{
}



/*
    Tabcontrol
*/

.tabcontrol > .steps
{
    position: relative;
    display: block;
    width: 100%;
}

.tabcontrol > .steps > ul
{
    position: relative;
    margin: 6px 0 0 0;
    top: 1px;
    z-index: 1;
}

.tabcontrol > .steps > ul > li
{
    float: left;
    margin: 5px 2px 0 0;
    padding: 1px;

    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.tabcontrol > .steps > ul > li:hover
{
    background: #edecec;
    border: 1px solid #bbb;
    padding: 0;
}

.tabcontrol > .steps > ul > li.current
{
    background: #fff;
    border: 1px solid #bbb;
    border-bottom: 0 none;
    padding: 0 0 1px 0;
    margin-top: 0;
}

.tabcontrol > .steps > ul > li > a
{
    color: #5f5f5f;
    display: inline-block;
    border: 0 none;
    margin: 0;
    padding: 10px 30px;
    text-decoration: none;
}

.tabcontrol > .steps > ul > li > a:hover
{
    text-decoration: none;
}

.tabcontrol > .steps > ul > li.current > a
{
    padding: 15px 30px 10px 30px;
}

.tabcontrol > .content
{
    position: relative;
    display: inline-block;
    width: 100%;
    height: 35em;
    overflow: hidden;
    border-top: 1px solid #bbb;
    padding-top: 20px;
}

.tabcontrol > .content > .body
{
    float: left;
    position: absolute;
    width: 95%;
    height: 95%;
    padding: 2.5%;
}

.tabcontrol > .content > .body ul
{
    list-style: disc !important;
}

.tabcontrol > .content > .body ul > li
{
    display: list-item;
}
</style>
</head>
<body class="sidebar-mini">
  <div id="app">
    <div class="main-wrapper">
      <?php $this->load->view('includes/navbar'); ?>
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>
              <?= $this->lang->line('team_members') ? $this->lang->line('team_members') : 'Create User' ?>
            </h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a
                  href="<?= base_url() ?>"><?= $this->lang->line('dashboard') ? $this->lang->line('dashboard') : 'Dashboard' ?></a>
              </div>
              <div class="breadcrumb-item active"><a
                  href="<?= base_url('users') ?>"><?= $this->lang->line('employees') ? $this->lang->line('employees') : 'Employees' ?></a>
              </div>
              <div class="breadcrumb-item">
                <?= $this->lang->line('create_user') ? $this->lang->line('create_user') : 'Create User' ?></div>
            </div>
          </div>
          <?php
          ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="card  card-primary">
                <div class="card-body">
                <form id="example-advanced-form" action="<?= base_url('auth/create-user') ?>" method="POST" enctype="multipart/form-data">
                    <h3><span class="number"><i class="icon-user-following txt-black"></i></span><span class="head-font capitalize-font">Information</span></h3>
                    <div id="message"></div>
                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('employee_id') ? $this->lang->line('employee_id') : 'Employee Id' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="employee_id" id="employee_id_create" class="form-control" required="" readonly>
                            </div>
                            <div class="form-group col-md-6">
                            <label><?= $this->lang->line('first_name') ? $this->lang->line('first_name') : 'First Name' ?><span
                                class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('last_name') ? $this->lang->line('last_name') : 'Last Name' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('father_name') ? $this->lang->line('father_name') : 'Father Name' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="father_name" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('gender') ? $this->lang->line('gender') : 'Gender' ?><span class="text-danger">*</span></label>
                                <select name="gender" class="form-control select3">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('martial_status') ? $this->lang->line('martial_status') : 'Martial status' ?><span class="text-danger">*</span></label>
                                <select name="martial_status" class="form-control select3">
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('mobile') ? $this->lang->line('mobile') : 'Mobile' ?></label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('cnic') ? $this->lang->line('cnic') : 'CNIC' ?></label>
                                <input type="text" name="cnic" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('date_of_birth') ? $this->lang->line('date_of_birth') : 'Date of Birth' ?></label>
                                <input type="text" id="date_of_birth" name="date_of_birth" class="form-control datepicker">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('emg_person') ? $this->lang->line('emg_person') : 'Emergency Person' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="emg_person" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('emg_number') ? $this->lang->line('emg_number') : 'Emergency Contact Number' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="emg_number" class="form-control">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('desgnation') ? $this->lang->line('desgnation') : 'Designation' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="desgnation" class="form-control">
                            </div>
                            
                            
                            <div class="form-group col-md-12">
                                <label><?= $this->lang->line('address') ? $this->lang->line('address') : 'Address' ?><span
                                    class="text-danger">*</span></label>
                                <textarea class="form-control" style="height:100px;" name="address" rows="10"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    
                    <h3><span class="number"><i class="icon-bag txt-black"></i></span><span class="head-font capitalize-font">Documents</span></h3>
                    <fieldset>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="file" name="files[]" class="custom-file-input" id="profile">
                            <label class="custom-file-label" for="profile"><?=$this->lang->line('File')?$this->lang->line('File'):'File'?></label>
                        </div>
                    </div>
                    <div id="add_file_button"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="addColumnButton" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add More Column</button>
                        </div>
                    </div>
                    </fieldset>
                    <h3><span class="number"><i class="icon-bag txt-black"></i></span><span class="head-font capitalize-font">Applied Policies</span></h3>
                    <fieldset>
                    <div class="alert alert-danger">The numbers in the total leaves represent the leave allowance for each leave type based on their respective durations.</div>
                        <div class="row" style="margin-bottom:-15px">
                            <div class="form-group col-md-3">
                                <label><?= $this->lang->line('leave_type') ? $this->lang->line('leave_type') : 'Leave Type' ?></label>                            
                            </div>
                            <div class="form-group col-md-3">
                                <label><?= $this->lang->line('total_leaves') ? $this->lang->line('total_leaves') : 'Total Leaves' ?></label>                            
                            </div>
                        </div>
                        <?php foreach ($leave_types as $leave_type) : ?>
                            <?php
                                $duration = $leave_type["duration"];

                                if ($duration == "3_months") {
                                    $available = "3 Months";
                                } elseif ($duration == "4_months") {
                                    $available = "4 Months";
                                } elseif ($duration == "6_months") {
                                    $available = "6 Months";
                                } elseif ($duration == "year") {
                                    $available = "Annually";
                                } else {
                                    $available = $duration; // Display the original value if none of the above conditions match
                                }
                                ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="designation" class="form-control" value="<?= $leave_type["name"] ?> ( <?=$available?> )" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" min="0" name="leavecount[<?= $leave_type["id"] ?>]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                    <h3><span class="number"><i class="icon-credit-card txt-black"></i></span><span class="head-font capitalize-font">Attendance Config</span></h3>
                        <fieldset>
                            <div class="form-group col-md-12">
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" id="checkbox" name="finger_config" checked onchange="toggleSelects()">
                                    <label for="checkbox_1" >Attendance?</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('device') ? $this->lang->line('device') : 'Device' ?></label>
                                <select id="devices_select" name="device" class="form-control select3">
                                <?php foreach ($devices as $device) { ?>
                                    <option value="<?= $device['id'] ?>">
                                    <?= $device['device_name'] ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('type') ? $this->lang->line('type') : 'Shift Type' ?></label>
                                <select id = "shifts_select" name="type" class="form-control select3">
                                <?php foreach ($shift_types as $shift_type) { ?>
                                    <option value="<?= $shift_type['id'] ?>">
                                    <?= $shift_type['name'] ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                    </fieldset>
                    
                    <h3><span class="number"><i class="icon-basket-loaded txt-black"></i></span><span class="head-font capitalize-font">Account Settings</span></h3>
                    <fieldset>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('join_date') ? $this->lang->line('join_date') : 'Join Date' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" id="join_date" name="join_date" class="form-control datepicker">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('probation_period') ? $this->lang->line('probation_period') : 'Probation Period' ?><span
                                    class="text-danger">*</span></label>
                                <select name="probation_period" class="form-control select3">
                                        <option value="1">1 Month</option>
                                        <option value="2">2 Months</option>
                                        <option value="3">3 Months</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('department') ? $this->lang->line('type') : 'Department' ?></label>
                                <select name="department" class="form-control select3">
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?= $department['id'] ?>">
                                    <?= $department['department_name'] ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('role') ? $this->lang->line('role') : 'Role' ?><span class="text-danger">*</span></label>
                                <select name="groups" class="form-control select3">
                                <?php foreach ($user_groups as $user_group) {
                                    if ($user_group->id == 3 || $user_group->id == 4) {
                                    continue;
                                    }
                                    ?>
                                    <option value="<?= htmlspecialchars($user_group->id) ?>">
                                    <?= ucfirst(htmlspecialchars($user_group->description)) ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('email') ? $this->lang->line('email') : 'Email' ?><span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('password') ? $this->lang->line('password') : 'Password' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= $this->lang->line('confirm_password') ? $this->lang->line('confirm_password') : 'Confirm Password' ?><span
                                    class="text-danger">*</span></label>
                                <input type="text" name="password_confirm" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                </form>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    </section>
  </div>

  <?php $this->load->view('includes/footer'); ?>
  </div>
  </div>
  
  <?php $this->load->view('includes/js'); ?>
  <script src="<?=base_url('assets/modules/jquery.steps/build/jquery.steps.min.js')?>"></script>
  <script>
$(document).ready(function() {
    var form_2 = $("#example-advanced-form");
		form_2.steps({
			headerTag: "h3",
			bodyTag: "fieldset",
			transitionEffect: "fade",
			titleTemplate: '#title#',
			labels: {
				finish: "Create",
				next: "Next",
				previous: "Previous",
			},
			onStepChanging: function (event, currentIndex, newIndex)
			{
				if (currentIndex > newIndex)
				{
					return true;
				}
				if (newIndex === 3 && Number($("#age-2").val()) < 18)
				{
					return false;
				}
				if (currentIndex < newIndex)
				{
					form_2.find(".body:eq(" + newIndex + ") label.error").remove();
					form_2.find(".body:eq(" + newIndex + ") .error").removeClass("error");
				}
				return true; 
			},
			onFinishing: function (event, currentIndex)
			{
                form_2.find(".actions a[href='#finish']").html('<i class="fa fa-spinner fa-spin"></i> Creating...');
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: $(this).attr('action'),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(result){
                        if(result['error'] == false){
                            window.location.href = '<?=base_url('users')?>';
                        }else{
                            form_2.find(".actions a[href='#finish']").html('Create');
                            $("#message").append('<div class="alert alert-danger">'+result['message']+'</div>');
                            $("#message").find('.alert').delay(4000).fadeOut();    
                        }
                        return false;
                    }
                });
			},
			onFinished: function (event, currentIndex)
			{
                location.reload();
			},
            onInit: function (event, currentIndex) {
            form_2.find('.actions a[href="#finish"]').addClass("btn btn-primary");
            form_2.find('.actions a[href="#next"]').addClass("btn btn-primary");
            form_2.find('.actions a[href="#previous"]').addClass("btn btn-light");
            if ($('.select3').length > 0 && !$('.select3').data('select3')) {
                $('.select3').select2();
            }
        },
		});
});
</script>
<script>
    $(document).ready(function() {
        var maxInputs = 4; 
        var currentInputs = 0; 
        $('#addColumnButton').click(function() {
            if (currentInputs < maxInputs) {
                var html = '';
                html += '<div class="row">';
                html += '<div class="form-group col-md-6">';
                html += '<input type="file" name="files[]" class="custom-file-input" id="profile">';
                html += '<label class="custom-file-label" for="profile"><?=$this->lang->line('File')?$this->lang->line('File'):'File'?></label>';
                html += '</div>';
                html += '</div>';
                $('#add_file_button').append(html);
                currentInputs++; 
            } else {
                $("#message").append('<div class="alert alert-danger">Only Five Documents Can Be Upload.</div>');
                $("#message").find('.alert').delay(4000).fadeOut();             }
        });
    });
</script>
<script>

    $(document).ready(function () {
      function getEmployeeId() {

        $.ajax({
          url: '<?= base_url('users/get_employee_id') ?>',
          method: 'POST', 
          dataType: 'json',
          success: function (response) {
            var employee_id = response.max_employee_id;
            employee_id++;

            $('#employee_id_create').val(employee_id);
          },
        });
      }
      getEmployeeId();
      const checkbox = document.getElementById("checkbox");
        const shiftsSelect = document.getElementById("shifts_select");
        const devicesSelect = document.getElementById("devices_select");

        checkbox.addEventListener("change", function () {
            if (checkbox.checked) {
                shiftsSelect.disabled = false;
                devicesSelect.disabled = false;
            } else {
                shiftsSelect.disabled = true;
                devicesSelect.disabled = true;
            }
        });
    });
  </script>
  <script>
    $(document).ready(function(){
  $('#join_date').daterangepicker({
    locale: {format: date_format_js},
    singleDatePicker: true,
    isInvalidDate: function(date) {
        return date.isAfter(moment()); 
    }
  });

  $('#resign_date').daterangepicker({
    locale: {format: date_format_js},
    singleDatePicker: true,
    isInvalidDate: function(date) {
        return date.isAfter(moment()); 
    }
  });
  $('#date_of_birth').daterangepicker({
    locale: {
        format: date_format_js,
    },
    singleDatePicker: true,
    showDropdowns: true, 
    isInvalidDate: function(date) {
        return date.isAfter(moment());
    },
    minYear: 1900, 
    maxYear: new Date().getFullYear(), 
});
});
  </script>

</body>

</html>