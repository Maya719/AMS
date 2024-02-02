<?php $this->load->view('includes/header'); ?>
<style>
  .static-column-left {
    position: sticky;
    left: 0;
    background-color: #f1f1f1;
    z-index: 1;
    width: 150px;
  }

  .static-column-right {
    position: sticky;
    right: 0;
    background-color: #f1f1f1;
    z-index: 1;
    width: 150px;
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
        <div class="row">
          <div class="col-lg-12 mb-3 d-flex">
            <a class="fs-6" href="javascript:history.go(-1)"><i class="fas fa-angle-left mx-3 mt-2"></i></a>
            <div class="title">
              <div style="color: #6B6D71; font-size: 20px; font-family: Poppins; font-weight: 500; line-height: 30px; letter-spacing: 0.10px; word-wrap: break-word"><?= $name ?></div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="basic-form">
                  <form class="row">
                    <div class="col-lg-12 mb-3">
                      <select class="form-select select2" id="dateFilter">
                        <option value="today"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Today' ?></option>
                        <option value="ystdy"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Yesterday' ?></option>
                        <option value="tweek"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'This Week' ?></option>
                        <option value="tmonth" selected><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'This Month' ?></option>
                        <option value="lmonth"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Last Month' ?></option>
                        <option value="custom"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Custom' ?></option>
                      </select>
                    </div>
                    <div id="custom-date-range" class="row" style="display: none;">
                      <div class="col-lg-3">
                        <input name="datepicker" class="datepicker-default form-control" placeholder="From Date" id="from">
                      </div>
                      <div class="col-lg-3">
                        <input name="datepicker" class="datepicker-default form-control" placeholder="To Date" id="too">
                      </div>
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
              <div class="card-header">
                <div class="col-lg-8">
                  <h5 id="date-range" style="margin-bottom: -10px;">Jan 2024 to Feb 2024</h5>
                </div>
                <div class="col-lg-4 text-end">
                  <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Export</button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">CSV</a>
                    <a class="dropdown-item" href="#">PDF</a>
                    <a class="dropdown-item" href="#">EXCEL</a>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm mb-0" id="user_attendance">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--**********************************
	Content body end
***********************************-->
    <!--**********************************
    Footer start
***********************************-->
    <?php $this->load->view('includes/footer'); ?>
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    $(document).ready(function() {
      checkCustomSelect();

      $("#date-filter").change(function() {
        checkCustomSelect();
      });

      function checkCustomSelect() {
        var selectedValue = $("#date-filter").val();
        if (selectedValue === "custom") {
          $("#custom-date-range").show();
        } else {
          $("#custom-date-range").hide();
        }
      }
    });
  </script>
  <script>
    $(document).ready(function() {
      setFilter();
      $(document).on('change', '#dateFilter, #from,#too', function() {
        setFilter();
      });
    });

    function setFilter() {
      var filterOption = $('#dateFilter').val();
      var currentUrl = window.location.href;
      var id;
      if (currentUrl.match(/\/attendance\/user_attendance\/\d+(?:#|$)/)) {
        id = currentUrl.match(/\/(\d+)(?:#|$)/)[1];
      } else if (currentUrl.match(/\/attendance\/user_attendance(?:#|$)/)) {
        id = <?= json_encode($user_id) ?>;
      }
      var employee_id = id;
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
        case "custom":
          $("#custom-date-range").show();
          var fromInput = $('#from').val();
          var toInput = $('#too').val();
          fromDate = new Date(convertDateFormat(fromInput));
          toDate = new Date(convertDateFormat(toInput));
          break;
        default:
          console.error("Invalid filter option:", filterOption);
          return null;
      }


      var formattedFromDate = formatDate(fromDate, "Y-m-d");
      var formattedToDate = formatDate(toDate, "Y-m-d");
      var rangetext = getRangeText(formattedFromDate, formattedToDate);
      $("#date-range").html(rangetext);
      ajaxCall(employee_id, formattedFromDate, formattedToDate);
    }

    function convertDateFormat(inputDate) {
      const months = {
        Jan: '01',
        Feb: '02',
        Mar: '03',
        Apr: '04',
        May: '05',
        Jun: '06',
        Jul: '07',
        Aug: '08',
        Sep: '09',
        Oct: '10',
        Nov: '11',
        Dec: '12'
      };

      const [day, month, year] = inputDate.split(' ');

      return `${year}-${months[month]}-${day}`;
    }

    function getRangeText(fromDate, toDate) {
      var from = new Date(fromDate);
      var to = new Date(toDate);
      if (from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear()) {
        return formatMonthYear(from);
      } else {
        return formatMonthYear(from) + ' to ' + formatMonthYear(to);
      }
    }

    function formatMonthYear(date) {
      var options = {
        year: 'numeric',
        month: 'long'
      };
      return date.toLocaleDateString('en-US', options);
    }

    function ajaxCall(employee_id, from, too) {
      $.ajax({
        url: '<?= base_url() ?>attendance/get_single_user_attendance',
        type: 'POST',
        data: {
          user_id: employee_id,
          from: from,
          too: too
        },
        success: function(response) {
          var tableData = JSON.parse(response);
          console.log(tableData);
          showTable(tableData);
        },
        complete: function() {},
        error: function(error) {
          console.error(error);
        }
      });
    }

    function showTable(data) {
      var table = $('#user_attendance');
      emptyDataTable(table);
      var thead = table.find('thead');
      var theadRow = '<tr>';
      theadRow += '<th class="border-bottom-0 static-column-left">Date</th>';

      var uniqueDates = getUniqueDates(data);


      uniqueDates.forEach(date => {
        const formattedDate = new Date(date);
        const formattedDateString = formattedDate.toLocaleString('en-US', {
          day: 'numeric'
        });
        theadRow += '<th style="font-size:10px;">' + formattedDateString + '</th>';
      });
      // theadRow += '<th style="background: #FAFAFA; color: #000000;" class="text-center border-bottom-0 fw-6 static-column-right">Absent/<br>Half Day/<br>Late Min</th>';

      theadRow += '</tr>';
      thead.html(theadRow);
      var tbody = table.find('tbody');
      data.forEach(user => {
        var userRow = '<tr><th style="background: #FAFAFA; width: 2rem;" class="static-column-left">Day</th>';
        uniqueDates.forEach(date => {
          const formattedDate = new Date(date);
          const formattedDateString = formattedDate.toLocaleString('en-US', {
            weekday: 'short'
          }); // Use 'short' to get abbreviated day names
          userRow += '<th style="font-size:10px;">' + formattedDateString + '</th>';
        });


        userRow += '</tr>';
        userRow += '<tr>';
        userRow += '<th class="static-column-left" style="background: #FAFAFA; width: 2rem;">Status</th>';
        // show status here
        uniqueDates.forEach(date => {
          var statusIndex = uniqueDates.indexOf(date);
          var status = user.status ? user.status[statusIndex] : '';
          if (status == 'P') {
            userRow += '<td class="text-success">' + status + '</td>';
          }
          if (status == 'A') {
            userRow += '<td class="text-danger">' + status + '</td>';
          }
          if (status == 'H') {
            userRow += '<td class="text-warning">' + status + '</td>';
          }
          if (status == 'L') {
            userRow += '<td class="text-info">' + status + '</td>';
          }
          if (status == 'HD L') {
            userRow += '<td class="text-info">' + status + '</td>';
          }
        });
        userRow += '</tr>';
        userRow += '<tr>';
        userRow += '<th class="border-bottom-0 static-column-left" style="background: #FAFAFA;">'+data[0].text+'</th>';

        uniqueDates.forEach(date => {
          if (user.dates[date]) {
            userRow += '<td style="font-size:10px;">' + user.dates[date].join('<br>') + '</td>';
          } else {
            userRow += '<td style="font-size:10px;">Absent</td>';
          }
        });
        // userRow += '<td style="border-left: 1px dashed #e6e6e6; background: #FAFAFA;" class="border-bottom-0 text-center static-column-right" rowspan="2">7/<br>12/<br> 0 Min</td>';
        userRow += '</tr>';

        tbody.append(userRow);
      });
    }

    function formatDate(date, format) {
      const options = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
      };
      const formattedDate = date.toLocaleDateString('en-US', options);
      return format
        .replace("Y", date.getFullYear())
        .replace("m", formattedDate.slice(0, 2))
        .replace("d", formattedDate.slice(3, 5));
    }

    function emptyDataTable(table) {
      table.find('thead').empty();
      table.find('tbody').empty();
    }

    function getUniqueDates(data) {
      var uniqueDates = [];
      data.forEach(user => {
        Object.keys(user.dates).forEach(date => {
          if (!uniqueDates.includes(date)) {
            uniqueDates.push(date);
          }
        });
      });
      uniqueDates.sort();
      return uniqueDates;
    }
  </script>
  <!--**********************************
        Main wrapper end
    ***********************************-->
</body>

</html>