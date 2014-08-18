$(function () {
  tour.start();
  $("#helpMe").click(helpMeEvent);
});

var helpMeEvent = function(){
  if(window.location.pathname.indexOf("doctor") > -1)
  {
    tour.setCurrentStep(9);
  }
  else
  {
      
  }
  tour.start(true);
}