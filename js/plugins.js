$(document).ready(function () {
  $(document).click(function (event) { 
      var clickover = $(event.target); 
      var _opened = $(".navbar-collapse").hasClass("show"); 
      if (_opened === true && !clickover.hasClass("navbar-toggler")) { 
          $(".navbar-toggler").click();
      }
  });
});

$(document).ready(function(){
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();

      var hash = this.hash;
      
      $('html, body').animate({ 
        scrollTop: $(hash).offset().top 
      }, 800, function(){
        window.location.hash = hash; 
      });
    }
  });
});

/*========== Configuração Lightbox
https://lokeshdhakar.com/projects/lightbox2/ ==========*/

$(document).ready(function(){ 
  lightbox.option({
    'resizeDuration': 700,
    'wrapAround': false,
    'imageFadeDuration': 600
  })
});


$(function () {

  $('#contact-form').validator();
  $('#contact-form').on('submit', function (e) {
      if (!e.isDefaultPrevented()) {
          var url = "contact/contact.php";
          $.ajax({
              type: "POST",
              url: url,
              data: $(this).serialize(),
              success: function (data)
              {
                  var messageAlert = 'alert-' + data.type;
                  var messageText = data.message;
                  var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    if (messageAlert && messageText) {
                    $('#contact-form').find('.messages').html(alertBox);
                                  $('#contact-form')[0].reset();
                  }
              }
          });
          return false;
      }
  })
});