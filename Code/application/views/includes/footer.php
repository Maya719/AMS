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
<style>
  #presentation {
    width: 480px;
    height: 120px;
    padding: 20px;
    margin: auto;
    background: #FFF;
    margin-top: 10px;
    box-shadow: 0 3px 15px -5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    border-radius: 10px;

    h1 {
      font-weight: 400;
    }

    h3 {
      font-weight: 400;
      color: #666;
    }
  }

  #presentation:hover {
    box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.13);
    transition: all 0.3s;
    transform: translateZ(10px);
  }

  #floating-button {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: <?= theme_color() ?>;
    position: fixed;
    bottom: 30px;
    right: 30px;
    cursor: pointer;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
  }

  .plus {
    color: white;
    position: absolute;
    top: 0;
    display: block;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    padding: 0;
    margin: 0;
    line-height: 55px;
    font-size: 38px;
    font-family: 'Roboto';
    font-weight: 300;
    animation: plus-out 0.3s;
    transition: all 0.3s;
  }

  #container-floating {
    position: fixed;
    width: 70px;
    height: 70px;
    bottom: 30px;
    right: 30px;
    z-index: 50px;
  }

  #container-floating:hover {
    height: 400px;
    width: 90px;
    padding: 30px;
  }

  #container-floating:hover .plus {
    animation: plus-in 0.15s linear;
    animation-fill-mode: forwards;
  }

  .edit {
    position: absolute;
    top: 0;
    display: block;
    bottom: 0;
    left: 0;
    display: block;
    right: 0;
    padding: 0;
    opacity: 0;
    margin: auto;
    line-height: 65px;
    transform: rotateZ(-70deg);
    transition: all 0.3s;
    animation: edit-out 0.3s;
  }

  #container-floating:hover .edit {
    animation: edit-in 0.2s;
    animation-delay: 0.1s;
    animation-fill-mode: forwards;
  }

  @keyframes edit-in {
    from {
      opacity: 0;
      transform: rotateZ(-70deg);
    }

    to {
      opacity: 1;
      transform: rotateZ(0deg);
    }
  }

  @keyframes edit-out {
    from {
      opacity: 1;
      transform: rotateZ(0deg);
    }

    to {
      opacity: 0;
      transform: rotateZ(-70deg);
    }
  }

  @keyframes plus-in {
    from {
      opacity: 1;
      transform: rotateZ(0deg);
    }

    to {
      opacity: 0;
      transform: rotateZ(180deg);
    }
  }

  @keyframes plus-out {
    from {
      opacity: 0;
      transform: rotateZ(180deg);
    }

    to {
      opacity: 1;
      transform: rotateZ(0deg);
    }
  }

  .nds {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    position: fixed;
    z-index: 300;
    transform: scale(0);
    cursor: pointer;
  }

  .nd1 {
    background: #d3a411;
    right: 40px;
    bottom: 120px;
    animation-delay: 0.2s;
    animation: bounce-out-nds 0.3s linear;
    animation-fill-mode: forwards;
  }

  .nd3 {
    background: #3c80f6;
    right: 40px;
    bottom: 180px;
    animation-delay: 0.15s;
    animation: bounce-out-nds 0.15s linear;
    animation-fill-mode: forwards;
  }

  .nd4 {
    background: #ba68c8;
    right: 40px;
    bottom: 240px;
    animation-delay: 0.1s;
    animation: bounce-out-nds 0.1s linear;
    animation-fill-mode: forwards;
  }

  @keyframes bounce-nds {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  @keyframes bounce-out-nds {
    from {
      opacity: 1;
      transform: scale(1);
    }

    to {
      opacity: 0;
      transform: scale(0);
    }
  }

  #container-floating:hover .nds {

    animation: bounce-nds 0.1s linear;
    animation-fill-mode: forwards;
  }

  #container-floating:hover .nd3 {
    animation-delay: 0.08s;
  }

  #container-floating:hover .nd4 {
    animation-delay: 0.15s;
  }

  #container-floating:hover .nd5 {
    animation-delay: 0.2s;
  }

  .letter {
    font-size: 23px;
    font-family: 'Roboto';
    color: white;
    position: absolute;
    left: 0;
    right: 0;
    margin: 0;
    top: 0;
    bottom: 0;
    text-align: center;
    line-height: 40px;
  }

  .reminder {
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 0;
    bottom: 0;
    line-height: 40px;
  }

  .profile {
    border-radius: 50%;
    width: 40px;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    right: 20px;
  }



  .modal {
    display: none;
    position: fixed;
    top: 6%;
    left: 80%;
    width: 20%;
    height: 95vh;
    background-color: white;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
    overflow-y: auto;
    z-index: 1;
    transition: transform 0.3s ease-in-out;
    padding: 1rem;
  }

  .modal-content {
    padding: 1rem;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 22px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  .modal.open {
    display: block;
    transform: translateX(0);
  }

  /* Media Queries for Responsive Behavior */
  @media (max-width: 768px) {

    /* Adjust breakpoint as needed */
    .modal {
      left: 0;
      /* Make modal take full width on smaller screens */
      width: 100%;
      /* Expand modal to full width */
      height: 100vh;
      /* Make modal take full viewport height */
    }
  }
  @media (min-width: 768px) and (max-width: 1024px) {
  /* Tablet-specific styles */
  .modal {
    left: 70%; /* Adjust as needed for tablet positioning */
    width: 30%; /* Adjust width for tablet */
  }
}
</style>
<div id="container-floating">
  <div class="nd3 nds"><img class="reminder">
    <a href="javascript:void(0);" id="openModalBtn">
      <p class="letter"><i class="fa-solid fa-info"></i></p>
    </a>
  </div>
  <div class="nd1 nds">
    <a href="<?= base_url('chat') ?>">
      <p class="letter"><i class="fa-regular fa-message"></i></p>
    </a>
  </div>

  <div id="floating-button">
    <p class="plus"><i class="fa-regular fa-comment"></i></p>
    <img class="edit" height="35" src="<?= base_url('assets2/icons/material-design-iconic-font/help.png') ?>">
  </div>
</div>

<!-- Right Side Modal -->
<div id="rightModal" class="modal">
  <div class="modal-content">
    <span id="closeModalBtn" class="close">&times;</span>
    <div class="row">
      <p>hiasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdas</p>
    </div>
  </div>
</div>
<script>
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('rightModal').classList.add('open');
  });

  document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('rightModal').classList.remove('open');
  });
</script>
<div class="footer">
  <div class="copyright">
    <p><?= htmlspecialchars(footer_text()) ?></p>
  </div>
</div>