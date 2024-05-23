"use strict";

var timeout = '';
var msg_count = []

$(document).on('click', '#delete_chat', function (e) {
  e.preventDefault();
  var id = $(this).data("id");
  Swal.fire({
    title: are_you_sure,
    text: you_want_to_delete_this_chat_this_can_not_be_undo,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'OK'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: base_url + 'chat/delete-chat/' + id,
        data: "opposite_user_id=" + id,
        dataType: "json",
        success: function (result) {
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

$("#chat-form").submit(function (event) {
  event.preventDefault(); // Prevent default form submission

  clearTimeout(timeout); // Clear any existing timeouts

  const chatInput = $('#chat_input');
  const chatText = chatInput.val().trim();

  if (chatText.length > 0) {
    const formData = new FormData(this);

    // Send the form data via AJAX
    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (result) {
        if (result.error) {
          iziToast.error({
            title: 'Something went wrong, please try again',
            message: '',
            position: 'topRight'
          });
        } else {
          // Add the chat message to the chat box (assuming it's sent from the right)
          $.chatCtrl('#mychatbox', {
            text: chatText,
            position: 'right', // You can adjust this if needed
          });
        }
      },
      error: function (xhr, status, error) {
        console.error(`Error in chat submission: ${status} - ${error}`);
        iziToast.error({
          title: 'Something went wrong, please try again',
          message: '',
          position: 'topRight'
        });
      }
    });

    // Clear the chat input field
    chatInput.val('');
  }

  return false; // Prevent form submission
});



$.chatCtrl = function (chatbox, options) {
  const { text, position = 'right', time = new Date().toLocaleTimeString() } = options;
  let messageHtml = '';

  if (position === 'left') {
    messageHtml = `
      <div class="media my-4 justify-content-start align-items-start">
        <div class="image-box me-sm-3 me-2">
        <ul class="kanbanimg me-4 mt-2">
          <li><span>ME</span></li>
        </ul>
        </div>
        <div class="message-received">
          <p class="mb-1">${text}</p>
        </div>
      </div>
    `;
  } else {
    messageHtml = `
      <div class="media mb-4 justify-content-end align-items-end">
        <div class="message-sent">
          <p class="mb-1">${text}</p>
        </div>
        <div class="image-box ms-sm-3 ms-2 mb-4">
        <ul class="kanbanimg me-4 mt-2">
          <li><span>ME</span></li>
        </ul>
        </div>
      </div>
    `;
  }

  $(chatbox).append(messageHtml);
  $(chatbox).scrollTop($(chatbox)[0].scrollHeight); // Scroll to the bottom
};

function get_chat(opposite_user_id) {
  $.ajax({
    type: "POST",
    url: `${base_url}chat/get_chat`,
    data: { opposite_user_id: opposite_user_id },
    dataType: "json",
    success: function (result) {
      console.log(result);
      if (result.error) {
        iziToast.error({
          title: 'Something went wrong, try again',
          message: '',
          position: 'topRight'
        });
        return;
      }

      if (!result.data) {
        return;
      }

      const chats = result.data;
      const chatbox = $('#mychatbox');

      if (!msg_count[opposite_user_id] || msg_count[opposite_user_id] < chats.length) {
        msg_count[opposite_user_id] = chats.length;
        chatbox.empty();
        chats.forEach(chat => {
          const chatHtml = createChatHtml(chat, result.opposite_user);
          chatbox.append(chatHtml);
        });
      }
      markChatAsRead(opposite_user_id);
    },
    error: function (xhr, status, error) {
      console.error(`Error fetching chat: ${status} - ${error}`);
      iziToast.error({
        title: 'Something went wrong, try again',
        message: '',
        position: 'topRight'
      });
    }
  });

  timeout = setTimeout(function () {
    const to_id = $("#to_id").val();
    if (to_id) {
      get_chat(to_id);
    }
  }, 7000);
}

function createChatHtml(chat, user) {
  if (chat.position === 'left') {
    var html = `<div class="media my-4  justify-content-start align-items-start">
    <div class="image-box me-sm-3 me-2">`;
    if (user.profile) {
      html += `<img src="` + user.profile + `" alt="" class="rounded-circle img-1">`;
    } else {
      html += `<ul class="kanbanimg me-4 mt-2">
      <li><span>ME</span></li>
    </ul>`;
    }


    html += `</div>
    <div class="message-received">
      <p class="mb-1 me-5">
      ${chat.text || ''}
      </p>
    </div>
  </div>
    `;
    return html;
  } else {
    return `
      <div class="media mb-4 justify-content-end align-items-end">
        <div class="message-sent d-block">
          <p class="mb-1">${chat.text || ''}</p>
        </div>
        <div class="image-box ms-sm-3 ms-2 mb-4">
        <ul class="kanbanimg me-4 mt-2">
          <li><span>ME</span></li>
        </ul>
        </div>
      </div>
    `;
  }
}

function markChatAsRead(opposite_user_id) {
  $.ajax({
    type: "POST",
    url: `${base_url}chat/chat_mark_read`,
    data: { opposite_user_id: opposite_user_id },
    dataType: "json",
    success: function (result) {
      // Optionally handle the result
    },
    error: function (xhr, status, error) {
      console.error(`Error marking chat as read: ${status} - ${error}`);
    }
  });
}


$(document).on('click', '.user-selected-for-chat', function (e) {
  e.preventDefault();
  $(".chat-content").html('');
  clearTimeout(timeout);
  var card = $('#mychatbox');

  $(this).find('.new_msg').remove();
  $("#delete_chat").removeClass('d-none');
  $("#delete_chat2").removeClass('d-none');
  var id = $(this).data("id");
  msg_count[id] = '';
  $.ajax({
    type: "POST",
    url: base_url + 'users/ajax_get_user_by_id',
    data: "id=" + id,
    dataType: "json",
    success: function (result) {
      get_chat(result['data'].id);
      if (result['error'] == false) {
        $("#to_id").val(result['data'].id);
        $("#delete_chat").attr('data-id', result['data'].id);
        $("#chat-form").removeClass('d-none');
        $("#current_chating_user").html(result['data'].first_name + ' ' + result['data'].last_name);
      }
      console.log(result);
    }
  });
});

