$(function () {
  tour.start();
  $("#helpMe").click(helpMeEvent);
});

var helpMeEvent = function(){
  tour.setCurrentStep(0);
  tour.start(true);
}