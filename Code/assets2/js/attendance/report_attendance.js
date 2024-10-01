$(document).ready(function () {
    apply_filters_from_session();
    setFilter();
    updateConfig();
    // on change functions
    $(document).on('change', '#repo_att_shift_id, #repo_att_department_id, #repo_att_employee_id, #repo_att_status', function () {
        setFilter();
    });
    $('#repo_att_status').change(function () {
        sessionStorage.setItem('repo_att_status', $(this).val());
        sessionStorage.removeItem('repo_att_employee_id', $(this).val());
        update_employee_filter();
    });
    $('#repo_att_shift_id').change(function () {
        sessionStorage.setItem('repo_att_shift_id', $(this).val());
        sessionStorage.removeItem('repo_att_employee_id', $(this).val());
        update_employee_filter();
    });

    $('#repo_att_department_id').change(function () {
        sessionStorage.setItem('repo_att_department_id', $(this).val());
        sessionStorage.removeItem('repo_att_employee_id', $(this).val());
        update_employee_filter();
    });
    $('#repo_att_employee_id').change(function () {
        sessionStorage.setItem('repo_att_employee_id', $(this).val());
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

    $('#repo_att_config-demo').click(function () {
        $(this).data('daterangepicker').show();
    });

    function setFilter() {
        var employee_id = $('#repo_att_employee_id').val();
        var shift_id = $('#repo_att_shift_id').val();
        var status = $('#repo_att_status').val();
        var department_id = $('#repo_att_department_id').val();
        var startDate = $("#repo_att_startDate").val();
        var endDate = $("#repo_att_endDate").val();
        ajaxCall(employee_id, shift_id, department_id, status, startDate, endDate);
    }

    function ajaxCall(employee_id, shift_id, department_id, status, from, too) {
        $.ajax({
            url: base_url + 'reports/get_attendance_report',
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
                showTable(tableData);
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
        var table = $('#attendance_list');

        // Destroy the existing DataTable if it is initialized
        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }

        emptyDataTable(table);  // Clear existing table content if needed

        var thead = table.find('thead');
        var tbody = table.find('tbody');

        // Extract the headers (index 0 and 1)
        var head_top_data = data[0];  // First header row
        var head_low_data = data[1];  // Second header row

        // Construct the thead content
        var theadRow = '<tr>';
        head_top_data.forEach(head_top => {
            theadRow += '<th>' + head_top + '</th>';
        });
        theadRow += '</tr><tr>';
        head_low_data.forEach(head_low => {
            theadRow += '<th>' + head_low + '</th>';
        });
        theadRow += '</tr>';
        thead.html(theadRow);  // Set table header

        // Clear the tbody before appending new data
        tbody.empty();

        // Loop through data starting from index 2 to skip the headers
        data.slice(2).forEach(row => {  // Skip the first two elements (headers)
            var userRow = '<tr>';
            row.forEach(cell => {
                userRow += '<td>' + cell + '</td>';
            });
            userRow += '</tr>';
            tbody.append(userRow);  // Append each row to the table body
        });

        // Check for session storage settings or use default for page length
        let att_length = sessionStorage.getItem('att_length');
        if (att_length == null) {
            att_length = 10;
        }

        // Initialize DataTable
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
            "columnDefs": [
                {
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

        // If DataTable is initialized, set the page number
        if ($.fn.DataTable.isDataTable('#attendance_list')) {
            let att_page_no = sessionStorage.getItem('att_page_no');
            if (att_page_no == null) {
                att_page_no = 1;
            }
            var tableInstance = $('#attendance_list').DataTable();
            tableInstance.page(att_page_no - 1).draw(false);
        } else {
            console.error("DataTable initialization failed or table not found.");
        }
    }



    function emptyDataTable(table) {
        table.find('thead').empty();
        table.find('tbody').empty();
    }

    function apply_filters_from_session() {
        let statusFilterValue = sessionStorage.getItem('repo_att_status') || '1';
        $('#repo_att_status').val(statusFilterValue).trigger('change');
        let shiftFilterValue = sessionStorage.getItem('repo_att_shift_id') || '';
        $('#repo_att_shift_id').val(shiftFilterValue).trigger('change');
        let departmentFilterValue = sessionStorage.getItem('repo_att_department_id') || '';
        $('#repo_att_department_id').val(departmentFilterValue).trigger('change');
        // setting the date filter
        const startDate = sessionStorage.getItem('repo_att_startDate') || moment().startOf('month').format('YYYY-MM-DD');
        const endDate = sessionStorage.getItem('repo_att_endDate') || moment().format('YYYY-MM-DD');
        $('#repo_att_startDate').val(startDate);
        $('#repo_att_endDate').val(endDate);
        sessionStorage.setItem('repo_att_startDate', startDate);
        sessionStorage.setItem('repo_att_endDate', endDate);
        // updating Employees
        update_employee_filter();
    }

    function update_employee_filter() {
        let status = $('#repo_att_status').val();
        let shift = $('#repo_att_shift_id').val();
        let department = $('#repo_att_department_id').val();
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
                $('#repo_att_employee_id').empty();
                $('#repo_att_employee_id').append(`<option value="">Employees</option>`);
                if (tableData.length > 0) {
                    tableData.forEach(employee => {
                        $('#repo_att_employee_id').append(`<option value="${employee.id}">${employee.name}</option>`);
                    });
                } else {
                    $('#repo_att_employee_id').empty();
                    $('#repo_att_employee_id').append(`<option value="">No employees found</option>`);
                }
                let employeeFilterValue = sessionStorage.getItem('repo_att_employee_id') || '';
                $('#repo_att_employee_id').val(employeeFilterValue).trigger('change');
            },
            complete: function () { },
            error: function (error) {
                console.error(error);
            }

        });
    }

    function updateConfig() {
        // Retrieve dates from sessionStorage or use defaults
        const storedStartDate = sessionStorage.getItem('repo_att_startDate');
        const storedEndDate = sessionStorage.getItem('repo_att_endDate');

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

        $('#repo_att_config-demo').daterangepicker(options, function (start, end, label) {
            const formattedStartDate = start.format('YYYY-MM-DD');
            const formattedEndDate = end.format('YYYY-MM-DD');
            $('#repo_att_startDate').val(formattedStartDate);
            $('#repo_att_endDate').val(formattedEndDate);
            sessionStorage.setItem('repo_att_startDate', formattedStartDate);
            sessionStorage.setItem('repo_att_endDate', formattedEndDate);
            setFilter();
        });

        // Update the date range picker input to show the selected date range
        $('#repo_att_config-demo').val(`${startDate.format('MM/DD/YYYY')} - ${endDate.format('MM/DD/YYYY')}`);
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
        let repo_att_length = sessionStorage.getItem('repo_att_length');

        if (repo_att_length == null) {
            repo_att_length = 10;
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
            "pageLength": repo_att_length
        });
    }
    $('#attendance_list').on('length.dt', function (e, settings, len) {
        var currentPageLength = len;
        console.log(currentPageLength);
        sessionStorage.setItem('repo_att_length', currentPageLength);
    });

    // Event listener for page change
    $('#attendance_list').on('page.dt', function () {
        var table = $('#attendance_list').DataTable();
        var pageNumber = table.page.info().page + 1;
        sessionStorage.setItem('repo_att_page_no', pageNumber);
    });
});