<?php $this->load->view('includes/head'); ?>
<style>
  .toggle-heading {
    cursor: pointer;
  }

  .card-header {
  position: relative;
}

.toggle-icon {
  position: absolute;
  right: 10px; /* Added 'px' unit here */
  top: 10px; /* Added 'px' unit here */
}
  .toggle-icon::before {
    content: "\f078"; /* Up arrow icon */
    font-family: 'Font Awesome 5 Free';
    display: inline-block;
    width: 20px; /* Adjust the width as needed */
    text-align: center;
  }

  .expanded .toggle-icon::before {
    content: "\f077"; /* Down arrow icon when expanded */
  }

.hidden{
    display: none;
  }

</style>
<link rel="stylesheet" href="<?=base_url('assets/modules/multiselect/multselect.css')?>">

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
              <h1><?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?>
              <?php
              if($create){
                ?>
              <a href="#" id="modal-add-leaves" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> <?=$this->lang->line('create')?$this->lang->line('create'):'Create'?></a>
            <?php
              }
              ?>
            </h1>
              <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?=base_url()?>"><?=$this->lang->line('dashboard')?$this->lang->line('dashboard'):'Dashboard'?></a></div>
                <div class="breadcrumb-item"><?=$this->lang->line('settings')?$this->lang->line('settings'):'Settings'?></div>
              </div>
            </div>
            <div class="section-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-primary" id="settings-card">
                    <?php $this->load->view('setting-forms/'.htmlspecialchars($main_page)); ?>
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

<?php if($this->uri->segment(2) == 'custom-code'){ ?>
  <script>
    CodeMirror.fromTextArea(document.getElementById('header_code'), { 
      lineNumbers: true,
      theme: 'duotone-dark',
    }).on('change', editor => {
      $("#header_code").val(editor.getValue());
    });

    CodeMirror.fromTextArea(document.getElementById('footer_code'), { 
      lineNumbers: true,
      theme: 'duotone-dark',
    }).on('change', editor => {
      $("#footer_code").val(editor.getValue());
    });
  </script>
<?php } ?>


<script>
$(document).ready(function(){
  
  $('#name').on('change', function() {
    var nameInput = $('#name').val();
    if (nameInput == 'client' || nameInput == 'members') {
      $('#users_roles_div').hide();
    } else {
      $('#users_roles_div').show();
    }
  });

  $(".toggle-heading").click(function(){
    $(this).toggleClass("expanded");
    var target = $(this).data("toggle");
    $(".inner-content").not("[data-target=" + target + "]").hide();
    $("[data-target=" + target + "]").toggle();
  });
});

// $(document).ready(function() {
//     function getDepartmentTime() {
//         $.ajax({
//             url: '<?= base_url('settings/get_grace_minutes') ?>',
//             method: 'POST',
//             dataType: 'json',
//             success: function(response) {
//                 if (response) {
//                     var grace = JSON.parse(response);
//                     if (grace.days_counter) {
//                         $('#days_counter').val(grace.days_counter);
//                     }if (grace.grace_minutes) {
//                         $('#grace_minutes').val(grace.grace_minutes);
//                     }
//                     if (grace.apply == 1) {
//                         $('#enableGraceMinutes').prop('checked', true);
//                         $("#show_div").show();
//                     }else{
//                       $("#show_div").hide();
//                     }
//                     if (grace.sandwich == 1) {
//                         $('#enebleSandwich').prop('checked', true);
//                     }
//                 }
//             },
//             error: function() {
//             }
//         });
//     }

//     getDepartmentTime();
// });

function teamMembersFormatter(value, row) {
    const teamMembers = value.split('<br>');
    const maxVisibleTeamMembers = 10;
    if (teamMembers.length > maxVisibleTeamMembers) {
        const visibleMembers = teamMembers.slice(0, maxVisibleTeamMembers).join('<br>');
        const hiddenMembers = teamMembers.slice(maxVisibleTeamMembers).join('<br>');
        return `
            <div class="visible-members">${visibleMembers}</div>
            <div class="hidden-members" style="display: none">${hiddenMembers}</div>
            <a href="#" class="see-more-link text-danger">See More...</a>
        `;
    } else {
        return value;
    }
}

$(document).ready(function () {
    if ($("#enableGraceMinutes").is(":checked")) {
        $("#show_div").show();
        $("#enebleSandwich").prop("checked", false);
        $("#show_div2").hide();
    } else {
        $("#show_div").hide();
    }

    $("#enableGraceMinutes").change(function () {
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

    $("#enebleSandwich").change(function () {
        if ($(this).is(":checked")) {
            $("#show_div2").show();
            $("#enableGraceMinutes").prop("checked", false);
            $("#show_div").hide();
        } else {
            $("#show_div2").hide();
        }
    });
});

function permissionsFormatter(value, row) {
    const teamMembers = value.split('<br>');
    const maxVisibleTeamMembers = 10;

    if (teamMembers.length > maxVisibleTeamMembers) {
        const visibleMembers = teamMembers.slice(0, maxVisibleTeamMembers).join('<br>');
        const hiddenMembers = teamMembers.slice(maxVisibleTeamMembers).join('<br>');
        return `
            <div class="visible-members">${visibleMembers}</div>
            <div class="hidden-members" style="display: none">${hiddenMembers}</div>
            <a href="#" class="see-more-link text-danger">See More...</a>
        `;
    } else {
        return value;
    }
}

$(document).ready(function() {
  $('#permissions').multiSelect();
  $("#selectAllPermissions").change(function () {
            if ($(this).prop("checked")) {
                // Select all options in the multi-select
                $('#permissions').multiSelect('select_all');
            } else {
                // Deselect all options in the multi-select
                $('#permissions').multiSelect('deselect_all');
            }
        });

  $('#assigned_users').multiSelect();
  $("#selectAllUsers4").change(function () {
            if ($(this).prop("checked")) {
                // Select all options in the multi-select
                $('#assigned_users').multiSelect('select_all');
            } else {
                // Deselect all options in the multi-select
                $('#assigned_users').multiSelect('deselect_all');
            }
        });

  $('#users').multiSelect();
   // Handle the checkbox change event
   $("#selectAllUsers").change(function () {
            if ($(this).prop("checked")) {
                // Select all options in the multi-select
                $('#users').multiSelect('select_all');
            } else {
                // Deselect all options in the multi-select
                $('#users').multiSelect('deselect_all');
            }
        });
  $('#users_create').multiSelect();
  $("#selectAllUsers_create").change(function () {
            if ($(this).prop("checked")) {
                // Select all options in the multi-select
                $('#users_create').multiSelect('select_all');
            } else {
                // Deselect all options in the multi-select
                $('#users_create').multiSelect('deselect_all');
            }
        });
});

$(document).ready(function() {
    $(document).on('click', '.see-more-link', function(e) {
        e.preventDefault();
        console.log('See More link clicked');
        const $this = $(this);
        const $cell = $this.closest('td');
        $cell.find('.hidden-members').slideToggle();
        $this.text($this.text() === 'See More...' ? 'See Less' : 'See More...');
    });
});

    function setTableHeight() {
        var options = $('#shift_list').bootstrapTable('getOptions');
        options.height = 650;

        $('#shift_list').bootstrapTable('refreshOptions',options);
        var options = $('#leaves_list').bootstrapTable('getOptions');
        options.height = 600;

        $('#leaves_list').bootstrapTable('refreshOptions',options);
    }

    // Call the function initially and whenever the table data is refreshed
    $(document).ready(function() {
        setTableHeight();
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
                <select name="step[]" id="step_${stepCounter}" class="form-control select2" multiple>
                    <option>Select Role</option>
                  <?php foreach($groups as $value){ ?>
                    <option value="<?=htmlspecialchars($value->id)?>"><?=htmlspecialchars($value->description)?></option>
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
        $(".select2").select2();
    }

    $("#add-more-steps").on("click", function() {
        addStep();
    });

    $(".more-steps").on("click", ".remove-step", function() {
        $(this).closest('.step-container').remove();
    });
});
</script>
<script src="<?=base_url('assets/modules/multiselect/multiselect.js')?>"></script>


</body>
</html>
