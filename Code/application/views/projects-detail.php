<?php $this->load->view('includes/header'); ?>
<style>
  /* 1.10 Dropzone */
  .dropzone {
    border: 2px dashed var(--theme-color);
    min-height: 240px;
    text-align: center;
  }

  .dropzone .dz-message {
    font-size: 24px;
    color: #34395e;
    margin: 3.4em;
  }

  .dropzone .dz-preview .dz-details {
    padding: 2.2em 1em;
  }

  .dropzone .dz-preview .dz-image {
    border-radius: 3px;
  }

  @media (max-width: 575.98px) {
    .dropzone .dz-message {
      margin: 2em;
    }
  }

  @media (min-width: 576px) and (max-width: 767.98px) {
    .dropzone .dz-message {
      margin: 2.75em;
    }
  }
</style>
<style>
  .image-radio-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    margin-right: 10px;
  }

  .image-radio-input {
    display: none;
  }

  .image-radio-label svg {
    width: 200px;
    height: 200px;
    fill: #000000;
    border: 2px solid transparent;
    border-radius: 5px;
    margin-bottom: 5px;
  }

  .image-label-text {
    font-size: 14px;
  }

  .image-radio-input:checked+.image-radio-label svg {
    border-color: var(--theme-color);
  }
</style>
<link rel="stylesheet" href="<?= base_url('assets/modules/multiselect/multselect.css') ?>">
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


      <?php
      if (isset($project[0]) && !empty($project[0])) {
        $project = $project[0];
      ?>
        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
              <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('projects') ?>">Projects</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
            </ol>
          </nav>
          <div class="card">
            <div class="card-body">
              <?php if ($project['dash_type'] == 1) : ?>
                <a class="btn btn-sm btn-outline-primary" href="<?= base_url('backlog/project/' . $project["id"]) ?>" aria-expanded="false">
                  <i class="fas fa-clone"></i>
                  <span class="nav-text">Backlog</span>
                </a>
              <?php endif ?>
              <a class="btn btn-sm btn-outline-primary" href="<?= base_url('board/tasks/' . $project["id"]) ?>" aria-expanded="false">
                <i class="fas fa-table"></i>
                <span class="nav-text">Board</span>
              </a>
              <a class="btn btn-sm btn-outline-primary" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-chart-line"></i>
                <span class="nav-text">Analytics</span>
              </a>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <h4>
                    <a><?= htmlspecialchars($project['title']) ?></a>
                  </h4>
                  <h5>
                    <?php
                    if ($project['dash_type'] == 0) {
                    ?><svg fill="#000000" width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9,3 L9,21 L15,21 L15,3 L9,3 Z M8,3 L3.5,3 C2.67157288,3 2,3.67157288 2,4.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 L8,21 L8,3 Z M16,3 L16,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,4.5 C22,3.67157288 21.3284271,3 20.5,3 L16,3 Z M1,4.5 C1,3.11928813 2.11928813,2 3.5,2 L20.5,2 C21.8807119,2 23,3.11928813 23,4.5 L23,19.5 C23,20.8807119 21.8807119,22 20.5,22 L3.5,22 C2.11928813,22 1,20.8807119 1,19.5 L1,4.5 Z M4,6 L6,6 C6.55228475,6 7,6.44771525 7,7 L7,8 C7,8.55228475 6.55228475,9 6,9 L4,9 C3.44771525,9 3,8.55228475 3,8 L3,7 C3,6.44771525 3.44771525,6 4,6 Z M4,10 L6,10 C6.55228475,10 7,10.4477153 7,11 L7,12 C7,12.5522847 6.55228475,13 6,13 L4,13 C3.44771525,13 3,12.5522847 3,12 L3,11 C3,10.4477153 3.44771525,10 4,10 Z M11,6 L13,6 C13.5522847,6 14,6.44771525 14,7 L14,8 C14,8.55228475 13.5522847,9 13,9 L11,9 C10.4477153,9 10,8.55228475 10,8 L10,7 C10,6.44771525 10.4477153,6 11,6 Z M18,6 L20,6 C20.5522847,6 21,6.44771525 21,7 L21,8 C21,8.55228475 20.5522847,9 20,9 L18,9 C17.4477153,9 17,8.55228475 17,8 L17,7 C17,6.44771525 17.4477153,6 18,6 Z M18,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,12 C21,12.5522847 20.5522847,13 20,13 L18,13 C17.4477153,13 17,12.5522847 17,12 L17,11 C17,10.4477153 17.4477153,10 18,10 Z M18,14 L20,14 C20.5522847,14 21,14.4477153 21,15 L21,16 C21,16.5522847 20.5522847,17 20,17 L18,17 C17.4477153,17 17,16.5522847 17,16 L17,15 C17,14.4477153 17.4477153,14 18,14 Z M4,7 L4,8 L6,8 L6,7 L4,7 Z M4,11 L4,12 L6,12 L6,11 L4,11 Z M11,7 L11,8 L13,8 L13,7 L11,7 Z M18,7 L18,8 L20,8 L20,7 L18,7 Z M18,11 L18,12 L20,12 L20,11 L18,11 Z M18,15 L18,16 L20,16 L20,15 L18,15 Z M3.5,5 C3.22385763,5 3,4.77614237 3,4.5 C3,4.22385763 3.22385763,4 3.5,4 L6.5,4 C6.77614237,4 7,4.22385763 7,4.5 C7,4.77614237 6.77614237,5 6.5,5 L3.5,5 Z M10.5,5 C10.2238576,5 10,4.77614237 10,4.5 C10,4.22385763 10.2238576,4 10.5,4 L13.5,4 C13.7761424,4 14,4.22385763 14,4.5 C14,4.77614237 13.7761424,5 13.5,5 L10.5,5 Z M17.5,5 C17.2238576,5 17,4.77614237 17,4.5 C17,4.22385763 17.2238576,4 17.5,4 L20.5,4 C20.7761424,4 21,4.22385763 21,4.5 C21,4.77614237 20.7761424,5 20.5,5 L17.5,5 Z" />
                      </svg>
                      Kanban
                    <?php
                    } else {
                    ?>
                      <svg fill="#000000" width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.3171203,20 L20.5,20 C20.7761424,20 21,20.2238576 21,20.5 C21,20.7761424 20.7761424,21 20.5,21 L3.5,21 C3.22385763,21 3,20.7761424 3,20.5 C3,20.2238576 3.22385763,20 3.5,20 L11.9975864,20 L11.9992783,19.9999948 C13.3169414,19.9980929 14.5879191,19.4831487 15.5355339,18.5355339 C17.4881554,16.5829124 17.4881554,13.4170876 15.5355339,11.4644661 C15.1550557,11.0839879 14.7285139,10.7776478 14.2738601,10.5454458 C14.254923,10.5373678 14.2363578,10.5280549 14.2182818,10.5174987 C12.5524962,9.69291702 10.5227538,9.8537508 8.99894709,11 L10.5,11 C10.7761424,11 11,11.2238576 11,11.5 C11,11.7761424 10.7761424,12 10.5,12 L7.5,12 C7.22385763,12 7,11.7761424 7,11.5 L7,8.5 C7,8.22385763 7.22385763,8 7.5,8 C7.77614237,8 8,8.22385763 8,8.5 L8,10.5276441 C9.46401314,9.21593206 11.4173682,8.74894646 13.2298049,9.12668728 C13.0840962,8.75531167 13,8.36566448 13,8 C13,6.34314575 14.3431458,5 16,5 L16.2928932,5 L16.1464466,4.85355339 C15.9511845,4.65829124 15.9511845,4.34170876 16.1464466,4.14644661 C16.3417088,3.95118446 16.6582912,3.95118446 16.8535534,4.14644661 L17.8535534,5.14644661 C18.0488155,5.34170876 18.0488155,5.65829124 17.8535534,5.85355339 L16.8535534,6.85355339 C16.6582912,7.04881554 16.3417088,7.04881554 16.1464466,6.85355339 C15.9511845,6.65829124 15.9511845,6.34170876 16.1464466,6.14644661 L16.2928932,6 L16,6 C14.8954305,6 14,6.8954305 14,8 C14,8.56129192 14.3301293,9.27278631 14.7516956,9.66637738 C15.2886433,9.94356402 15.792506,10.3072247 16.2426407,10.7573593 C18.5857864,13.1005051 18.5857864,16.8994949 16.2426407,19.2426407 C15.9569017,19.5283797 15.6466243,19.7813454 15.3171203,20 L15.3171203,20 Z" />
                      </svg>
                      Scrum
                    <?php
                    }
                    ?>
                  </h5>
                </div>
                <div class="card-body">
                  <!-- <div class="author-box-job text-<?= htmlspecialchars($project['project_class']) ?>"><?= htmlspecialchars($project['project_status']) ?></div> -->
                  <div class="author-box-description">
                    <p class="description-wrapper"><?= $project['description'] ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-<?= !empty($project['project_client']) ? 12 : 5 ?>">
              <div class="card <?= !empty($project['project_client']) ? '' : 'card-' . htmlspecialchars($project['project_class']) ?>">
                <div class="card-header">
                  <h4><?= $this->lang->line('task_overview') ? $this->lang->line('task_overview') : 'Task Overview' ?></h4>
                </div>
                <div class="card-body text-white text-black">
                  <ul class="list-group list-group-flush">
                    <!-- <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('days') ? $this->lang->line('days') : 'Days' ?> <?= htmlspecialchars($project['days_status']) ?></span><strong><?= htmlspecialchars($project['days_count']) ?></strong></li> -->
                    <!-- <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?></span><strong><?= htmlspecialchars($project['starting_date']) ?></strong></li> -->
                    <!-- <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('ending_date') ? $this->lang->line('ending_date') : 'Ending Date' ?></span><strong><?= htmlspecialchars($project['ending_date']) ?></strong></li> -->
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('total_tasks') ? $this->lang->line('total_tasks') : 'Total Tasks' ?></span><strong><?= htmlspecialchars($project['total_tasks']) ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('completed_tasks') ? $this->lang->line('completed_tasks') : 'Completed Tasks' ?></span><strong><?= htmlspecialchars($project['completed_tasks']) ?></strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="mb-0"><?= $this->lang->line('pending_tasks') ? $this->lang->line('pending_tasks') : 'Pending Tasks' ?></span><strong><?= htmlspecialchars($project['total_tasks']) - htmlspecialchars($project['completed_tasks']) ?></strong></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4><?= $this->lang->line('Tasks_overview') ? $this->lang->line('Tasks_overview') : 'Tasks Overview' ?></h4>
                </div>
                <div class="card-body p-2">
                  <div class="table-responsive">
                    <table id="project_performance_list" class="table table-sm mb-0">
                      <thead>
                        <tr>
                          <th><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?></th>
                          <th><?= $this->lang->line('completed') ? $this->lang->line('completed') : 'Completed Tasks' ?> / <?= $this->lang->line('task_count') ? $this->lang->line('task_count') : 'Total Tasks' ?></th>
                          <th><?= $this->lang->line('task_completeness_ratio') ? $this->lang->line('task_completeness_ratio') : 'Task Completeness Ratio' ?></th>
                        </tr>
                      </thead>
                      <tbody id="customers">
                        <?php foreach ($project["get_project_users_performance"] as $user) : ?>
                          <tr>
                            <td><a href="#" style="font-weight: bold;font-size: 12px;"><?= $user["first_name"] . ' ' . $user["last_name"] ?></a></td>
                            <td><?= $user["task_count"] ?></td>
                            <td><?= $user["performance"] ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <?php if ($project['dash_type'] == 1) : ?>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4><?= $this->lang->line('sprints_overview') ? $this->lang->line('sprints_overview') : 'Sprints Overview' ?></h4>
                  </div>
                  <div class="card-body p-2">
                    <div class="table-responsive">
                      <table id="project_sprints_list" class="table table-sm mb-0">
                        <thead>
                          <tr>
                            <th><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?></th>
                            <th><?= $this->lang->line('goal') ? $this->lang->line('goal') : 'Goal' ?></th>
                            <th><?= $this->lang->line('starting') ? $this->lang->line('starting') : 'Starting at' ?></th>
                            <th><?= $this->lang->line('ending') ? $this->lang->line('ending') : 'Ending at' ?></th>
                            <th><?= $this->lang->line('duration') ? $this->lang->line('duration') : 'Duration' ?></th>
                            <th><?= $this->lang->line('task_count') ? $this->lang->line('task_count') : 'Task Count' ?></th>
                            <th><?= $this->lang->line('total_effort_points') ? $this->lang->line('total_effort_points') : 'Comulative Effort Points' ?></th>
                          </tr>
                        </thead>
                        <tbody id="customers">
                          <?php foreach ($project["project_sprints"] as $sprint) : ?>
                            <tr>
                              <td><?= $sprint->title ?></td>
                              <td><?= $sprint->goal ?></td>
                              <td><?= $sprint->starting_date ?></td>
                              <td><?= $sprint->ending_date ?></td>
                              <td><?= $sprint->duration ?></td>
                              <td><?= $sprint->task_count ?></td>
                              <td><?= $sprint->total_story_points ?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif ?>
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h4><?= $this->lang->line('upload_project_files') ? $this->lang->line('upload_project_files') : 'Upload Project Files' ?></h4>
                </div>
                <div class="card-body">
                  <form action="<?= base_url('projects/upload-files/' . htmlspecialchars($project['id'])) ?>" class="dropzone" id="mydropzone">
                    <div class="fallback">
                      <input name="file" type="file" multiple />
                    </div>
                  </form>

                  <?php
                  if (!is_storage_limit_exceeded()) { ?>
                    <div class="alert alert-danger mt-2">
                      <?= $this->lang->line('storage_limit_exceeded') ? $this->lang->line('storage_limit_exceeded') : 'Storage Limit Exceeded' ?>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!-- ************************************* *****
    Model forms
  ****************************************************-->
    <form action="<?= base_url('projects/edit-project') ?>" method="post" id="form-project">
      <input type="hidden" name="update_id" value="<?= htmlspecialchars($project['id']) ?>">
      <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel">Project Type</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
              <input type="radio" id="radio1" name="board" value="0" class="image-radio-input">
              <label for="radio1" class="image-radio-label me-4">
                <svg fill="#000000" width="200" height="200" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9,3 L9,21 L15,21 L15,3 L9,3 Z M8,3 L3.5,3 C2.67157288,3 2,3.67157288 2,4.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 L8,21 L8,3 Z M16,3 L16,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,4.5 C22,3.67157288 21.3284271,3 20.5,3 L16,3 Z M1,4.5 C1,3.11928813 2.11928813,2 3.5,2 L20.5,2 C21.8807119,2 23,3.11928813 23,4.5 L23,19.5 C23,20.8807119 21.8807119,22 20.5,22 L3.5,22 C2.11928813,22 1,20.8807119 1,19.5 L1,4.5 Z M4,6 L6,6 C6.55228475,6 7,6.44771525 7,7 L7,8 C7,8.55228475 6.55228475,9 6,9 L4,9 C3.44771525,9 3,8.55228475 3,8 L3,7 C3,6.44771525 3.44771525,6 4,6 Z M4,10 L6,10 C6.55228475,10 7,10.4477153 7,11 L7,12 C7,12.5522847 6.55228475,13 6,13 L4,13 C3.44771525,13 3,12.5522847 3,12 L3,11 C3,10.4477153 3.44771525,10 4,10 Z M11,6 L13,6 C13.5522847,6 14,6.44771525 14,7 L14,8 C14,8.55228475 13.5522847,9 13,9 L11,9 C10.4477153,9 10,8.55228475 10,8 L10,7 C10,6.44771525 10.4477153,6 11,6 Z M18,6 L20,6 C20.5522847,6 21,6.44771525 21,7 L21,8 C21,8.55228475 20.5522847,9 20,9 L18,9 C17.4477153,9 17,8.55228475 17,8 L17,7 C17,6.44771525 17.4477153,6 18,6 Z M18,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,12 C21,12.5522847 20.5522847,13 20,13 L18,13 C17.4477153,13 17,12.5522847 17,12 L17,11 C17,10.4477153 17.4477153,10 18,10 Z M18,14 L20,14 C20.5522847,14 21,14.4477153 21,15 L21,16 C21,16.5522847 20.5522847,17 20,17 L18,17 C17.4477153,17 17,16.5522847 17,16 L17,15 C17,14.4477153 17.4477153,14 18,14 Z M4,7 L4,8 L6,8 L6,7 L4,7 Z M4,11 L4,12 L6,12 L6,11 L4,11 Z M11,7 L11,8 L13,8 L13,7 L11,7 Z M18,7 L18,8 L20,8 L20,7 L18,7 Z M18,11 L18,12 L20,12 L20,11 L18,11 Z M18,15 L18,16 L20,16 L20,15 L18,15 Z M3.5,5 C3.22385763,5 3,4.77614237 3,4.5 C3,4.22385763 3.22385763,4 3.5,4 L6.5,4 C6.77614237,4 7,4.22385763 7,4.5 C7,4.77614237 6.77614237,5 6.5,5 L3.5,5 Z M10.5,5 C10.2238576,5 10,4.77614237 10,4.5 C10,4.22385763 10.2238576,4 10.5,4 L13.5,4 C13.7761424,4 14,4.22385763 14,4.5 C14,4.77614237 13.7761424,5 13.5,5 L10.5,5 Z M17.5,5 C17.2238576,5 17,4.77614237 17,4.5 C17,4.22385763 17.2238576,4 17.5,4 L20.5,4 C20.7761424,4 21,4.22385763 21,4.5 C21,4.77614237 20.7761424,5 20.5,5 L17.5,5 Z" />
                </svg>
                <span class="image-label-text">Kanban</span>
              </label>
              <input type="radio" id="radio2" name="board" value="1" class="image-radio-input">
              <label for="radio2" class="image-radio-label ms-4">
                <svg fill="#000000" width="200" height="200" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.3171203,20 L20.5,20 C20.7761424,20 21,20.2238576 21,20.5 C21,20.7761424 20.7761424,21 20.5,21 L3.5,21 C3.22385763,21 3,20.7761424 3,20.5 C3,20.2238576 3.22385763,20 3.5,20 L11.9975864,20 L11.9992783,19.9999948 C13.3169414,19.9980929 14.5879191,19.4831487 15.5355339,18.5355339 C17.4881554,16.5829124 17.4881554,13.4170876 15.5355339,11.4644661 C15.1550557,11.0839879 14.7285139,10.7776478 14.2738601,10.5454458 C14.254923,10.5373678 14.2363578,10.5280549 14.2182818,10.5174987 C12.5524962,9.69291702 10.5227538,9.8537508 8.99894709,11 L10.5,11 C10.7761424,11 11,11.2238576 11,11.5 C11,11.7761424 10.7761424,12 10.5,12 L7.5,12 C7.22385763,12 7,11.7761424 7,11.5 L7,8.5 C7,8.22385763 7.22385763,8 7.5,8 C7.77614237,8 8,8.22385763 8,8.5 L8,10.5276441 C9.46401314,9.21593206 11.4173682,8.74894646 13.2298049,9.12668728 C13.0840962,8.75531167 13,8.36566448 13,8 C13,6.34314575 14.3431458,5 16,5 L16.2928932,5 L16.1464466,4.85355339 C15.9511845,4.65829124 15.9511845,4.34170876 16.1464466,4.14644661 C16.3417088,3.95118446 16.6582912,3.95118446 16.8535534,4.14644661 L17.8535534,5.14644661 C18.0488155,5.34170876 18.0488155,5.65829124 17.8535534,5.85355339 L16.8535534,6.85355339 C16.6582912,7.04881554 16.3417088,7.04881554 16.1464466,6.85355339 C15.9511845,6.65829124 15.9511845,6.34170876 16.1464466,6.14644661 L16.2928932,6 L16,6 C14.8954305,6 14,6.8954305 14,8 C14,8.56129192 14.3301293,9.27278631 14.7516956,9.66637738 C15.2886433,9.94356402 15.792506,10.3072247 16.2426407,10.7573593 C18.5857864,13.1005051 18.5857864,16.8994949 16.2426407,19.2426407 C15.9569017,19.5283797 15.6466243,19.7813454 15.3171203,20 L15.3171203,20 Z" />
                </svg>
                <span class="image-label-text">Scrum</span>
              </label>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
              <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" id="next-btn" data-bs-dismiss="modal" disabled>Next</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel2">Edit</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label class="col-form-label"><?= $this->lang->line('project_title') ? $this->lang->line('project_title') : 'Project Title' ?><span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" id="title" required="">
              </div>
              <div class="form-group mt-3">
                <label class="col-form-label"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                <textarea name="description" id="description"></textarea>
              </div>

              <div class="form-group mt-3">
                <label class="col-form-label"><?= $this->lang->line('project_users') ? $this->lang->line('project_users') : 'Project Users' ?> <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('add_users_who_will_work_on_this_project_only_this_users_are_able_to_see_this_project') ? $this->lang->line('add_users_who_will_work_on_this_project_only_this_users_are_able_to_see_this_project') : "Add users who will work on this project. Only this users are able to see this project." ?>"></i></label>
                <select name="users[]" class="form-control multiple" multiple="multiple" id="assignees">
                  <?php foreach ($system_users as $system_user) {
                    if ($system_user->saas_id == $this->session->userdata('saas_id') && $system_user->active == 1) { ?>
                      <option value="<?= htmlspecialchars($system_user->id) ?>"><?= htmlspecialchars($system_user->first_name) ?> <?= htmlspecialchars($system_user->last_name) ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
              <div class="form-group mt-3">
                <label class="col-form-label"><?= $this->lang->line('project_client') ? $this->lang->line('project_client') : 'Project Client' ?></label>
                <select name="client" class="form-control" id="clients_create">
                  <option value="">Client</option>
                  <?php foreach ($system_clients as $system_client) {
                    if ($system_client->saas_id == $this->session->userdata('saas_id')) { ?>
                      <option value="<?= htmlspecialchars($system_client->id) ?>"><?= htmlspecialchars($system_client->first_name) ?> <?= htmlspecialchars($system_client->last_name) ?></option>
                  <?php }
                  } ?>
                </select>
              </div>

              <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="checkbox" id="send_email_notification" name="send_email_notification">
                <label class="form-check-label text-danger" for="send_email_notification"><?= $this->lang->line('send_email_notification') ? $this->lang->line('send_email_notification') : 'Send email notification' ?></label>
              </div>
              <div class="message"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
              <button type="button" class="btn btn-primary edit-project">Save</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
    project_id = "<?= htmlspecialchars($project['id']) ?>";
    task_status = '<?= json_encode($tmpT) ?>';
    task_status_values = '<?= json_encode($tmpTV) ?>';
    progres_count = '<?= $progres_count ?>';

    var endingDateValue = '';
    $(document).ready(function() {
      $('#modal-edit-project').click(function() {
        endingDateValue = $('#ending_date').val();
      });
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
  <script>
    $('.image-radio-input').change(function() {
      var anyChecked = $('.image-radio-input:checked').length > 0;
      $('#next-btn').prop('disabled', !anyChecked);
    });
    $('.multiple').multiSelect();
    $(document).on('click', '.btn-edit-projecct', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      $.ajax({
        type: "POST",
        url: base_url + 'projects/get_project_by_id',
        data: "id=" + id,
        dataType: "json",
        beforeSend: function() {
          $(".modal-body").append(ModelProgress);
        },
        success: function(result) {
          console.log(result.data);
          $('#title').val(result.data.details.title);
          $('#clients_create').val(result.data.details.client_id);
          // multi select
          var userIDsToSelect = [];
          console.log(result.data.users);
          result.data.users.forEach(function(user) {
            userIDsToSelect.push(user.id);
          });
          $('#description').html(result.data.details.description);
          $('#assignees').val(userIDsToSelect);
          $('#assignees').multiSelect('refresh');

          $('input:radio[name="board"][value="' + result.data.details.dash_type + '"]').prop('checked', true);
          $('#next-btn').prop('disabled', false);
          tinymce.init({
            selector: 'textarea',
            height: 240,
            plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap emoticons code',
            menubar: 'edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
            setup: function(editor) {
              editor.on('change keyup', function() {
                tinyMCE.triggerSave();
              });
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
          });


        },
        complete: function() {
          $(".loader-progress").remove();
        }
      });
    });

    var table3 = $('#project_performance_list').DataTable({
      "paging": true,
      "searching": false,
      "language": {
        "paginate": {
          "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "lengthChange": true,
      "lengthMenu": [10, 20, 50, 500],
      "order": false,
      "pageLength": 10,
      "dom": '<"top"f>rt<"bottom"lp><"clear">',
    });
    var table9 = $('#project_sprints_list').DataTable({
      "paging": true,
      "searching": false,
      "language": {
        "paginate": {
          "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
        }
      },
      "info": false,
      "lengthChange": true,
      "lengthMenu": [10, 20, 50, 500],
      "order": false,
      "pageLength": 10,
      "dom": '<"top"f>rt<"bottom"lp><"clear">',
    });
  </script>
  <script src="<?= base_url('assets/modules/dropzonejs/min/dropzone.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/page/projects-details.js') ?>"></script>
</body>

</html>