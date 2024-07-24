<?php $this->load->view('includes/head'); ?>
</head>

<body class="sidebar-mini">
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <a href="<?= base_url() ?>">
                                <img src="<?= base_url('assets/uploads/logos/' . full_logo()); ?>" alt="logo" width="40%">
                            </a>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header d-flex justify-content-center">
                                <h4><?= $this->lang->line('create_company') ? htmlspecialchars($this->lang->line('create_company')) : 'Create Company' ?></h4>
                            </div>
                            <form action="<?= base_url('auth/save-departments') ?>" method="POST" id="create-company">
                                <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                                <div class="card-body row">
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label"><?= $this->lang->line('department_name') ? $this->lang->line('department_name') : 'Department Name' ?><span class="text-danger">*</span></label>
                                        <div id="input-container">
                                            <input type="text" name="department_name[]" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button type="button" class="add-btn btn btn-success btn-lg btn-block" tabindex="3">Add More</button>
                                    <button type="submit" class="savebtn btn btn-primary btn-lg btn-block" tabindex="3">
                                        <?= $this->lang->line('create') ? $this->lang->line('create') : 'Create' ?>
                                    </button>
                                </div>
                                <div class="result"></div>
                            </form>
                            <div class="simple-footer">
                                <?= htmlspecialchars(footer_text()) ?>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <?php $this->load->view('includes/js'); ?>

    <script>
        $("#create-company").submit(function(e) {
            e.preventDefault();
            let save_button = $(this).find('.savebtn'),
                output_status = $(this).find('.result'),
                card = $('#create-company');

            let card_progress = $.cardProgress(card, {
                spinner: true
            });
            save_button.addClass('btn-progress');
            output_status.html('');
            var form = $(this);
            var formData = form.serialize();

            console.log(formData);
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    card_progress.dismiss(function() {
                        if (result['error'] == false) {
                            window.location.replace(base_url + 'auth/create-roles/' + result.saas_id);
                        } else {
                            output_status.prepend('<div class="alert alert-danger">' + result['message'] + '</div>');
                        }
                        output_status.find('.alert').delay(4000).fadeOut();
                        save_button.removeClass('btn-progress');
                        $('html, body').animate({
                            scrollTop: output_status.offset().top
                        }, 1000);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('.modal-body').append('<div class="alert alert-danger">An error occurred while processing your request. Please try again later.</div>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".add-btn").click(function() {
                var inputHtml = '<div class="input-group mt-2"><input type="text" name="department_name[]" class="form-control" required=""><div class="input-group-append"><button class="remove-btn btn btn-danger" type="button">Remove</button></div></div>';
                $("#input-container").append(inputHtml);
            });

            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".input-group").remove();
            });
        });
    </script>
</body>

</html>