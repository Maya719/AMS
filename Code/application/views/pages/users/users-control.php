<?php $this->load->view('includes/header'); ?>
<link rel="stylesheet" href="<?= base_url('assets2/css/users/controls.css') ?>">
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
        <?php $this->load->view('includes/sidebar'); ?>
        <div class="content-body default-height">
            <ol class="mt-5">
                <li style="--accent-color: <?= theme_color() ?>">
                    <a href="<?= base_url('users/special_roles/' . $ceo->id) ?>">
                        <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/ceo.png') ?>" alt="handshake--v1" /></div>
                        <div class="title"><?= $ceo->description ?></div>
                        <div class="descr"><?= $ceo->descriptive_name ?></div>
                    </a>
                </li>
                <li style="--accent-color: <?= theme_color() ?>">
                    <a href="<?= base_url('users/special_roles/' . $partners->id) ?>">
                        <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/partners.png') ?>" alt="handshake--v1" /></div>
                        <div class="title"><?= $partners->description ?></div>
                        <div class="descr"><?= $partners->descriptive_name ?></div>
                    </a>
                </li>
                <?php if ($this->ion_auth->is_admin() || permissions('client_view')) { ?>
                    <li style="--accent-color: <?= theme_color() ?>">
                        <a href="<?= base_url('users/special_roles/' . $clients->id) ?>">
                            <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/clients.png') ?>" alt="handshake--v1" /></div>
                            <div class="title"><?= $clients->description ?></div>
                            <div class="descr"><?= $clients->descriptive_name ?></div>
                        </a>
                    </li>
                <?php } ?>
                <li style="--accent-color: <?= theme_color() ?>">
                    <a href="<?= base_url('users/special_roles/' . $hr_manager->id) ?>">
                        <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/hr.png') ?>" alt="handshake--v1" /></div>
                        <div class="title"><?= $hr_manager->description ?></div>
                        <div class="descr"><?= $hr_manager->descriptive_name ?></div>
                    </a>
                </li>
                <li style="--accent-color: <?= theme_color() ?>">
                    <a href="<?= base_url('users/employees') ?>">
                        <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/employee.png') ?>" alt="handshake--v1" /></div>
                        <div class="title">Employees</div>
                        <div class="descr">General Users</div>
                    </a>
                </li>
            </ol>
        </div>
        <?php $this->load->view('includes/footer'); ?>
        <!-- ************************************* *****
    Model forms
  ****************************************************-->

        <!--**********************************
  Content body end
***********************************-->
    </div>
    <?php $this->load->view('includes/scripts'); ?>
</body>

</html>