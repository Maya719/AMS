<?php $this->load->view('includes/header'); ?>
<style>
  .table tbody td a {
    font-weight: bold;
    font-size: 12px;
  }

  .table th {
    padding: 5px 10px;
    border: none;
  }

  .table tbody td {
    border: none;
  }
</style>
<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap-table/bootstrap-table.min.css'); ?>">
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
***********************************--> <!--**********************************
	Content body start
***********************************-->
    <div class="content-body default-height">
      <div class="container-fluid">
        <div class="row d-flex justify-content-end mb-3">
          <div class="col-xl-2 col-sm-3 mt-2">
            <a href="<?= base_url('front/create-feature') ?>" class="btn btn-block btn-primary">+ ADD</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="feature_div">
            <div class="card card-primary">

              <?php if (!isset($_GET['reorder'])) { ?>
                <div class="card-header">
                  <div class="card-header-action">
                    <a href="<?= base_url('front/features?reorder') ?>" class="btn btn-primary"><?= $this->lang->line('reorder') ? htmlspecialchars($this->lang->line('reorder')) : 'Reorder' ?></a>
                  </div>
                </div>
              <?php } else { ?>
                <div class="card-header">
                  <div class="card-header-action">
                    <a href="<?= base_url('front/features') ?>" class="btn btn-primary"><?= $this->lang->line('go_back') ? htmlspecialchars($this->lang->line('go_back')) : 'Go Back' ?></a>
                  </div>
                </div>
              <?php } ?>

              <div class="card-body">
                <table class='table-striped' id='features_list' data-toggle="table" data-url="<?= base_url('front/get_feature') ?>" data-click-to-select="true" <?php if (isset($_GET['reorder'])) { ?> data-use-row-attr-func="true" data-reorderable-rows="true" <?php } ?> data-use-row-attr-func="true" data-reorderable-rows="true" data-side-pagination="server" data-pagination="false" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-columns="false" data-show-refresh="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="false" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "features-list",
                            "ignoreColumn": ["state"] 
                          }' data-query-params="queryParams">
                  <thead>
                    <tr>
                      <th data-field="title" data-sortable="true"><?= $this->lang->line('title') ? $this->lang->line('title') : 'Title' ?></th>
                      <th data-field="description" data-sortable="true"><?= $this->lang->line('description') ? $this->lang->line('description') : 'Description' ?></th>
                      <th data-field="icon" data-sortable="true"><?= $this->lang->line('icon') ? $this->lang->line('icon') : 'Icon' ?></th>

                      <?php if (!isset($_GET['reorder'])) { ?>
                        <th data-field="action" data-sortable="false"><?= $this->lang->line('action') ? $this->lang->line('action') : 'Action' ?></th>
                      <?php } ?>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
  <script>
    $('#features_list').bootstrapTable({
      onReorderRow: function(data) {

        $.ajax({
          type: "POST",
          url: base_url + 'front/order_feature/',
          data: "data=" + JSON.stringify(data),
          dataType: "json",
          success: function(result) {
            if (result['error'] == false) {

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
    $(document).on('click', '.delete_feature', function(e) {
      e.preventDefault();
      var id = $(this).data("id");
      Swal.fire({
        title: are_you_sure,
        text: you_want_to_delete_this_feature,
        icon: 'warning',
        showCancelButton: true,
        dangerMode: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: base_url + 'front/delete-feature/' + id,
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