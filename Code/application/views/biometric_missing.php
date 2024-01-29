<?php $this->load->view('includes/header');?>
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
  <?php $this->load->view('includes/sidebar');?>
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <div class="content-body default-height">
      <!-- row -->
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="#" id="modal-add-leaves"  class="btn btn-block btn-primary">+ ADD</a>
          </div>
          <div class="col-lg-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <div class="col-lg-4 mb-3">
                      <select class="form-select" id="employee_id">
                        <option value=""><?=$this->lang->line('employee') ? $this->lang->line('employee') : 'Employee'?></option>
                        <?php foreach ($system_users as $system_user) {
                          if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == '1' && $system_user->finger_config == '1') {?>
                        <option value="<?=$system_user->employee_id?>"><?=htmlspecialchars($system_user->first_name)?> <?=htmlspecialchars($system_user->last_name)?></option>
                        <?php }
                        }?>
                      </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                      <select class="form-select" id="status">
                        <option value="" selected>Status</option>
                        <option value="1">Approved</option>
                        <option value="3">Pending</option>
                        <option value="2">Rejected</option>
                      </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                      <select class="form-select" id="dateFilter">
                        <option value="tmonth" selected>This Month</option>
                        <option value="lmonth">Last Month</option>
                        <option value="tyear">This Year</option>
                        <option value="lyear">last Year</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="biom_list" class="table table-sm mb-0">
                    <thead>
                    </thead>
                    <tbody id="customers">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- *******************************************
  Footer -->
  <?php $this->load->view('includes/footer');?>
    <!-- ************************************* *****
    Model forms
  ****************************************************-->

    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts');?>
  <script>
    $(document).ready(function() {
      setFilter();
      $(document).on('change', '#status, #employee_id,#dateFilter, #from,#too', function() {
          setFilter();
      });
      function setFilter() {
  var employee_id = $('#employee_id').val();
  var filterOption = $('#dateFilter').val();
  var status = $('#status').val();

  const today = new Date();
  const year = today.getFullYear();
  const month = today.getMonth();
  const day = today.getDate();

  let fromDate, toDate;

  switch (filterOption) {
    case "today":
      fromDate = new Date(year, month, day);
      toDate = new Date(year, month, day);
      break;
    case "ystdy":
      fromDate = new Date(year, month, day - 1);
      toDate = new Date(year, month, day - 1);
      break;
    case "tweek":
      fromDate = new Date(year, month, day - today.getDay());
      toDate = new Date(year, month, day);
      break;
    case "lweek":
      fromDate = new Date(year, month, day - today.getDay() - 7);
      toDate = new Date(year, month, day - today.getDay() - 1);
      break;
    case "tmonth":
      fromDate = new Date(year, month, 1);
      toDate = today; 
      break;
    case "lmonth":
      fromDate = new Date(year, month - 1, 1);
      toDate = new Date(year, month, 0);
      break;
    case "tyear": 
      fromDate = new Date(year, 0, 1); 
      toDate = today; 
      break;
    case "lyear": 
      fromDate = new Date(year - 1, 0, 1); 
      toDate = new Date(year - 1, 11, 31); 
      break;
    default:
      console.error("Invalid filter option:", filterOption);
      return null; 
  }

  // Format dates as strings
  var formattedFromDate = formatDate(fromDate, "Y-m-d");
  var formattedToDate = formatDate(toDate, "Y-m-d");
  ajaxCall(employee_id, status, formattedFromDate, formattedToDate);
}
function ajaxCall(employee_id,status,from,too){
    $.ajax({
        url: '<?=base_url('biometric_missing/get_biometric')?>',
        type: 'GET',
        data: {
            user_id: employee_id,
            status: status,
            from: from,
            too: too
        },
        success: function(response) {
            var tableData = JSON.parse(response);
            // console.log(response);
            showTable(tableData);
        },
        complete: function () {
        },
        error: function(error) {
            console.error(error);
        }
    });
}
function showTable(data) {
    var table = $('#biom_list');
    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }
    emptyDataTable(table);
    var thead = table.find('thead');
    var theadRow = '<tr>';
    theadRow += '<th style="font-size: 15px;">ID</th>';
    theadRow += '<th style="font-size: 15px;">Employee Name</th>';
    theadRow += '<th style="font-size: 15px;">Reason</th>';
    theadRow += '<th style="font-size: 15px;">Date</th>';
    theadRow += '<th style="font-size: 15px;">Time</th>';
    theadRow += '<th style="font-size: 15px;">Status</th>';
    theadRow += '<th style="font-size: 15px;">Action</th>';
    theadRow += '</tr>';
    thead.html(theadRow);

    // Add table body
    var tbody = table.find('tbody');
    
    data.forEach(user => {
        var userRow = '<tr>';
        userRow += '<td>' + user.user_id + '</td>';
        userRow += '<td>' + user.user + '</td>';
        userRow += '<td>' + user.reason + '</td>';
        userRow += '<td>' + user.date+'</td>';
        userRow += '<td>' + user.time+'</td>';
        userRow += '<td>' + user.status + '</td>';
        userRow += '<td>';
        userRow += '<div class="d-flex">';
        userRow += '<span class="badge light badge-primary"><a href="javascript:void()" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>';
        userRow += '<span class="badge light badge-danger ms-2"><a href="javascript:void()" class="text-danger" data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a></span>';
        userRow += '</div>';
        userRow += '</td>';
        userRow += '</tr>';
        tbody.append(userRow);
    });
    table.DataTable({
        "paging": true,
        "searching":false,
        "language": {
			"paginate": {
			  "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
			}
		  },
        "info": false,         
        "dom": '<"top"i>rt<"bottom"lp><"clear">',
        "lengthMenu": [5, 10, 20], 
        "order": [[3, 'desc']],
        "pageLength": 5 
    });
}


function emptyDataTable(table) {
    table.find('thead').empty();
    table.find('tbody').empty();
}
function formatDate(date, format) {
  const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
  const formattedDate = date.toLocaleDateString('en-US', options);
  return format
    .replace("Y", date.getFullYear())
    .replace("m", formattedDate.slice(0, 2))
    .replace("d", formattedDate.slice(3, 5));
}
});
  </script>
  
  

</body>

</html>