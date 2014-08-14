$(function () {
  $("#helpMe").click(helpMeEvent);
  tour.setCurrentStep(3);
  tour.start(true);
});

var helpMeEvent = function(){
  tour.setCurrentStep(4);
  tour.start(true);
}