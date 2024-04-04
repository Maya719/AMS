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
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select class="form-select" id="board_type">
                                                <option value="1"><?= $this->lang->line('agile') ? $this->lang->line('agile') : 'Agile' ?></option>
                                                <option value="0"><?= $this->lang->line('kanban') ? $this->lang->line('kanban') : 'Kanban' ?></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-select" id="project_id">
                                                <option value="" selected>Project</option>
                                                <?php foreach ($projects as $project) : ?>
                                                    <option value="<?= $project["id"] ?>"><?= $project["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3" id="sprintCol">
                                            <select class="form-select" id="sprint_id">
                                                <?php foreach ($sprints as $sprint) : ?>
                                                    <option value="<?= $sprint["id"] ?>"><?= $sprint["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-select" id="user_id">
                                                <option value="" selected>Member</option>
                                                <?php foreach ($system_users as $system_user) : ?>
                                                    <?php if ($system_user->active == '1') : ?>
                                                        <option value="<?= $system_user->id ?>"><?= $system_user->first_name . ' ' . $system_user->last_name ?></option>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 px-3" id="sprint_detail">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h3 id="sprint_name"></h3>
                                        <span id="from-to"></span>
                                    </div>
                                    <div class="mt-xl-0 mt-3">
                                        <div class="d-flex align-items-center mb-xl-4 mb-0 pb-3 justify-content-end flex-wrap">
                                            <h6 class="me-3 mb-0">Total Progress 60%</h6>
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
                                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                        <a class="dropdown-item" href="javascript:void(0)">Edit</a>
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
                        console.log('AJAX Success:', response);
                        $('#html').html(response.html);
                        initSorting();
                        initPopovers();
                        $('#sprint_name').html(response.sprint.title);
                        const from_to = response.sprint.starting_date + ' - ' + response.sprint.starting_date;
                        $('#from-to').html(from_to);
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
                const zones = document.querySelectorAll(".draggable-zone");
                if (zones.length === 0) return;

                new Sortable.default(zones, {
                    draggable: ".draggable",
                    handle: ".draggable-handle",
                    mirror: {
                        appendTo: "body",
                        constrainDimensions: true
                    },
                }).on("drag:stop", (event) => {
                    setTimeout(() => {
                        jQuery(".dropzoneContainer").each(function() {
                            const count = jQuery(this).find(".draggable-handle").length;
                            jQuery(this).find(".totalCount").html(count);
                        });
                    }, 200);

                    console.log("Sortable event data:", event);

                    const draggedCard = event.data.originalSource;

                    if (!draggedCard) {
                        console.error("Dragged card is undefined.");
                        return;
                    }

                    // Get the closest drop zone (assuming .dropzoneContainer is the drop zone class)
                    const dropZone = draggedCard.closest(".dropzoneContainer");
                    if (!dropZone) {
                        console.error("Drop zone not found.");
                        return;
                    }

                    const statusId = dropZone.dataset.statusId;
                    const issueId = draggedCard.dataset.issueId;

                    if (!statusId || !issueId) {
                        console.error("Missing status ID or issue ID on dragged card.");
                        return;
                    }

                    console.log("Drop Zone:", dropZone);
                    console.log("Dropped at Status ID:", statusId);
                    console.log("Issue ID:", issueId);
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
                } else {
                    $('#sprintCol').show();
                    $('#sprint_detail').show();
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
    </script>
</body>

</html>