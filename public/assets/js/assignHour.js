$.getScript('/assets/js/createPatientAccept.js');
var DEBUG = true;
//var selectHospitalCombo;
var currentDoctor;
//var currentHospital;
var selectDoctorCombo;
var selectPatientCombo = $('#selectPatientCombo');
var patientsMagicSuggest;
var currentDatesInMemory = {
  Year: -1,
  Months: {
    startMonth: -1,
    centralMonth: -1,
    endMonth: -1
    }
}
var eventType = {
  NotWork: 0,
  PatientHour: 1
}
var calendarSpinner;

$(document).ready(function() {
   patientsMagicSuggest = selectPatientCombo.magicSuggest({
    width: 'auto',
    sortOrder: 'name',
    groupBy: 'userInfo.city',
    maxSelection: 1,
    highlight: false,
    data: hospitalWithPatients.patients,
    selectionRenderer: patientsComboSelectionRenderer,
    renderer: patientsComboRenderer,
    valueField: 'rut',
    placeholder: 'Escriba o seleccione un elemento',
    noSuggestionText: 'No hay resultados para su búsqueda',
    allowFreeEntries: false
  }); 
  if (role == "secretary")
  {
    selectDoctorCombo = $('#selectDoctorCombo').magicSuggest({
      width: 'auto',
      sortOrder: 'name',
      groupBy: 'userInfo.city',
      valueField: 'rut',
      maxSelection: 1,
      highlight: false,
      allowFreeEntries: false,
      data: hospital.doctors,
      placeholder: 'Escriba o seleccione un elemento',
      noSuggestionText: 'No hay resultados para su búsqueda',
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

    if (typeof hospital.doctors === "undefined")
      selectDoctorCombo.disable();
    else
      selectDoctorCombo.enable();

    selectDoctorCombo.clear();
    $(selectDoctorCombo).on('selectionchange', doctorsComboSelectionChange);
    if (typeof hospital.doctors == "undefined")
    {
      // TODO
      /*********** SI UN HOSPITAL NO TIENE DOCTORES OCURREN ERRORES. POR EJEMPLO: SE SELECCIONA PRIMERO UN HOSPITAL CON DOCTORES, LUEGO SE SELECCIONA
      UN DOCTOR, LUEGO SE SELECCIONA UN HOSPITAL SIN DOCTORES *******/
    }
    else if (hospital.doctors.length == 1)
    {
      $('#selectDoctorCombo').magicSuggest().setValue();
    }
  }
  else if (role == "doctor")
  {
    currentDoctor = user;  
  }
 
  debugWrite(hospitalWithPatients);
  debugWrite(hospital);

  $("#createPatientButton").on('click', createPatientClick);
  if (role == "doctor")
    makeCalendar();
});

var patientsComboSelectionRenderer = function (a){
  return a.name;
}

var patientsComboRenderer = function(v){
  return '<div>' +
    '<div style="float:left;"><img src="' + v.image + '"/></div>' +
    '<div style="padding-left: 85px;">' +
    '<div style="padding-top: 20px;font-style:bold;font-size:120%;color:#333">' + v.fullName + '</div>' +
    '<div style="color: #999">' + v.rutFormated + '</div>' +
    '</div>' +
    '</div><div style="clear:both;"></div>';
}

var createPatientClick = function()
{
  //$("#assignHourModal").modal('hide');
  $("#createPatientModal").modal('show');
}

function getEventsForDay(date, patientsHours)
{
  var dayEvents = [];
    $.each(patientsHours, function(key, value){
    var startDate = moment(value.dateTimeAssign);
    var endDate = moment(value.dateTimeEnd);     
    if (
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
        textColor: 'white',
        eventType: eventType.NotWork
      }
      dayEvents.push(tempEvent);           
    }
  });
  return dayEvents;
}

function getDaySchedule(date, selectedDoctor)
{
  var selectedDaySchedule = null;
  var selectedNumberDayOfWeek = date.utc().format('d');
  $.each(selectedDoctor.schedules, function(key, value){
    if(value.dayOfWeek == selectedNumberDayOfWeek)
    {
      selectedDaySchedule = value;
    }
  }); 

  return selectedDaySchedule;

}
var dayClickEvent = function(date, jsEvent, view) {
  //Solo debe correr cuando la vista actual es month
  if(view.name != 'month')
  {
    return; 
  }
  var selectedDoctor = currentDoctor;  
  var selectedDaySchedule = null; 
  var dayEvents = [];
    
  selectedDaySchedule = getDaySchedule(date, selectedDoctor);

  if(!selectedDaySchedule)
  {
    changeViewAndSource(getNotWorkEvent(date), getNotWorkDaySchedule(date), date, "agendaDay");
    return;
  }

  dayEvents = getEventsForDay(date, selectedDoctor.patientsHours);
  changeViewAndSource(dayEvents, selectedDaySchedule, date, "agendaDay");
}

//Evento que se dispara cuando se selecciona un doctor
var doctorsComboSelectionChange = function(event, combo, selection){
  currentDoctor = selection[0];
  makeCalendar();
}

var makeCalendar = function(){
  var now = moment();
  currentMonth = parseInt(now.utc().format('M'));
  currentYear = parseInt(now.utc().format('YYYY'));

  currentDatesInMemory.Months.startMonth = currentMonth - 1; 
  currentDatesInMemory.Months.centralMonth = currentMonth;  
  currentDatesInMemory.Months.endMonth = currentMonth + 1; 
  currentDatesInMemory.Year = currentYear;

  changeViewAndSource(getAvailableHoursEvents(), "", null, "month");
  //changeViewAndSource(getAvailableHoursEvents(currentDoctor), "", null, "month");
}

//Evento que se dispara cuando se hace click en un evento del calendario
var eventClickEvent = function(calEvent, jsEvent, view) {
  if(view.name != 'agendaDay')
  {
    dayClickEvent(calEvent.start, jsEvent, view);
    return; 
  }
  
  switch(calEvent.eventType)
    {
      case evetType.NotWork:
        return;
        
      case eventType.PatientHour:
        //TODO: cargar la información pertinente antes de abrir el modal
        $('#assignHourModal').modal('show');
        break;
    }
}



/*
$("#createPatientCancel").click(function(e) {
  $('#assignHourModal').modal('show');
})*/

$("#createPatientAccept").click(function(e) {
  createPatient();
  //$('#assignHourModal').modal('show');
})
//Evento que se dispara cuando se selecciona un bloque del calendario

var selectBlockEvent = function(start, end, jsEvent, view)
{
  if(view.name != 'agendaDay')
  {
    return; 
  }
  else
  {
    $("#startHour").val(start);
    $("#endHour").val(end)
    $('#assignHourModal').modal('show');
  }
}

//Devuelve un arreglo que contiene en cada clave la cantidad de horas pedidas para ese día
function getAvailableHoursEvents()//currentDoctor)
{

  var usedBlocksPerDay = [];
  
  var freeBlocksPerDay = [];
  
  var blocksPerDay = [];
  usedBlocksPerDay[currentDatesInMemory.Months.startMonth] = [];       
  usedBlocksPerDay[currentDatesInMemory.Months.centralMonth] = []; 
  usedBlocksPerDay[currentDatesInMemory.Months.endMonth] = [];
  //$(currentDoctor.schedules).each(function(key,value) {
  $.each(currentDoctor.schedules, function(key,value) {
    
    var startHour = moment(value.startHour, "HH:mm:ss");

    var endHour = moment(value.endHour, "HH:mm:ss");

    var interval = moment(value.intervalTime, "HH:mm:ss").hours()*60 + moment(value.intervalTime, "HH:mm:ss").minutes();

    var durationInMinutes = moment.duration(endHour.subtract(startHour)).asMinutes();

    blocksPerDay[value.dayOfWeek] = Math.ceil(durationInMinutes / interval);
    
  });

  //Obtengo las horas por día
  $.each(currentDoctor.patientsHours, function(key, value) {
    
    var dayNumber = parseInt(moment(value.dateTimeAssign).utc().format('D'));
    var monthNumber = parseInt(moment(value.dateTimeAssign).utc().format('MM'));
    var dayOfWeek = parseInt(moment(value.dateTimeAssign).utc().format('d'));

    (usedBlocksPerDay[monthNumber][dayNumber] == undefined) ? usedBlocksPerDay[monthNumber][dayNumber] = blocksPerDay[dayOfWeek] - 1 :     usedBlocksPerDay[monthNumber][dayNumber] -= 1;
    
  }); 
  
  var dayEvents = [];
  $.each(currentDatesInMemory.Months, function(key, value) {
    if(usedBlocksPerDay[value] == undefined)
    {
      return true;
    }
    else
    {
      var initDate = moment("01-" + value + "-" + currentDatesInMemory.Year, "DD-MM-YYYY").utc();
      var initMonth = parseInt(initDate.format('MM'));
      for(parseInt(initDate.format('D')); parseInt(initDate.format('MM')) == initMonth; initDate.add('days', 1))
      {
        var monthDay = initDate.format('D'); 
        var dayOfWeek = parseInt(initDate.format('d')); 
        //caso doctor no trabaja
        var schedule = getDaySchedule(initDate, currentDoctor);
        if(schedule == null)
        {
          dayEvents.push(getNotWorkEvent(initDate)[0]);
          continue;
        }
        else
        {
          if(usedBlocksPerDay[value][monthDay] == undefined)
          {
            var startEvent = moment(initDate.utc());
            startEvent.hours(0);
            startEvent.minutes(0);
            var endEvent =  moment(initDate.utc());
            endEvent.hours(23)
            endEvent.minutes(59);
            
            var tempEvent = {
              title: blocksPerDay[dayOfWeek] + ' Horas disponibles',
              start:  startEvent,
              end: endEvent,
              color: '#5cb85c',
              textColor: 'white',
              eventType: eventType.PatientHour
            }
            dayEvents.push(tempEvent);
          }
          else
          {
            var startEvent = moment(initDate.utc());
            startEvent.hours(0);
            startEvent.minutes(0);
            var endEvent =  moment(initDate.utc());
            endEvent.hours(23)
            endEvent.minutes(59);
            
            var backgroundColor = (usedBlocksPerDay[value][monthDay] > 0) ? '#5cb85c' : '#f0ad4e';
            var title = (usedBlocksPerDay[value][monthDay] > 0) ? usedBlocksPerDay[value][monthDay] + ' Horas disponibles' : 'No quedan horas disponibles'; 
            
            var tempEvent = {
              title: title,
              start:  startEvent,
              end: endEvent,
              color: backgroundColor,
              textColor: 'white',
              eventType: eventType.PatientHour
            }
            dayEvents.push(tempEvent);
          }

        }

      }

    }

  }); 
  return dayEvents;
}

 
function changeViewAndSource(events, agendaDayOptions, date, view){
  date = (date === null) ? $('#calendar').fullCalendar("getDate") : date;
  $('#calendar').fullCalendar('destroy');
  var options = {
    defaultDate: date,
    defaultView: view,
    slotDuration: agendaDayOptions.intervalTime,
    minTime: agendaDayOptions.startHour,
    maxTime: agendaDayOptions.endHour,
    allRowsTimestamp: true,
    hasAxisRange: true,
    axisRangeSeparator: 'a',
    //axisFormat: 'hh:mma',
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
    viewRender: viewChangeEvent,
    onNextOrPrev: onDateChange
  }
  
  $('#calendar').fullCalendar(options);  

}

function changeSource(eventSource)
{
  $('#calendar').fullCalendar('removeEvents');
  $('#calendar').fullCalendar('addEventSource', eventSource );
}
function getNotWorkDaySchedule(date)
{
  var startEvent = moment(date.utc());
  startEvent.hours(0);
  startEvent.minutes(0);
  var endEvent =  moment(date.utc());
  endEvent.hours(23)
  endEvent.minutes(59);
  
  var schedule = {
    intervalTime: moment.duration('24:00:00'),
    startHour: startEvent.format('HH:mm:ss'),
    endHour: endEvent.format('HH:mm:ss')
  }
  return schedule;
}
function getNotWorkEvent(date)
{
  var startEvent = moment(date.utc());
  startEvent.hours(0);
  startEvent.minutes(0);
  var endEvent =  moment(date.utc());
  endEvent.hours(23)
  endEvent.minutes(59);
  var dayEvents = [];   
  var tempEvent = {
    title: 'El doctor no trabaja hoy',
    start: startEvent,
    end: endEvent,
    color: '#d9534f',
    textColor: 'white',
    eventType: eventType.NotWork
  }
  dayEvents.push(tempEvent);           
  return dayEvents;
}
$("#assignHourAccept").click(function(e) {
  $.ajax({ 
      url: '/dashboard/' + localStorage.userRole + '/assignHour',
      data: {
        'idHospital' : localStorage.idHospitalSelected,
        'doctorsRut' : currentDoctor.rut,
        'patientsRut' : patientsMagicSuggest.getSelection()[0].rut,
        'dateTimeAssign' : $("#startHour").val(),
        'dateTimeEnd' : $("#endHour").val()
      },
      dataType: 'json',
      type: 'post',
      success: function(response) {
        console.log(response);
        alert("asignó");
        $("#assignHourModal").modal('hide');
      },
    error: function(response){
      console.log(response);
    }
  });
});

var onDateChange = function(view)
{
  debugWrite(view.intervalStart.utc());
  currentMonth = parseInt(moment(view.intervalStart).utc().format('M'));
  currentYear = parseInt(moment(view.intervalStart).utc().format('YYYY'));
  //Si aún no he cargado las horas para este mes
  if(currentMonth != currentDatesInMemory.Months.centralMonth)
  {
    currentDatesInMemory.Months.startMonth = currentMonth - 1; 
    currentDatesInMemory.Months.centralMonth = currentMonth;  
    currentDatesInMemory.Months.endMonth = currentMonth + 1; 
    currentDatesInMemory.Year = currentYear;
    $.ajax({ 
      url: '/dashboard/secretary/refreshHoursForCalendar',
      data: {
        idHospital: hospital.idHospital,
             rut: currentDoctor.rut,
             dv:currentDoctor.dv,
             months: currentDatesInMemory.Months,
             year: currentDatesInMemory.Year
      },
      dataType: 'json',
      type: 'post',
      beforeSend: function() { 
        //TODO: PONER FEEDBACK DE CARGA MIENTRAS EL CALENDARIO ESTA EN TRANSICION
      },
      success: function(response) {
        currentDoctor.patientsHours = response;
        switch(view.name)
        {
          case 'agendaDay':  
            var date = view.intervalStart.utc();
            var dayEvents = getEventsForDay(date, currentDoctor.patientsHours);
            var selectedDaySchedule = getDaySchedule(date, currentDoctor);
            if(!selectedDaySchedule)
            {
              changeViewAndSource(getNotWorkEvent(date), getNotWorkDaySchedule(date), date, "agendaDay");
              return;
            }
            dayEvents = getEventsForDay(date, currentDoctor.patientsHours);
            changeViewAndSource(dayEvents, selectedDaySchedule, date, "agendaDay");

            break;
          case 'month':
            var date = view.intervalStart.utc();
            changeViewAndSource(getAvailableHoursEvents(currentDoctor), "", date, "month");      
            break;
        }  
      }
    });
  }
  else
  {
    switch(view.name)
    {
      case 'agendaDay':   
        var date = view.intervalStart.utc();
        var dayEvents = getEventsForDay(date, currentDoctor.patientsHours);
        var selectedDaySchedule = getDaySchedule(date, currentDoctor);
        if(!selectedDaySchedule)
        {
          //Doctor no trabaja hoy
          //return;
          changeViewAndSource(getNotWorkEvent(date), getNotWorkDaySchedule(date), date, "agendaDay");
          return;
        }
        dayEvents = getEventsForDay(date, currentDoctor.patientsHours);
        changeViewAndSource(dayEvents, selectedDaySchedule, date, "agendaDay");
        break;
      case 'month':
        var date = view.intervalStart.utc();
        changeViewAndSource(getAvailableHoursEvents(currentDoctor), "", date, "month");           
        break;
    }    
  }

}

var viewChangeEvent = function(view, element)
{
  
}


function debugWrite(data)
{
  if(DEBUG)
  {
    console.log(data);
  }
}