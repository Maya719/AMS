<?php $this->load->view('includes/header'); ?>
<style>
  .hidden {
    display: none;
  }

  #example3 tbody td a {
    font-weight: bold;
    font-size: 12px;
  }
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
  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">
    <?php $this->load->view('includes/sidebar'); ?>
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-sm mb-0">
                    <thead>
                      <tr>
                        <th><?= $this->lang->line('user') ? $this->lang->line('user') : 'User' ?></th>
                        <th><?= $this->lang->line('plan') ? $this->lang->line('plan') : 'Plan' ?></th>
                        <th><?= $this->lang->line('price_usd') ? $this->lang->line('price_usd') . ' - ' . get_saas_currency('currency_code') : 'Price - ' . get_saas_currency('currency_code') ?></th>
                        <th><?= $this->lang->line('billing_type') ? $this->lang->line('billing_type') : 'Billing Type' ?></th>
                        <th><?= $this->lang->line('date') ? $this->lang->line('date') : 'Date' ?></th>
                        <th><?= $this->lang->line('status') ? $this->lang->line('status') : 'Status' ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($temps as $temp) : ?>
                        <tr>
                            <td><?=$temp["user"]?></td>
                            <td><?=$temp["title"]?></td>
                            <td><?=$temp["price"]?></td>
                            <td><?=$temp["billing_type"]?></td>
                            <td><?=$temp["created"]?></td>
                            <td><?=$temp["status"]?></td>
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
    </div>
    <!-- *******************************************
  Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets/js/page/saas-users.js') ?>"></script>
  <script>
    var table3 = $('#example3').DataTable({
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
  </script>
</body>

</html>