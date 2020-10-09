// Array of words
count = 0; 
var words = ['2019', '2009', '2010', '2011', '2012', '2015']; 
// Function that executes every 2000 milliseconds 
var t = setInterval(function() { 
  // Change the word in the span for a random one in the array of words 
  $('#text').text( words[ count % words.length ] ); 
}, 3000); 

// Array of words
count = 0; 
var words2 = ['2014/15', '2005/06', '2008/09', '2009/10']; 
// Function that executes every 2000 milliseconds 
var t = setInterval(function() { 
  // Change the word in the span for a random one in the array of words 
  $('#text2').text( words2[ count % words.length ] ); 
}, 3000); 

setTimeout(function(){
    document.getElementById('rocket-red').className = 'fireworks';
}, 12000);
setTimeout(function(){
    document.getElementById('rocket-red-left').className = 'fireworks';
}, 12000);
setTimeout(function(){
    document.getElementById('fireworks-yellow').className = 'fireworks';
}, 11500);
setTimeout(function(){
    document.getElementById('fireworks-yellow-left').className = 'fireworks';
}, 11500);
setTimeout(function(){
    document.getElementById('pack').className = 'pack';
}, 1000);
setTimeout(function(){
    document.getElementById('pack-rotate').className = 'pack-rotate';
}, 6200);

$('li').click(function(){
    $(this).addClass('active')
})

jQuery(document).ready(function($) {
  $('.resume') .hide()
$('a[href^="#"]').on('click', function(event) {
$('.resume') .hide()
    var target = $(this).attr('href');

    $('.resume'+target).toggle();

});
});