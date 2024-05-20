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

    .undercard {
        padding: 15px;
        border: 2px dashed <?= theme_color() ?>;
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('projects') ?>">Projects</a></li>
                        <li class="breadcrumb-item"><a class="text-primary" href="<?= base_url('board/tasks/' . $selectedproject->id) ?>">Board</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $main_page ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <?php if ($is_allowd_to_create_new) { ?>
                        <div class="col-xl-9 col-lg-8">
                            <div class="card card-bx mb-3">
                                <div class="card-header">
                                    <h6 class="title">Create Issue</h6>
                                </div>
                                <form action="<?= base_url('issues/create_issue') ?>" method="post" id="modal-add-issue-part">
                                    <input type="hidden" name="redirect_to" id="redirect_to" value="<?= $selectedproject->dash_type ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Project <span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="project_id" id="project_id3">
                                                    <option value="">Project</option>
                                                    <?php foreach ($projects as $project) : ?>
                                                        <option value="<?= $project["id"] ?>" <?= ($project_id == $project["id"]) ? 'selected' : '' ?>><?= $project["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Issue Type <span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="issue_type" id="issue_type">
                                                    <?php if ($selectedproject->dash_type == 0) : ?>
                                                        <option value="task">Task</option>
                                                    <?php else : ?>
                                                        <option value="epic">Epic</option>
                                                        <option value="story">Story</option>
                                                        <option value="task">Task</option>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Status </label>
                                                <select class="form-control select2" name="status">
                                                    <?php foreach ($statuses as $status) : ?>
                                                        <option value="<?= $status["id"] ?>"><?= $status["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label class="form-label">Priority </label>
                                                <select class="form-control select2" name="priority">
                                                    <?php foreach ($priorities as $priority) : ?>
                                                        <option value="<?= $priority["id"] ?>"><?= $priority["title"] ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-3" id="story_point_show">
                                                <label class="form-label">Story Points</label>
                                                <input type="number" min="0" class="form-control" name="story_points" value="0">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label"><?= $this->lang->line('starting_date') ? $this->lang->line('starting_date') : 'Starting Date' ?><span class="text-danger">*</span></label>
                                                <input type="text" name="starting_date" id="starting_date" class="form-control datepicker-default">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label"><?= $this->lang->line('due_date') ? $this->lang->line('due_date') : 'Due Date' ?><span class="text-danger">*</span></label>
                                                <input type="text" name="due_date" id="due_date" class="form-control datepicker-default">
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title">
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                                <textarea name="description"></textarea>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">Assignee <span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="user">
                                                    <option value="">Member</option>
                                                    <?php foreach ($project_userss as $p_user) {
                                                        if ($p_user->saas_id == $this->session->userdata('saas_id')) { ?>
                                                            <option value="<?= htmlspecialchars($p_user->id) ?>">
                                                                <?= htmlspecialchars($p_user->first_name) ?>
                                                                <?= htmlspecialchars($p_user->last_name) ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3 <?= ($selectedproject->dash_type == 0) ? 'hidden' : '' ?>" id="sprint_div">
                                                <label class="form-label">Sprint</label>
                                                <select class="form-control select2" name="sprint">
                                                    <option value="">Sprint</option>
                                                    <?php foreach ($sprints as $sprint) : ?>
                                                        <option value="<?= $sprint["id"] ?>"><?= $sprint["title"] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            
                                            <?php if ($selectedproject->dash_type == 1) : ?>
                                                <div id="sub-childs">
                                                </div>
                                            <?php endif ?>

                                        </div>
                                        <div class="message"></div>
                                    </div>
                                    <!-- <?php var_dump(json_encode($project_userss)); ?> -->
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="button" id="sub-child-div" class="btn btn-light add-child mb-2 me-2"><i class="fa-solid fa-diagram-project me-2"></i> Child Issue</button>
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
            setup: function(editor) {
                editor.on("change keyup", function(e) {
                    tinyMCE.triggerSave();
                });
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        $(document).on('click', '.btn-create', function(e) {
            var form = $('#modal-add-issue-part');
            var formData = form.serialize();
            console.log(formData);
            project_id = $("#project_id3").val();
            redirect_to = $("#redirect_to").val();
            console.log(redirect_to);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    if (result['error'] == false) {
                        if (redirect_to == '1') {
                            window.location.href = base_url + 'backlog/project/' + project_id;
                        } else {
                            window.location.href = base_url + 'board/tasks/' + project_id;
                        }
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
                        url: base_url + 'issues/get_project_users',
                        data: {
                            project_id: projectId
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            var select = $('select[name="user"]');
                            select.empty();
                            select.append('<option value="">Member</option>');
                            $.each(response['users'], function(index, user) {
                                select.append('<option value="' + user.id + '">' + user.first_name + ' ' + user.last_name + '</option>');
                                if (response['dash_type'] == 0) {
                                    $("#redirect_to").val('kanban');
                                    $("#sprint_div").addClass('hidden');

                                } else {
                                    $("#sprint_div").removeClass('hidden');
                                    $("#redirect_to").val('scrum');
                                }
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
        $('#starting_date').on('change', function(ev, picker) {
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

    <script>
        document.getElementById("project_id3").addEventListener("change", function() {
            var projectId = this.value;
            if (projectId !== "") {
                window.location.href = base_url + 'issues/tasks/' + projectId;
            }
        });
        $(document).ready(function() {
            // Add child
            $('.add-child').on('click', function() {
                var newChild = '<div class="col-sm-12 mb-3">' +
                    '<div class="row undercard">' +
                    '<div class="col-md-5">' +
                    '<select class="form-control select2" name="subType[]">' +
                    '<option value="task">Task</option>' +
                    '<option value="story">Story</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-sm-5 mb-3 ms-1">' +
                    '<select class="form-control select2" name="subStatus[]">' +
                    '<?php foreach ($statuses as $status) : ?>' +
                    '<option value="<?= $status["id"] ?>"><?= $status["title"] ?></option>' +
                    '<?php endforeach ?>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-10">' +
                    '<input type="text" class="form-control" name="subTitle[]" placeholder="Sub Child Description">' +
                    '</div>' +
                    '<div class="col-md-1">' +
                    '<button type="button" class="btn btn-outline-danger ms-1 remove-child"><i class="fas fa-times"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#sub-childs').append(newChild);
            });

            // Remove child
            $('#sub-childs').on('click', '.remove-child', function() {
                $(this).closest('.col-sm-12').remove();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var issueTypeSelect = document.getElementById('issue_type');
            var subChildsDiv = document.getElementById('sub-childs');
            var subChildsBtn = document.getElementById('sub-child-div');

            issueTypeSelect.addEventListener('change', function() {
                if (this.value === 'epic') {
                    subChildsDiv.style.display = 'block';
                    subChildsBtn.style.display = 'block';
                } else {
                    subChildsDiv.style.display = 'none';
                    subChildsBtn.style.display = 'none';
                }
            });

            if (issueTypeSelect.value === 'epic') {
                subChildsDiv.style.display = 'block';
                subChildsBtn.style.display = 'block';
            }
        });


        $('.select2').select2()


    </script>



</body>

</html>