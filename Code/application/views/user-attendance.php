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

  .table th,
  .table td {
    padding: 5px;
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
            <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('attendance') ?>">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $name ?></li>
          </ol>
        </nav>
        <div class="row">
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
                    <a class="dropdown-item" id="csv" href="javascript:void(0);">CSV</a>
                    <a class="dropdown-item" id="pdf" href="javascript:void(0);">PDF</a>
                    <a class="dropdown-item" id="excel" href="javascript:void(0);">EXCEL</a>
                  </div>
                  <button type="button" id="print" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></button>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets2/js/loader.js') ?>"></script>
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
        beforeSend: function() {
          // showLoader();
        },
        success: function(response) {
          var tableData = JSON.parse(response);
          console.log(tableData);
          showTable(tableData);
        },
        complete: function() {
          // hideLoader();
        },
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
          } else if (status == 'A') {
            userRow += '<td class="text-danger">' + status + '</td>';
          } else if (status == 'H') {
            userRow += '<td class="text-warning">' + status + '</td>';
          } else if (status == 'L' || status == 'HD L' || status == 'HD' || status == 'SL') {
            userRow += '<td class="text-info">' + status + '</td>';
          } else {
            userRow += '<td class="text-muted">' + status + ' m</td>';
          }
        });
        userRow += '</tr>';
        userRow += '<tr>';
        userRow += '<th class="border-bottom-0 static-column-left" style="background: #FAFAFA;">' + data[0].text + '</th>';

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

  <script>
    $(document).on('click', '#csv', function() {
      var filters = setFilter2();
      ajaxCall2(filters.employee_id, filters.from, filters.too)
        .then(function(response) {
          downloadCSV(response[0].dates, "data.csv");
        })
        .catch(function(error) {
          console.error("Error fetching data:", error);
        });
    });
    $(document).on('click', '#excel', function() {
      var filters = setFilter2();
      ajaxCall2(filters.employee_id, filters.from, filters.too)
        .then(function(response) {
          console.log(response[0].dates);
          downloadExcel(response[0].dates, "<?= $name ?>.xlsx");
        })
        .catch(function(error) {
          console.error("Error fetching data:", error);
        });
    });
    $(document).on('click', '#pdf', function() {
      var filters = setFilter2();
      ajaxCall2(filters.employee_id, filters.from, filters.too)
        .then(function(response) {
          downloadPDF(response[0].dates, response[0].text, "<?= $name ?>.pdf");
        })
        .catch(function(error) {
          console.error("Error fetching data:", error);
        });
    });

    $(document).on('click', '#print', function() {
      var filters = setFilter2();
      ajaxCall2(filters.employee_id, filters.from, filters.too)
        .then(function(response) {
          printContent(response[0].dates, response[0].text);
        })
        .catch(function(error) {
          console.error("Error fetching data:", error);
        });
    });

    function printContent(data, summaryText) {
      var printWindow = window.open('', '_blank');
      var htmlContent = '<html><head><title>Attendance Report</title></head><body>';

      var currentTime = new Date().toLocaleString();
      htmlContent += '<h3><?= $name ?> Attendance Report</h3>';
      htmlContent += '<table style="border:1px solid #000000"><tr><th>Date</th><th>Fingers</th></tr>';

      var sortedDates = Object.keys(data).sort();

      sortedDates.forEach(function(date) {
        var checkins = data[date];
        var checkinsString = checkins.join(', ');
        htmlContent += '<tr><td style="border:1px solid #000000">' + date + '</td><td style="border:1px solid #000000;">' + checkinsString + '</td></tr>';
      });

      htmlContent += '</table>';
      htmlContent += '<h3>Summery</h3>';
      htmlContent += '<p>' + summaryText + '</p>';

      htmlContent += '</body></html>';
      printWindow.document.open();
      printWindow.document.write(htmlContent);
      printWindow.document.close();

      printWindow.print();

      if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
          if (!mql.matches) {
            printWindow.close();
          }
        });
      } else {
        printWindow.onafterprint = function() {
          printWindow.close();
        };
      }
    }


    function downloadPDF(data, summaryText, filename) {
      var doc = new jsPDF();

      var currentTime = new Date().toLocaleString();
      doc.text('<?= $name ?> Attendance Report (' + currentTime + ')', 10, 10);

      var y = 20;

      var columns = ['Date', 'Check-in'];
      columns.forEach(function(column, index) {
        doc.text(column, 10 + (index * 60), y);
      });

      y += 10;

      // Sort the dates
      var sortedDates = Object.keys(data).sort();

      sortedDates.forEach(function(date) {
        var checkins = data[date];
        var checkinsString = checkins.join(', ');
        doc.text(date, 10, y);
        doc.text(checkinsString, 70, y);
        y += 10;
      });

      var summaryWithoutLineBreaks = summaryText.replace(/<br>/g, '\n');

      doc.text(summaryWithoutLineBreaks, 10, y + 10);
      doc.save(filename);
    }

    function downloadCSV(data, filename) {
      var csvContent = "Date,Check-in\n";

      // Extract and sort the dates
      var sortedDates = Object.keys(data).sort();

      // Iterate over the sorted dates
      sortedDates.forEach(function(date) {
        var checkins = data[date];
        var checkinString = checkins.join(",");
        csvContent += date + "," + checkinString + "\n";
      });

      var blob = new Blob([csvContent], {
        type: 'text/csv;charset=utf-8;'
      });

      var csvUrl = URL.createObjectURL(blob);

      var link = document.createElement("a");
      link.href = csvUrl;
      link.setAttribute("download", filename);

      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }


    function downloadExcel(data, filename) {
      var workbook = XLSX.utils.book_new();
      var worksheet = XLSX.utils.aoa_to_sheet([
        ["Date", "Check-in"]
      ]);

      // Extract and sort the dates
      var sortedDates = Object.keys(data).sort();

      // Iterate over the sorted dates
      sortedDates.forEach(function(date, index) {
        var checkins = data[date];
        var row = [date, checkins.join(", ")];
        XLSX.utils.sheet_add_aoa(worksheet, [row], {
          origin: -1
        });
      });

      XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
      XLSX.writeFile(workbook, filename);
    }



    function setFilter2() {
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

      return {
        employee_id: employee_id,
        from: formattedFromDate,
        too: formattedToDate
      }
    }

    function ajaxCall2(employee_id, from, too) {
      return new Promise(function(resolve, reject) {
        $.ajax({
          url: base_url + 'attendance/get_single_user_attendance',
          type: 'POST',
          data: {
            user_id: employee_id,
            from: from,
            too: too
          },
          success: function(response) {
            var tableData = JSON.parse(response);
            resolve(tableData);
          },
          error: function(xhr, status, error) {
            reject(error);
            console.error("An error occurred:", error);
            alert("An error occurred while fetching data.");
          }
        });
      });
    }

    $('.select2').select2()

  </script>
  <!--**********************************
        Main wrapper end
    ***********************************-->
</body>

</html>