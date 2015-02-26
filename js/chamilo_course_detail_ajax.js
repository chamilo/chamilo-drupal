(function($) {
  $(document).ready(function() {
    $('.ajax-container .ajax-link a').click(function() {
      $(this).parent().parent().parent().children('.ajax-container-close').addClass('active');
      $(this).parent().parent().parent().children('.ajax-container-close').show();
      $(this).parent().parent().removeClass('active');
      $(this).parent().hide();
    });

    $('.ajax-container-close .ajax-link a').click(function() {
      $(this).parent().parent().parent().children('.ajax-container').addClass('active');
      $(this).parent().parent().parent().children('.ajax-container').children('.ajax-link').show();
      $(this).parent().parent().removeClass('active');
      $(this).parent().parent().hide();
    });
  });
})(jQuery);
