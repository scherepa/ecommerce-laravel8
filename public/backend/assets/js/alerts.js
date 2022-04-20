$closeA = $('.del-alert');
$closeA.parent().hide();
$('.myAlert').removeClass('hidden');
$closeA.parent().show(2000);
 $closeA.click(function(){
   $('.myAlert').slideUp(2000);
   $('.myAlert').addClass('hidden');
});
setTimeout(function(){
  if(!$('.myAlert').hasClass('hidden')){
  $('.myAlert').slideUp("slow", function(){$('.myAlert').addClass('hidden');});
  }
}, 5000);
