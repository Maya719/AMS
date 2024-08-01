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

  #floating-button2 {
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

  /* chat open and close */
  .chat-bar-open {
    text-align: center;
    position: fixed;
    bottom: 40px;
    right: 50px;
  }

  .chat-bar-close {
    display: none;
    text-align: center;
    position: fixed;
    bottom: 40px;
    right: 50px;
  }

  .chat-bar-open .close,
  .chat-bar-close .close {
    background-color: #fff;
    width: 70px;
    cursor: pointer;
    height: 70px;
    padding: 15px;
    border-radius: 50%;
    border-style: none;
    vertical-align: middle;
    box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
  }

  .chat-bar-close .close {
    width: 56px;
    height: 56px;
    padding: 12px;
  }

  .chat-bar-open .close img {
    height: 40px;
  }

  .chat-bar-close .close i {
    font-size: 30px;
  }

  .chat-bar-open .close::after {
    position: absolute;
    content: "";
    top: 43px;
    left: 37px;
    transform: rotate(-51deg);
    border-left: 23px solid transparent;
    border-right: 30px solid transparent;
    border-top: 30px solid #fff;
  }

  .chat-bar-close .close::after {
    position: absolute;
    content: "";
    top: 27px;
    left: 23px;
    transform: rotate(-55deg);
    border-left: 24px solid transparent;
    border-right: 29px solid transparent;
    border-top: 31px solid #fff;
  }

  /* chat window 1 */
  .chat-window {
    width: 332px;
    /* height: 280px; */
    border-radius: 10px;
    background-color: #fff;
    padding: 16px;
    z-index: 9999999;
    position: fixed;
    bottom: 120px;
    right: 54px;
    display: none;
    box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
  }

  .hi-there {
    background-color: #7f8ac5;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
  }

  .hi-there .p1 {
    font-size: 20px;
  }

  .hi-there .p2 {
    font-size: 13px;
  }

  .chat-window .start-conversation {
    padding: 15px 24px;
  }

  .chat-window .start-conversation h1 {
    font-size: 15px;
  }

  .chat-window .start-conversation p {
    font-size: 12px;
  }

  .chat-window .start-conversation button {
    cursor: pointer;
    border: none;
    border-radius: 20px;
    padding: 7px 30px;
    margin: -10px 0px;
    background-color: #13a884;
    color: white;
  }

  .chat-window .start-conversation button span {
    font-size: 14px;
  }

  .chat-window .start-conversation button i {
    font-size: 16px;
    position: relative;
    left: 6px;
    top: 3px;
  }

  /* chat window 2 */
  .chat-window2 {
    display: none;
    width: 332px;
    height: 434px;
    border-radius: 10px;
    background-color: #fff;
    padding: 16px;
    z-index: 9999999;
    position: fixed;
    bottom: 120px;
    right: 54px;
    box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
  }

  .chat-window2 .second-chat p {
    text-align: left;
  }

  .chat-window2 .hi-there .p2 {
    font-size: 12px;
  }

  .message-box {
    height: 316px;
    width: 100%;
    padding-right: 5px;
    overflow: auto;
  }

  .message-box .first-chat {
    width: 200px;
    float: right;
    background-color: #4c5aa1;
    padding: 10px;
    margin: 14px 0px;
    border-radius: 5px;
    color: white;
  }

  .message-box .first-chat p {
    font-size: 12px;
    overflow-wrap: break-word;
  }

  .message-box .first-chat .arrow {
    content: "";
    width: 0px;
    height: 0px;
    border-left: 9px solid transparent;
    border-right: 9px solid #4c5aa1;
    border-top: 9px solid #4c5aa1;
    border-bottom: 9px solid transparent;
    right: -172px;
    bottom: -23px;
    position: relative;
    margin-top: -15px;
  }

  .message-box .second-chat {
    display: inline-block;
    width: 95%;
    background-color: #ecf1fb;
    padding: 12px;
    margin: 14px 0px;
    border-radius: 10px;
    color: #000;
    position: relative;
  }

  .message-box .second-chat .circle {
    background-color: #4c5aa1;
    height: 30px;
    width: 30px;
    border-radius: 50%;
    float: left;
    padding: 5px 8px 8px 10px;
    margin-top: 10px;
    margin-right: 20px;
  }

  .message-box .second-chat #circle-mar {
    margin-top: 5px;
  }

  .message-box .second-chat .arrow {
    content: "";
    width: 0px;
    height: 0px;
    border-right: 9px solid transparent;
    border-left: 9px solid #ecf1fb;
    border-top: 12px solid #ecf1fb;
    border-bottom: 9px solid transparent;
    margin-left: 40px;
    margin-top: -2%;
    display: inline-block;
  }

  .message-box img {
    height: 100%;
    width: 100%;
    border-radius: 0;
    cursor: pointer;
  }

  .chat-window2 .input-box {
    position: absolute;
    font-size: 12px;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0px 30px;
    padding-bottom: 18px;
    border-top: 1px solid lightgray;
  }

  .chat-window2 .input-box .write-reply {
    float: left;
  }

  .chat-window2 .input-box .write-reply input[type="text"] {
    border: none;
    outline: none;
    font-size: 14px;
  }

  .chat-window2 .input-box .send-button {
    float: right;
    border: none;
    outline: none;
  }

  .chat-window2 .input-box .send-button button {
    border: none;
    background-color: transparent;
    cursor: pointer;
    outline: none;
  }

  .chat-window2 .input-box .send-button button i {
    color: grey;
    font-size: 20px;
    font-weight: bold;
  }

  .chat-window2 .input-box .surveysparrow img {
    width: 15px;
    margin-bottom: -4px;
  }

  .chat-window2 .input-box .surveysparrow p {
    display: inline;
    font-size: 10px;
    color: #636262;
  }

  .chat-window2 .input-box .surveysparrow {
    position: relative;
    bottom: 28px;
    right: -65px;
  }

  /* RESPONSIVE */
  @media screen and (max-width: 396px) {
    .chat-window {
      right: 14px;
      bottom: 87px;
    }

    .hi-there {
      padding: 12px 30px;
    }

    .chat-window2 {
      right: 14px;
      bottom: 87px;
      height: 420px;
    }

    .chat-bar-open {
      bottom: 20px;
      right: 21px;
    }

    .chat-bar-close {
      bottom: 21px;
      right: 25px;
    }

    .message-box .second-chat .arrow {
      margin-left: 41px;
    }
  }
</style>
<?php if (!is_saas_admin()) : ?>
  <div id="container-floating">
    <div class="nd3 nds"><img class="reminder">
      <a href="javascript:void(0);" id="chat-open-button" onclick="chatOpen()">
        <p class="letter"><i class="fa-solid fa-info"></i></p>
      </a>
    </div>
    <div class="nd1 nds">
      <a href="<?= base_url('chat') ?>">
        <p class="letter"><i class="fa-regular fa-message"></i></p>
      </a>
    </div>

    <div id="floating-button2" style="display: none;" onclick="chatClose()">
      <p class="plus"><i style="font-size: 30px;" class="fa-solid fa-xmark"></i></p>
      <img class="edit" height="35" src="<?= base_url('assets2/icons/material-design-iconic-font/chatbot.png') ?>">
    </div>
    <div id="floating-button">
      <p class="plus"><i style="font-size: 30px;" class="fa-regular fa-comment"></i></p>
      <img class="edit" height="35" src="<?= base_url('assets2/icons/material-design-iconic-font/help.png') ?>">
    </div>
  </div>
<?php endif ?>
<div class="footer">
  <div class="copyright">
    <p><?= htmlspecialchars(footer_text()) ?></p>
  </div>
</div>

<!-- chat-window 1 -->
<div class="chat-window" id="chat-window1">
  <div class="start-conversation">
    <h1>Start a Conversation</h1>
    <br />
    <p>Hi! I'm Peri, a ChatBot of this application. Ask i will response you!</p>
    <button class="new-conversation" type="button" onclick="openConversation()">
      <span>Conversation</span><i class="fa-regular fa-paper-plane"></i>
    </button>
  </div>
</div>
<!-- chat chat-window 2 -->
<div class="chat-window2" id="chat-window2">
  <div class="message-box" id="messageBox">
    <div class="second-chat">
      <div class="circle"><strong style="color: #FFF; font-size:16px; display:flex;">P</strong></div>
      <p>Hi! I'm Peri, a ChatBot of this application. How can I help you?</p>
      <div class="arrow"></div>
    </div>
  </div>
  <div class="input-box">
    <div class="surveysparrow">
      <img src="<?= base_url('assets/uploads/logos/' . favicon()) ?>" />
      <p>we run on surveysparrow</p>
    </div>
    <div class="write-reply">
      <input class="inputText" type="text" id="textInput" placeholder="Write a reply..." />
    </div>
    <div class="send-button">
      <button type="submit" class="send-message" id="send" onclick="userResponse()">
        <i class="fa-regular fa-paper-plane"></i>
      </button>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    fetch(base_url + 'chatbot/get_user_advices')
      .then(response => {
        return response.json();
      })
      .then(data => {
        const chatContainer = document.getElementById('messageBox');
        data.forEach(item => {
          // Create first-chat element
          const firstChat = document.createElement('div');
          firstChat.classList.add('first-chat');

          const firstChatText = document.createElement('p');
          firstChatText.textContent = item.question;

          const firstChatArrow = document.createElement('div');
          firstChatArrow.classList.add('arrow');

          firstChat.appendChild(firstChatText);
          firstChat.appendChild(firstChatArrow);

          // Create second-chat element
          const secondChat = document.createElement('div');
          secondChat.classList.add('second-chat');

          const circle = document.createElement('div');
          circle.classList.add('circle');
          circle.id = 'circle-mar';
          circle.innerHTML = '<strong style="color: #FFF; font-size:16px; display:flex;">P</strong>';

          const secondChatText = document.createElement('div');
          secondChatText.innerHTML = item.response_message;

          const secondChatArrow = document.createElement('div');
          secondChatArrow.classList.add('arrow');

          secondChat.appendChild(circle);
          secondChat.appendChild(secondChatText);
          secondChat.appendChild(secondChatArrow);

          // Append to chat container
          chatContainer.appendChild(firstChat);
          chatContainer.appendChild(secondChat);
        });
        console.log('API response data:', data);
        handleImageClick();
      })
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
  };
</script>
<script>
  function chatOpen() {
    document.getElementById("chat-window1").style.display = "block";
  }

  function chatClose() {
    document.getElementById("chat-window1").style.display = "none";
    document.getElementById("chat-window2").style.display = "none";
    document.getElementById("floating-button2").style.display = "none";
    document.getElementById("floating-button").style.display = "block";

  }

  function openConversation() {
    document.getElementById("chat-window2").style.display = "block";
    document.getElementById("floating-button2").style.display = "block";
    document.getElementById("floating-button").style.display = "none";
    document.getElementById("chat-window1").style.display = "none";
  }

  //Gets the text from the input box(user)
  function userResponse() {
    let userText = document.getElementById("textInput").value;
    if (userText == "") {
      alert("Please type something!");
    } else {
      document.getElementById("messageBox").innerHTML += `<div class="first-chat">
      <p>${userText}</p>
      <div class="arrow"></div>
    </div>`;
      document.getElementById("textInput").value = "";
      var objDiv = document.getElementById("messageBox");
      objDiv.scrollTop = objDiv.scrollHeight;

      setTimeout(() => {
        adminResponse(userText);
      }, 1000);
    }
  }

  //admin Respononse to user's message
  function adminResponse(userText) {
    let requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        text: userText,
      })
    };

    // Fetch the advice from the server using POST request
    fetch(base_url + 'chatbot/get_advice', requestOptions)
      .then(response => response.json())
      .then(adviceData => {
        console.log(adviceData);
        let Adviceobj = adviceData.slip;
        let messageBox = document.getElementById("messageBox");

        // Append new advice with potential images
        messageBox.innerHTML += `
                <div class="second-chat">
                    <div class="circle" id="circle-mar"><strong style="color: #FFF; font-size:16px; display:flex;">P</strong></div>
                    <div>${Adviceobj.advice}</div>
                    <div class="arrow"></div>
                </div>`;

        // Handle image click events
        handleImageClick();

        // Scroll to the bottom of the message box
        messageBox.scrollTop = messageBox.scrollHeight;
      })
      .catch(error => {
        console.log('Error fetching advice:', error);
      });
  }


  // Handle image click events

  // Handle image click events
  function handleImageClick() {
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    // Add event listener to all images inside message box
    document.querySelectorAll("#messageBox img").forEach(img => {
      img.addEventListener('click', function() {
        $('#myModal').modal('show');
        modalImg.src = this.src;
      });
    });
  }

  //press enter on keyboard and send message
  addEventListener("keypress", (e) => {
    if (e.keyCode === 13) {

      const e = document.getElementById("textInput");
      if (e === document.activeElement) {
        userResponse();
      }
    }
  });
</script>
<div class="modal" tabindex="-1" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img class="modal-content" id="img01">
      </div>
    </div>
  </div>
</div>