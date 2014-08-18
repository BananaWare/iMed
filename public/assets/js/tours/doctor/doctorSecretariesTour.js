
$(function () {
  $("#helpMe").click(helpMeEvent);
  tour.start();
});

var helpMeEvent = function(){
  tour.setCurrentStep(4);
  tour.start(true);
}