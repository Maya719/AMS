function doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
     
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}

    // leaves
    $("#leave-modal").on('click', '.btn-create', function(e) {
        var modal = $('#leave-modal');
        var form = $('#modal-add-leaves-part');
        var formData = form.serialize();
        console.log(formData);
      
        $.ajax({
          type: 'POST',
          url: form.attr('action'),
          data: formData,
          dataType: "json",
          success: function(result) {
            // Hide error message after 4 seconds
            modal.find('.modal-body').append('<div class="alert alert-danger">' + result['message'] + '</div>').find('.alert').delay(4000).fadeOut();
          }
        });
      
        e.preventDefault();
      });
      

