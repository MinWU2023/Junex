//faq
var action = 'click';
var speed = "500";

//Document.Ready
$(document).ready(function(){
  //Question handler
$('li.question').on(action, function(){
  //gets next element
  //opens .a of selected question
$(this).next().slideToggle(speed)
    //selects all other answers and slides up any open answer
    .siblings('li.answer').slideUp();
  
  //Grab img from clicked question
var img = $(this).children('div.column');
  //Remove Rotate class from all images except the active
  $('div.column').not(img).removeClass('rotate');
  //toggle rotate class
  img.toggleClass('rotate');

});//End on click
});//End Ready
 