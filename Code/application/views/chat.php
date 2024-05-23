<?php $this->load->view('includes/header'); ?>

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
          <div class="col-xl-12">
            <div class="card mb-0 h-auto">
              <div class="card-body p-0">
                <div class="row">
                  <div class="col-xl-3 col-xxl-4 border-right pe-0 chat-left-body ">
                    <div class="meassge-left-side">
                      <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                          <h3 class="mb-0 me-2">Inbox</h3>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade show active" style="max-height: 800px; overflow:auto">
                      <div class="chat-sidebar" id="chatSidebar">
                        <!--  -->
                        <?php
                        if (isset($chat_users) && !empty($chat_users)) {
                          foreach ($chat_users as $user) {
                            if ($user['id'] != $this->session->userdata('user_id')) {
                        ?>
                              <div class="chat-bx d-flex border-bottom user-selected-for-chat" data-id="<?= htmlspecialchars($user['id']) ?>">
                                <?php
                                if (isset($user['profile']) && !empty($user['profile'])) { ?>
                                  <div class="chat-img">
                                    <img src="<?= htmlspecialchars($user['profile']) ?>" alt="<?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?>">
                                  </div>
                                <?php
                                } else { ?>
                                  <ul class="kanbanimg me-4">
                                    <li><span><?= htmlspecialchars($user['short_name']) ?></span></li>
                                  </ul>
                                <?php
                                }
                                ?>

                                <div class="w-100">
                                  <div class="d-flex align-items-center mt-1">
                                    <h6 class="mb-0"><?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?></h6>
                                  </div>
                                  <div class="d-flex justify-content-between">
                                    <?=$user['is_read']==0?'':'<p class="mb-0 lh-base">'.($this->lang->line('new_message')?$this->lang->line('new_message'):'New Message').'</p>'?>
                                  </div>
                                </div>

                              </div>
                        <?php }
                          }
                        } ?>
                        <!--  -->
                      </div>
                    </div>


                  </div>
                  <div class="col-xl-9 col-xxl-8 ps-xl-0">
                    <div class="d-flex justify-content-between align-items-center border-bottom px-4 pt-4 flex-wrap">
                      <div class="d-flex align-items-center pb-3">
                        <div class="ms-3">
                          <h4 id="current_chating_user"></h4>
                        </div>
                      </div>
                      <?php if ($this->ion_auth->is_admin() || permissions('chat_delete')) { ?>
                        <div class="activity d-flex align-items-center pb-3 d-none" id="delete_chat2">
                          <div class="dropdown ms-2">
                            <div class="btn-link" data-bs-toggle="dropdown">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12.4999" cy="3.5" r="2.5" fill="var(--primary)" />
                                <circle cx="12.4999" cy="11.5" r="2.5" fill="var(--primary)" />
                                <circle cx="12.4999" cy="19.5" r="2.5" fill="var(--primary)" />
                              </svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item text-danger d-none" id="delete_chat" data-id="" href="javascript:void(0)">Delete</a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                    <div class="chat-box-area dlab-scroll chat-box-area" id="chatArea">
                      <div class="chat-box-area dz-scroll chat-content" id="mychatbox">
                      </div>
                    </div>
                    <form id="chat-form" class="d-none" action="<?= base_url('chat/create') ?>" method="POST">
                      <input type="hidden" name="to_id" id="to_id" value="">
                      <div class="card-footer border-1 type-massage">
                        <div class="input-group">
                          <input class="form-control" name="message" id="chat_input" placeholder="<?= $this->lang->line('type_your_message') ? $this->lang->line('type_your_message') : 'Type your message' ?>"></input>
                          <button type="submit" class="btn btn-primary text-white"><i class="far fa-paper-plane me-2"></i>SEND</button>
                        </div>
                      </div>
                  </div>
                  </form>
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

  <!--**********************************
	Content body end
***********************************-->
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script src="<?= base_url('assets2/js/chat/chat.js'); ?>"></script>
</body>

</html>