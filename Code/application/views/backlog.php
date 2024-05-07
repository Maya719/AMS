<?php $this->load->view('includes/header'); ?>
<style>
    .hidden {
        display: none;
    }

    .drag-drop {
        max-height: 380px;
        overflow: auto;
    }

    .highlight-drop {
        border: 2px dashed #5cb85c;
        background-color: #f0f8ff;
    }

    .drag-item {
        cursor: move;
    }

    .fa-solid {
        font-size: 10px;
    }

    .dragging {
        border-radius: 5px;
        box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);
        z-index: 999;
        background-color: #FFFFFF;
        width: 100%;
    }

    .no-overflow {
        overflow: visible !important;
        max-height: 380px;
    }

    .drop-area {
        border: 2px dashed #5cb85c;
        background-color: #f0f8ff;
        border-radius: 8px;
        padding: 70px;
        text-align: center;
        cursor: pointer;
        display: none;
    }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
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
            <div class="container-fluid">

                <div class="row d-flex justify-content-end">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header pb-0 border-0 mb-2">
                                <!-- <p><?= var_dump(json_encode($issues[0])) ?></p> -->
                                <div>
                                    <h4 class="card-title">BackLog</h4>
                                    <!-- <p class="mb-0">8 Issues</p> -->
                                </div>
                                <?php if ($this->ion_auth->is_admin() || permissions('project_create')) : ?>
                                    <div class="d-flex">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#sprint-add-modal">+ Sprint</a>
                                    </div>
                                <?php endif ?>

                            </div>
                            <div class="card-body px-0 py-2 drag-drop" data-sprint-id="0">
                                <div class="drop-area" id="dropArea">
                                    <span class="drop-text">Your <b>Backlog</b> is empty</span>
                                </div>
                                <?php foreach ($issues as $issue) : ?>
                                    <?php if (!$issue["sprint_id"]) : ?>
                                        <div class="msg-bx d-flex justify-content-between align-items-center drag-item" data-issue-id="<?= $issue["id"] ?>">
                                            <div class="ms-3 w-100">
                                                <a href="javascript:void(0);" class="d-flex btn-detail-model" data-id="<?= $issue["id"] ?>" data-bs-toggle="modal" data-bs-target="#issue-detail-modal">
                                                    <?php if ($issue["issue_type"] == 'epic') : ?>
                                                        <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#0055CC" xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="24" height="24" fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z" fill="#0055CC" />
                                                        </svg>
                                                        <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                    <?php elseif ($issue["issue_type"] == 'story') : ?>
                                                        <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#9F8FEF" xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="24" height="24" fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z" fill="#9F8FEF" />
                                                        </svg>
                                                        <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                    <?php else : ?>
                                                        <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#216E4E" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.7649 9.89758C7.7503 9.64424 7.75 9.30433 7.75 8.8076V2.06874C8.9058 2 10.2996 2 12 2C13.7004 2 15.0942 2 16.25 2.06874V8.8076C16.25 9.30433 16.2497 9.64424 16.2351 9.89758C16.22 10.1601 16.1923 10.2408 16.1854 10.2563C16.0383 10.5876 15.6753 10.7662 15.323 10.6807C15.3066 10.6767 15.2257 10.6493 15.0085 10.5012C14.7989 10.3582 14.5294 10.151 14.1358 9.84799L14.0688 9.79636C13.6986 9.51094 13.4101 9.28851 13.0958 9.15196C12.3968 8.84828 11.6032 8.84828 10.9042 9.15196C10.5899 9.28851 10.3014 9.51094 9.9312 9.79636L9.86419 9.84799C9.47062 10.151 9.20112 10.3582 8.99148 10.5012C8.77428 10.6493 8.69342 10.6767 8.67695 10.6807C8.32471 10.7662 7.96171 10.5876 7.81457 10.2563C7.80769 10.2408 7.78003 10.1601 7.7649 9.89758Z" fill="#216E4E" />
                                                            <path d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.1485 2.78043 5.02727 2.4159 6.25 2.22164L6.25 8.831C6.25 9.29858 6.24999 9.6821 6.26739 9.98389C6.28454 10.2816 6.32145 10.5899 6.44371 10.8652C6.88513 11.859 7.97413 12.3949 9.03087 12.1383C9.32356 12.0673 9.59039 11.9084 9.83672 11.7404C10.0864 11.57 10.3903 11.336 10.7608 11.0508L10.7793 11.0365C11.2487 10.6751 11.3808 10.5804 11.5019 10.5277C11.8196 10.3897 12.1804 10.3897 12.4981 10.5277C12.6192 10.5804 12.7513 10.6751 13.2207 11.0365L13.2392 11.0508C13.6097 11.336 13.9136 11.57 14.1633 11.7404C14.4096 11.9084 14.6764 12.0673 14.9691 12.1383C16.0259 12.3949 17.1149 11.859 17.5563 10.8652C17.6786 10.5899 17.7155 10.2816 17.7326 9.98389C17.75 9.68211 17.75 9.29859 17.75 8.83102V2.22164C18.9727 2.4159 19.8515 2.78043 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="#216E4E" />
                                                        </svg>
                                                        <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                    <?php endif ?>
                                                    <h5 class="ms-2"><?= $issue["title"] ?></h5>
                                                </a>
                                            </div>

                                            <div class="col-1 my-1">
                                                <input type="number" min="0" class="form-control storypoint" name="story-point" value="<?= $issue["story_points"] ?>" placeholder="0" data-issue-id="<?= $issue["id"]; ?>">
                                            </div>

                                            <div class="col-auto ms-2">
                                                <select class="me-sm-2 form-control wide issue_user" id="inlineFormCustomSelect12" data-issue-id="<?= $issue["id"]; ?>">
                                                    <option value="">Member</option>
                                                    <?php foreach ($issue["project_users"] as $system_user) {
                                                        if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                            <option value="<?= htmlspecialchars($system_user->id) ?>" <?= ($system_user->id ==  $issue["user"]) ? 'selected' : '' ?>><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>

                                            <?php if ($this->ion_auth->is_admin() || permissions('task_status')) : ?>
                                                <div class="col-auto my-1 ms-2">
                                                    <select class="me-sm-2 form-control wide issue_status" id="inlineFormCustomSelect4" data-issue-id="<?= $issue["id"]; ?>">
                                                        <?php foreach ($task_statuses as $task_status) : ?>
                                                            <option value="<?= $task_status["id"] ?>" <?= ($issue["status"] == $task_status["id"]) ? 'selected' : '' ?>><?= $task_status["title"] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            <?php endif ?>
                                            <?php if ($this->ion_auth->is_admin() || permissions('task_delete') || permissions('task_edit')) : ?>
                                                <div class="dropdown">
                                                    <div class="btn-link" data-bs-toggle="dropdown">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <?php if ($this->ion_auth->is_admin() || permissions('task_delete')) : ?>
                                                            <a class="dropdown-item delete_issue" data-issue-id="<?= $issue["id"]; ?>" href="javascript:void(0)">Delete</a>
                                                        <?php endif ?>
                                                        <?php if ($this->ion_auth->is_admin() || permissions('task_edit')) : ?>
                                                            <a class="dropdown-item" href="<?= base_url('issues/edit/' . $issue["id"]) ?>">Edit</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <?php if ($this->ion_auth->is_admin() || permissions('task_create')) : ?>
                                    <div class="col-1">
                                        <a href="<?= base_url('issues') ?>" class="btn btn-primary btn-block btn-xs">+ Issue</a>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>
                    <?php foreach ($sprints as $sprint) : ?>
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header pb-0 border-0 mb-2">
                                    <div>
                                        <h4 class="card-title" id="editableField"><?= $sprint["title"] ?></h4>
                                        <p class="mb-0"><?= $sprint["starting_date"] ?> - <?= $sprint["ending_date"] ?></p>
                                    </div>
                                    <?php if ($this->ion_auth->is_admin() || permissions('project_create') || permissions('task_create') || permissions('task_status') || permissions('task_edit') || permissions('task_delete')) : ?>
                                        <div class="d-flex">
                                            <?php if ($this->ion_auth->is_admin() || permissions('task_create')) : ?>
                                                <?php if ($sprint["status"] == 0) : ?>
                                                    <a href="javascript:void(0);" data-id="<?= $sprint["id"] ?>" class="btn btn-primary btn-xs start_sprint">Start Sprint</a>
                                                <?php elseif ($sprint["status"] == 1) : ?>
                                                    <a href="javascript:void(0);" data-id="<?= $sprint["id"] ?>" class="btn btn-primary btn-xs complete_sprint">Complete Sprint</a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" data-id="<?= $sprint["id"] ?>" class="btn btn-primary btn-xs" disabled>Completed</a>
                                                <?php endif ?>
                                            <?php endif ?>

                                            <?php if ($this->ion_auth->is_admin() || permissions('task_delete') || permissions('task_edit')) : ?>
                                                <div class="dropdown ms-2">
                                                    <div class="btn-link mt-2" data-bs-toggle="dropdown">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 12C7 13.1046 6.10457 14 5 14C3.89543 14 3 13.1046 3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12Z" fill="#A5A5A5" />
                                                            <path d="M14 12C14 13.1046 13.1046 14 12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12Z" fill="#A5A5A5" />
                                                            <path d="M21 12C21 13.1046 20.1046 14 19 14C17.8954 14 17 13.1046 17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12Z" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <?php if ($this->ion_auth->is_admin() || permissions('task_delete')) : ?>
                                                            <a class="dropdown-item delete_sprint" data-id="<?= $sprint["id"] ?>" href="javascript:void(0)">Delete Sprint</a>
                                                        <?php endif ?>
                                                        <?php if ($this->ion_auth->is_admin() || permissions('task_edit')) : ?>
                                                            <a class="dropdown-item edit_sprint" href="javascript:void(0)" data-id="<?= $sprint["id"] ?>" data-bs-toggle="modal" data-bs-target="#sprint-edit-modal">Edit Sprint</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                </div>

                                <div class="card-body px-0 py-2 drag-drop" data-sprint-id="<?= $sprint["id"] ?>">
                                    <div class="drop-area" id="dropArea">
                                        <?php if ($sprint["status"] == 0) : ?>
                                            <span class="drop-text">Drag issue from <b>Backlog</b> section or create new issue to plan the work for this<br> sprint, Select <b>Start Sprint</b> when you are ready.</span>
                                        <?php elseif ($sprint["status"] == 1) : ?>
                                            <span class="drop-text">Drag issue from <b>Backlog</b> section or create new issue to plan the work for this<br> sprint, Select <b>Start Sprint</b> when you are ready.</span>
                                        <?php else : ?>
                                            <span class="drop-text">Drag issue from <b>Backlog</b> section or create new issue to plan the work for this<br> sprint, Select <b>Start Sprint</b> when you are ready.</span>
                                        <?php endif ?>
                                    </div>
                                    <?php foreach ($issues as $issue) : ?>
                                        <?php if ($issue["sprint_id"] == $sprint["id"]) : ?>
                                            <div class="msg-bx d-flex justify-content-between align-items-center drag-item" data-issue-id="<?= $issue["id"] ?>">
                                                <div class="ms-3 w-100">
                                                    <a href="javascript:void(0);" class="d-flex btn-detail-model" data-id="<?= $issue["id"] ?>" data-bs-toggle="modal" data-bs-target="#issue-detail-modal">
                                                        <?php if ($issue["issue_type"] == 'epic') : ?>
                                                            <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#0055CC" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="24" height="24" fill="white" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z" fill="#0055CC" />
                                                            </svg>
                                                            <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                        <?php elseif ($issue["issue_type"] == 'story') : ?>
                                                            <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#9F8FEF" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="24" height="24" fill="white" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z" fill="#9F8FEF" />
                                                            </svg>
                                                            <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                        <?php else : ?>
                                                            <svg style="margin-top: 2px;" width="20" height="20" viewBox="0 0 24 24" fill="#216E4E" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7.7649 9.89758C7.7503 9.64424 7.75 9.30433 7.75 8.8076V2.06874C8.9058 2 10.2996 2 12 2C13.7004 2 15.0942 2 16.25 2.06874V8.8076C16.25 9.30433 16.2497 9.64424 16.2351 9.89758C16.22 10.1601 16.1923 10.2408 16.1854 10.2563C16.0383 10.5876 15.6753 10.7662 15.323 10.6807C15.3066 10.6767 15.2257 10.6493 15.0085 10.5012C14.7989 10.3582 14.5294 10.151 14.1358 9.84799L14.0688 9.79636C13.6986 9.51094 13.4101 9.28851 13.0958 9.15196C12.3968 8.84828 11.6032 8.84828 10.9042 9.15196C10.5899 9.28851 10.3014 9.51094 9.9312 9.79636L9.86419 9.84799C9.47062 10.151 9.20112 10.3582 8.99148 10.5012C8.77428 10.6493 8.69342 10.6767 8.67695 10.6807C8.32471 10.7662 7.96171 10.5876 7.81457 10.2563C7.80769 10.2408 7.78003 10.1601 7.7649 9.89758Z" fill="#216E4E" />
                                                                <path d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.1485 2.78043 5.02727 2.4159 6.25 2.22164L6.25 8.831C6.25 9.29858 6.24999 9.6821 6.26739 9.98389C6.28454 10.2816 6.32145 10.5899 6.44371 10.8652C6.88513 11.859 7.97413 12.3949 9.03087 12.1383C9.32356 12.0673 9.59039 11.9084 9.83672 11.7404C10.0864 11.57 10.3903 11.336 10.7608 11.0508L10.7793 11.0365C11.2487 10.6751 11.3808 10.5804 11.5019 10.5277C11.8196 10.3897 12.1804 10.3897 12.4981 10.5277C12.6192 10.5804 12.7513 10.6751 13.2207 11.0365L13.2392 11.0508C13.6097 11.336 13.9136 11.57 14.1633 11.7404C14.4096 11.9084 14.6764 12.0673 14.9691 12.1383C16.0259 12.3949 17.1149 11.859 17.5563 10.8652C17.6786 10.5899 17.7155 10.2816 17.7326 9.98389C17.75 9.68211 17.75 9.29859 17.75 8.83102V2.22164C18.9727 2.4159 19.8515 2.78043 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="#216E4E" />
                                                            </svg>
                                                            <span class="ms-3" style="margin-top: 2px;"><?= getTitleAcronym($issue["project_title"]) ?>-0<?= $issue["id"] ?></span>
                                                        <?php endif ?>
                                                        <h5 class="ms-2"><?= $issue["title"] ?></h5>
                                                    </a>
                                                </div>
                                                <div class="col-1 my-1">
                                                    <input type="number" min="0" class="form-control storypoint" value="<?= $issue["story_points"] ?>" name="story-point" placeholder="0" data-issue-id="<?= $issue["id"]; ?>">
                                                </div>

                                                <div class="col-auto ms-2">
                                                    <select class="me-sm-2 form-control wide issue_user" id="inlineForm CustomSelect12" data-issue-id="<?= $issue["id"]; ?>">
                                                        <option value="" selected>Member</option>
                                                        <?php foreach ($issue["project_users"] as $system_user) {
                                                            if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                                <option value="<?= htmlspecialchars($system_user->id) ?>" <?= ($system_user->id ==  $issue["user"]) ? 'selected' : '' ?>><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="col-auto my-1 ms-2">
                                                    <select class="me-sm-2 form-control wide issue_status" id="inlineFormCustomSelect4" data-issue-id="<?= $issue["id"]; ?>">
                                                        <?php foreach ($task_statuses as $task_status) : ?>
                                                            <option value="<?= $task_status["id"] ?>" <?= ($issue["status"] == $task_status["id"]) ? 'selected' : '' ?>><?= $task_status["title"] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>

                                                <div class="dropdown">
                                                    <div class="btn-link" data-bs-toggle="dropdown">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
                                                            <circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item delete_issue" data-issue-id="<?= $issue["id"]; ?>" href="javascript:void(0)">Delete</a>
                                                        <a class="dropdown-item" href="<?= base_url('issues/edit/' . $issue["id"]) ?>">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <?php if ($this->ion_auth->is_admin() || permissions('task_create')) : ?>
                                        <div class="col-1">
                                            <a href="<?= base_url('issues') ?>" class="btn btn-primary btn-block btn-xs">+ Issue</a>
                                        </div>
                                    <?php endif ?>
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
        <div class="modal fade" id="sprint-add-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('board/create_sprint') ?>" method="post" id="modal-add-sprint-part">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('sprint') ? $this->lang->line('sprint') : 'Sprint Name' ?><span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required="">
                                </div>
                                <div class="col-xl-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?></label>
                                    <select name="duration" class="form-control">
                                        <option value="1"><?= $this->lang->line('week1') ? $this->lang->line('week1') : '1 Week' ?></option>
                                        <option value="2"><?= $this->lang->line('week2') ? $this->lang->line('week2') : '2 Weeks' ?></option>
                                        <option value="3"><?= $this->lang->line('week3') ? $this->lang->line('week3') : '3 Weeks' ?></option>
                                        <option value="4"><?= $this->lang->line('week4') ? $this->lang->line('week4') : '4 Weeks' ?></option>
                                        <option value="5"><?= $this->lang->line('custom') ? $this->lang->line('custom') : 'Custom' ?></option>
                                    </select>
                                </div>
                                <div class="row" id="dates" style="display: none;">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="starting_date" name="starting_date" class="form-control datepicker-default" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="starting_time" name="starting_time" class="form-control timepicker" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="ending_date" name="ending_date" class="form-control datepicker-default" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('ending_Time') ? $this->lang->line('ending_Time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="ending_time" name="ending_time" class="form-control timepicker" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?= $this->lang->line('sprint_goal') ? $this->lang->line('sprint_goal') : 'Sprint goal' ?><span class="text-danger">*</span></label>
                                    <textarea type="text" name="goal" class="form-control" required=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-create-sprint btn-block btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="sprint-edit-modal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= base_url('board/edit_sprint') ?>" method="post" id="modal-edit-sprint-part">
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('sprint') ? $this->lang->line('sprint') : 'Sprint Name' ?><span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" required="">
                                </div>
                                <div class="col-xl-12 form-group mb-3">
                                    <label class="col-form-label"><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?></label>
                                    <select name="duration" class="form-control" id="duration">
                                        <option value="1"><?= $this->lang->line('week1') ? $this->lang->line('week1') : '1 Week' ?></option>
                                        <option value="2"><?= $this->lang->line('week2') ? $this->lang->line('week2') : '2 Weeks' ?></option>
                                        <option value="3"><?= $this->lang->line('week3') ? $this->lang->line('week3') : '3 Weeks' ?></option>
                                        <option value="4"><?= $this->lang->line('week4') ? $this->lang->line('week4') : '4 Weeks' ?></option>
                                        <option value="5"><?= $this->lang->line('custom') ? $this->lang->line('custom') : 'Custom' ?></option>
                                    </select>
                                </div>
                                <div class="row" id="dates2" style="display: none;">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="edit_starting_date" name="starting_date" class="form-control datepicker-default" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('starting_time') ? $this->lang->line('starting_time') : 'Starting Time' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="edit_starting_time" name="starting_time" class="form-control timepicker" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="edit_ending_date " name="ending_date" class="form-control datepicker-default" required="">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="col-form-label"><?= $this->lang->line('ending_Time') ? $this->lang->line('ending_Time') : 'Ending Time' ?><span class="text-danger">*</span></label>
                                        <input type="text" id="edit_ending_time " name="ending_time" class="form-control timepicker" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label"><?= $this->lang->line('sprint_goal') ? $this->lang->line('sprint_goal') : 'Sprint goal' ?><span class="text-danger">*</span></label>
                                    <textarea type="text" name="goal" id="goal" class="form-control" required=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-edit-sprint btn-block btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#contact"><i class="fa-solid fa-diagram-project me-2"></i> Project </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#home"><i class="fa-solid fa-arrow-rotate-left me-2"></i> Sprint </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile"><i class="fa-solid fa-anchor me-2"></i> Additional Information</a>
                                </li>
                            </ul>
                            <div class="tab-content">
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
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="home" role="tabpanel">
                                    <div class="pt-2">
                                        <h4 id="sprint_title"></h4>
                                        <p id="sprint_goal"></p>
                                        <div class="cm-content-body publish-content form excerpt" id="sprint_dates">

                                        </div>
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
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            updateItemCounts();
            $(".drag-item").draggable({
                revert: "invalid",
                containment: "drag-drop",
                scroll: true,
                start: function(event, ui) {
                    $(this).addClass("dragging");
                    $(".drag-drop").addClass("no-overflow");
                },
                stop: function(event, ui) {
                    $(this).removeClass("dragging");
                    $(".drag-drop").removeClass("no-overflow");
                }
            });



            $(".drag-drop").droppable({
                accept: ".drag-item",
                drop: function(event, ui) {
                    var droppedItem = ui.draggable;
                    var currentDropArea = $(this);

                    var issueId = droppedItem.data("issue-id");
                    var sprintId = currentDropArea.data("sprint-id");
                    var movedToSprintId = currentDropArea.data("sprint-id");

                    droppedItem.appendTo(currentDropArea).animate({
                        opacity: 1
                    }, 200);
                    droppedItem.css({
                        top: 0,
                        left: 0
                    });


                    UpdateIssueSprint(issueId, movedToSprintId);
                    updateItemCounts();
                }
            });

            function UpdateIssueSprint(issueId, SprintId) {
                console.log("Issue ID:", issueId);
                console.log("Sprint ID (Moved To):", SprintId);
                $.ajax({
                    url: '<?= base_url('issues/update_issues_sprint') ?>',
                    type: 'POST',
                    data: {
                        issueId: issueId,
                        SprintId: SprintId
                    },
                    success: function(response) {
                        var tableData = JSON.parse(response);
                        console.log(tableData);
                        // showTable(tableData);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            function updateItemCounts() {
                $(".drag-drop").each(function() {
                    var itemCount = $(this).find('.drag-item').length;
                    var dropArea = $(this).find('.drop-area');
                    if (itemCount === 0) {
                        dropArea.css('display', 'block');
                    } else {
                        dropArea.css('display', 'none');
                    }
                });
            }
        });
        $(document).ready(function() {
            function toggleDatesVisibility() {
                var durationSelect = $('select[name="duration"]');
                var datesContainer = $('#dates');

                durationSelect.on('change', function() {
                    var selectedDuration = $(this).val();
                    if (selectedDuration === '5') {
                        datesContainer.show();
                    } else {
                        datesContainer.hide();
                    }
                });

                durationSelect.trigger('change');
            }

            toggleDatesVisibility();
        });
        $("#sprint-edit-modal").on('click', '.btn-edit-sprint', function(e) {
            var modal = $('#sprint-edit-modal');
            var form = $('#modal-edit-sprint-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                beforeSend: function() {
                    $(".modal-body").append(ModelProgress);
                },
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {
                        location.reload();
                    } else {
                        modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                },
                complete: function() {
                    $(".loader-progress").remove();
                }
            });

            e.preventDefault();
        });
        $("#sprint-add-modal").on('click', '.btn-create-sprint', function(e) {
            var modal = $('#sprint-add-modal');
            var form = $('#modal-add-sprint-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                beforeSend: function() {
                    $(".modal-body").append(ModelProgress);
                },
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {

                        location.reload();
                    } else {

                        modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                },
                complete: function() {
                    $(".loader-progress").remove();
                }
            });

            e.preventDefault();
        });
        var time24 = false;
        $('.timepicker').timepicker({
            format: 'HH:mm',
            showMeridian: true,
            time24Hour: time24
        });
        $(document).on('change', '.issue_user', function(e) {
            var issue = $(this).data('issue-id');
            var user = $(this).val();
            console.log(issue);
            console.log(user);
            $.ajax({
                url: '<?= base_url('issues/update_issues_user') ?>',
                type: 'POST',
                data: {
                    issue: issue,
                    user: user
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $(document).on('change', '.issue_status', function(e) {
            var issue = $(this).data('issue-id');
            var status = $(this).val();
            console.log(issue);
            console.log(status);
            $.ajax({
                url: '<?= base_url('issues/update_issues_status') ?>',
                type: 'POST',
                data: {
                    issue: issue,
                    status: status
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $(document).on('keyup', '.storypoint', function(e) {
            var issue = $(this).data('issue-id');
            var story_points = $(this).val();
            console.log(issue);
            console.log(story_points);
            $.ajax({
                url: '<?= base_url('issues/update_issues_story_points') ?>',
                type: 'POST',
                data: {
                    issue: issue,
                    story_points: story_points
                },
                success: function(response) {
                    var tableData = JSON.parse(response);
                    console.log(tableData);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        $(document).on('click', '.start_sprint', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to start the sprint!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'backlog/start_sprint/' + id,
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
        $(document).on('click', '.edit_sprint', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            $.ajax({
                type: "POST",
                url: base_url + 'backlog/get_sprint_by_id/' + id,
                data: "id=" + id,
                dataType: "json",
                success: function(result) {
                    console.log(result.sprint);
                    $('#name').val(result.sprint.title);
                    $('#update_id').val(result.sprint.id);
                    $('#goal').val(result.sprint.goal);
                    if (result.sprint.duration) {
                        $('#duration').val(result.sprint.duration);
                        toggleDatesVisibility2();
                    } else {
                        $('#duration').val(5);
                        toggleDatesVisibility2();
                        console.log(result.sprint.starting_date);
                        $('#edit_starting_date').daterangepicker({
                            locale: {
                                format: date_format_js
                            },
                            singleDatePicker: true,
                            startDate: result.sprint.starting_date,
                        });
                        $('#edit_starting_time').timepicker({
                            format: 'HH:mm',
                            showMeridian: true,
                            time24Hour: time24
                        });
                        $('#edit_starting_time').timepicker('setTime', result.sprint.starting_date);

                        $('#edit_ending_date').daterangepicker({
                            locale: {
                                format: date_format_js
                            },
                            singleDatePicker: true,
                            startDate: result.sprint.ending_date,
                        });
                        $('#edit_ending_time').timepicker({
                            format: 'HH:mm',
                            showMeridian: true,
                            time24Hour: time24
                        });
                        $('#edit_ending_time').timepicker('setTime', result.sprint.ending_time);

                    }


                }
            });

            function toggleDatesVisibility2() {
                var durationSelect = $('#duration');
                var datesContainer = $('#dates2');

                durationSelect.on('change', function() {
                    var selectedDuration = $(this).val();
                    if (selectedDuration === '5') {
                        datesContainer.show();
                    } else {
                        datesContainer.hide();
                    }
                });

                durationSelect.trigger('change');
            }
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
                    console.log(result);
                    $("#issue_title").html(result.issue.title);
                    $("#issue_description").html(result.issue.description);
                    if (result.issue.issue_type == 'task') {
                        $("#issue_type").html('Task');
                    } else if (result.issue.issue_type == 'epic') {
                        $("#issue_type").html('Epic');
                    } else {
                        $("#issue_type").html('Story');
                    }

                    if (result.issue.priority == 1) {
                        $("#issue_priority").html(result.priority.title + ' <i class="fa-solid fa-angle-up text-' + result.priority.class + '"></i>');
                    } else if (result.issue.priority != 1) {
                        $("#issue_priority").html(result.priority.title + ' <i class="fa-solid fa-angles-up text-' + result.priority.class + '"></i>');
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
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>

    <?php
    function getTitleAcronym($title)
    {
        $words = explode(" ", $title); // Split title into words

        $acronym = "";
        $num_words = count($words);
        $limit = min($num_words, 3);

        if ($num_words == 1) {
            // If there's only one word, get the first three letters
            $acronym = strtoupper(substr($words[0], 0, 3));
        } else {
            // If there are multiple words, get the first letter of each word
            for ($i = 0; $i < $limit; $i++) {
                $acronym .= strtoupper(substr($words[$i], 0, 1)); // Get the first letter of each word and convert it to uppercase
            }
        }
        return $acronym;
    }
    ?>



</body>

</html>