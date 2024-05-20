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
                        <?php var_dump($saas_id); ?>
                        <div class="card card-primary">
                            <div class="card-header d-flex justify-content-center">
                                <h4><?= $this->lang->line('create_company') ? htmlspecialchars($this->lang->line('create_company')) : 'Create Company' ?></h4>
                            </div>
                            <form action="<?= base_url('auth/create-company') ?>" method="POST" id="create-company">
                                <input type="hidden" name="saas_id" value="<?= $saas_id ?>">
                                <div class="card-body row">
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('company_name') ? $this->lang->line('company_name') : 'Company Name' ?><span class="text-danger">*</span><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="<?= $this->lang->line('this_details_will_be_used_as_billing_details') ? $this->lang->line('this_details_will_be_used_as_billing_details') : "This details will be used as billing details." ?>"></i></label>
                                        <input type="text" name="company_name" class="form-control" required="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('address') ? $this->lang->line('address') : 'Address' ?></label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('city') ? $this->lang->line('city') : 'City' ?></label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('state') ? $this->lang->line('state') : 'State' ?></label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('country') ? $this->lang->line('country') : 'Country' ?></label>
                                        <input type="text" name="country" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label"><?= $this->lang->line('zip_code') ? $this->lang->line('zip_code') : 'Zip Code' ?></label>
                                        <input type="text" name="zip_code" class="form-control">
                                    </div>
                                </div>

                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button type="submit" class="savebtn btn btn-primary btn-lg btn-block" tabindex="6">
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

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    card_progress.dismiss(function() {
                        if (result['error'] == false) {
                            location.href = base_url + 'auth/purchase-plan/' + result.saas_id;
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
</body>

</html>