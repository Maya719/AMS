<?php $this->load->view('includes/header'); ?>
<style>

</style>
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
  <?php $this->load->view('includes/sidebar'); ?>
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <div class="content-body default-height">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="#" id="modal-add-leaves"  class="btn btn-block btn-primary">+ ADD</a>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Holiday Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="customers">
                      <?php
                      foreach ($data as $value) {
                        ?>
                        <tr class="btn-reveal-trigger" height="20">
                          <td class="py-2 "> <?=$value["sn"]?></td>
                          <td class="py-2 "> <?=$value["type"]?></td>
                          <td class="py-2 "> <?=$value["starting_date"]?></td>
                          <td class="py-2 "> <?=$value["ending_date"]?></td>
                          <td class="py-2 "> <?=$value["remarks"]?></td>
                        <td>
                          <div class="d-flex">
                            <span class="badge light badge-primary"><a href="javascript:void()" class="text-primary" data-bs-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i></a></span>
                            <span class="badge light badge-danger"><a href="javascript:void()" class="text-danger" data-bs-toggle="tooltip" data-placement="top" title="Close"><i class="fas fa-trash"></i></a></span>
                          </div>
                        </td>
                      </tr>
                      <?php
                      }?>
                    </tbody>
                  </table>
                </div>
              </div>
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

</body>

</html>