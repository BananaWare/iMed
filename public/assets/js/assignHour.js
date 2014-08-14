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
    sortOrder: 'lastname',
    maxSelection: 1,
    highlight: false,
    data: hospital.patients,
    selectionRenderer: patientsComboSelectionRenderer,
    renderer: patientsComboRenderer,
    displayField: 'fullNameRut', // Campo necesario ya que magicSuggest no filtra por dos atributos
    valueField: 'rut',
    placeholder: 'Escriba o seleccione un paciente',
    noSuggestionText: 'No hay resultados para su búsqueda',
    allowFreeEntries: false,
    typeDelay: 100,
  }); 
  if (role == "secretary")
  {
    selectDoctorCombo = $('#selectDoctorCombo').magicSuggest({
      width: 'auto',
      sortOrder: 'lastname',
      valueField: 'rut',
      maxSelection: 1,
      highlight: false,
      allowFreeEntries: false,
      displayField: 'fullNameRut', // Campo necesario ya que magicSuggest no filtra por dos atributos
      data: hospital.doctors,
      placeholder: 'Escriba o seleccione un doctor',
      noSuggestionText: 'No hay resultados para su búsqueda',
      selectionRenderer: function(v){
        return v.fullName;
      },
      renderer: function(v){
        /*'<div style="float:left;">' + '<img src="' + v.image + '"/></div>' + */
        return  '<div">' +
          '<div style="padding-left:10px;font-style:bold;font-size:120%;color:#333">' + v.fullName + '  <span style="font-style:none;color: #999">' + v.rutFormated + '</span></div>' +
          '</div>';
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
      selectDoctorCombo.setValue(selectDoctorCombo.getData())
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
  $('.dp').datepicker();
  
  $(patientsMagicSuggest).on('keyup', keyUpPatientsMagicSuggest);
});

var patientsComboSelectionRenderer = function (a){
  return a.fullName;
}

var patientsComboRenderer = function(v){
  /*'<div style="float:left;">' + '<img src="' + v.image + '"/></div>' + */
  return  '<div">' +
    '<div style="padding-left:10px;font-style:bold;font-size:120%;color:#333">' + v.fullName + '  <span style="font-style:none;color: #999">' + v.rutFormated + '</span></div>' +
    '</div>';
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
      (startDate.format("YYYY-MM-DD") == date.format("YYYY-MM-DD")) 
      && (endDate.format("YYYY-MM-DD") == date.format("YYYY-MM-DD"))
    )
    { 
      var backgroundColor = value.confirmed ? '#329232' : '#C97D12';
      var confirmedText = value.confirmed ? 'Confirmada' : 'Por confirmar';
      var tempEvent = {
        title: 'Estado: ' + confirmedText + ' - Paciente: ' + value.patient.fullName + " - RUT: " +
          value.patient.rutFormated + " - Asignado por: " + value.assigner.fullName,
        start:  value.dateTimeAssign,
        end: value.dateTimeEnd,
        color: backgroundColor,
        textColor: 'white',
        eventType: eventType.AssignedHour,
        patientHour: value
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
  if (selectedDaySchedule === null)
    return selectedDaySchedule;
  
  //Aqui comienza la logica de horas extras para los dias correspondientes.
  var extra = getExtraHoursFromDay(date);
  var end = moment("1990-01-01 " + selectedDaySchedule.endHour, "YYYY-MM-DD HH:mm:ss");
  var interval = moment.duration({
    minutes: selectedDaySchedule.intervalTime.split(':')[1],
    hours: selectedDaySchedule.intervalTime.split(':')[0]
  });
  
  for(i=0; i<extra; i++)
    end = end.add(interval);
  
  selectedDaySchedule.endHourFinal = end.format("HH:mm:ss");
  return selectedDaySchedule;

}
var dayClickEvent = function(date, jsEvent, view) {
  //Solo debe correr cuando la vista actual es month
  if(view.name != 'month')
  {
    return; 
  }
  renderDay(date, view);
}

function renderDay(date, view)
{
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
      case eventType.AssignedHour:
        console.log(calEvent);
        $('#idPatientHourSelected').val(calEvent.patientHour.idHour);
        $('#ahDateTime').text(calEvent.start.format("LLLL"));
        $('#ahName').text(calEvent.patientHour.patient.fullName);
        $('#ahRut').text(calEvent.patientHour.patient.rutFormated);
        $('#ahAssignBy').text(calEvent.patientHour.assigner.fullName);
        if (calEvent.patientHour.confirmed)
          $('#ahState')[0].innerHTML = "<span class='label label-success'>Confirmada</span>";
        else
          $('#ahState')[0].innerHTML = "<span class='label label-warning'>Por confirmar</span>";
        if (calEvent.patientHour.confirmed === 1)
          $('#confirmHourAccept').hide();
        else
          $('#confirmHourAccept').show();
        $('#confirmHourModal').modal('show');
        return;
        
      case eventType.NotWork:
        return;
        
      case eventType.PatientHour:
        //TODO: cargar la información pertinente antes de abrir el modal
        $('#assignHourModal').modal('show');
        break;
    }
}

$("#createPatientAccept").click(function(e) {
  createPatient();
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
    console.log(start);
  console.log(end);
    $("#dateTimeFormatted").html(start.format('dddd DD [de] MMMM YYYY H:mm') + " - " + end.format('H:mm'));
    patientsMagicSuggest.clear();
    $("#startHour").val(start);
    $("#endHour").val(end)
    $('#assignHourModal').modal('show');
  }
}

//Devuelve un arreglo que contiene en cada clave la cantidad de horas pedidas para ese día
function getAvailableHoursEvents()
{
  var usedBlocksPerDay = [];
  
  var freeBlocksPerDay = [];
  
  var blocksPerDay = [];
  usedBlocksPerDay[currentDatesInMemory.Months.startMonth] = [];       
  usedBlocksPerDay[currentDatesInMemory.Months.centralMonth] = []; 
  usedBlocksPerDay[currentDatesInMemory.Months.endMonth] = [];
  //$(currentDoctor.schedules).each(function(key,value) {
  $.each(currentDoctor.schedules, function(key,value) {
    if(value.dayOfWeek == 7)
      value.dayOfWeek = 0;
    
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
    var extraHours = getExtraHoursFromDay(moment(value.dateTimeAssign));
    
    (usedBlocksPerDay[monthNumber][dayNumber] == undefined) ? usedBlocksPerDay[monthNumber][dayNumber] = blocksPerDay[dayOfWeek] + extraHours - 1 :     usedBlocksPerDay[monthNumber][dayNumber] -= 1;
    
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
            
            var extraHours = getExtraHoursFromDay(initDate);
            
            var tempEvent = {
              title: (blocksPerDay[dayOfWeek] + extraHours)  + ' Horas disponibles',
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
            var endEvent = moment(initDate.utc());
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
    maxTime: agendaDayOptions.endHourFinal,
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

  viewChange(view);
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
    endHourFinal: endEvent.format('HH:mm:ss')
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
  if (patientsMagicSuggest.getSelection().length === 0)
  {
    BootstrapDialog.show({
          type: BootstrapDialog.TYPE_WARNING,
          title: 'Debe seleccionar un paciente',
          message: "Para asignar una hora debe seleccionar un paciente en la barra de más arriba o crear un paciente nuevo en el botón de al lado.",
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
    return;
  }
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
        
        currentDoctor.patientsHours.push(response);
        var view = $('#calendar').fullCalendar('getView');
        var date = view.intervalStart.utc();
        renderDay(date, view);
        
        $("#assignHourModal").modal('hide');
        
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Hora correctamente asignada',
          message: 'La hora fue asignada correctamente al paciente.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      },
    error: function(response){
      console.log(response);
      if(response.responseText == "denied")
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_DANGER,
          title: 'Tenemos un problema',
          message: "No se pueden asignar horas anteriores a la fecha y hora actual.",
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      else
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_DANGER,
          title: 'Tenemos un problema',
          message: "No se pudo asignar la hora al paciente, actualice la página " + 
            "y compruebe que la hora no ha sido ocupada.",
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
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
      url: '/dashboard/' + localStorage.userRole + '/refreshHoursForCalendar',
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
      },
      error: function(res){
         BootstrapDialog.show({
          type: BootstrapDialog.TYPE_DANGER,
          title: 'Tenemos un problema',
          message: "Error cargando los datos para el calendario.",
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      console.log(res);
      
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

$("#confirmHourAccept").click(function(e) {
  $.ajax({ 
      url: '/dashboard/' + localStorage.userRole + '/confirmHour',
      data: {
        'idPatientHour' : $("#idPatientHourSelected").val()
      },
      dataType: 'json',
      type: 'post',
      success: function(response) {
        console.log(response);
        $(currentDoctor.patientsHours).each(function(index, element){
          if (element.idHour == response.idHour)
          {
            currentDoctor.patientsHours[index].confirmed = true;
            return false;
          }
        });
        var view = $('#calendar').fullCalendar('getView');
        var date = view.intervalStart.utc();
        renderDay(date, view);
        $("#confirmHourAccept").modal('hide');
        
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Hora correctamente confirmada',
          message: 'La hora fue confirmada correctamente.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      },
    error: function(response){
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_DANGER,
        title: 'Tenemos un problema',
        message: 'Hubo un problema al confirmar la hora',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialogRef){
            dialogRef.close();
          }
        }]
      });
      console.log(response);
    }
  });
});

$("#revokeHourAccept").click(function(e) {
  $.ajax({ 
      url: '/dashboard/' + localStorage.userRole + '/revokeHour',
      data: {
        'idPatientHour' : $("#idPatientHourSelected").val()
      },
      dataType: 'json',
      type: 'post',
      success: function(response) {
        console.log(response);
        $(currentDoctor.patientsHours).each(function(index, element){
          if (element.idHour == response.idHour)
          {
            currentDoctor.patientsHours.splice($.inArray(element, currentDoctor.patientsHours),1);
            return false;
          }
        });
        var view = $('#calendar').fullCalendar('getView');
        var date = view.intervalStart.utc();
        renderDay(date, view);
        $("#revokeHourAccept").modal('hide');
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Hora correctamente eliminada',
          message: 'La hora fue eliminada correctamente.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
        
      },
    error: function(response){
      console.log(response);
      if(response.responseText == "denied")
      {  
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_DANGER,
          title: 'Tenemos un problema',
          message: 'No se pueden eliminar horas de pacientes que sean de fechas que ya pasaron.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      }
    }
  });
});

function getExtraHoursFromDay(day){
  var extra = 0;
   $.each(currentDoctor.customSchedules, function(key, value){
    if(value.day == day.utc().format("YYYY-MM-DD"))
    {
      extra = value.extraHours;
      return false;
    }
  });
  return extra;
}


function viewChange(viewName)
{
  //Primero revisamos si el doctor trabaja hoy.
  var dow = $('#calendar').fullCalendar('getDate').format('d');
  if (dow === 0) dow = 7;
  var work = false;
  $.each(currentDoctor.schedules, function(index, value){
    if (value.dayOfWeek == dow)
      work = true;
  });
    
  
  // Luego ocultamos o mostramos
  if (viewName == "agendaDay" && work)
    $("#addExtraHourButton").show();
  else
    $("#addExtraHourButton").hide();
}
function addExtraHour(){
  $("#addExtraHourModal").modal("show");
}

$("#addExtraHourAccept").click(function(e) {
  var currentView = $('#calendar').fullCalendar('getView');
  if (currentView.name != "agendaDay")
    return;
  var currentDate = $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
  $.ajax({ 
      url: '/dashboard/' + localStorage.userRole + '/addExtraHour',
      data: {
        'doctorsRut' : currentDoctor.rut,
        'day' : currentDate
      },
      dataType: 'json',
      type: 'post',
      success: function(response) {
        if (response === false)
        {
          BootstrapDialog.show({
            type: BootstrapDialog.TYPE_DANGER,
            title: 'No se pueden agregar más horas',
            message: 'No se pudo agregar la hora ya que esta excedería el día actual y pertenecería al día siguiente.',
            buttons: [{
              label: 'Aceptar',
              cssClass: 'btn-primary',
              action: function(dialogRef){
                dialogRef.close();
              }
            }]
          });
          return;
        }
        var foundIt = false;
        $.each(currentDoctor.customSchedules, function(key, value){
          // Si el dia ya tiene horas extras, entonces le sumamos una hora extra
          if(value.day == currentDate)
          {
            value.extraHours += 1;
            foundIt = true;
            return false; //Salir antes del bucle
          }
        });
        // Si el dia no tenia horas extras, entonces creamos un objeto de hora extra nuevo.
        if (!foundIt)
        {
          var customSchedule = {day: currentDate, extraHours: 1};
          currentDoctor.customSchedules.push(customSchedule);
        }
        onDateChange(currentView);
      },
    error: function(response){
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_DANGER,
        title: 'Tenemos un problema',
        message: 'Hubo un error y no se pudo agregar la hora extra.',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialogRef){
            dialogRef.close();
          }
        }]
      });
      console.log(response);
    }
  });
});

function keyUpPatientsMagicSuggest(e, m, v)
{
  var foundIt = false;
  if (v.keyCode == 13) {
    $.each(hospital.patients, function(index, patient){
      if (patient.fullNameRut.toLowerCase().indexOf(patientsMagicSuggest.getRawValue().toLowerCase()) >= 0)
      {
        foundIt = true;
        return false; // break
      }
    });
    if (!foundIt)
    $("#createPatientModal").modal('show'); 
  }
}
