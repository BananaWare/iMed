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
  
  if(view.name != 'month')
  {
    return; 
  }
  
  console.log($('#selectDoctorCombo').magicSuggest().getSelectedItems());

  var selectedNumberDayOfWeek = date.utc().format('d');
  var selectedDoctor = $('#selectDoctorCombo').magicSuggest().getSelectedItems()[0];
  var selectedDaySchedule = null;
 
  var agendaDayOptions = {}
  
  var dayEvents = [];
    
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
  agendaDayOptions = {
    slotDuration: selectedDaySchedule.intervalTime,
    minTime: selectedDaySchedule.startHour,
    maxTime: selectedDaySchedule.endHour
  }
  
  $.each(selectedDoctor.patientsHours, function(key, value){
    var startDate = moment(value.dateTimeAssign);
    var endDate = moment(value.dateTimeEnd);
     
    if(
      (startDate.utc().format("YYYY-MM-DD") == date.utc().format("YYYY-MM-DD")) 
      && (endDate.utc().format("YYYY-MM-DD") == date.utc().format("YYYY-MM-DD"))
    )
    {
      var backgroundColor = value.confirmed ? '#5cb85c' : '#f0ad4e';
      var confirmedText = value.confirmed ? 'Confirmada' : 'Por confirmar';
      
        
      var tempEvent = {
        title: 'Hora asignada - Estado: ' + confirmedText + ' - Motivo: ' + value.reason,
        start:  value.dateTimeAssign,
        end: value.dateTimeEnd,
        color: backgroundColor,
        textColor: 'white'
      }

      dayEvents.push(tempEvent);
      
    }

  });
  
  drawCalendar(dayEvents, agendaDayOptions);
  
  $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
  $('#calendar').fullCalendar('gotoDate', date);
}

var hospitalsComboSelectionChange = function(event, combo, selection){

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

//Evento que se dispara cuando se selecciona un doctor
var doctorsComboSelectionChange = function(event, combo, selection){
  console.log(selection); 
  var currentDoctor = selection[0];  
  
  drawCalendar(null, "");
}

//Evento que se dispara cuando se hace click en un evento del calendario
var eventClickEvent = function(calEvent, jsEvent, view) {
  if(view.name != 'agendaDay')
  {
    return; 
  }
  //TODO: cargar la información pertinente antes de abrir el modal
  $('#assignHourModal').modal('show');
}

//Evento que se dispara cuando se selecciona un bloque del calendario
var selectBlockEvent = function(start, end, jsEvent, view)
{
  if(view.name != 'agendaDay')
  {
    return; 
  }
  else
  {
    console.log(start.utc().format("YYYY:mm:ss") + " ---- " + end.utc().format("YYYY:mm:ss"));
    $('#assignHourModal').modal('show');
  }
}

var viewChangeEvent = function(view, element)
{
  if(view.name == 'month')
  {
     
  }
  
  
}

//Devuelve un arreglo que contiene en cada clave la cantidad de horas pedidas para ese día
function getAvailableHours(patientsHours)
{
  var usedBlocksPerDay = new Array();
  var selectedDoctor = $('#selectDoctorCombo').magicSuggest().getSelectedItems()[0];
  
  var freeBlocksPerDay = new Array();
  
  var blocksPerDay = new Array();
  /*    slotDuration: selectedDaySchedule.intervalTime,
    minTime: selectedDaySchedule.startHour,
    maxTime: selectedDaySchedule.endHour
*/    
  $.each(selectedDoctor.schedules, function(key,value) {
    var startHour = moment(value.startHour, "HH:mm:ss");
    var endHour = moment(value.endHour, "HH:mm:ss");
    var interval = moment(value.intervalTime, "HH:mm:ss").minutes();
    var durationInMinutes = moment.duration(endHour.subtrack(startHour)).asMinutes();
    
    blocksPerDay[value.dayOfWeek] = Math.floor(durationInMinutes / interval);
    
  });
  
  //Obtengo las horas por día
  $.each(patientsHours, function(key, value) {

    var dayNumber = moment(value.dateTimeAssign).utc().format('D');
    
    console.log(dayNumber);
    (usedBlocksPerDay[dayNumber] == undefined) ? usedBlocksPerDay[dayNumber] = 1 : usedBlocksPerDay[dayNumber] += 1;
    
  }); 
  
  return hoursPerDay;
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
    editable: false,
    selectable: true,
    dragable: false,
    events: events,
    dayClick: dayClickEvent,
    eventClick: eventClickEvent,
    select: selectBlockEvent,
    viewRender: viewChangeEvent
  }
  
  $('#calendar').fullCalendar(options);  

}