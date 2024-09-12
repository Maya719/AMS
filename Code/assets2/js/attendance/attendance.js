$(document).ready(function () {
    apply_filters_from_session();
    setFilter();
    updateConfig();
    // on change functions
    $(document).on('change', '#att_shift_id, #att_department_id, #att_employee_id, #att_status', function () {
        setFilter();
    });
    $('#att_status').change(function () {
        sessionStorage.setItem('att_status', $(this).val());
        sessionStorage.removeItem('att_employee_id', $(this).val());
        update_employee_filter();
    });
    $('#att_shift_id').change(function () {
        sessionStorage.setItem('att_shift_id', $(this).val());
        sessionStorage.removeItem('att_employee_id', $(this).val());
        update_employee_filter();
    });

    $('#att_department_id').change(function () {
        sessionStorage.setItem('att_department_id', $(this).val());
        sessionStorage.removeItem('att_employee_id', $(this).val());
        update_employee_filter();
    });
    $('#att_employee_id').change(function () {
        sessionStorage.setItem('att_employee_id', $(this).val());
    });

    $('#config-text').keyup(function () {
        eval($(this).val());
    });

    $('.configurator input').change(function () {
        updateConfig();
    });

    $('.demo i').click(function () {
        $(this).parent().find('input').click();
    });

    $('#config-demo').click(function () {
        $(this).data('daterangepicker').show();
    });

    function setFilter() {
        var employee_id = $('#att_employee_id').val();
        var shift_id = $('#att_shift_id').val();
        var status = $('#att_status').val();
        var department_id = $('#att_department_id').val();
        var startDate = $("#att_startDate").val();
        var endDate = $("#att_endDate").val();
        ajaxCall(employee_id, shift_id, department_id, status, startDate, endDate);
    }

    function ajaxCall(employee_id, shift_id, department_id, status, from, too) {
        $.ajax({
            url: base_url + 'attendance/get_attendance',
            type: 'GET',
            data: {
                user_id: employee_id,
                department: department_id,
                shifts: shift_id,
                status: status,
                from: from,
                too: too
            },
            beforeSend: function () {
                showLoader();
            },
            success: function (response) {
                var tableData = JSON.parse(response);
                if (tableData.data.length > 0) {
                    showTable(tableData);
                } else {
                    emptyTable();
                }
            },
            complete: function () {
                hideLoader();
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    function showTable(data) {
        var uniqueDates = getUniqueDates(data.data);
        var count = 1;
        var table = $('#attendance_list');
        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }
        emptyDataTable(table);
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
        var tbody = table.find('tbody');
        data.data.forEach(user => {
            var userRow = '<tr>';
            userRow += '<td style="font-size:10px;"><a href="'+base_url + 'attendance/user_attendance/'+user.user_id+'">' + count + '</a></td>';
            userRow += '<td style="font-size:10px;">' + user.user + '</td>';
            userRow += '<td style="font-size:10px;">' + user.name + '</td>';
            userRow += '<td style="font-size:10px;"><a href="'+base_url + 'attendance/user_attendance/'+user.user_id+'">' + user.summery + '</a></td>';
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
        
        let att_length = sessionStorage.getItem('att_length');

        if (att_length == null) {
            att_length = 10;
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
            "pageLength": att_length,
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
            let att_page_no = sessionStorage.getItem('att_page_no');
            if (att_page_no == null) {
                att_page_no = 1;
            }
            var table = $('#attendance_list').DataTable();
            table.page(att_page_no - 1).draw(false);
        } else {
            console.error("DataTable initialization failed or table not found.");
        }
    }

    function emptyDataTable(table) {
        table.find('thead').empty();
        table.find('tbody').empty();
    }

    function apply_filters_from_session() {
        let statusFilterValue = sessionStorage.getItem('att_status') || '1';
        $('#att_status').val(statusFilterValue).trigger('change');
        let shiftFilterValue = sessionStorage.getItem('att_shift_id') || '';
        $('#att_shift_id').val(shiftFilterValue).trigger('change');
        let departmentFilterValue = sessionStorage.getItem('att_department_id') || '';
        $('#att_department_id').val(departmentFilterValue).trigger('change');
        // setting the date filter
        const startDate = sessionStorage.getItem('att_startDate') || moment().startOf('month').format('YYYY-MM-DD');
        const endDate = sessionStorage.getItem('att_endDate') || moment().format('YYYY-MM-DD');
        $('#att_startDate').val(startDate);
        $('#att_endDate').val(endDate);
        sessionStorage.setItem('att_startDate', startDate);
        sessionStorage.setItem('att_endDate', endDate);
        // updating Employees
        update_employee_filter();
    }

    function update_employee_filter() {
        let status = $('#att_status').val();
        let shift = $('#att_shift_id').val();
        let department = $('#att_department_id').val();
        $.ajax({
            url: base_url + 'attendance/get_filters_for_user',
            type: 'GET',
            data: {
                status: status,
                shift: shift,
                department: department
            },
            success: function (response) {
                var tableData = JSON.parse(response);
                console.log(tableData);
                $('#att_employee_id').empty();
                $('#att_employee_id').append(`<option value="">Employees</option>`);
                if (tableData.length > 0) {
                    tableData.forEach(employee => {
                        $('#att_employee_id').append(`<option value="${employee.id}">${employee.name}</option>`);
                    });
                } else {
                    $('#att_employee_id').empty();
                    $('#att_employee_id').append(`<option value="">No employees found</option>`);
                }
                let employeeFilterValue = sessionStorage.getItem('att_employee_id') || '';
                $('#att_employee_id').val(employeeFilterValue).trigger('change');
            },
            complete: function () { },
            error: function (error) {
                console.error(error);
            }

        });
    }

    function updateConfig() {
        // Retrieve dates from sessionStorage or use defaults
        const storedStartDate = sessionStorage.getItem('att_startDate');
        const storedEndDate = sessionStorage.getItem('att_endDate');

        const startDate = storedStartDate ? moment(storedStartDate) : moment().startOf('month');
        const endDate = storedEndDate ? moment(storedEndDate) : moment();

        const options = {
            startDate: startDate,
            endDate: endDate,
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

        $('#config-demo').daterangepicker(options, function (start, end, label) {
            const formattedStartDate = start.format('YYYY-MM-DD');
            const formattedEndDate = end.format('YYYY-MM-DD');
            $('#att_startDate').val(formattedStartDate);
            $('#att_endDate').val(formattedEndDate);
            sessionStorage.setItem('att_startDate', formattedStartDate);
            sessionStorage.setItem('att_endDate', formattedEndDate);
            setFilter();
        });

        // Update the date range picker input to show the selected date range
        $('#config-demo').val(`${startDate.format('MM/DD/YYYY')} - ${endDate.format('MM/DD/YYYY')}`);
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

    function emptyTable() {
        var table = $('#attendance_list');

        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }
        emptyDataTable(table);

        var thead = table.find('thead');
        var theadRow = '<tr><th style="font-size:12px;">#</th><th style="font-size:12px;">ID</th><th style="font-size:12px; width:20px;">Employee</th></tr>';
        thead.html(theadRow);
        let att_length = sessionStorage.getItem('att_length');

        if (att_length == null) {
            att_length = 10;
        }
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
            "pageLength": att_length
        });
    }
    $('#attendance_list').on('length.dt', function (e, settings, len) {
        var currentPageLength = len;
        console.log(currentPageLength);
        sessionStorage.setItem('att_length', currentPageLength);
    });

    // Event listener for page change
    $('#attendance_list').on('page.dt', function () {
        var table = $('#attendance_list').DataTable();
        var pageNumber = table.page.info().page + 1;
        sessionStorage.setItem('att_page_no', pageNumber);
    });
});