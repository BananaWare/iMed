	$(document).ready(function() {

    console.log(secretary.name);
    console.log(hospitals);
    var selectHospitalCombo = $('#selectHospitalCombo').magicSuggest({
      width: 'auto',
      //sortOrder: 'name',
      //groupBy: 'hospital.city',
      maxSelection: 1,
      highlight: false,
      data: hospitals,
      selectionRenderer: hospitalsComboSelectionRenderer,
      renderer: hospitalsComboRenderer,
    });

    $(selectHospitalCombo).on('selectionchange', hospitalsComboSelectionChange);
    if (hospitals.length == 1)
      $('#selectHospitalCombo').magicSuggest().setValue();
  });

var dayClickEvent = function(date, jsEvent, view) {

  console.log(date.utc());
  console.log(date.utc().format('dddd'));
  console.log(date.utc().format('d'));
  console.log($('#selectDoctorCombo').magicSuggest().getSelectedItems());
  //date.tz('America/Santiago');
  var selectedNumberDayOfWeek = date.utc().format('d');
  var selectedDoctor = $('#selectDoctorCombo').magicSuggest().getSelectedItems()[0];
  var selectedDaySchedule = null;
  $.each(selectedDoctor.schedules, function(key, value){
    if(value.dayOfWeek == selectedNumberDayOfWeek)
    {
      selectedDaySchedule = value;
      return;
    }
  });
  
  //Doctor no trabaja este día
  //TODO: HACER LOGICA PARA DIA EN QUE NO TRABAJA
  if(selectedDaySchedule == null)
  {
    alert("El doctor no trabaja hoy");
    return;
  }
  
  var agendaDayOptions = {
    slotDuration: selectedDaySchedule.intervalTime,
    minTime: selectedDaySchedule.startHour,
    maxTime: selectedDaySchedule.endHour
  }

  drawCalendar(null, agendaDayOptions);
  
  $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
  $('#calendar').fullCalendar('gotoDate', date);
}

var eventClickEvent = function(calEvent, jsEvent, view) {
  
  //TODO: cargar la información pertinente antes de abrir el modal
  $('#assignHourModal').modal('show');
}

var hospitalsComboSelectionChange = function(event, combo, selection){
    console.log(selection);
    var selectDoctorCombo = $('#selectDoctorCombo').magicSuggest({
      width: 'auto',
      sortOrder: 'name',
      groupBy: 'desc',
      maxSelection: 1,
        highlight: false,
        data: selection[0].doctors,
        renderer: function(v){
        return '<div>' +
            '<div style="float:left;"><img src="' + v.image + '"/></div>' +
            '<div style="padding-left: 85px;">' +
                '<div style="padding-top: 20px;font-style:bold;font-size:120%;color:#333">' + v.name + ' ' + v.lastname + '</div>' +
                '<div style="color: #999">' + v.city + '</div>' +
                '</div>' +
            '</div><div style="clear:both;"></div>';
        }
    });
    if (selection[0].doctors.length == 1)
      $('#selectDoctorCombo').magicSuggest().setValue();
  
    $(selectDoctorCombo).on('selectionchange', doctorsComboSelectionChange);
}

var hospitalsComboSelectionRenderer = function (a){
  return a.name;
}

var hospitalsComboRenderer = function(v){
        return '<div>' +
            '<div style="float:left;"><img src="' + v.image + '"/></div>' +
            '<div style="padding-left: 85px;">' +
                '<div style="padding-top: 20px;font-style:bold;font-size:120%;color:#333">' + v.name + '</div>' +
                '<div style="color: #999">' + v.address + '</div>' +
                '</div>' +
            '</div><div style="clear:both;"></div>';
}

var doctorsComboSelectionChange = function(event, combo, selection){
  console.log(selection); 
  var currentDoctor = selection[0];  
  
  var currentHours = [];
  
  //currentDoctor.patientsHours.each(function( index ) {
  //console.log( index + ": " + $( this ).text() );
//});
    
  drawCalendar(null, "");
}

function drawCalendar(events, agendaDayOptions){
    $('#calendar').fullCalendar('destroy'); 
  var options = {
    slotDuration: agendaDayOptions.slotDuration,
    minTime: agendaDayOptions.minTime,
    maxTime: agendaDayOptions.maxTime,
    allRowsTimestamp: true,
    hasAxisRange: true,
    axisRangeSeparator: 'a',
    axisFormat: 'hh:mma',
    ignoreTimezone: true,
    allDaySlot: false,
    allDayText: false,
    theme: true,
    lang: 'es',
    handleWindowResize: true,
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month'
    },
    editable: true,
    events: [
      {
        title: 'All Day Event',
        start: '2014-01-01'
      },
      {
        title: 'Long Event',
        start: '2014-01-07',
        end: '2014-01-10'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2014-01-09T16:00:00'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2014-01-16T16:00:00'
      },
      {
        title: 'Meeting',
        start: '2014-01-12T10:30:00',
        end: '2014-01-12T12:30:00'
      },
      {
        title: 'Lunch',
        start: '2014-01-12T12:00:00'
      },
      {
        title: 'Birthday Party',
        start: '2014-01-13T07:00:00'
      },
      {
        title: 'Click for Google',
        url: 'http://google.com/',
        start: '2014-01-28'
      }
    ],
    dayClick: dayClickEvent,
    eventClick: eventClickEvent
  }
  
  $('#calendar').fullCalendar(options);  

}