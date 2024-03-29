<?php $this->load->view('includes/header'); ?>
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
                                    <form class="row">
                                        <div class="col-lg-6">
                                            <select class="form-select">
                                                <?php foreach ($sprints as $sprint) : ?>
                                                    <option value="<?=$sprint["id"]?>"><?=$sprint["title"]?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-select">
                                                <option value="tmonth" selected>Member</option>
                                                <?php foreach ($system_users as $system_user) : ?>
                                                    <?php if ($system_user->active == '1') : ?>
                                                        <option value="lmonth"><?=$system_user->first_name.' '.$system_user->last_name?></option>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </form>
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
                                            <h4 class="mb-0"><?=$task_status["title"]?></h4>
                                        </div>
                                    </div>
                                    <?php foreach ($issues as $issue) : ?>
                                        <?php if ($issue["status"] == $task_status["id"]) : ?>
                                            <div class="card draggable-handle draggable">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="sub-title">
                                                            <svg class="me-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="5" cy="5" r="5" fill="#FFA7D7" />
                                                            </svg>
                                                            Deisgner
                                                        </span>
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
                                                    <h5 class="mb-0"><a href="javascript:void(0);" class="text-black">Create
                                                            wireframe for landing page phase 1</a></h5>
                                                    <div class="progress default-progress my-4">
                                                        <div class="progress-bar bg-design progress-animated" style="width: 45%; height:7px;" role="progressbar">
                                                            <span class="sr-only">45% Complete</span>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between align-items-center kanban-user">
                                                        <ul class="users col-6">
                                                            <li><img src="<?= base_url('assets2/images/contacts/pic11.jpg') ?>" alt=""></li>
                                                            <li><img src="<?= base_url('assets2/images/contacts/pic22.jpg') ?>" alt=""></li>
                                                            <li><img src="<?= base_url('assets2/images/contacts/pic33.jpg') ?>" alt=""></li>
                                                        </ul>
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

</body>

</html>