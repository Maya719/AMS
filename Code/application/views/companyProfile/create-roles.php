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
                            <form action="<?= base_url('auth/save-roles') ?>" method="POST" id="create-company">
                                <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                                <div class="card-body" id="input-container">
                                    <div class="input-group row">
                                        <div class="form-group col-lg-6">
                                            <label class="col-form-label"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>
                                            <input type="text" name="description[]" class="form-control" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label class="col-form-label"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>
                                            <input type="text" name="descriptive_name[]" class="form-control" required="">
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
                            window.location.replace(base_url + 'auth/purchase-plan/' + result['saas_id']);
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
            // Function to add more fields
            $(".add-btn").click(function() {
                var html = '<div class="input-group row">';
                html += '<div class="form-group col-lg-5">';
                html += '<label class="col-form-label"><?= $this->lang->line('name') ? $this->lang->line('name') : 'Name' ?><span class="text-danger">*</span></label>';
                html += '<input type="text" name="description[]" class="form-control" required="">';
                html += '</div>';
                html += '<div class="form-group col-lg-5">';
                html += '<label class="col-form-label"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?><span class="text-danger">*</span></label>';
                html += '<input type="text" name="descriptive_name[]" class="form-control" required="">';
                html += '</div>';
                html += '<div class="form-group col-lg-2">';
                html += '<label class="col-form-label"><?= $this->lang->line('remove') ? $this->lang->line('remove') : 'remove' ?><span class="text-danger">*</span></label>';
                html += '<button class="remove btn btn-danger btn-block" tabindex="3" type="button">Remove</button>';
                html += '</div>';
                html += '</div>';

                $("#input-container").append(html);
            });

            // Function to remove the added fields
            $(document).on('click', '.remove', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>


</body>

</html>