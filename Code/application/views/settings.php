<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" href="<?= base_url('assets/modules/multiselect/multselect.css') ?>">
<style>
  .toggle-heading {
    cursor: pointer;
  }

  .toggle-icon {
    position: absolute;
    right: 10px;
    top: 10px;
  }

  .toggle-icon::before {
    content: "\f078";
    /* Up arrow icon */
    font-family: 'Font Awesome 5 Free';
    display: inline-block;
    width: 20px;
    /* Adjust the width as needed */
    text-align: center;
  }

  .expanded .toggle-icon::before {
    content: "\f077";
    /* Down arrow icon when expanded */
  }

  .box {
    border: 2px dashed #ccc;
    padding: 13px;
    align-items: center;
    justify-content: center;
  }

  .box2 {
    border: 2px dashed #ccc;
    padding: 13px;
    align-items: center;
    justify-content: center;
  }

  .dd-handle {
    cursor: move;
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
  <div id="loader">
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
        <?php $this->load->view('setting-forms/' . htmlspecialchars($main_page2)); ?>
      </div>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets2/vendor/nestable2/js/jquery.nestable.min.js') ?>"></script>
  <script src="<?= base_url('assets2/js/plugins-init/nestable-init.js') ?>"></script>

  <script>
    /*
     * Leave Type Setting
     */
    $("#add-leave-type-modal").on('click', '.btn-create', function(e) {
      var modal = $('#add-leave-type-modal');
      var form = $('#modal-add-leaves-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $("#edit-leave-type-modal").on('click', '.btn-create', function(e) {
      var modal = $('#edit-leave-type-modal');
      var form = $('#modal-edit-leaves-type-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.edit-leave-type', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'settings/get_leaves_type_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false && result['data'] != '') {
            console.log(result);
            $("#update_id").val(result['data'].id);
            $("#name").val(result['data'].name);
            $("#duration").val(result['data'].duration).trigger('change');
            $("#count").val(result['data'].leave_counts);

          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    })

    $(document).on('click', '.delete-leave-type', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'settings/leaves_type_delete/' + id,
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
  </script>
  <script>
    /*
     * Department Setting
     */
    $("#add-department-modal").on('click', '.btn-create', function(e) {
      var modal = $('#add-department-modal');
      var form = $('#modal-add-department-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $("#edit-department-modal").on('click', '.btn-edit', function(e) {
      var modal = $('#edit-department-modal');
      var form = $('#modal-edit-department-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.edit-department', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'department/get_department_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false && result['data'] != '') {
            console.log(result);
            $("#update_id").val(result['data'][0].id);
            $("#department_name").val(result['data'][0].department_name);


          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    })

    $(document).on('click', '.delete-department', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'department/delete/' + id,
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
  </script>

  <script>
    /*
     * Shift Setting
     */
    $("#add-shift-modal").on('click', '.btn-create', function(e) {
      var modal = $('#add-shift-modal');
      var form = $('#modal-add-leaves-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $("#edit-shift-modal").on('click', '.btn-edit', function(e) {
      var modal = $('#edit-shift-modal');
      var form = $('#modal-edit-shift-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.edit-shift', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'shift/get_shift_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          console.log(result);
          if (result['error'] == false && result['data'] != '') {
            $("#update_id").val(result['data'].id);
            $("#type").val(result['data'].name);

            var starting_time = moment(result['data'].starting_time, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#starting_time').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#starting_time').timepicker('setTime', starting_time);

            var ending_time = moment(result['data'].ending_time, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#ending_time').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#ending_time').timepicker('setTime', ending_time);
            // 
            var break_start = moment(result['data'].break_start, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#break_start').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#break_start').timepicker('setTime', break_start);
            // 
            var break_end = moment(result['data'].break_end, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#break_end').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#break_end').timepicker('setTime', break_end);
            // 
            var half_day_check_in = moment(result['data'].half_day_check_in, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#half_day_check_in').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#half_day_check_in').timepicker('setTime', half_day_check_in);

            // 
            var half_day_check_out = moment(result['data'].half_day_check_out, 'HH:mm:ss').format('HH:mm');
            var time24 = false;
            $('#half_day_check_out').timepicker({
              format: 'HH:mm',
              showMeridian: true,
              time24Hour: time24
            });
            $('#half_day_check_out').timepicker('setTime', half_day_check_out);
          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    })

    $(document).on('click', '.delete-shift', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'shift/delete/' + id,
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
  </script>
  <script>
    /*
     *
     * Device Setting
     *
     */
    $("#add-device-modal").on('click', '.btn-create', function(e) {
      var modal = $('#add-device-modal');
      var form = $('#modal-add-device-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $("#edit-device-modal").on('click', '.btn-edit', function(e) {
      var modal = $('#edit-device-modal');
      var form = $('#modal-edit-device-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.edit-device', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'device_config/get_device_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false && result['data'] != '') {
            console.log(result['data'][0]);
            $("#update_id").val(result['data'][0].id);
            $("#device_name").val(result['data'][0].device_name);
            $("#device_ip").val(result['data'][0].device_ip);
            $("#port").val(result['data'][0].port);

          } else {
            iziToast.error({
              title: something_wrong_try_again,
              message: "",
              position: 'topRight'
            });
          }
        }
      });
    })

    $(document).on('click', '.delete-device', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'device_config/delete/' + id,
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
  </script>

  <script>
    $(document).ready(function() {
      let stepCounter = 0;

      function addStep() {
        stepCounter++;
        let newStep;
        newStep = `
            <div class="step-container">
            <div class="row arrow"><div class="col-md-6 text-center mb-3"><i class="fa fa-arrow-down" aria-hidden="true"></i></div></div>
            <div class="row">
              <div class="form-group col-md-6">
                <select name="step[]" id="step_${stepCounter}" class="form-control select6" multiple>
                    <option>Select Role</option>
                  <?php foreach ($groups as $value) { ?>
                    <option value="<?= htmlspecialchars($value->id) ?>"><?= htmlspecialchars($value->description) ?></option>
                  <?php } ?>
                </select>
              </div>
                <div class="form-group col-md-6">
                    <button class="btn text-danger remove-step" type="button"><i class="fas fa-times"></i></button>
                </div>
            </div>
            </div>
        `;
        $(".more-steps").append(newStep);
        $(".select6").select2();
      }

      $("#add-more-steps").on("click", function() {
        addStep();
      });

      $(".more-steps").on("click", ".remove-step", function() {
        $(this).closest('.step-container').remove();
      });
    });
    $(document).on('click', '.savebtn', function(e) {
      var form = $('#setting-form2');
      var formData = form.serialize();
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            $('.message').append('<div class="alert alert-success">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          } else {
            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.savebtn', function(e) {
      var form = $('#setting-form')[0]; // Get the form element
      if (!form || form.nodeName !== 'FORM') {
        console.error('Form element not found or not a form');
        return;
      }
      var formData = new FormData(form); // Pass the form element
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function(result) {
          console.log(result);
          if (result['error'] == false) {
            $('.message').append('<div class="alert alert-success">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          } else {
            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $(document).on('click', '.savebtn2', function(e) {
      var form = $('#setting-form');
      var formData = form.serialize();
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            $('.message').append('<div class="alert alert-success">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          } else {
            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });
  </script>
  <script>
    var time24 = false;
    $('.timepicker').timepicker({
      format: 'HH:mm',
      showMeridian: true,
      time24Hour: time24
    });
    $(".select7").select2();
  </script>
  <script>
    $(document).ready(function() {
      if ($("#enableGraceMinutes").is(":checked")) {
        $("#show_div").show();
        $("#enebleSandwich").prop("checked", false);
        $("#show_div2").hide();
      } else {
        $("#show_div").hide();
      }

      $("#enableGraceMinutes").change(function() {
        if ($(this).is(":checked")) {
          $("#show_div").show();
          $("#enebleSandwich").prop("checked", false);
          $("#show_div2").hide();
        } else {
          $("#show_div").hide();
        }
      });

      if ($("#enebleSandwich").is(":checked")) {
        $("#show_div2").show();
        $("#enableGraceMinutes").prop("checked", false);
        $("#show_div").hide();
      } else {
        $("#show_div2").hide();
      }

      $("#enebleSandwich").change(function() {
        if ($(this).is(":checked")) {
          $("#show_div2").show();
          $("#enableGraceMinutes").prop("checked", false);
          $("#show_div").hide();
        } else {
          $("#show_div2").hide();
        }
      });
    });
  </script>
  <script>
    $('#users').multiSelect();
    $("#selectAllUsers").change(function() {
      if ($(this).prop("checked")) {
        $('#users').multiSelect('select_all');
      } else {
        $('#users').multiSelect('deselect_all');
      }
    });
    $('#users_create').multiSelect();
    $("#selectAllUsers_create").change(function() {
      if ($(this).prop("checked")) {
        $('#users_create').multiSelect('select_all');
      } else {
        $('#users_create').multiSelect('deselect_all');
      }
    });
    $('#assigned_users').multiSelect();
    $("#selectAllUsers4").change(function() {
      if ($(this).prop("checked")) {
        $('#assigned_users').multiSelect('select_all');
      } else {
        $('#assigned_users').multiSelect('deselect_all');
      }
    });
    $('#permissions').multiSelect();
    $("#selectAllPermissions").change(function() {
      if ($(this).prop("checked")) {
        $('#permissions').multiSelect('select_all');
      } else {
        $('#permissions').multiSelect('deselect_all');
      }
    });
    $(".select2").select2();
  </script>
  <script>
    /*
     *
     *roles
     * 
     */
    $("#add-role-modal").on('click', '.btn-create', function(e) {
      var modal = $('#add-role-modal');
      var form = $('#modal-add-role-part');
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
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });

    $("#edit-role-modal").on('click', '.btn-edit', function(e) {
      var modal = $('#edit-role-modal');
      var form = $('#modal-edit-roles-part');
      var formData = form.serialize();
      console.log(formData);
      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            // console.log(result);
            location.reload();
          } else {
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        }
      });

      e.preventDefault();
    });
    $(document).on('click', '.edit-role', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: base_url + 'settings/get_roles_by_id',
        data: "id=" + id,
        dataType: "json",
        success: function(result) {
          if (result['error'] == false) {
            console.log(result["data"]);

            $("#update_id").val(result['data'].id);

            $("#description").val(result['data'].description);
            $("#description").trigger("change");

            $("#descriptive_name").val(result['data'].descriptive_name);
            $("#descriptive_name").trigger("change");
            if (result['data'] != '' && result['data'].change_permissions_of != null) {
              var inputString = result['data'].change_permissions_of.replace(/[\[\]"]+/g, '');
              newArray = inputString.split(',');
              console.log(newArray);

              $("#change_permissions_of").val(newArray);
              $("#change_permissions_of").trigger("change");
            }

            if (result['data'].permissions != null) {
              var inputString = result['data'].permissions.replace(/[\[\]"]+/g, '');
              permissions = inputString.split(',');

              if (permissions !== null) {
                $('#permissions').multiSelect('deselect_all');

                permissions.forEach(function(value) {
                  $('#permissions').multiSelect('select', value);
                });

                $('#permissions').multiSelect('refresh');
              }
            }

            if (result['data'].assigned_users != null) {
              var inputString = result['data'].assigned_users.replace(/[\[\]"]+/g, '');
              assigned_users = inputString.split(',');

              if (assigned_users !== null) {
                $('#assigned_users').multiSelect('deselect_all');

                assigned_users.forEach(function(value) {
                  $('#assigned_users').multiSelect('select', value);
                });

                $('#assigned_users').multiSelect('refresh');
              }
            }

            $("#modal-edit-roles").trigger("click");
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


    $(document).on('click', '.delete-role', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'settings/roles_delete/' + id,
            data: "id=" + id,
            dataType: "json",
            success: function(result) {
              if (result['error'] == false) {
                location.reload()
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

    $('#table').DataTable({
      "paging": true,
      "searching": false,
      "language": {
        "paginate": {
          "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "dom": '<"top"i>rt<"bottom"lp><"clear">',
      "lengthMenu": [10, 20, 50, 500],
      "pageLength": 10
    });
  </script>
  <script>
    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.dataset.id);
      ev.target.classList.add("dragging");
    }

    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      var draggedItem = document.querySelector('.dd-item[data-id="' + data + '"]');
      var targetBox = ev.target.closest(".box");

      if (targetBox) {
        var match = targetBox.id.match(/\d+/);
        var newStep = match ? parseInt(match[0]) : 0;
        draggedItem.setAttribute("data-step", newStep);
        targetBox.appendChild(draggedItem.cloneNode(true));
        draggedItem.parentNode.removeChild(draggedItem);
        return;
      }

      var hierarchyCard = document.getElementById("hierarchyCard");
      var newLevel = hierarchyCard.querySelectorAll(".box").length + 1;
      var newBox = document.createElement("div");
      newBox.className = "box";
      newBox.id = "level" + newLevel;
      newBox.innerHTML = "<h6 class='text-center'>level " + newLevel + "</h6>";
      newBox.appendChild(draggedItem.cloneNode(true));
      hierarchyCard.appendChild(newBox);

      draggedItem.setAttribute("data-step", newLevel);
      draggedItem.parentNode.removeChild(draggedItem);
    }
  </script>
  <script>
    $(document).ready(function() {
      $('#saveBtn').on('click', function() {
        var data = [];
        $('.dd-item').each(function() {
          var groupId = $(this).data('id');
          var stepNo = $(this).data('step');
          var selectedValue = $('input[name=level' + stepNo + ']:checked').val();
          console.log(stepNo);
          if (stepNo != 0 && !isNaN(stepNo)) {
            data.push({
              group_id: groupId,
              step_no: stepNo,
              recomender_approver: selectedValue
            });
          }
        });
        $.ajax({
          type: "POST",
          url: base_url + 'settings/save_hierarchy_setting',
          data: JSON.stringify(data),
          contentType: 'application/json',
          dataType: "json",
          success: function(result) {
            if (result['error'] == false) {
              console.log(result);
              $('.message').append('<div class="alert alert-success">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
            } else {
              $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
            }
          }
        });
        console.log(data);
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#departments, #shifts').change(function() {
        var departmentIds = $('#departments').val();
        var shiftIds = $('#shifts').val();

        $.ajax({
          url: base_url + 'settings/get_user_by_shift_and_department',
          type: 'POST',
          dataType: 'json',
          data: {
            departments: departmentIds,
            shifts: shiftIds
          },
          success: function(response) {
            $('#users_create').empty();
            $.each(response, function(index, user) {
              $('#users_create').append($('<option>', {
                value: user.id,
                text: user.first_name + ' ' + user.last_name
              }));
            });

            $('#users_create').multiSelect('refresh');
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#departmentsEdit, #shiftsEdit').change(function() {
        var departmentIds = $('#departmentsEdit').val();
        var shiftIds = $('#shiftsEdit').val();

        $.ajax({
          url: base_url + 'settings/get_user_by_shift_and_department',
          type: 'POST',
          dataType: 'json',
          data: {
            departments: departmentIds,
            shifts: shiftIds
          },
          success: function(response) {
            $('#assigned_users').empty();
            $.each(response, function(index, user) {
              $('#assigned_users').append($('<option>', {
                value: user.id,
                text: user.first_name + ' ' + user.last_name
              }));
            });

            $('#assigned_users').multiSelect('refresh');
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
    $(document).on('change', '.project_filter', function(e) {
      var value = $(this).val();
      window.location.replace(value);
    });
  </script>


  <script>
    $(document).ready(function() {
      // Function to handle checkbox behavior for view_all and view_selected
      function handleViewAllSelected(checkedCheckbox, uncheckedCheckbox) {
        if ($(checkedCheckbox).prop('checked')) {
          $(uncheckedCheckbox).prop('checked', false); // Uncheck the other checkbox
        }
      }

      // Function to handle view_all and view_selected checkboxes for a specific section
      function handleViewAllSelectedInSection(sectionName) {
        // Event listener for view_all checkbox
        $(`#${sectionName}_view_all`).change(function() {
          handleViewAllSelected(this, `#${sectionName}_view_selected`);
        });

        // Event listener for view_selected checkbox
        $(`#${sectionName}_view_selected`).change(function() {
          handleViewAllSelected(this, `#${sectionName}_view_all`);
        });
      }
      <?php foreach ($roles as $role) : ?>
      handleViewAllSelectedInSection('<?= $role['name'] ?>_user');
      handleViewAllSelectedInSection('<?= $role['name'] ?>_attendance');
      handleViewAllSelectedInSection('<?= $role['name'] ?>_leaves');
      handleViewAllSelectedInSection('<?= $role['name'] ?>_biometric_request');
      handleViewAllSelectedInSection('<?= $role['name'] ?>_task');
      handleViewAllSelectedInSection('<?= $role['name'] ?>_project');
      <?php endforeach; ?>
    });
  </script>

</body>

</html>