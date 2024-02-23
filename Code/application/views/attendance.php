<?php $this->load->view('includes/header'); ?>
<style>
    #attendance_list tbody td a {
        font-weight: bold;
        font-size: 10px;
    }

    .dataTables_wrapper .dataTables_scrollFoot {
        position: sticky;
        bottom: 0;
        background-color: white;
        /* Adjust as needed */
        z-index: 1000;
        /* Adjust as needed */
    }

    #attendance_list tbody td {
        padding: 1px 10px;
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
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form class="row">
                                        <div class="col-lg-3 mb-3">
                                            <select class="form-select" id="employee_id">
                                                <option value=""><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></option>
                                                <?php foreach ($system_users as $system_user) {
                                                    if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == '1' && $system_user->finger_config == '1') { ?>
                                                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 mb-3">
                                            <select class="form-select" id="shift_id">
                                                <option value=""><?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?></option>
                                                <?php foreach ($shifts as $shift) : ?>
                                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 mb-3">
                                            <select class="form-select" id="department_id">
                                                <option value=""><?= $this->lang->line('department') ? $this->lang->line('department') : 'Department' ?></option>
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= $department["id"] ?>"><?= $department["department_name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 mb-3">
                                            <select class="form-select" id="dateFilter">
                                                <option value="today"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Today' ?></option>
                                                <option value="ystdy"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Yesterday' ?></option>
                                                <option value="tweek"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'This Week' ?></option>
                                                <option value="tmonth" selected><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'This Month' ?></option>
                                                <option value="lmonth"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Last Month' ?></option>
                                                <option value="custom"><?= $this->lang->line('select_filter') ? $this->lang->line('select_filter') : 'Custom' ?></option>
                                            </select>
                                        </div>
                                        <div id="custom-date-range" style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <input name="datepicker" class="datepicker-default form-control" placeholder="From Date" id="from">
                                                </div>
                                                <div class="col-lg-3">
                                                    <input name="datepicker" class="datepicker-default form-control" placeholder="To Date" id="too">
                                                </div>
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
                            <div class="card-body p-1">
                                <div class="table-responsive">
                                    <table id="attendance_list" class="table table-sm mb-0">
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
        <!--**********************************
	Content body end
***********************************-->
        <?php $this->load->view('includes/footer'); ?>
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script>
        var dateFilterSelect = document.getElementById('dateFilter');
        var customDateDiv = document.getElementById('custom-date-range');
        dateFilterSelect.addEventListener('change', function() {
            if (dateFilterSelect.value === 'custom') {
                customDateDiv.style.display = 'block';
            } else {
                customDateDiv.style.display = 'none';
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            setFilter();
            $(document).on('change', '#shift_id, #department_id, #employee_id,#dateFilter, #from,#too', function() {
                setFilter();
            });
        });

        function ajaxCall(employee_id, shift_id, department_id, from, too) {
            $.ajax({
                url: '<?= base_url('attendance/get_attendance') ?>',
                type: 'GET',
                data: {
                    user_id: employee_id,
                    department: department_id,
                    shifts: shift_id,
                    from: from,
                    too: too
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    if (tableData.data.length > 0) {
                        showTable(tableData);
                    } else {
                        emptyTable();
                    }
                },
                complete: function() {
                    hideLoader();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function emptyTable() {
            var table = $('#attendance_list');

            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            emptyDataTable(table);

            var thead = table.find('thead');
            var theadRow = '<tr><th style="font-size:12px;">#</th><th style="font-size:12px;">ID</th><th style="font-size:12px; width:20px;">Employee</th></tr>';
            thead.html(theadRow);

            table.DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                },
                "info": false,
                "dom": '<"top"i>rt<"bottom"lp><"clear">',
                "lengthMenu": [5, 10, 20],
                "pageLength": 5
            });
        }

        // Call this function when you want to add an empty row to the table
        function addEmptyRowToTable() {
            var table = $('#attendance_list').DataTable();
            table.row.add(['', '', '']).draw(); // Add an empty row with three empty cells
        }

        // Call this function when you want to remove all rows from the table
        function removeAllRowsFromTable() {
            var table = $('#attendance_list').DataTable();
            table.clear().draw(); // Clear all rows from the table
        }



        function showTable(data) {
            console.log(data);
            var table = $('#attendance_list');
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            emptyDataTable(table);
            var uniqueDates = getUniqueDates(data.data);
            var thead = table.find('thead');
            var theadRow = '<tr><td style="background=#FAFAFA;border:2px solid #FAFAFA;" colspan="3"></td> ';
            const dataArray = Object.entries(data.range);
            dataArray.forEach(([month, value]) => {
                theadRow += '<td class="text-center" style="background=#FAFAFA; font-weight:600; border:2px solid #FAFAFA;" colspan="' + value + '">' + month + '</td>';
            });
            theadRow += '</tr><tr><th style="font-size:12px;">#</th><th style="font-size:12px;">ID</th><th style="font-size:12px;  width:20px;">Employee</th>';

            uniqueDates.forEach(date => {
                var filterOption = $('#dateFilter').val();
                if (filterOption == 'today' || filterOption == 'ystdy') {
                    theadRow += '<th style="font-size:12px;">Times</th>';
                } else {
                    if (filterOption == 'custom') {
                        var fromInput = $('#from').val();
                        var toInput = $('#too').val();
                        if (fromInput == toInput) {
                            theadRow += '<th style="font-size:12px;">Times</th>';
                        } else {
                            const formattedDate = new Date(date);
                            const formattedDateString = formattedDate.toLocaleString('en-US', {
                                day: 'numeric'
                            });
                            theadRow += '<th style="font-size:12px;">' + formattedDateString + '</th>';
                        }
                    } else {
                        const formattedDate = new Date(date);
                        const formattedDateString = formattedDate.toLocaleString('en-US', {
                            day: 'numeric'
                        });
                        theadRow += '<th style="font-size:12px;">' + formattedDateString + '</th>';
                    }

                }
            });

            theadRow += '</tr>';
            thead.html(theadRow);

            // Add table body
            var tbody = table.find('tbody');

            var count = 1;
            data.data.forEach(user => {
                var userRow = '<tr>';
                userRow += '<td style="font-size:12px;"><a href="' + base_url + 'attendance/user_attendance/' + user.user_id + '">' + count + '</a></td>';
                userRow += '<td style="font-size:12px;">' + user.user + '</td>';
                userRow += '<td style="font-size:12px;">' + user.name + '</td>';

                uniqueDates.forEach(date => {
                    if (user.dates[date]) {
                        userRow += '<td style="font-size:12px;">' + user.dates[date].join('<br>') + '</td>';
                    } else {
                        userRow += '<td style="font-size:10px;">Absent</td>';
                    }
                });
                userRow += '</tr>';
                tbody.append(userRow);
                count++;
            });
            table.DataTable({
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
                "lengthMenu": [5, 10, 20],
                "pageLength": 5
            });
        }
        $(document).ready(function() {
            $(".dataTables_info").appendTo("#attendance_list_wrapper .bottom");
            $(".dataTables_length").appendTo("#attendance_list_wrapper .bottom");
        });

        function emptyDataTable(table) {
            table.find('thead').empty();
            table.find('tbody').empty();
        }

        function getUniqueDates(data) {
            // Extract unique dates from the data
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

        function setFilter() {
            var employee_id = $('#employee_id').val();
            var shift_id = $('#shift_id').val();
            var filterOption = $('#dateFilter').val();
            var department_id = $('#department_id').val();
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
                    toDate = today; // Set toDate as today
                    break;
                case "lmonth":
                    fromDate = new Date(year, month - 1, 1);
                    toDate = new Date(year, month, 0);
                    break;
                case "custom":
                    var fromInput = $('#from').val();
                    var toInput = $('#too').val();
                    console.log(from);
                    fromDate = new Date(convertDateFormat(fromInput));
                    toDate = new Date(convertDateFormat(toInput));
                    break;
                default:
                    console.error("Invalid filter option:", filterOption);
                    return null;
            }

            // Format dates as strings
            var formattedFromDate = formatDate(fromDate, "Y-m-d");
            var formattedToDate = formatDate(toDate, "Y-m-d");
            ajaxCall(employee_id, shift_id, department_id, formattedFromDate, formattedToDate);
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
        $(document).on('change', '#employee_id', function() {
            var employee_id = $('#employee_id').val();
            $.ajax({
                url: '<?= base_url('attendance/get_filters_for_user') ?>',
                type: 'GET',
                data: {
                    employee_id: employee_id,
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    $('#shift_id').empty();
                    $('#department_id').empty();
                    tableData.shift.forEach(function(shift) {
                        $('#shift_id').append('<option value="' + shift.id + '">' + shift.name + '</option>');
                    });
                    tableData.department.forEach(function(department) {
                        $('#department_id').append('<option value="' + department.id + '">' + department.department_name + '</option>');
                    });
                },
                complete: function() {},
                error: function(error) {
                    console.error(error);
                }

            });
        });
        $(document).on('change', '#department_id', function() {
            var department_id = $('#department_id').val();
            $.ajax({
                url: '<?= base_url('attendance/get_users_by_department') ?>',
                type: 'POST',
                data: {
                    department: department_id,
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">Employee</option>');
                    tableData.forEach(function(department) {
                        $('#employee_id').append('<option value="' + department.id + '">' + department.first_name + ' ' + department.last_name + '</option>');
                    });
                },
                complete: function() {},
                error: function(error) {
                    console.error(error);
                }

            });
        });
        $(document).on('change', '#shift_id', function() {
            var shift_id = $('#shift_id').val();
            $.ajax({
                url: '<?= base_url('attendance/get_users_by_shifts') ?>',
                type: 'POST',
                data: {
                    shift_id: shift_id,
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">Employee</option>');
                    tableData.forEach(function(department) {
                        $('#employee_id').append('<option value="' + department.id + '">' + department.first_name + ' ' + department.last_name + '</option>');
                    });
                },
                complete: function() {},
                error: function(error) {
                    console.error(error);
                }

            });
        });
    </script>
</body>

</html>