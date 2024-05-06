<?php $this->load->view('includes/header'); ?>
<style>
    .hidden {
        display: none;
    }

    .drag-drop {
        min-height: 50px;
        margin-bottom: 10px;
    }

    .highlight-drop {
        border: 2px dashed #5cb85c;
        background-color: #f0f8ff;
    }

    .drag-item {
        cursor: move;
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
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="card card-bx mb-3">
                            <div class="card-header">
                                <h6 class="title">Edit Issue</h6>
                            </div>
                            <form action="<?= base_url('issues/edit_issue') ?>" method="post" id="modal-edit-issue-part">
                                <input type="hidden" name="update_id" value="<?= $issue->id ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Project <span class="text-danger">*</span></label>
                                            <select class="form-control wide" name="project_id">
                                                <option value="">Project</option>
                                                <?php foreach ($projects as $project) : ?>
                                                    <option value="<?= $project["id"] ?>" <?= ($issue->project_id === $project["id"]) ? 'selected' : ''; ?>><?= $project["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Issue Type <span class="text-danger">*</span></label>
                                            <select class="form-control wide" name="issue_type" id="issue_type">
                                                <option value="epic" <?= ($issue->issue_type === 'epic') ? 'selected' : ''; ?>>Epic</option>
                                                <option value="story" <?= ($issue->issue_type === 'story') ? 'selected' : ''; ?>>Story</option>
                                                <option value="task" <?= ($issue->issue_type === 'task') ? 'selected' : ''; ?>>Task</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 mb-3">
                                            <label class="form-label">Status </label>
                                            <select class="form-control" name="status">
                                                <?php foreach ($statuses as $status) : ?>
                                                    <option value="<?= $status["id"] ?>" <?= ($issue->status === $status["id"]) ? 'selected' : ''; ?>><?= $status["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-4 mb-3">
                                            <label class="form-label">Priority </label>
                                            <select class="form-control" name="priority">
                                                <?php foreach ($priorities as $priority) : ?>
                                                    <option value="<?= $priority["id"] ?>" <?= ($issue->priority === $priority["id"]) ? 'selected' : ''; ?>><?= $priority["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 mb-3" id="story_point_show">
                                            <label class="form-label">Story Points</label>
                                            <input type="number" class="form-control" name="story_points" min="0" value="<?= $issue->story_points ?>">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                            <input type="text" name="starting_date" id="starting_date" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label"><?= $this->lang->line('due_date') ? $this->lang->line('due_date') : 'Due Date' ?><span class="text-danger">*</span></label>
                                            <input type="text" name="due_date" id="due_date" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Title<span class="text-danger">*</span></label>
                                            <input type="text" value="<?= $issue->title ?>" class="form-control" name="title">
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description"><?= $issue->description ?></textarea>
                                        </div>
                                        <?php
                                        // var_dump(($issues_users->user_id));
                                        ?>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Assignee</label>
                                            <select class="form-control wide" name="user">
                                                <option value="">Assignee</option>
                                                <?php foreach ($project_users as $project_user) {
                                                    if ($project_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                        <option value="<?= htmlspecialchars($project_user->id) ?>" <?= ($project_user->id == $issues_users->user_id) ? 'selected' : '' ?>><?= htmlspecialchars($project_user->first_name) ?> <?= htmlspecialchars($project_user->last_name) ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 mb-3 <?= ($issue_projects->dash_type == '1') ? '' : 'hidden' ?>" id="showHideSprint">
                                            <label class="form-label">Sprint</label>
                                            <select class="form-control" name="sprint">
                                                <option value="">Sprint</option>
                                                <?php foreach ($sprints as $sprint) : ?>
                                                    <option value="<?= $sprint["id"] ?>" <?= ($sprint["id"] == $issues_sprint->sprint_id) ? 'selected' : '' ?>><?= $sprint["title"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="message"></div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="button" class="btn btn-primary mb-2 btn-edit">+ Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 240,
            plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap  emoticons code',
            menubar: 'edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
            setup: function(editor) {
                editor.on("change keyup", function(e) {
                    tinyMCE.triggerSave();
                });
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        $(document).on('click', '.btn-edit', function(e) {
            var form = $('#modal-edit-issue-part');
            var formData = form.serialize();
            console.log(formData);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {
                        window.location.href = base_url + 'backlog'
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                },
            });

            e.preventDefault();
        });
        $(document).ready(function() {
            $('select[name="project_id"]').change(function() {
                var projectId = $(this).val();
                console.log(projectId);
                if (projectId !== '') {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'issues/get_project_users', // Replace with your AJAX endpoint URL
                        data: {
                            project_id: projectId
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response.users);
                            if (response.dash_type == '0') {
                                $('#showHideSprint').hide();
                            } else {
                                $('#showHideSprint').show();
                            }
                            var select = $('select[name="user"]');
                            select.empty();
                            select.append('<option value="">Assignee</option>');
                            $.each(response.users, function(index, user) {
                                console.log(user.id);
                                select.append('<option value="' + user.id + '">' + user.first_name + ' ' + user.last_name + '</option>');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        start_date = '<?= $issue->starting_date ?>';
        dueDate = '<?= $issue->due_date ?>';


        var startingDatepicker = $('#starting_date').daterangepicker({
            locale: {
                format: date_format_js
            },
            singleDatePicker: true,
            startDate: moment(start_date, 'YYYY-MM-DD').toDate(),
        });


        $('#due_date').daterangepicker({
            locale: {
                format: date_format_js
            },
            singleDatePicker: true,
            startDate: moment(dueDate, 'YYYY-MM-DD').toDate(),
            minDate: moment(start_date, 'YYYY-MM-DD').toDate()

        });

        $('#issue_type').on('change', function() {
            issue_type = $('#issue_type').val();
            if (issue_type !== 'task') {
                $('#story_point_show').show();
            } else {
                $('#story_point_show').hide();
            }
        });
        startingDatepicker.on('change', function(ev, picker) {
            start = $('#starting_date').val();
            $('#due_date').daterangepicker({
                locale: {
                    format: date_format_js
                },
                singleDatePicker: true,
                startDate: start,
                minDate: start

            });
        });
    </script>


</body>

</html>