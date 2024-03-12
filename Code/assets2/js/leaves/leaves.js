$(document).on('click', '.btn-create-leave', function (e) {
    e.preventDefault();

    var form = $('#modal-create-leaves-part')[0]; // Get the native DOM element
    var formData = new FormData(form); // Create FormData object

    console.log(formData);

    $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        dataType: "json",
        beforeSend: function () {
            $(".btn-create-leave").prop("disabled", true).html('Creating...');
        },
        success: function (result) {
            if (result['error'] == false) {
                location.href = base_url + "leaves"
            } else {
                toastr.error(result['message'], "Error", {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                });
            }
        },
        complete: function () {
            $(".btn-create-leave").prop("disabled", false).html('Create');
        }
    });
});


function setFilter() {
    var employee_id = $('#employee_id').val();
    var leave_type = $('#leave_type').val();
    var filterOption = $('#dateFilter').val();
    var status = $('#status_name').val();

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
            toDate = new Date(year, month + 1, 0);
            break;
        case "lmonth":
            fromDate = new Date(year, month - 1, 1);
            toDate = new Date(year, month, 0);
            break;
        case "tyear":
            fromDate = new Date(year, 0, 1);
            toDate = new Date(year, 11, 31);
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
    ajaxCall(employee_id, leave_type, status, formattedFromDate, formattedToDate);
}
function ajaxCall(employee_id, leave_type, status, from, too) {
    $.ajax({
        url: base_url + 'leaves/get_leaves',
        type: 'GET',
        data: {
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
            console.log(tableData);
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
    theadRow += '<th>Created</th>';
    theadRow += '<th>Starting Time</th>';
    theadRow += '<th>Ending Time</th>';
    theadRow += '<th>Paid</th>';
    theadRow += '<th>Status</th>';
    theadRow += '<th>Action</th>';
    theadRow += '</tr>';
    thead.html(theadRow);
    var tbody = table.find('tbody');
    data.forEach(user => {
        var createdAt = moment(user.created, 'YYYY-MM-DD').format(date_format_js);
        var userRow = '<tr>';
        userRow += '<td style="font-size:13px;">' + user.user_id + '</td>';
        userRow += '<td style="font-size:13px;">' + user.user + '</td>';
        userRow += '<td style="font-size:13px;">' + user.name + '</td>';
        userRow += '<td style="font-size:13px;">' + user.leave_reason + '</td>';
        userRow += '<td style="font-size:13px;">' + user.leave_duration + '</td>';
        userRow += '<td style="font-size:13px;">' + createdAt + '</td>';
        userRow += '<td style="font-size:13px;">' + user.starting_date + ' ' + user.starting_time + '</td>';
        userRow += '<td style="font-size:13px;">' + user.ending_date + ' ' + user.ending_time + '</td>';
        userRow += '<td style="font-size:13px;">' + user.paid + '</td>';
        userRow += '<td style="font-size:13px;">' + user.status + '</td>';
        userRow += '<td>';
        userRow += '<div class="d-flex">';
        userRow += '<a href="' + base_url + 'leaves/manage/' + user.id + '" data-id="' + user.id + '" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-eye text-primary"></i></a>';
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
        "pageLength": 10,
        "dom": '<"top"f>rt<"bottom"lp><"clear">',
        "order": [[5, "desc"]]
    });

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
$(document).ready(function () {
    $('select[name="user_id_add"]').on('change', function () {
        updateLeaveCounts();
    });

    $('select[name="type_add"]').on('change', function () {
        updateLeaveCounts();
    });

    $('.btn-create').on('click', function () {
        updateLeaveCounts();
    });

    function updateLeaveCounts() {
        var type = $('select[name="type_add"]').val();
        var user_id = $('select[name="user_id_add"]').val();
        console.log(type);
        $.ajax({
            url: base_url + 'leaves/get_leaves_count',
            method: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id,
                type: type
            },
            beforeSend: function () {
                $(".modal-body").append(ModelProgress);
            },
            success: function (response) {
                console.log(response);
                var totalLeaves = response.total_leaves;
                var consumedLeaves = response.consumed_leaves;
                var remainingLeaves = response.remaining_leaves;
                var query = response.query;

                $('#total_leaves').val(totalLeaves);
                $('#consumed_leaves').val(consumedLeaves);
                if (remainingLeaves == 0) {
                    $('#paidUnpaid').prop('disabled', true);
                    $('#paidUnpaid').val('1');
                    $("#paidUnpaid").trigger("change");
                } else {
                    $('#paidUnpaid').prop('disabled', false);
                    $('#paidUnpaid').val('0');
                    $("#paidUnpaid").trigger("change");
                }
                $('#remaining_leaves').val(remainingLeaves);
            },
            complete: function () {
                $(".loader-progress").remove();
            }
        });
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
                        location.href = base_url + 'leaves';
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
$(document).on('click', '.btn-edit-leave', function (e) {
    var form = $('#modal-edit-leaves-part')[0]; // Get the native DOM element
    if (!form || form.nodeName !== 'FORM') {
        console.error('Form element not found or not a form');
        return;
    }
    var formData = new FormData(form); // Create FormData object

    console.log(formData);

    $.ajax({
        type: 'POST',
        url: $(form).attr('action'), // Use $(form) to get the jQuery object and then retrieve the action attribute
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        dataType: "json",
        beforeSend: function () {
            $(".btn-edit-leave").prop("disabled", true);
        },
        success: function (result) {
            if (result['error'] == false) {
                location.reload();
            } else {
                toastr.error(result['message'], "Error", {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                });
            }
        },
        complete: function () {
            $(".btn-edit-leave").prop("disabled", false);
        }
    });

    e.preventDefault();
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