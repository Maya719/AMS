<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets2/vendor/range-picker/daterangepicker.css') ?>" />
<style>
    #attendance_list tbody td a {
        font-weight: bold;
        font-size: 10px;
    }

    .dataTables_wrapper .dataTables_scrollFoot {
        position: sticky;
        bottom: 0;
        background-color: white;
        z-index: 1000;
    }

    #attendance_list tbody td {
        padding: 1px 5px;
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
    <div id="main-wrapper">

        <?php $this->load->view('includes/sidebar'); ?>
        <div class="content-body default-height">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <input type="hidden" id="startDate">
                                        <input type="hidden" id="endDate">
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="status" onchange="setCookieFromSelect('status')">
                                                <option value="1"><?= $this->lang->line('active') ? $this->lang->line('active') : 'Active' ?></option>
                                                <option value="2"><?= $this->lang->line('inactive') ? $this->lang->line('inactive') : 'Inactive' ?></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="employee_id" onchange="setCookieFromSelect('employee_id')">
                                                <option value=""><?= $this->lang->line('employee') ? $this->lang->line('employee') : 'Employee' ?></option>
                                                <?php foreach ($system_users as $system_user) {
                                                    if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == '1' && $system_user->finger_config == '1') { ?>
                                                        <option value="<?= $system_user->id ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="shift_id" onchange="setCookieFromSelect('shift_id')">
                                                <option value=""><?= $this->lang->line('shift') ? $this->lang->line('shift') : 'Shift' ?></option>
                                                <?php foreach ($shifts as $shift) : ?>
                                                    <option value="<?= $shift["id"] ?>"><?= $shift["name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-select select2" id="department_id" onchange="setCookieFromSelect('department_id')">
                                                <option value=""><?= $this->lang->line('department') ? $this->lang->line('department') : 'Department' ?></option>
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= $department["id"] ?>"><?= $department["department_name"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" id="config-demo" class="form-control">
                                        </div>
                                    </div>
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
        <?php $this->load->view('includes/footer'); ?>
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets2/vendor/range-picker/daterangepicker.js') ?>"></script>
    <script>
        $(document).ready(function() {
            setFilter();
            $(document).on('change', '#shift_id, #department_id, #employee_id,#config-demo, #status', function() {
                console.log('call filters');
                setFilter();
            });
        });

        function setFilter() {
            var employee_id = $('#employee_id').val();
            var shift_id = $('#shift_id').val();
            var filterOption = $('#dateFilter').val();
            var status = $('#status').val();
            var department_id = $('#department_id').val();
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            console.log(startDate);
            console.log(endDate);

            ajaxCall(employee_id, shift_id, department_id,status, startDate, endDate);
        }

        function ajaxCall(employee_id, shift_id, department_id,status, from, too) {
            $.ajax({
                url: '<?= base_url('attendance/get_attendance') ?>',
                type: 'GET',
                data: {
                    user_id: employee_id,
                    department: department_id,
                    shifts: shift_id,
                    status: status,
                    from: from,
                    too: too
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
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

        function showTable(data) {
            var table = $('#attendance_list');
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            emptyDataTable(table);
            var uniqueDates = getUniqueDates(data.data);
            var thead = table.find('thead');
            var theadRow = '<tr><td style="background=#FAFAFA;border:2px solid #FAFAFA;" colspan="4"></td> ';
            const dataArray = Object.entries(data.range);
            dataArray.forEach(([month, value]) => {
                theadRow += '<td class="text-center" style="background=#FAFAFA; font-weight:600; border:2px solid #FAFAFA;" colspan="' + value + '">' + month + '</td>';
            });
            theadRow += '</tr><tr><th style="font-size:12px;">#</th><th style="font-size:12px;">ID</th><th style="font-size:12px;  width:100px;">Employee</th><th style="font-size:12px;  width:20px;">A/L/Min</th>';

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
                userRow += '<td style="font-size:10px;"><a href="#" onclick="openChildWindow(' + user.user_id + ')">' + count + '</a></td>';
                userRow += '<td style="font-size:10px;">' + user.user + '</td>';
                userRow += '<td style="font-size:10px;">' + user.name + '</td>';
                userRow += '<td style="font-size:10px;"><a href="#" onclick="openChildWindow(' + user.user_id + ')">' + user.summery + '</a></td>';

                uniqueDates.forEach(date => {
                    if (user.dates[date]) {
                        userRow += '<td style="font-size:10px;">' + user.dates[date].join('<br>') + '</td>';
                    } else {
                        userRow += '<td style="font-size:10px;">Absent</td>';
                    }
                });
                userRow += '</tr>';
                tbody.append(userRow);
                count++;
            });
            let cookieValue = getCookie('attendance_list_length');

            if (cookieValue) {} else {
                cookieValue = 10;
            }
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
                "lengthMenu": [10, 20, 50, 500],
                "pageLength": cookieValue,
                "columnDefs": [{
                        "orderable": true,
                        "targets": [1, 2]
                    },
                    {
                        "orderable": false,
                        "targets": '_all'
                    }
                ],
                "order": [
                    [0, 'asc']
                ]
            });
            if ($.fn.DataTable.isDataTable('#attendance_list')) {
                let cookieValue = getCookie('page_no');
                if (cookieValue) {} else {
                    cookieValue = 1;
                }
                var table = $('#attendance_list').DataTable();
                table.page(cookieValue - 1).draw(false);
            } else {
                console.error("DataTable initialization failed or table not found.");
            }
        }
        $(document).ready(function() {

            $(".dataTables_info").appendTo("#attendance_list_wrapper .bottom");
            $(".dataTables_length").appendTo("#attendance_list_wrapper .bottom");
        });

        function emptyDataTable(table) {
            table.find('thead').empty();
            table.find('tbody').empty();
        }

        let childWindow;

        function openChildWindow(id) {
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;
            window.open('' + base_url + 'attendance/user_attendance/' + id + '', 'childWindow', 'width=' + screenWidth + ',height=' + screenHeight + '');
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
        $(document).on('change', '#employee_id', function() {
            var employee_id = $('#employee_id').val();
            $('#dateFilter').val('tmonth').trigger('change');

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
                    $('#shift_id').append('<option value="" selected>Shift</option>');
                    tableData.shift.forEach(function(shift) {
                        $('#shift_id').append('<option value="' + shift.id + '">' + shift.name + '</option>');
                    });
                    $('#department_id').append('<option value="" selected>Department</option>');
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
        
        $(document).on('change', '#status', function() {
            var status = $('#status').val();
            $.ajax({
                url: '<?= base_url('attendance/get_users_by_status') ?>',
                type: 'POST',
                data: {
                    status: status,
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

        function emptyTable() {
            var table = $('#attendance_list');

            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            emptyDataTable(table);

            var thead = table.find('thead');
            var theadRow = '<tr><th style="font-size:12px;">#</th><th style="font-size:12px;">ID</th><th style="font-size:12px; width:20px;">Employee</th></tr>';
            thead.html(theadRow);
            let cookieValue = getCookie('attendance_list_length');

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
                "pageLength": cookieValue
            });
        }

        function addEmptyRowToTable() {
            var table = $('#attendance_list').DataTable();
            table.row.add(['', '', '']).draw(); // Add an empty row with three empty cells
        }

        // Call this function when you want to remove all rows from the table
        function removeAllRowsFromTable() {
            var table = $('#attendance_list').DataTable();
            table.clear().draw(); // Clear all rows from the table
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Set the default values for the input fields
            $('#startDate').val(moment().startOf('month').format('YYYY-MM-DD'));
            $('#endDate').val(moment().format('YYYY-MM-DD'));

            $('#config-text').keyup(function() {
                eval($(this).val());
            });

            $('.configurator input').change(function() {
                updateConfig();
            });

            $('.demo i').click(function() {
                $(this).parent().find('input').click();
            });

            updateConfig();

            $('#config-demo').click(function() {
                $(this).data('daterangepicker').show();
            });

            function updateConfig() {
                var options = {
                    startDate: moment().startOf('month'),
                    endDate: moment(),
                    maxDate: moment(),
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment()],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                };

                $('#config-demo').daterangepicker(options, function(start, end, label) {
                    $('#startDate').val(start.format('YYYY-MM-DD'));
                    $('#endDate').val(end.format('YYYY-MM-DD'));
                    setFilter();
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                }).click();



                $('#config-text').val("$('#demo').daterangepicker(" + JSON.stringify(options, null, '    ') + ", function(start, end, label) {\n  console.log(\"New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')\");\n});");

            }


        });
    </script>

    <!-- Set Filter Cookies -->
    <script>
        function setCookie(name, value, minutes) {
            let expires = "";
            if (minutes) {
                let date = new Date();
                date.setTime(date.getTime() + (minutes * 60 * 1000));
                // date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            name = 'att_' + name;
            let nameEQ = name + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i].trim();
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function setCookieFromSelect(selectId) {
            let select = document.getElementById(selectId);
            let selectedValue = select.options[select.selectedIndex].value;
            let att_selectId = 'att_' + selectId;
            setCookie(att_selectId, selectedValue, 7);
        }

        function setSelectFromCookie(selectId) {
            let select = document.getElementById(selectId);
            let cookieValue = getCookie(selectId);
            if (cookieValue) {
                if (selectId == 'dateFilter' && cookieValue == 'custom') {
                    $('#custom-dates').modal('show');
                }
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === cookieValue) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            } else {}
        }

        function setCookieFromSelectForDataTable(currentPageLength) {
            setCookie('att_attendance_list_length', currentPageLength, 7);
        }
        document.addEventListener('DOMContentLoaded', (event) => {
            const selectIds = ['employee_id', 'department_id', 'shift_id'];
            selectIds.forEach(setSelectFromCookie);
            $('.select2').select2();
            let cookieValue = getCookie('attendance_list_length');
        });
        $('#attendance_list').on('length.dt', function(e, settings, len) {
            var currentPageLength = len;
            setCookieFromSelectForDataTable(currentPageLength)
        });
        // Event listener for page change
        $('#attendance_list').on('page.dt', function() {
            var table = $('#attendance_list').DataTable();
            var pageNumber = table.page.info().page + 1;
            setCookieFromPageForDataTable(pageNumber)
        });

        function setCookieFromPageForDataTable(pageNumber) {
            setCookie('att_page_no', pageNumber, 7);
        }
    </script>
</body>

</html>