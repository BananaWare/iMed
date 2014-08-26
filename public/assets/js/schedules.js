var panel = $("daysOfWeekPanel");
$(function() {
  var time = $('.startHourTimePicker').timepicker({ step : '10', scrollDefault : "09:00" });
  $('.endHourTimePicker').timepicker({
    'minTime': '00:00am',
    'maxTime': '11:30pm',
    'showDuration': true,
    'step': '10',
    'scrollDefault': $(this).val()
  });
  $('.startHourTimePicker').on('changeTime', function() {
    $('.endHourTimePicker[data-day-of-week='+ $(this).data('dayOfWeek') +']').timepicker('option', 'minTime', $(this).val());
  });
});

$(':checkbox').change(function() {
    if (this.checked) {
      console.log($(this).data('dayOfWeek') );
       $('.startHourTimePicker[data-day-of-week='+ $(this).data('dayOfWeek') +']').timepicker('setTime', '');
       $('.endHourTimePicker[data-day-of-week='+ $(this).data('dayOfWeek') +']').timepicker('setTime', '');
       $('.intervalTimePicker[data-day-of-week='+ $(this).data('dayOfWeek') +']').val('');
    }
    else {
      
    }
});

$('.startHourTimePicker').change(uncheckDayOfWeek);
$('.endHourTimePicker').change(uncheckDayOfWeek);
$('.intervalTimePicker').change(uncheckDayOfWeek);

function uncheckDayOfWeek()
{
  if ($(this).val() !== '')
    $('.checkboxDayOfWeek[data-day-of-week='+ $(this).data('dayOfWeek') +']').attr('checked', false);
}

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
    var day = new Object();
    day.idDoctorSchedule = daysOfWeek[i].dataset.idDoctorSchedule;
    day.activate = !checkboxes[i].checked;
    day.startHour = $(startHours[i]).timepicker('getTime') !== null ? $(startHours[i]).timepicker('getTime').toLocaleTimeString() : null;
    day.endHour = $(endHours[i]).timepicker('getTime') != null ? $(endHours[i]).timepicker('getTime').toLocaleTimeString() : null;
    var tempDate =  new Date('1990-01-01 00:00:00');
    tempDate.setMinutes(intervalTimes[i].value);
    day.intervalTime = intervalTimes[i].value !== null ? tempDate.toLocaleTimeString() : null;
    day.dayOfWeek = i+1;

    days.push(day);
  }
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