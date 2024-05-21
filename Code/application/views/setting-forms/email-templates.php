<div class="row">
  <div class="card">
    <div class="card-body">
      <form action="<?= base_url('settings/save-email-templates-setting') ?>" method="POST" id="setting-form">
        <div class="card-body row">
          <div class="form-group col-md-12">
            <label class="col-form-label"><?= $this->lang->line('select_template') ? $this->lang->line('select_template') : 'Select Email Template' ?></label>
            <select name="select_template" id="select_template" class="form-control select2 project_filter">

              <option value="<?= base_url('settings/email-templates/new_user_registration') ?>" <?= ($this->uri->segment(3) == 'new_user_registration') ? "selected" : "" ?>> <?= $this->lang->line('new_user_registration') ? htmlspecialchars($this->lang->line('new_user_registration')) : 'New user registration' ?> </option>

              <option value="<?= base_url('settings/email-templates/forgot_password') ?>" <?= ($this->uri->segment(3) == 'forgot_password') ? "selected" : "" ?>> <?= $this->lang->line('forgot_password') ? htmlspecialchars($this->lang->line('forgot_password')) : 'Forgot password' ?> </option>

              <option value="<?= base_url('settings/email-templates/email_verification') ?>" <?= ($this->uri->segment(3) == 'email_verification') ? "selected" : "" ?>> <?= $this->lang->line('email_verification') ? htmlspecialchars($this->lang->line('email_verification')) : 'Email verification' ?> </option>

              <option value="<?= base_url('settings/email-templates/leave_request') ?>" <?= ($this->uri->segment(3) == 'leave_request') ? "selected" : "" ?>> <?= $this->lang->line('leave_request') ? htmlspecialchars($this->lang->line('leave_request')) : 'Leave Request Received' ?> </option>

              <option value="<?= base_url('settings/email-templates/leave_accept') ?>" <?= ($this->uri->segment(3) == 'leave_accept') ? "selected" : "" ?>> <?= $this->lang->line('leave_accept') ? htmlspecialchars($this->lang->line('leave_accept')) : 'Leave Request Accepted' ?> </option>

              <option value="<?= base_url('settings/email-templates/new_project') ?>" <?= ($this->uri->segment(3) == 'new_project') ? "selected" : "" ?>> <?= $this->lang->line('new_project') ? htmlspecialchars($this->lang->line('new_project')) : 'New project' ?> </option>

              <option value="<?= base_url('settings/email-templates/client_new_project') ?>" <?= ($this->uri->segment(3) == 'client_new_project') ? "selected" : "" ?>> <?= $this->lang->line('client_new_project') ? htmlspecialchars($this->lang->line('client_new_project')) : 'Client New project' ?> </option>

              <option value="<?= base_url('settings/email-templates/biometric') ?>" <?= ($this->uri->segment(3) == 'biometric') ? "selected" : "" ?>> <?= $this->lang->line('biometric') ? htmlspecialchars($this->lang->line('biometric')) : 'Attendance' ?> </option>

              <option value="<?= base_url('settings/email-templates/new_task') ?>" <?= ($this->uri->segment(3) == 'new_task') ? "selected" : "" ?>> <?= $this->lang->line('new_task') ? htmlspecialchars($this->lang->line('new_task')) : 'New task' ?> </option>

              <option value="<?= base_url('settings/email-templates/client_new_task') ?>" <?= ($this->uri->segment(3) == 'client_new_task') ? "selected" : "" ?>> <?= $this->lang->line('client_new_task') ? htmlspecialchars($this->lang->line('client_new_task')) : 'Client New task' ?> </option>

              <!-- <option value="<?= base_url('settings/email-templates/new_meeting') ?>" <?= ($this->uri->segment(3) == 'new_meeting') ? "selected" : "" ?>> <?= $this->lang->line('new_meeting') ? htmlspecialchars($this->lang->line('new_meeting')) : 'New meeting' ?> </option> -->

              <option value="<?= base_url('settings/email-templates/new_invoice') ?>" <?= ($this->uri->segment(3) == 'new_invoice') ? "selected" : "" ?>> <?= $this->lang->line('new_invoice') ? htmlspecialchars($this->lang->line('new_invoice')) : 'New invoice' ?> </option>

              <option value="<?= base_url('settings/email-templates/new_estimate') ?>" <?= ($this->uri->segment(3) == 'new_estimate') ? "selected" : "" ?>> <?= $this->lang->line('new_estimate') ? htmlspecialchars($this->lang->line('new_estimate')) : 'New estimate' ?> </option>

              <option value="<?= base_url('settings/email-templates/front_enquiry_form') ?>" <?= ($this->uri->segment(3) == 'front_enquiry_form') ? "selected" : "" ?>> <?= $this->lang->line('frontend_enquiry_form') ? htmlspecialchars($this->lang->line('frontend_enquiry_form')) : "Frontend enquiry form" ?> </option>
             
             
              <!-- ------ New Email templates  ------- -->
              <option value="<?= base_url('settings/email-templates/new_user_registration_2') ?>" <?= ($this->uri->segment(3) == 'new_user_registration_2') ? "selected" : "" ?>> <?= $this->lang->line('new_user_registration_2') ? htmlspecialchars($this->lang->line('new_user_registration_2')) : "New User Registration template 2" ?> </option>
              <option value="<?= base_url('settings/email-templates/forgot_password_2') ?>" <?= ($this->uri->segment(3) == 'forgot_password_2') ? "selected" : "" ?>> <?= $this->lang->line('forgot_password_2') ? htmlspecialchars($this->lang->line('forgot_password_2')) : 'Forgot password template 2' ?> </option>
              <option value="<?= base_url('settings/email-templates/email_verification_2') ?>" <?= ($this->uri->segment(3) == 'email_verification_2') ? "selected" : "" ?>> <?= $this->lang->line('email_verification_2') ? htmlspecialchars($this->lang->line('email_verification_2')) : 'Email verification template 2' ?> </option>
              <option value="<?= base_url('settings/email-templates/new_project_2') ?>" <?= ($this->uri->segment(3) == 'new_project_2') ? "selected" : "" ?>> <?= $this->lang->line('new_project_2') ? htmlspecialchars($this->lang->line('new_project_2')) : 'New Project template 2' ?> </option>
              <option value="<?= base_url('settings/email-templates/new_task_2') ?>" <?= ($this->uri->segment(3) == 'new_task_2') ? "selected" : "" ?>> <?= $this->lang->line('new_task_2') ? htmlspecialchars($this->lang->line('new_task_2')) : 'New task 2' ?> </option>
             <!-- <option value="<?= base_url('settings/email-templates/new_meeting_2') ?>" <?= ($this->uri->segment(3) == 'new_meeting_2') ? "selected" : "" ?>> <?= $this->lang->line('new_meeting_2') ? htmlspecialchars($this->lang->line('new_meeting_2')) : 'New meeting template 2' ?> </option> -->
             <option value="<?= base_url('settings/email-templates/new_invoice_2') ?>" <?= ($this->uri->segment(3) == 'new_invoice_2') ? "selected" : "" ?>> <?= $this->lang->line('new_invoice_2') ? htmlspecialchars($this->lang->line('new_invoice_2')) : 'New invoice template 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/new_estimate_2') ?>" <?= ($this->uri->segment(3) == 'new_estimate_2') ? "selected" : "" ?>> <?= $this->lang->line('new_estimate_2') ? htmlspecialchars($this->lang->line('new_estimate_2')) : 'New estimate template 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/front_enquiry_form_2') ?>" <?= ($this->uri->segment(3) == 'front_enquiry_form_2') ? "selected" : "" ?>> <?= $this->lang->line('frontend_enquiry_form_2') ? htmlspecialchars($this->lang->line('frontend_enquiry_form_2')) : "Frontend enquiry form template 2" ?> </option>
             <option value="<?= base_url('settings/email-templates/leave_request_2') ?>" <?= ($this->uri->segment(3) == 'leave_request_2') ? "selected" : "" ?>> <?= $this->lang->line('leave_request_2') ? htmlspecialchars($this->lang->line('leave_request_2')) : 'Leave Request Received template 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/biometric_2') ?>" <?= ($this->uri->segment(3) == 'biometric_2') ? "selected" : "" ?>> <?= $this->lang->line('biometric_2') ? htmlspecialchars($this->lang->line('biometric_2')) : 'Attendance 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/leave_accept_2') ?>" <?= ($this->uri->segment(3) == 'leave_accept_2') ? "selected" : "" ?>> <?= $this->lang->line('leave_accept_2') ? htmlspecialchars($this->lang->line('leave_accept_2')) : 'Leave Request Accepted 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/client_new_project_2') ?>" <?= ($this->uri->segment(3) == 'client_new_project_2') ? "selected" : "" ?>> <?= $this->lang->line('client_new_project_2') ? htmlspecialchars($this->lang->line('client_new_project_2')) : 'Client New project template 2' ?> </option>
             <option value="<?= base_url('settings/email-templates/client_new_task_2') ?>" <?= ($this->uri->segment(3) == 'client_new_task_2') ? "selected" : "" ?>> <?= $this->lang->line('client_new_task_2') ? htmlspecialchars($this->lang->line('client_new_task_2')) : 'Client New task template 2' ?> </option>



            </select>
          </div>
          <div class="form-group col-md-12">
            <label class="col-form-label"><?= $this->lang->line('email_subject') ? $this->lang->line('email_subject') : 'Email Subject' ?></label>
            <input type="hidden" name="name" value="<?= $template ? $template[0]['name'] : '' ?>">
            <input type="text" name="subject" value="<?= $template ? $template[0]['subject'] : '' ?>" class="form-control" required="">
          </div>
          <div class="form-group col-md-12">
            <label class="col-form-label"><?= $this->lang->line('email_message') ? $this->lang->line('email_message') : 'Email Message' ?></label>
            <textarea type="text" name="message" class="form-control"><?= $template ? $template[0]['message'] : '' ?></textarea>

          </div>

          <div class="form-group col-md-12">
            <div class="section-title">VARIABLES:</div>
            <?= $template ? $template[0]['variables'] : '' ?>
          </div>

        </div>
        <?php if (is_saas_admin()) { ?>
          <div class="card-footer bg-whitesmoke text-end">
            <button class="btn btn-primary savebtn"><?= $this->lang->line('save_changes') ? $this->lang->line('save_changes') : 'Save Changes' ?></button>
          </div>
        <?php } ?>
        <div class="message"></div>
      </form>
    </div>
  </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    height: 720,
    plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap  emoticons code',
    menubar: 'edit view insert format tools table tc help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor permanentpen removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment code',
    setup: function(editor) {
      editor.on("change keyup", function(e) {
        tinyMCE.triggerSave();
      });
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  });
</script>