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
                                        <div class="col-lg-6">
                                            <select class="form-select" id="sprint_id">
                                                <option value="" selected>Sprint</option>
                                                <?php foreach ($sprints as $sprint) : ?>
                                                    <option value="<?= $sprint["id"] ?>"><?= $sprint["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
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
                    <div class="col-xl-12 px-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h3>Fillow Company Profile Website Phase 1</h3>
                                        <!-- <h3>Fillow Company Profile Website Phase 1 <?php var_dump($issues) ?></h3> -->
                                        <span>Created by <strong class="text-black">Hajime Mahmuden</strong> on June 31,
                                            2020</span>
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
                <div class="row kanban-bx px-3">
                    <?php foreach ($task_statuses as $task_status) : ?>
                        <div class="col-xl-3 col-md-6 px-0">
                            <div class="kanbanPreview-bx">
                                <div class="draggable-zone dropzoneContainer">
                                    <div class="sub-card align-items-center d-flex justify-content-between mb-4">
                                        <div>
                                            <h4 class="mb-0"><?= $task_status["title"] ?></h4>
                                        </div>
                                    </div>
                                    <?php foreach ($issues as $issue) : ?>
                                        <?php if ($issue["status"] == $task_status["id"]) : ?>
                                            <div class="card draggable-handle draggable">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <?php if ($issue["priority"] == 1) : ?>
                                                            <span class="text-info">
                                                                <svg class="me-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="5" cy="5" r="5" fill="#D653C1" />
                                                                </svg>
                                                                <?= $issue["project_name"] ?>
                                                            </span>
                                                        <?php elseif ($issue["priority"] == 2) : ?>
                                                            <span class="text-warning">
                                                                <svg class="me-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="5" cy="5" r="5" fill="#FFCF6D" />
                                                                </svg>
                                                                <?= $issue["project_name"] ?>
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="text-danger">
                                                                <svg class="me-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="5" cy="5" r="5" fill="#FC2E53" />
                                                                </svg>
                                                                <?= $issue["project_name"] ?>
                                                            </span>
                                                        <?php endif ?>

                                                        <div class="dropdown">
                                                            <div class="btn-link" data-bs-toggle="dropdown">
                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="3.5" cy="11.5" r="2.5" transform="rotate(-90 3.5 11.5)" fill="#717579" />
                                                                    <circle cx="11.5" cy="11.5" r="2.5" transform="rotate(-90 11.5 11.5)" fill="#717579" />
                                                                    <circle cx="19.5" cy="11.5" r="2.5" transform="rotate(-90 19.5 11.5)" fill="#717579" />
                                                                </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                                <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="mb-0"><a href="javascript:void(0);" class="text-black"> <?= $issue["title"] ?></a></h5>
                                                    <?php if ($issue["priority"] == 1) : ?>
                                                        <div class="section-title mt-3 mb-1"><?= $this->lang->line('priority') ? htmlspecialchars($this->lang->line('priority')) : 'Priority' ?></div>
                                                        <span class="badge light badge-info">Low</span>
                                                    <?php elseif ($issue["priority"] == 2) : ?>
                                                        <div class="section-title mt-3 mb-1"><?= $this->lang->line('priority') ? htmlspecialchars($this->lang->line('priority')) : 'Priority' ?></div>
                                                        <span class="badge light badge-warning">Medium</span>
                                                    <?php else : ?>
                                                        <div class="section-title mt-3 mb-1"><?= $this->lang->line('priority') ? htmlspecialchars($this->lang->line('priority')) : 'Priority' ?></div>
                                                        <span class="badge light badge-danger">High</span>
                                                    <?php endif ?>
                                                    <div class="row justify-content-between align-items-center kanban-user" id="kanban_footer">
                                                        <div class="section-title mt-3 mb-1"><?= $this->lang->line('team_members') ? htmlspecialchars($this->lang->line('team_members')) : 'Team Members' ?></div>
                                                        <?php if ($issue["profile"]) : ?>
                                                            <ul class="users col-6">
                                                                <li style="cursor: pointer;"><img data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $issue["user_name"] ?>" src="<?= $issue["user"] ?>" alt="<?= $issue["user"] ?>"></li>
                                                            </ul>
                                                        <?php else : ?>
                                                            <ul class="kanbanimg col-6">
                                                                <li><span data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $issue["user_name"] ?>"><?= $issue["user"] ?></span></li>
                                                            </ul>
                                                        <?php endif ?>

                                                        <div class="col-6 d-flex justify-content-end">
                                                            <span class="fs-14"><i class="far fa-clock me-2"></i>Due in 4
                                                                days</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
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
            $('#sprint_id, #user_id').change(function() {
                ajaxCall();
            });
        });

        function ajaxCall() {
            var sprintId = $('#sprint_id').val();
            var userId = $('#user_id').val();
            $.ajax({
                url: 'board/filter_board',
                type: 'POST',
                data: {
                    sprint_id: sprintId,
                    user_id: userId
                },
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX Success:', response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    </script>
</body>

</html>