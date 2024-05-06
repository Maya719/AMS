<?php $this->load->view('includes/header'); ?>
<style>
    .kanbanimg li span {
        height: 2rem;
        width: 2rem;
        border-radius: 50px;
        line-height: 2rem;
        display: block;
        font-size: 12px;
        font-weight: 600;
    }

    .section .section-title {
        font-size: 18px;
        color: #191d21;
        font-weight: 600;
        position: relative;
        margin: 30px 0 25px 0;
    }

    .section-title:before {
        content: ' ';
        border-radius: 5px;
        height: 8px;
        width: 30px;
        background-color: var(--theme-color);
        display: inline-block;
        float: left;
        margin-top: 6px;
        margin-right: 15px;
    }

    .section-title+.section-lead {
        margin-top: -20px;
    }

    .custom-circle-fill-info {
        fill: #D653C1;
    }

    .custom-circle-fill-danger {
        fill: #FC2E53;
    }

    .custom-circle-fill-warning {
        fill: #FFCF6D;
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
            <div class="container-fluid">
                <?php if ($this->ion_auth->is_admin() || permissions('task_create')) : ?>
                    <div class="row d-flex justify-content-end">
                        <div class="col-xl-2 col-sm-3">
                            <a href="<?= base_url('issues') ?>" class="btn btn-block btn-primary <?php echo $is_allowd_to_create_new ? "" : "disabled" ?>">Add
                                Issue</a>
                        </div>
                    </div>
                <?php endif ?>
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select class="form-select" id="board_type">
                                                <option value="0">
                                                    <?= $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban' ?>
                                                </option>
                                                <option value="1">
                                                    <?= $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile' ?>
                                                </option>
                                            </select>
                                        </div>
                                        <?php if ($this->ion_auth->is_admin() || permissions('task_view_all') || permissions('task_view_selected')) : ?>
                                            <div class="col-lg-3">
                                                <select class="form-select" id="project_id">
                                                    <option value="" selected>Project</option>
                                                    <?php foreach ($projects as $project) : ?>
                                                        <?php if ($project["dash_type"] == 1) : ?>
                                                            <option value="<?= $project["id"] ?>"><?= $project["title"] ?></option>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <div class="col-lg-3" id="sprintCol" style="display: none;">
                                            <select class="form-select" id="sprint_id">
                                                <?php foreach ($sprints as $sprint) : ?>
                                                    <option value="<?= $sprint["id"] ?>"><?= $sprint["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <?php if ($this->ion_auth->is_admin() || permissions('task_view_all') || permissions('task_view_selected')) : ?>
                                            <div class="col-lg-3">
                                                <select class="form-select" id="user_id">
                                                    <option value="" selected>Member</option>
                                                    <?php foreach ($system_users as $system_user) : ?>
                                                        <?php if ($system_user->active == '1') : ?>
                                                            <option value="<?= $system_user->id ?>">
                                                                <?= $system_user->first_name . ' ' . $system_user->last_name ?>
                                                            </option>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 px-3" id="sprint_detail" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h3 id="sprint_name"></h3>
                                        <span id="from-to"></span>
                                    </div>
                                    <div class="mt-xl-0 mt-3">
                                        <div class="d-flex align-items-center mb-xl-4 mb-0 pb-3 justify-content-end flex-wrap">
                                            <h6 class="me-3 mb-0" id="percent"></h6>
                                            <div>
                                                <div class="dropdown">
                                                    <div class="btn-link" data-bs-toggle="dropdown">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item complete_sprint" href="javascript:void(0)">Complete Sprint</a>
                                                        <a class="dropdown-item" href="javascript:void(0)">Edit
                                                            Sprint</a>
                                                        <a class="dropdown-item delete_sprint" href="javascript:void(0)">Delete Sprint</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row kanban-bx px-3" id="html">
                </div>
            </div>
        </div>

        <!-- *******************************************
  Footer -->
        <?php $this->load->view('includes/footer'); ?>
        <!-- ************************************* *****
    Model forms
  ****************************************************-->
        <div class="modal fade" id="issue-detail-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Issue Detail</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-title">
                            <h4 class="text-warning" id="issue_title"></h4>
                        </div>
                        <p id="issue_description"></p>
                        <!-- Nav tabs -->
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#contact" id="project_tab_anchor"><i class="fa-solid fa-diagram-project me-2"></i> Project
                                    </a>
                                </li>

                                <li class="nav-item" id="sprint_li">
                                    <a class="nav-link" data-bs-toggle="tab" href="#home" id="sprint_tab_anchor"><i class="fa-solid fa-arrow-rotate-left me-2"></i> Sprint </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile"><i class="fa-solid fa-anchor me-2"></i> Additional Information</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="home" role="tabpanel">
                                    <div class="pt-2">
                                        <h4 id="sprint_title"></h4>
                                        <p id="sprint_goal"></p>
                                        <div class="cm-content-body publish-content form excerpt" id="sprint_dates">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <div class="cm-content-body publish-content form excerpt">
                                        <ul class="list-style-1 block">
                                            <li>
                                                <div>
                                                    <label class="form-label mb-0 me-2">
                                                        <i class="fa-solid fa-key"></i>
                                                        Issue Type:
                                                    </label>
                                                    <span class="font-w500" id="issue_type"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <label class="form-label mb-0 me-2">
                                                        <i class="fa-solid fa-key"></i>
                                                        Priority:
                                                    </label>
                                                    <span class="font-w500" id="issue_priority"></span>
                                                </div>
                                            </li>
                                            <li id="issue_start_li">
                                                <div>
                                                    <label class="form-label mb-0 me-2">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        Starting Date:
                                                    </label>
                                                    <span class="font-w500" id="issue_start"></span>
                                                </div>
                                            </li>
                                            <li id="issue_due_li">
                                                <div>
                                                    <label class="form-label mb-0 me-2">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        Due Date:
                                                    </label>
                                                    <span class="font-w500" id="issue_due"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="contact">
                                    <div class="pt-4">
                                        <h4 id="project_title"></h4>
                                        <p class="" id="project_description"></p>
                                        <div class="cm-content-body publish-content form excerpt" id="project_dates">

                                        </div>
                                    </div>
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
    </div>
    <?php $this->load->view('includes/scripts'); ?>
    <script src="<?= base_url('assets2/vendor/draggable/draggable.js') ?>"></script>
    <script>
        $(document).ready(function() {
            ajaxCall();
            $('#sprint_id, #user_id, #project_id').change(function() {
                ajaxCall();
            });
            loading = true;

            function ajaxCall() {
                const sprintId = $('#sprint_id').val();
                const userId = $('#user_id').val();
                const projectId = $('#project_id').val();
                const board = $('#board_type').val();
                console.log(board);
                $.ajax({
                    url: 'board/filter_board',
                    type: 'POST',
                    data: {
                        sprint_id: sprintId,
                        user_id: userId,
                        project_id: projectId,
                        board: board,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        console.log(response);
                        $('#html').html(response.html);
                        initSorting();
                        initPopovers();
                        if (board == 1) {
                            $('#sprint_name').html(response.sprint.title);
                            // const from_to = response.sprint.starting_date + ' - ' + response.sprint.starting_date;
                            $('#from-to').html(response.sprint.goal);
                        }
                        $('.delete_sprint').attr('data-id', sprintId);
                        $('.complete_sprint').attr('data-id', sprintId);
                        $('#percent').html(response.percent)
                    },
                    complete: function() {
                        hideLoader();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            function initSorting() {
                const zones = document.querySelectorAll(".draggable-zone.dropzoneContainer");
                if (zones.length === 0) return;

                const sortable = new Sortable.default(zones, {
                    draggable: ".draggable",
                    handle: ".draggable-handle",
                    mirror: {
                        appendTo: "body",
                        constrainDimensions: true,
                    },
                });
                sortable.on("drag:stop", (event) => {
                    const draggedElement = event.data.source;

                    if (draggedElement) {
                        const dataID = draggedElement.getAttribute("data-id");
                        console.log("Dragged card data-id:", dataID);

                        const closestDropZone = draggedElement.closest(".draggable-zone.dropzoneContainer");
                        if (closestDropZone) {
                            const statusID = closestDropZone.getAttribute("data-status-id");
                            saveStatus(dataID, statusID);
                            console.log("Closest drop zone data-status-id:", statusID);
                        } else {
                            console.log("Could not find a closest drop zone to the dragged element");
                        }
                    } else {
                        console.log("Could not access the dragged element during drag:start event");
                    }
                });
            }

            function saveStatus(task, status) {
                $.ajax({
                    url: 'board/saveStatus',
                    type: 'POST',
                    data: {
                        task: task,
                        status: status,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            function initPopovers() {
                $('[data-bs-toggle="popover"]').popover({
                    trigger: 'hover focus',
                    placement: 'auto'
                });
            }

            $('#board_type').change(function() {
                var boardType = $(this).val();
                if (boardType == '0') {
                    $('#sprintCol').hide();
                    $('#sprint_detail').hide();
                    $('#sprint_li').hide();
                    $('#home').removeClass('active');
                    $('#contact').addClass('active');
                    $('#home').removeClass('show');
                    $('#contact').addClass('show');
                    $('#project_tab_anchor').addClass('active');
                    $('#sprint_tab_anchor').removeClass('active');
                } else {
                    $('#sprintCol').show();
                    $('#sprint_detail').show();
                    $('#sprint_li').show();
                    $('#home').removeClass('active');
                    $('#contact').addClass('active');
                    $('#home').removeClass('show');
                    $('#contact').addClass('show');
                }
                $.ajax({
                    url: 'board/get_project_by_board_type',
                    type: 'POST',
                    data: {
                        boardType: boardType,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        $('#project_id').empty();
                        $('#project_id').append('<option value="">Project</option>');
                        $.each(response, function(index, project) {
                            $('#project_id').append('<option value="' + project.id + '">' + project.title + '</option>');
                        });
                        ajaxCall();
                    },
                    complete: function() {
                        hideLoader();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
        $(document).on('click', '.delete_issue', function(e) {
            e.preventDefault();
            var id = $(this).data("issue-id");
            console.log(id);
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
                        url: base_url + 'issues/delete_issue/' + id,
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            if (result['error'] == false) {
                                location.reload();
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
        $(document).on('click', '.delete_sprint', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
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
                        url: base_url + 'backlog/delete_sprint/' + id,
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            if (result['error'] == false) {
                                location.reload();
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
        $(document).on('click', '.complete_sprint', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to move tasks to the backlog before completing the sprint?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                var moveToBacklog = false;
                if (result.isConfirmed) {
                    moveToBacklog = true;
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to complete the sprint!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'backlog/complete_sprint/' + id,
                            data: {
                                id: id,
                                moveToBacklog: moveToBacklog
                            },
                            dataType: "json",
                            success: function(result) {
                                if (result['error'] == false) {
                                    location.reload();
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
        });
        $(document).on('click', '.btn-detail-model', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: base_url + 'issues/get_issue_by_id/' + id,
                data: "id=" + id,
                dataType: "json",
                success: function(result) {
                    $("#issue_title").html(result.issue.title);
                    $("#issue_description").html(result.issue.description);
                    if (result.issue.issue_type == 0) {
                        $("#issue_type").html('Task');
                    } else if (result.issue.issue_type == 1) {
                        $("#issue_type").html('Epic');
                    } else {
                        $("#issue_type").html('Story');
                    }
                    if (result.issue.priority == 1) {
                        $("#issue_priority").html(result.priority.title + ' <i class="fa-solid fa-angle-up text-' + result.priority.class + '"></i>');
                    } else if (result.issue.priority != 1) {
                        $("#issue_priority").html(result.priority.title + ' <i class="fa-solid fa-angles-up text-' + result.priority.class + '"></i>');

                    }
                    if (result.sprint && result.sprint.title) {
                        $("#sprint_title").html(result.sprint.title);
                    } else {
                        $("#sprint_title").html('Backlog');
                    }
                    if (result.sprint && result.sprint.goal !== null) {
                        $("#sprint_goal").html(result.sprint.goal);
                    } else {
                        $("#sprint_goal").html('');
                    }
                    var html = '';
                    if (result.sprint && result.sprint.starting_date !== null) {
                        $("#sprint_goal").html(result.sprint.goal);
                        html += '<ul class="list-style-1 block">';
                        html += '<li class="border-bottom-0">';
                        html += '<div>';
                        html += '<label class="form-label mb-0 me-2">';
                        html += '<i class="fa-solid fa-calendar-days"></i> ';
                        html += 'Starting Datetime :';
                        html += '</label>';
                        html += '<span class="font-w500" id="starting_datetime">' + result.sprint.starting_date + ' ' + result.sprint.starting_time + '</span>';
                        html += '</div>';
                        html += '</li>';
                        html += '<li class="border-bottom-0">';
                        html += '<div>';
                        html += '<label class="form-label mb-0 me-2">';
                        html += '<i class="fa-solid fa-calendar-days"></i> ';
                        html += 'Ending Datetime :';
                        html += '</label>';
                        html += '<span class="font-w500" id="ending_datetime">' + result.sprint.ending_date + ' ' + result.sprint.ending_time + '</span>';
                        html += '</div>';
                        html += '</li>';
                        html += '</ul>';
                    } else {
                        $("#sprint_goal").html('');
                        html += '';
                    }
                    $('#sprint_dates').html(html);
                    if (result.project.dash_type == 0) {
                        $('#issue_start').html(moment(result.issue.starting_date, 'YYYY-MM-DD').format(date_format_js));
                        $('#issue_due').html(moment(result.issue.due_date, 'YYYY-MM-DD').format(date_format_js));
                    }else{
                        $('#issue_start_li').hide();
                        $('#issue_due_li').hide();

                    }

                    if (result.project && result.project.title !== null) {
                        $("#project_title").html(result.project.title);
                        $("#project_description").html(result.project.description);
                        var html2 = '<ul class="list-style-1 block">';
                        html2 += '<li class="border-bottom-0">';
                        html2 += '<div>';
                        html2 += '<label class="form-label mb-0 me-2">';
                        html2 += '<i class="fa-solid fa-calendar-days"></i> ';
                        html2 += 'Created at:';
                        html2 += '</label>';
                        html2 += '<span class="font-w500">' + result.project.created + '</span>';
                        html2 += '</div>';
                        html2 += '</li>';
                        html2 += '</ul>';
                        $("#project_dates").html(html2);
                    }
                    console.log(result);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var sprintSelect = document.getElementById('sprint_id');
            var agileOption = document.querySelector('#board_type option[value="1"]');

            if (sprintSelect && sprintSelect.childElementCount === 0) {
                agileOption.style.display = 'none';
            } else {
                agileOption.style.display = 'block';
            }
        });
    </script>
</body>

</html>