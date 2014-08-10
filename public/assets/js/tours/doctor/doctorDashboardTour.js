$(function () {
  
  tour.start();
 
  $("#helpMe").click(helpMeEvent);
});

var helpMeEvent = function(){
  tour.setCurrentStep(1);
  tour.start(true);
}