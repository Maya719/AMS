<!-- <footer class="main-footer">
    <div class="footer-left">
      
    </div>
    <?php
if ($this->ion_auth->logged_in()) {
  $current_url = current_url(); // Get the current page's URL
  $chat_page_url = base_url('chat'); // URL of the chat page

  // Check if the current URL is not the chat page
  if ($current_url !== $chat_page_url) {
?>
  <a href="<?= $chat_page_url ?>" class="chat-button">
    <i class="fas fa-comment text-primary"></i>
    <?= get_chat_message_count() ?>
  </a>
<?php
  }
}
?>
</footer> -->
<div class="footer">
      <div class="copyright">
        <p><?=htmlspecialchars(footer_text())?></p>
      </div>
    </div>