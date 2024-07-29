<?php $this->load->view('includes/header'); ?>
<link href="<?= base_url('assets2/vendor/introjs/modern.css') ?>" rel="stylesheet" type="text/css" />
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
        <div class="row">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
      </div>
      <!--**********************************
  Content body end
***********************************-->
      <?php $this->load->view('includes/footer'); ?>
    </div>

    <?php $this->load->view('includes/scripts'); ?>
</body>

</html>