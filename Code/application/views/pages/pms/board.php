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
                <div class="row">
                    <div class="col-xl-10 col-sm-9 mt-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                                <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('projects') ?>">Projects</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                            </ol>
                        </nav>
                    </div>
                    <?php if ($this->ion_auth->is_admin() || permissions('task_create')) : ?>
                        <div class="col-xl-2 col-sm-3">
                            <a href="<?= base_url('issues/tasks/' . $project_id) ?>" class="btn btn-block btn-primary <?php echo $is_allowd_to_create_new ? "" : "disabled" ?>">Add
                                Issue</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <?php if ($this->ion_auth->is_admin() || permissions('task_view_all') || permissions('task_view_selected')) : ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <select class="form-select select2" id="project_id" onchange="window.location.href = this.value;">
                                                <option value="" selected>Project</option>
                                                <?php foreach ($projects as $project) : ?>
                                                    <option value="<?= base_url('board/tasks/' . $project["id"]) ?>" <?= ($project_id == $project["id"]) ? 'selected' : '' ?>><?= $project["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-select select2" id="task_users">
                                                <option value="">Member</option>
                                                <?php foreach ($project_users as $system_user) : ?>
                                                    <option value="<?= $system_user["id"] ?>" <?= ($select_user == $system_user["id"]) ? 'selected' : '' ?>>
                                                        <?= $system_user["first_name"] . ' ' . $system_user["last_name"] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
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

                                <li class="nav-item">
                                    <a class="nav-link " data-bs-toggle="tab" id="sub22" href="#sub"><i class="fa-solid fa-diagram-next me-2"></i> Sub Issues </a>
                                </li>

                                <li class="nav-item" id="sprint_li">
                                    <a class="nav-link" data-bs-toggle="tab" href="#home" id="sprint_tab_anchor"><i class="fa-solid fa-arrow-rotate-left me-2"></i> Sprint </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile"><i class="fa-solid fa-anchor me-2"></i> Additional Information</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#comments">
                                        <i class="fa-regular fa-message  me-2"></i> Comments</a>
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
                                <div class="tab-pane fade" id="sub" role="tabpanel">
                                    <div class="pt-2" id="subtasksDetail">

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
                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    <div class="pt-2">
                                        <div class="mt-5 d-flex mb-3">
                                            <input type="hidden" name="comment_task_id" id="comment_task_id" value="">
                                            <input type="hidden" name="is_comment" id="is_comment" value="true">
                                            <input type="text" name="message" id="message" class="form-control" placeholder="<?= $this->lang->line('type_your_message') ? $this->lang->line('type_your_message') : 'Type your message' ?>">
                                            <button type="submit" class="btn btn-primary sendComment">
                                                <i class="far fa-paper-plane"></i>
                                            </button>
                                        </div>
                                        <div id="comments_append" style="max-height: 400px; overflow:auto">

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
            projectId = '<?= $project_id ?>'
            user_id = $('#task_users').val();
            console.log(projectId);
            callAjax(projectId, user_id);
        });
        $(document).on('change', '#task_users', function(e) {
            projectId = '<?= $project_id ?>'
            user_id = $('#task_users').val();
            callAjax(projectId, user_id);
        });

        function callAjax(projectId, user_id) {
            console.log(projectId, user_id);
            $.ajax({
                url: base_url + 'board/filter_board',
                type: 'POST',
                data: {
                    project_id: projectId,
                    user_id: user_id
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    console.log(response);
                    $('#html').html(response.html);
                    if (response.sprint_show) {
                        $('#sprint_detail').show();
                        $('#sprint_name').html(response.sprint.title);
                        $('#from-to').html(response.sprint.goal);
                    } else {
                        $('#sprint_detail').hide();
                    }
                    initSorting();
                    initPopovers();
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
                url: base_url + 'board/saveStatus',
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
        $(document).on('click', '.delete_issue', function(e) {
            e.preventDefault();
            var id = $(this).data("issue-id");
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
                    console.log(id);
                    $.ajax({
                        type: "POST",
                        url: base_url + 'issues/delete_issue/' + id,
                        data: "id=" + id,
                        dataType: "json",
                        success: function(result) {
                            console.log(result);
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
        $(document).on('click', '.delete-comment', function(e) {
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
                        url: base_url + 'projects/delete_task_comment/' + id,
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
        $(document).on('click', '.sendComment', function(e) {
            var comment_task_id = $("#comment_task_id").val();
            var message = $("#message").val();
            var is_comment = $("#is_comment").val();
            $.ajax({
                type: "POST",
                url: base_url + 'projects/create_comment',
                data: {
                    comment_task_id: comment_task_id,
                    message: message,
                    is_comment: is_comment,
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
                },
                error: function(error) {
                    console.error(error);
                }
            })
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
                    $("#comment_task_id").val(id);
                    var commentsHTML = '';
                    if (result.comments) {
                        result.comments.forEach(comment => {
                            commentsHTML += `<div class="msg-bx d-flex justify-content-between align-items-center">
                                                <div class="msg d-flex align-items-center w-100">
                                                    <div class="image-box">
                                                    <ul class="kanbanimg col-4">
                                                        <li><span data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="` + comment.first_name + ` ` + comment.last_name + `">` + comment.short_name + `</span></li>
                                                    </ul>
                                                    </div>
                                                    <div class="ms-3 w-100 ">
                                                        <a href="#">
                                                            <h5 class="mb-1">` + comment.first_name + ` ` + comment.last_name + `</h5>
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="me-auto mb-0 text-black">` + comment.message + `</p>
                                                            <small class="me-4">` + comment.created + `</small>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="dropdown">
                                                    <div class="btn-link" data-bs-toggle="dropdown">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right">`;
                            if (comment.can_delete) {
                                commentsHTML += `<a class="dropdown-item text-danger delete-comment" href="javascript:void(0)" data-id="` + comment.id + `">Delete</a>`;
                            }
                            commentsHTML += `       </div>
                                                </div>
                                            </div>`;

                        });
                    }
                    $("#comments_append").html(commentsHTML);
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
                    } else {
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
                    var subTaskHTML = '';
                    if (result.SubTasks && result.SubTasks.length > 0) {
                        result.SubTasks.forEach(SubTask => {
                            console.log('Subtask', SubTask.title);
                            subTaskHTML += `<div class="project-details">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mt-3">` + SubTask.title + `</h5>
                                                <div class="dropdown">
                                                    <div class="btn-link" data-bs-toggle="dropdown">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if (permissions('task_delete') || $this->ion_auth->is_admin()) { ?>
                                                            <a class="dropdown-item delete_issue text-danger" href="javascript:void(0)" data-issue-id="` + SubTask.id + `">Delete</a>
                                                        <?php } ?>
                                                        
                                                        <?php if (permissions('task_edit') || $this->ion_auth->is_admin()) { ?>
                                                        <a class="dropdown-item edit_sub_task text-primary" href="javascript:void(0)" data-type="` + SubTask.issue_type + `" data-title="` + SubTask.title + `" data-status2="` + SubTask.status.id + `" data-bs-toggle="modal" data-bs-target="#sub-task-edit-modal" data-issue-id="` + SubTask.id + `">Edit</a>
                                                        <?php } ?>
                                                        
                                                        <?php if (permissions('task_status') || $this->ion_auth->is_admin()) { ?>
                                                        <?php foreach ($task_statuses as $status) : ?>
                                                            <a class="dropdown-item status_change text-<?= $status["class"] ?>" href="javascript:void(0)" data-status="<?= $status["id"] ?>" data-issue-id="` + SubTask.id + `"><?= $status["title"] ?></a>
                                                        <?php endforeach ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="projects">
                                                <span class="badge badge-warning light me-3">` + SubTask.issue_type + `</span>
                                                <span class="badge badge-` + SubTask.status.class + ` light">` + SubTask.status.title + `</span>
                                            </div>
                                        </div>
                                        <hr>`;

                        });
                    } else {
                        subTaskHTML += `<p class="mt-3">No Sub Issue Available</p>`;
                    }
                    $("#subtasksDetail").html(subTaskHTML);
                    console.log(result);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $(document).on('click', '.status_change', function(e) {
            var id = $(this).data("issue-id");
            var status = $(this).data("status");
            console.log(id, status);
            $.ajax({
                url: '<?= base_url('issues/update_issues_status') ?>',
                type: 'POST',
                data: {
                    issue: id,
                    status: status
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                    $('#issue-detail-modal').modal('hide');
                    toastr.success("Status Changed", "Success", {
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
                    })
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
    <script>
        document.getElementById('project_id').addEventListener('change', function() {
            var selectedOption = this.value;
            if (selectedOption !== '') {
                window.location.href = selectedOption;
            }
        });

        $('.select2').select2()

    </script>
</body>

</html>