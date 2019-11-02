  $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //            modal.find('.modal-title').text('New message to ' + recipient)
      modal.find('.modal-body input').val(recipient)
  })


  $('#modal-next').click(function () {
      $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
  });

  $('#modal-back').click(function () {
      $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
  });

  $('#modal-next-md').click(function () {
      $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
  });

  $('#modal-back-md').click(function () {
      $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
  });


  // image gallery
  // init the state from the input
  $(".image-checkbox").each(function () {
      if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
          $(this).addClass('image-checkbox-checked');
      } else {
          $(this).removeClass('image-checkbox-checked');
      }
  });

  // sync the state to the input
  $(".image-checkbox").on("click", function (e) {
      $(this).toggleClass('image-checkbox-checked');
      var $checkbox = $(this).find('input[type="checkbox"]');
      $checkbox.prop("checked", !$checkbox.prop("checked"))

      e.preventDefault();
  });
