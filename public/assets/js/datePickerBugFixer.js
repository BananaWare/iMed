$(function() {
  var datepicker = $('.dp');
  var t ;
  $( document ).on(
      'DOMMouseScroll mousewheel scroll',
      '#modifyPatientModal', 
      function(){
          window.clearTimeout( t );
            t = window.setTimeout( function(){
                      $(datepicker[1]).datepicker('place')
                  }, 100 );   
      }
  );
  $( document ).on(
      'DOMMouseScroll mousewheel scroll',
      '#createPatientModal', 
      function(){
          window.clearTimeout( t );
            t = window.setTimeout( function(){
                      $(datepicker[0]).datepicker('place')
                  }, 100 );   
      }
  );
});