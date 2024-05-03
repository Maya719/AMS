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
                    <?php if ($is_allowd_to_create_new) { ?>
                        <div class="col-xl-9 col-lg-8">
                            <div class="card card-bx mb-3">
                                <div class="card-header">
                                    <h6 class="title">Create Issue</h6>
                                </div>
                                <form action="<?= base_url('issues/create_issue') ?>" method="post"
                                    id="modal-add-issue-part">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Project <span class="text-danger">*</span></label>
                                                <select class="form-control" name="project_id">
                                                    <option value="">Project</option>
                                                    <?php foreach ($projects as $project): ?>
                                                        <option value="<?= $project["id"] ?>"><?= $project["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Issue Type <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="issue_type">
                                                    <option value="epic">Epic</option>
                                                    <option value="story">Story</option>
                                                    <option value="task">Task</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Status </label>
                                                <select class="form-control" name="status">
                                                    <?php foreach ($statuses as $status): ?>
                                                        <option value="<?= $status["id"] ?>"><?= $status["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Priority </label>
                                                <select class="form-control" name="priority">
                                                    <?php foreach ($priorities as $priority): ?>
                                                        <option value="<?= $priority["id"] ?>"><?= $priority["title"] ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Story Points</label>
                                                <input type="number" min="0" class="form-control" name="story_points"
                                                    value="0">
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title">
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description"></textarea>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Assignee</label>
                                                <select class="form-control" name="user">
                                                    <option value="">Member</option>
                                                    <?php foreach ($system_users as $system_user) {
                                                        if ($system_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                            <option value="<?= htmlspecialchars($system_user->id) ?>">
                                                                <?= htmlspecialchars($system_user->first_name) ?>
                                                                <?= htmlspecialchars($system_user->last_name) ?>
                                                            </option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3" id="sprint_div">
                                                <label class="form-label">Sprint</label>
                                                <select class="form-control" name="sprint">
                                                    <option value="">Sprint</option>
                                                    <?php foreach ($sprints as $sprint): ?>
                                                        <option value="<?= $sprint["id"] ?>"><?= $sprint["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="message"></div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="button" class="btn btn-primary mb-2 btn-create">+ Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex justify-content-center align-items-center">
                            <p>Tasks limit has exceeded</p>
                        </div>
                    <?php } ?>

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
            setup: function (editor) {
                editor.on("change keyup", function (e) {
                    tinyMCE.triggerSave();
                });
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        $(document).on('click', '.btn-create', function (e) {
            var form = $('#modal-add-issue-part');
            var formData = form.serialize();
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function (result) {
                    console.log(result);
                    if (result['error'] == false) {
                        window.location.href = base_url + 'backlog';
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                    }
                },
            });

            e.preventDefault();
        });
        $(document).ready(function () {
            $('select[name="project_id"]').change(function () {
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
                        success: function (response) {
                            console.log(response);
                            var select = $('select[name="user"]');
                            select.empty();
                            select.append('<option value="">Member</option>');
                            $.each(response['users'], function (index, user) {
                                select.append('<option value="' + user.id + '">' + user.first_name + ' ' + user.last_name + '</option>');
                                if (response['dash_type'] == 0) {
                                    $("#sprint_div").addClass('hidden');
                                } else {
                                    $("#sprint_div").removeClass('hidden');
                                }
                            });

                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>


</body>

</html>