<?php $this->load->view('includes/header'); ?>
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
        <!--**********************************
    Sidebar start
***********************************-->
        <?php $this->load->view('includes/sidebar'); ?>
        <!--**********************************
    Sidebar end
***********************************-->
        <div class="content-body default-height">
            <div class="container-fluid">
                <div class="row d-flex justify-content-end">
                    <div class="col-xl-2 col-sm-3">
                        <a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#holiday-add-modal" class="btn btn-block btn-primary">+ ADD</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-1">
                                <div class="table-responsive">
                                    <table id="holiday_list" class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Question</th>
                                                <th>Response</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php foreach ($response_messages as $key => $response_message) : ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $response_message->question ?></td>
                                                    <td><?= $response_message->response_message ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="badge light badge-primary"><a href="javascript:void()" data-id="<?= $response_message->id ?>" data-bs-toggle="modal" data-bs-target="#chat-edit-modal" class="text-primary chat-edit" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                                                            <span class="badge light badge-danger ms-2"><a href="javascript:void()" class="text-danger btn-delete-chat" data-id="<?= $response_message->id ?>" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="holiday-add-modal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="<?= base_url('chatbot/create') ?>" method="POST" class="modal-part" id="modal-add-chat-part">
                            <div class="modal-body">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label"><?= $this->lang->line('question') ? $this->lang->line('question') : 'Question' ?><span class="text-danger">*</span></label>
                                    <input type="text" name="question" id="question" class="form-control">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label">Response <span class="text-danger">*</span></label>
                                    <textarea name="response"></textarea>
                                </div>
                                <div class="message"></div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-create btn-block btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="chat-edit-modal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="<?= base_url('chatbot/edit') ?>" method="POST" class="modal-part" id="modal-edit-chat-part">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="modal-body">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label"><?= $this->lang->line('question') ? $this->lang->line('question') : 'Question' ?><span class="text-danger">*</span></label>
                                    <input type="text" name="question" id="question_edit" class="form-control">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label">Response <span class="text-danger">*</span></label>
                                    <textarea id="response_edit" name="response"></textarea>
                                </div>
                                <div class="message"></div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-edit-chat btn-block btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--**********************************
  Content body end
***********************************-->
            <?php $this->load->view('includes/footer'); ?>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>

        <?php $this->load->view('includes/scripts'); ?>
        <script>
            var table3 = $('#holiday_list').DataTable({
                "paging": true,
                "searching": true,
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
                "dom": '<"top"f>rt<"bottom"lp><"clear">'
            });
            tinymce.init({
                selector: 'textarea',
                height: 500,
                plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons code',
                menubar: 'edit view insert format tools table tc help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
                setup: function(editor) {
                    editor.on("change keyup", function(e) {
                        tinyMCE.triggerSave();
                    });
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_url: base_url + 'chatbot/upload_image',
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function() {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            });

            $(document).on('click', '.btn-create', function(e) {
                var form = $('#modal-add-chat-part');
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
                            location.reload();
                        } else {
                            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                        }
                    },
                });

                e.preventDefault();
            });
            $(document).on('click', '.btn-edit-chat', function(e) {
                var form = $('#modal-edit-chat-part');
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
                            location.reload();
                        } else {
                            $('.message').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
                        }
                    },
                });

                e.preventDefault();
            });
            $(document).on('click', '.chat-edit', function(e) {
                e.preventDefault();
                var id = $(this).data("id");
                console.log(id);
                $.ajax({
                    type: "POST",
                    url: base_url + 'chatbot/get_chat_by_id',
                    data: "id=" + id,
                    dataType: "json",
                    beforeSend: function() {
                        $(".modal-body").append(ModelProgress);
                    },
                    success: function(result) {
                        if (result['error'] == false) {
                            $("#update_id").val(id);
                            $("#question_edit").val(result.response_messages.question);
                            $('#response_edit').html(result.response_messages.response_message);
                        }
                    },
                    complete: function() {
                        $(".loader-progress").remove();
                    }
                });
            });
            $(document).on('click', '.btn-delete-chat', function(e) {
                e.preventDefault();
                var id = $(this).data("id");
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
                            url: base_url + 'chatbot/delete/' + id,
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
        </script>

</body>

</html>