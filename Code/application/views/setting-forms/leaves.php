<?php $this->load->view('includes/head'); ?>

            
<div class="card-body row">
    <div class="alert alert-danger col-md-12 center row">
        <b><?=$this->lang->line('note')?$this->lang->line('note'):'Note'?></b> <?=$this->lang->line('the_numbers_in_the_total_leaves_represent_the_yearly_leave_allowance_for_each_leave_type')?$this->lang->line('the_numbers_in_the_total_leaves_represent_the_yearly_leave_allowance_for_each_leave_type'):": The numbers in the total leaves represent the yearly leave allowance for each leave type. "?>
    </div>
    <!-- <div class="row ml-3" >
        <?php if($this->ion_auth->is_admin() || permissions('leave_type_create')){ ?>
            <a href="#" id="modal-add-leaves-type" class="btn btn-sm btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> <?=$this->lang->line('create_leave_type')?$this->lang->line('create_leave_type'):'Create Leave Type'?></a>
        <?php } ?>
    </div> -->

    <div class="col-md-12" >
        <table class='table-striped' id='leaves_type_list'
            data-toggle="table"
            data-url="<?=base_url('settings/get_leaves_type')?>"
            data-click-to-select="true"
            data-side-pagination="server"
            data-pagination="true"
            
            data-page-list="[5, 10, 20, 50, 100, 200]"
            data-search="false" data-show-columns="true"
            data-show-refresh="false" data-trim-on-search="false"
            data-sort-name="id" data-sort-order="DESC"
            data-mobile-responsive="true"
            data-toolbar="" data-show-export="false"
            data-maintain-selected="true"
            data-export-types='["txt","excel"]'
            data-export-options='{
            "fileName": "shift-list",
            "ignoreColumn": ["state"] 
            }'
            data-query-params="queryParams">
            <thead>
            <tr>
                <th data-field="sr_no" data-sortable="false"><?=$this->lang->line('sr_no')?$this->lang->line('sr_no'):'#'?></th>
                <th data-field="name" data-sortable="false"><?=$this->lang->line('name')?$this->lang->line('name'):'Name'?></th>
                <th data-field="duration" data-sortable="false"><?=$this->lang->line('duration')?$this->lang->line('duration'):'Duration'?></th>
                <th data-field="action" data-sortable="false"><?=$this->lang->line('action')?$this->lang->line('action'):'Action'?></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<form action="<?=base_url('settings/leaves_type_create')?>" method="POST" class="modal-part"  id="modal-add-leaves-part" data-title="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>" data-btn="<?=$this->lang->line('create')?$this->lang->line('create'):'Create'?>">
    
    <div class="form-group">
        <label><?=$this->lang->line('name')?$this->lang->line('name'):'Name'?><span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required="">
    </div>
    <div class="form-group">
        <label><?=$this->lang->line('duration')?$this->lang->line('duration'):'Duration'?><span class="text-danger">*</span></label>
        <select name="duration" class="form-control select2">
            <option value="year">Annually</option>
            <option value="3_months">For 3 Months</option>
            <option value="4_months">For 4 Months</option>
            <option value="6_months">For 6 Months</option>
        </select>
    </div>
</form>

<form action="<?=base_url('settings/leaves_type_edit')?>" method="POST" class="modal-part" id="modal-edit-leaves-type-part" data-title="<?=$this->lang->line('edit')?$this->lang->line('edit'):'Edit'?>" data-btn="<?=$this->lang->line('update')?$this->lang->line('update'):'Update'?>">
    <input type="hidden" name="update_id" id="update_id">
    <div class="form-group">
        <label><?=$this->lang->line('name')?$this->lang->line('name'):'Name'?><span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control" required="">
    </div>
    <div class="form-group">
        <label><?=$this->lang->line('duration')?$this->lang->line('duration'):'Duration'?><span class="text-danger">*</span></label>
        <select name="duration" id="duration" class="form-control select2">
            <option value="year">Annually</option>
            <option value="3_months">For 3 Months</option>
            <option value="4_months">For 4 Months</option>
            <option value="6_months">For 6 Months</option>
        </select>
    </div>
</form>

<div id="modal-edit-leaves-type"></div>

<script>
  function queryParams(p){
    return {
      limit:p.limit,
      sort:p.sort,
      order:p.order,
      offset:p.offset,
      search:p.search
    };
  }
</script>

<style>
.left-pad{
  padding-left:0.5em !important;
  padding-right:0.5em !important;
  padding-bottom:0.5em !important;
  padding-top:0.5em !important;
} 
.create {
    position: absolute;
    top: 0;
    left: 0;
    margin-top: 20px;
    margin-left: 15px;
    z-index: 100; /* Set a higher value for z-index */
}
</style>




