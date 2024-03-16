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
	<!--**********************************
        Main wrapper start
    ***********************************-->
	<div id="main-wrapper">
		<?php $this->load->view('includes/sidebar'); ?>
		<div class="content-body default-height">
			<!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-2 col-sm-3 mt-2">
						<a href="#" id="modal-add-leaves" data-bs-toggle="modal" data-bs-target="#todo-modal" class="btn btn-block btn-primary">+ ADD</a>
					</div>
					<div class="col-xl-12 mt-3">
						<div class="card">
							<div class="card-body">
								<div class="default-tab">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == '') ? 'active' : '' ?>" href="<?= base_url('todo') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('all') ? $this->lang->line('all') : 'All' ?></a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == 'today') ? 'active' : '' ?>" href="<?= base_url('todo?filter=today') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('today') ? $this->lang->line('today') : 'Today' ?></a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == 'upcoming') ? 'active' : '' ?>" href="<?= base_url('todo?filter=upcoming') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('upcoming') ? $this->lang->line('upcoming') : 'Upcoming' ?></a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == 'finished') ? 'active' : '' ?>" href="<?= base_url('todo?filter=finished') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('finished') ? $this->lang->line('finished') : 'Finished' ?></a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == 'pending') ? 'active' : '' ?>" href="<?= base_url('todo?filter=pending') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('pending') ? $this->lang->line('pending') : 'Pending' ?></a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?= ($main_page == 'overdue') ? 'active' : '' ?>" href="<?= base_url('todo?filter=overdue') ?>"><i class="fas fa-calendar-alt"></i> <?= $this->lang->line('overdue') ? $this->lang->line('overdue') : 'Overdue' ?></a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="home" role="tabpanel">
											<div class="pt-4">
												<?php if ($todo && !empty($todo)) {
													foreach ($todo as $todos) { ?>
														<div class="msg-bx d-flex justify-content-between align-items-center">
															<div class="msg d-flex align-items-center w-100">
																<div class="form-check custom-checkbox mb-3 check-xs">
																	<input type="checkbox" class="form-check-input checkbox-todo <?= ($todos['done'] == 1) ? 'checked' : '' ?>" data-id="<?= htmlspecialchars($todos['id']) ?>" id="customCheck<?= htmlspecialchars($todos['id']) ?>" <?= ($todos['done'] == 1) ? 'checked' : '' ?>>
																	<label class="form-check-label" for="customCheck<?= htmlspecialchars($todos['id']) ?>"></label>
																</div>
																<div class="ms-3 w-100 ">
																	<a href="javascript:void(0);" id="text-small">
																		<?php if ($todos['done'] == 1) { ?>
																			<h5 class="text-primary check-todo mb-1"><?= htmlspecialchars($todos['todo']) ?></h5>
																		<?php } else { ?>
																			<h5 class="mb-1 text-muted check-todo"><?= htmlspecialchars($todos['todo']) ?></h5>
																		<?php } ?>
																	</a>
																	<div class="d-flex justify-content-between">
																		<small class="me-4 
																		<?php if ($todos['done'] == 1) {
																			echo 'text-success';
																		} elseif ($todos['days_status'] == 'Overdue') {
																			echo 'text-danger';
																		} else {
																			echo 'text-muted';
																		} ?> "><?= htmlspecialchars($todos['due_date']) ?>
																			<?php if ($todos['done'] == 1) {
																				echo $this->lang->line('finished') ? $this->lang->line('finished') : 'Finished';
																			} else {
																				echo htmlspecialchars($todos['days_count']) . ' ' . ($this->lang->line('days') ? $this->lang->line('days') : 'Days') . ' ' . htmlspecialchars($todos['days_status']);
																			} ?>

																		</small>
																	</div>
																</div>

															</div>
															<div class="dropdown">
																<div class="btn-link" data-bs-toggle="dropdown">
																	<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<circle cx="12.4999" cy="3.5" r="2.5" fill="#A5A5A5" />
																		<circle cx="12.4999" cy="11.5" r="2.5" fill="#A5A5A5" />
																		<circle cx="12.4999" cy="19.5" r="2.5" fill="#A5A5A5" />
																	</svg>
																</div>
																<div class="dropdown-menu dropdown-menu-right">
																	<a class="dropdown-item text-danger delete_todo" data-id="<?= htmlspecialchars($todos['id']) ?>" href="javascript:void(0)"><?= $this->lang->line('delete') ? $this->lang->line('delete') : 'Delete' ?></a>
																	<a class="dropdown-item btn-edit-todo" data-bs-toggle="modal" data-bs-target="#modal-edit-todo" data-edit="<?= htmlspecialchars($todos['id']) ?>" href="javascript:void(0)"><?= $this->lang->line('edit') ? $this->lang->line('edit') : 'Edit' ?></a>
																</div>
															</div>
														</div>
												<?php }
												} ?>
											</div>
										</div>
									</div>
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
		<div class="modal fade" id="todo-modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Create</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<form action="<?= base_url('todo/create') ?>" method="POST" class="modal-part" id="modal-add-todo-part">
						<div class="modal-body">
							<div class="row">
								<div class="form-group col-md-12">
									<label class="col-form-label"><?= $this->lang->line('todo') ? $this->lang->line('todo') : 'ToDo' ?><span class="text-danger">*</span></label>
									<textarea type="text" name="todo" class="form-control"></textarea>
								</div>
								<div class="form-group col-md-12">
									<label class="col-form-label"><?= $this->lang->line('due_date') ? $this->lang->line('due_date') : 'Due Date' ?><span class="text-danger">*</span></label>
									<input type="text" name="due_date" class="form-control datepicker-default">
								</div>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<div class="col-lg-4">
								<button type="button" class="btn btn-create-todo btn-block btn-primary">Create</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-edit-todo">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<form action="<?= base_url('todo/edit') ?>" method="POST" class="modal-part" id="modal-edit-todo-part">
						<div class="modal-body">
							<input type="hidden" name="update_id" id="update_id" value="">
							<div class="row">
								<div class="form-group col-md-12">
									<label class="col-form-label"><?= $this->lang->line('todo') ? $this->lang->line('todo') : 'ToDo' ?><span class="text-danger">*</span></label>
									<textarea type="text" name="todo" id="todo" class="form-control"></textarea>
								</div>
								<div class="form-group col-md-12">
									<label class="col-form-label"><?= $this->lang->line('due_date') ? $this->lang->line('due_date') : 'Due Date' ?><span class="text-danger">*</span></label>
									<input type="text" name="due_date" id="due_date" class="form-control datepicker-default">
								</div>
							</div>
						</div>
						<div class="modal-footer d-flex justify-content-center">
							<div class="col-lg-4">
								<button type="button" class="btn edit-todo btn-block btn-primary">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--**********************************
	Content body end
***********************************-->
	</div>
	<?php $this->load->view('includes/scripts'); ?>
	<script>
		$("#todo-modal").on('click', '.btn-create-todo', function(e) {
			var modal = $('#todo-modal');
			var form = $('#modal-add-todo-part');
			var formData = form.serialize();
			console.log(formData);
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: formData,
				dataType: "json",
				success: function(result) {
					if (result['error'] == false) {
						location.reload();
					} else {
						modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
					}
				}
			});

		});
		$("#modal-edit-todo").on('click', '.edit-todo', function(e) {
			var modal = $('#modal-edit-todo');
			var form = $('#modal-edit-todo-part');
			var formData = form.serialize();
			console.log(formData);
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: formData,
				dataType: "json",
				success: function(result) {
					if (result['error'] == false) {
						location.reload();
					} else {
						modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
					}
				}
			});

		});
		$(document).on('click', '.btn-edit-todo', function(e) {
			e.preventDefault();
			var id = $(this).data("edit");
			console.log(id);
			$.ajax({
				type: "POST",
				url: base_url + 'todo/get_todo',
				data: "id=" + id,
				dataType: "json",
				success: function(result) {
					console.log(result);
					if (result['error'] == false && result['data'] != '') {
						$("#update_id").val(result['data'][0].id);
						$("#todo").val(result['data'][0].todo);
						$('#due_date').daterangepicker({
							locale: {
								format: date_format_js
							},
							singleDatePicker: true,
							startDate: moment(result['data'][0].due_date, date_format_js),
						});
					} else {
						iziToast.error({
							title: something_wrong_try_again,
							message: "",
							position: 'topRight'
						});
					}
				}
			});
		});
		$(document).on('click', '.delete_todo', function(e) {
			e.preventDefault();
			var id = $(this).data("id");
			Swal.fire({
				title: are_you_sure,
				text: you_want_to_delete_this_todo,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'OK'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "POST",
						url: base_url + 'todo/delete/' + id,
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
		$(document).on('change', '.checkbox-todo', function(e) {

			if ($(this).hasClass('checked')) {
				var $h5 = $(this).closest('.msg-bx').find('.check-todo');
				$h5.removeClass('text-primary').addClass('text-muted');
				var status = 0;
			} else {
				var $h5 = $(this).closest('.msg-bx').find('.check-todo');
				$h5.removeClass('text-muted').addClass('text-primary');
				var status = 1;
			}
			var id = $(this).data("id");
			console.log(id);
			$.ajax({
				type: "POST",
				url: base_url + 'todo/update_status',
				data: "id=" + id + "&status=" + status,
				dataType: "json",
				success: function(result) {
					if (result['error'] == false) {

					} else {
						iziToast.error({
							title: something_wrong_try_again,
							message: "",
							position: 'topRight'
						});
					}
				}
			});
		});
	</script>
</body>

</html>