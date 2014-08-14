var panel = $("daysOfWeekPanel");
$(function() {
  console.log(schedules);
  
});

function getWeekDay(day)
{
  $(schedules).each(function(key, value){
    if (value.dayOfWeek == day)
      return value;
  });
  return null;
}

$("#buttonSaveSchedules").click(function(e) {
  var daysOfWeek = $(".dayOfWeek");
  var checkboxes = daysOfWeek.find('.checkboxDayOfWeek');
  var startHours = $("input[name='startHourTimePicker']");
  //$( "input[name='startHourTimePicker']" )[0].value
  var endHours = $("input[name='endHourTimePicker']");
  var intervalTimes = $("input[name='intervalTimePicker']");
  
  var days = [];
  for(i=0; i<7; i++)
  {
    console.log(i);
    var day = new Object();
    day.idDoctorSchedule = daysOfWeek[i].dataset.idDoctorSchedule;
    day.activate = checkboxes[i].checked;
    day.startHour = startHours[i].value;
    day.endHour = endHours[i].value;
    day.intervalTime = intervalTimes[i].value;
    day.dayOfWeek = i+1;

    days.push(day);
  }
  prueba = days;
  $.ajax({
    url: "/dashboard/doctor/changeSchedules",
    type: "POST",
    dataType: "json",
    data: { 'schedules': days },
    success: function(){
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_SUCCESS,
        title: 'Enhorabuena',
        message: "Los horarios se han actualizado correctamente.",
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialogRef){
            dialogRef.close();
          }
        }]
      });
    },
    error: function(xhr){
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_DANGER,
        title: 'Tenemos un problema',
        message: "Hubo un problema al actualizar los horarios, recargue la página e inténtelo nuevamente.",
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialogRef){
            dialogRef.close();
          }
        }]
      });
      console.log(xhr);
    }
  });
})