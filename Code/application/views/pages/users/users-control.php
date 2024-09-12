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
            <!-- row -->
            <div class="container-fluid">
                <div class="row">
                    <ol class="mt-5">
                        <?php foreach ($otherSuperRoles as $otherSuperRole) : ?>
                            <li style="--accent-color: <?= theme_color() ?>">
                                <a href="<?= base_url('users/special_roles/' . $otherSuperRole->id) ?>">
                                    <div class="icon"><img width="90" height="100" src="<?= base_url($otherSuperRole->icon) ?>" alt="handshake--v1" /></div>
                                    <div class="title"><?= $otherSuperRole->description ?></div>
                                    <div class="descr"><?= $otherSuperRole->descriptive_name ?></div>
                                </a>
                            </li>
                        <?php endforeach ?>
                        <li style="--accent-color: <?= theme_color() ?>">
                            <a href="<?= base_url('users/employees') ?>">
                                <div class="icon"><img width="90" height="100" src="<?= base_url('assets2/images/avatar/employee.png') ?>" alt="handshake--v1" /></div>
                                <div class="title">Employees</div>
                                <div class="descr">Employees with <?= count($showWithEmp) ?> roles</div>
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- *******************************************
            Footer -->
        <?php $this->load->view('includes/footer'); ?>

        <!--**********************************
            Content body end
        ***********************************-->
    </div>
    <?php $this->load->view('includes/scripts'); ?>
</body>

</html>