$(document).ready(function(){
   $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
			scrollTop: ($($anchor.attr('href')).offset().top) 
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

$('body').scrollspy({
    target: '.navbar-fixed-top'
})

$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

$(".smoothScroll").click(function() {
    var id = $(this).attr('data-id');
    $([document.documentElement, document.body]).animate({
        scrollTop: $(id).offset().top
    }, 2000);
});
$(".nav-item").click(function() {
    $('.nav-item').each(function(){
        $(this).removeClass('active');
    });
    $(this).addClass('active');
});