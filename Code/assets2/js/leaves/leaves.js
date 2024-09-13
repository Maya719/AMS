


function setFilter() {
    var employee_id = $('#le_employee_id').val();
    var leave_type = $('#le_leave_type').val();
    var status = $('#le_status_name').val();
    var userstatus = $('#le_status').val();
    var startDate = $("#le_startDate").val();
    var endDate = $("#le_endDate").val();

    ajaxCall(userstatus, employee_id, leave_type, status, startDate, endDate);
}
function ajaxCall(userstatus, employee_id, leave_type, status, from, too) {
    $.ajax({
        url: base_url + 'leaves/get_leaves',
        type: 'GET',
        data: {
            userstatus: userstatus,
            user_id: employee_id,
            leave_type: leave_type,
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
    console.log(data);
    var table = $('#leave_list');
    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }
    emptyDataTable(table);
    var thead = table.find('thead');
    var theadRow = '<tr>';
    theadRow += '<th>ID</th>';
    theadRow += '<th>Employee Name</th>';
    theadRow += '<th>Type</th>';
    theadRow += '<th>Reason</th>';
    theadRow += '<th>Duration</th>';
    theadRow += '<th>Starting Time</th>';
    theadRow += '<th>Ending Time</th>';
    theadRow += '<th>Created</th>';
    theadRow += '<th>Paid</th>';
    theadRow += '<th>Status</th>';
    theadRow += '<th>Document</th>';
    theadRow += '<th>Action</th>';
    theadRow += '</tr>';
    thead.html(theadRow);
    var tbody = table.find('tbody');
    data.forEach(user => {
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;
        var newWindowWidth = screenWidth / 2;
        var newWindowHeight = screenHeight;

        var createdAt = moment(user.created, 'YYYY-MM-DD').format(date_format_js);
        var userRow = '<tr>';
        userRow += '<td style="font-size:13px;">' + user.user_id + '</td>';
        userRow += '<td style="font-size:13px;">' + user.user + '</td>';
        userRow += '<td style="font-size:13px;">' + user.name + '</td>';
        userRow += '<td style="font-size:13px;">' + user.leave_reason + '</td>';
        userRow += '<td style="font-size:13px;">' + user.leave_duration + '</td>';
        userRow += '<td style="font-size:13px;">' + user.starting_date + ' ' + user.starting_time + '</td>';
        userRow += '<td style="font-size:13px;">' + user.ending_date + ' ' + user.ending_time + '</td>';
        userRow += '<td style="font-size:13px;">' + createdAt + '</td>';
        userRow += '<td style="font-size:13px;">' + user.paid + '</td>';
        userRow += '<td style="font-size:13px;">' + user.status + '</td>';
        userRow += '<td style="font-size:13px;">' + user.document + '</td>';
        userRow += '<td>';
        userRow += '<div class="d-flex">';
        if (user.status == '<span class="badge light badge-info">Pending</span>') {
            userRow += '<a href="#" onclick="openChildWindow(' + user.id + '); return false;" data-id="' + user.id + '" class="text-primary me-3" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square text-primary"></i></a>';
        } else {
            userRow += '<a href="#" onclick="openChildWindow(' + user.id + '); return false;" data-id="' + user.id + '" class="text-primary me-3" data-bs-toggle="tooltip" data-placement="top" title="See"><i class="fas fa-eye text-primary"></i></a>';
            // userRow += '<a href="' + base_url + 'leaves/manage/' + user.id + '" data-id="' + user.id + '" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit" target="_blank"><i class="fas fa-eye text-primary"></i></a>';
        }

        if (user.btn) {
            userRow += '<a href="' + base_url + 'leaves/manage/' + user.id + '" data-id="' + user.id + '" class="text-primary ms-2 btn-delete-leave" data-bs-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-trash text-danger"></i></a>';
        } else {
            userRow += '<a href="javascript:void(0);" class="text-primary ms-2" data-bs-toggle="tooltip" data-placement="top" title="Delete" disabled><i class="fa-solid fa-trash text-muted"></i></a>';
        }
        userRow += '</div>';
        userRow += '</td>';
        userRow += '</tr>';
        tbody.append(userRow);
    });
    let cookieValue = getCookie('leave_list_length');
    if (cookieValue) { } else {
        cookieValue = 10;
    }
    table.DataTable({
        "paging": true,
        "searching": true,
        "language": {
            "paginate": {
                "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        "info": false,
        "lengthChange": true,
        "lengthMenu": [10, 20, 50, 500],
        "pageLength": cookieValue,
        "dom": '<"top"f>rt<"bottom"lp><"clear">',
        "order": [[7, "desc"]]
    });
    if ($.fn.DataTable.isDataTable('#leave_list')) {
        let cookieValue = getCookie('page_no');
        if (cookieValue) { } else {
            cookieValue = 1;
        }
        var table = $('#leave_list').DataTable();
        table.page(cookieValue - 1).draw(false);
    } else {
        console.error("DataTable initialization failed or table not found.");
    }
}


function emptyDataTable(table) {
    table.find('thead').empty();
    table.find('tbody').empty();
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

$('#half_day').change(function () {
    if ($(this).is(':checked')) {
        $('#full_day_dates').hide();
        $('#short_leave').prop('checked', false);
        $('#short_leave_dates').hide();
        $('#half_day_date').show();
    } else {
        $('#full_day_dates').show();
        $('#half_day_date').hide();
    }
});

$('#short_leave').change(function () {
    if ($(this).is(':checked')) {
        $('#full_day_dates').hide();
        $('#half_day').prop('checked', false);
        $('#half_day_date').hide();
        $('#short_leave_dates').show();
    } else {
        $('#full_day_dates').show();
        $('#short_leave_dates').hide();
    }
});



$(document).on('click', '.btn-delete-leave', function (e) {
    e.preventDefault();
    var id = $("#update_id").val();
    if (!id) {
        var id = $(this).data('id');
    }
    Swal.fire({
        title: 'Are you sure?',
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
                url: base_url + 'leaves/delete/' + id,
                data: "id=" + id,
                dataType: "json",
                success: function (result) {
                    if (result['error'] == false) {
                        window.location.href = base_url + 'leaves';
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

$(document).on('change', '#starting_date_create', function (e) {
    closeEnddate();
});
$(document).ready(function () {
    closeEnddate();
});

function closeEnddate() {
    var starting_date_create = $('#starting_date_create').val();
    $('#ending_date_create').daterangepicker({
        locale: {
            format: date_format_js
        },
        singleDatePicker: true,
        minDate: moment(starting_date_create, date_format_js).toDate()
    });
}


$(document).on('change', '#starting_date', function (e) {
    closeEnddate2();
});

function closeEnddate2() {
    var starting_date_create = $('#starting_date').val();
    $('#ending_date').daterangepicker({
        locale: {
            format: date_format_js
        },
        singleDatePicker: true,
        minDate: moment(starting_date_create, date_format_js).toDate()
    });
}

var time24 = true;
var minimumTime = "08:00";
$('.timepicker').timepicker({
    format: time_format_js,
    showMeridian: false,
    time24Hour: time24,
    minTime: minimumTime
});