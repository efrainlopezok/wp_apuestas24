$(function(){
  // -- Smooth scroll on pageload
  if( window.location.hash ) {
    ea_scroll( window.location.hash );
  }
});
// Smooth scrolling anchor links
function ea_scroll( hash ) {
  var target = $( hash );
  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
  if (target.length) {
    var top_offset = 0;
    if ( $('.header').css('position') == 'fixed' ) {
      top_offset = $('.header').height(); /* .header <--- CHANGE THIS */
    }
    if( $('body').hasClass('admin-bar') ) {
      top_offset = top_offset + $('#wpadminbar').height();
    }
     $('html,body').animate({
       scrollTop: target.offset().top - top_offset
    }, 1000);
    return false;
  }
}
// -- Smooth scroll on click
$('a[href*="#"]:not([href="#"]):not(.no-scroll)').click(function() {
  if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
    ea_scroll( this.hash );
  }
});
