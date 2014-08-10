// Document ready
var selectHospitalCombo = $('#selectHospitalComboBox');
var selectPatientCombo = $('#selectPatientCombo');
var patientsInput = $('#patientsInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese el rut, nombre o apellido del paciente para seleccionarlo de la lista';
var dataTable;
var patientsMagicSuggest;
var patientSelected;
var drugsPrescriptions = [];
$(function() {
  //Iniciamos datatable para que pesque los textos inicialmente en español.
  
  dataTable = $('#medicalSheetsTable').dataTable({
    "oLanguage": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }); 
  
  dataTable.DataTable().clear().draw();
  dataTable.DataTable().destroy();
  
  
  if (typeof hospital === "undefined" || "undefined" === typeof hospital.patients)
  {
    //hospitalSelected.patients = [];
    return;
  } 
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
    allowFreeEntries: false
  });
  patientsMagicSuggest.enable();
  $(patientsMagicSuggest).on('selectionchange', patientsComboSelectionChange);
  
  $("#printPresciption").click( printPresciptionClickEvent );
});
var printPresciptionClickEvent = function() {
      var pdf = new jsPDF('p', 'pt', 'letter');

    source = $('#prescriptionTable')[0];

    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };

  
    var header = new Array();
  

    pdf.text(35, 35, "Datos del profesional \n");  
    pdf.text(35, 65, "Doctor: " + "Alfredo Gallardo");
    pdf.text(35, 85, "Consulta: " + "Consulta Privada");
  
    pdf.text(35, 135, "Datos del paciente");  
    pdf.text(35, 165, "Nombre: " + "Elpa Ciente");
    pdf.text(35, 185, "Rut: " + "6.148.683-7");
  
    pdf.text(35, 235, "Receta");
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
  
      margins = {
        top: 255,
        bottom: 0,
        left: 35,
        width: 512
    };
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        pdf.output("dataurlnewwindow");
    }, margins);
}
var eventClickEvent = function(calEvent, jsEvent, view) {
  //TODO: cargar la información pertinente antes de abrir el modal
        //$('#secretariesModal').modal('show');
}


var patientsComboSelectionChange = function(event, combo, selection){
  patientSelected = selectPatientCombo.magicSuggest().getSelection()[0];
  // Borramos los valores de la creacion de receta
  drugsPrescriptions = [];
  
  
  dataTable.DataTable().clear().draw();
  dataTable.DataTable().destroy();
  
  
  $("#tfullName").html((patientSelected !== undefined) ? patientSelected.fullName : null);
  $("#trut").html((patientSelected !== undefined) ? patientSelected.rutFormated : null);
  $("#tage").html((patientSelected !== undefined) ? patientSelected.age + " años" : null);
  
  $("#tadr").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ?
    spanDanger(patientSelected.userInfo.medicalHistory.adr) : null);
  $("#tmorbid").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ? 
    spanDanger(patientSelected.userInfo.medicalHistory.morbid) : null);
  $("#tgynecological").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ?          
    spanDanger(patientSelected.userInfo.medicalHistory.gynecological) : null);
  $("#tfamily").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ?
    spanDanger(patientSelected.userInfo.medicalHistory.family) : null);
  $("#thabit").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ?
    spanDanger(patientSelected.userInfo.medicalHistory.habit) : null);
  $("#tother").html((patientSelected !== undefined && patientSelected.userInfo.medicalHistory !== null) ?
    spanDanger(patientSelected.userInfo.medicalHistory.other) : null);
  
  $('.cpAdr').val($("#tadr > big > span").html());
  $('.cpMorbid').val($("#tmorbid > big > span").html());
  $('.cpGynecological').val($("#tgynecological > big > span").html());
  $('.cpFamily').val($("#tfamily > big > span").html());
  $('.cpHabit').val($("#thabit > big > span").html());
  $('.cpOther').val($("#tother > big > span").html());
  
  if ("undefined" === typeof patientSelected)
    return;
  
  dataTable = $('#medicalSheetsTable').dataTable({
    "order": [[ 1, "desc" ]],
    "aoColumnDefs": [
      {
        // Columna oculta utilizada para ordenar las fechas ya que no se pueden ordenar como tipo fecha.
        "mData": "dateHidden",
        "mRender": function ( data, type, row ) {
          return getDateFromString(row['dateTimeAssign']);
        },
        "bVisible": false,
        "aTargets": [ 0 ]
      },
      {
        "mData": "date",
        "iDataSort": 0,
        "sWidth" : "20%",
        "mRender": function ( data, type, row ) {
          var d = getDateFromString(row['dateTimeAssign']);
          
          var day = d.getDate();
          var month = d.getMonth() + 1;
          var year = d.getFullYear();
          if (day < 10) {
            day = "0" + day;
          }
          if (month < 10) {
            month = "0" + month;
          }

          var minutes = (d.getMinutes() < 10) ? "0" + d.getMinutes() :  d.getMinutes();
          return day + "/" + month + "/" + year + " " + d.getHours() + ":" + minutes;

        },
        "aTargets": [ 1 ]
      },/*
        {
          "mData": "time",
          "sWidth" : "20px",
          "mRender": function ( data, type, row ) {
            var d = new Date(row['dateTimeAssign']);
            var minutes = (d.getMinutes() < 10) ? "0" + d.getMinutes() :  d.getMinutes();

            return  d.getHours() + ":" + minutes;
          },
          "aTargets": [ 2 ]
        },*/
      {
        "mData": "observation",
        "mRender": function ( data, type, row ) {
          return (row['medicalSheet'] !== null ? row['medicalSheet'].observation : null);
        },
        "aTargets": [ 2 ]
      },
      {
        "mData": "medicalSheet",
        "mRender": function ( data, type, row ) {
          var date = getDateFromString(row['dateTimeAssign']);
          var now = new Date();
          if (row['medicalSheet'] !== null)
          {
            return "<a class='btn btn-info' data-rut=" + row["rutFormated"] +
              " data-id-hour=" + row["idHour"] +
              " onclick='seeDetails(this)'>" +
              "<i class='glyphicon glyphicon-list-alt icon-white'></i> Ver detalles</a>";
          }
          else if (now.getDate() == date.getDate() && now.getMonth() == date.getMonth() && now.getYear() == date.getYear())
          {
            return "<a class='btn btn-primary' data-rut=" + row["rutFormated"] +
              " data-id-hour=" + row["idHour"] +
              " onclick='createPrescription(this)'>" +
              "<i class='glyphicon glyphicon-pencil icon-white'></i> Recetar</a>";
          }
          else
            return "No tiene";
        },
        "aTargets": [ 3 ]
      }
    ],
    "sPaginationType": "full_numbers",
    "aaData": patientSelected.patientHours,
    "oLanguage": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }); 
}

var seeDetails = function (e){
  var indice = indexOfPatientHour(e.dataset.idHour);
  
  $("#tgeneral").html(patientSelected.patientHours[indice].medicalSheet.generalExamination);
  $("#tbloodPressure").html(patientSelected.patientHours[indice].medicalSheet.bloodPressure);
  $("#ttemperature").html(patientSelected.patientHours[indice].medicalSheet.temperature);
  $("#tsat").html(patientSelected.patientHours[indice].medicalSheet.sat);
  $("#tsegmentary").html(patientSelected.patientHours[indice].medicalSheet.segmentary);
  $("#tcomplementary").html(patientSelected.patientHours[indice].medicalSheet.complementary);
  $("#tobservation").html(patientSelected.patientHours[indice].medicalSheet.observation);
  
  $("#tdiagnostic").html(patientSelected.patientHours[indice].medicalSheet.diagnostic);
  
  
  $('#drugsPrescriptionsTable tbody tr').remove();
  
  var newrows;
 if(patientSelected.patientHours[indice].prescription !== null)
 {
   $(patientSelected.patientHours[indice].prescription.drugs).each(function(index, element)
  {
    if (element.pivot !== undefined)
    {
      name = element.name;
      dosage = element.pivot.dosage;
      intervalTime = element.pivot.intervalTime;
      term = element.pivot.term;
      observation = element.pivot.observation;
    }
    else
    {
      name = element.bruteDrugName;
      dosage = element.dosage;
      intervalTime = element.intervalTime;
      term = element.term;
      observation = element.observation;
    }
    newrows += "<tr><td>" + name + "</td><td>" + dosage + "</td><td>" + intervalTime 
      + "</td><td>" + term + "</td><td>" + observation + "</td></tr></tr>";
  });
  $('#drugsPrescriptionsTable').append(newrows);
 }
  
  $('#seeDetailsModal').modal('show');
}

$('#seeDetailsModal').on('shown.bs.modal', function (e) {
  
})

var patientsComboSelectionRenderer = function (a){
  return a.fullName;
}

var patientsComboRenderer = function(v){
  /*'<div style="float:left;">' + '<img src="' + v.image + '"/></div>' + */
  return  '<div">' +
    '<div style="padding-left:10px;font-style:bold;font-size:120%;color:#333">' + v.fullName + '  <span style="font-style:none;color: #999">' + v.rutFormated + '</span></div>' +
    '</div>';
}

indexOfPatientHour = function(idHour)
{
  temp = $.grep(patientSelected.patientHours, function( n, i ) {
    return (n.idHour==idHour);
  });
  return key = $.inArray(temp[0], patientSelected.patientHours);
}

indexOfHospitalSelected = function()
{
  temp = $.grep(hospitals, function( n, i ) {
    return (n.idHospital==hospitalSelected.idHospital);
  });
  return key = $.inArray(temp[0], hospitals);
}

spanDanger = function(text)
{
  if(text!== null)
    return '<big><span class="label label-danger">' + text + '</span></big>';
  else
    return '';
}

getDateFromString = function(text)
{
  var a=text.split(" ");
  var date=a[0].split("-");
  var time=a[1].split(":");
  return new Date(date[0],(date[1]-1),date[2],time[0],time[1],time[2]);
}

var idPatientHourSelected;
var createPrescription = function (e){
  idPatientHourSelected = e.dataset.idHour;
  $('#createPrescriptionModal').modal('show');
}

$("#addDrugButton").click(function(e) {
  var drugPrescription = new Object({ bruteDrugName: $(".cpBruteDrugName").val(), idDrug: $(".cpIdDrug").val(),
                                     dosage: $(".cpDosage").val(), 
                                     term: $(".cpTerm").val(), intervalTime: $(".cpIntervalTime").val(),
                                     observation: $(".cpDrugObservation").val()});
  if (drugPrescription.idDrug !== "")
    drugName = drugPrescription.idDrug;
  else
    drugName = drugPrescription.bruteDrugName;
  drawDrugPrescriptionData(drugName, drugPrescription);
  
  drugsPrescriptions.push(drugPrescription);
  
  $('.cpIdDrug').val('');
  $('.cpBruteDrugName').val(''); $('.cpDosage').val('');
  $('.cpTerm').val(''); $('.cpIntervalTime').val('');   $('.cpDrugObservation').val('');
});

$('#createPrescriptionModal').on('shown.bs.modal', function (e) {
  /*$(".rut").prop('disabled', false);
  $('.rut').val($('#patientsRutInput').val());*/
  
  $('.cpIdDrug').val('');
  $('.cpBruteDrugName').val(''); $('.cpDosage').val('');
  $('.cpTerm').val(''); $('.cpIntervalTime').val(''); $('.cpDrugObservation').val('');
  
  $("#createDrugsPrescriptionsTable tbody > tr").remove();
 
  $.each(drugsPrescriptions, function(index, drugPrescription){
    if (drugPrescription.idDrug !== "")
      drugName = drugPrescription.idDrug;
    else
      drugName = drugPrescription.bruteDrugName;
    drawDrugPrescriptionData(drugName, drugPrescription);
  });
});

function drawDrugPrescriptionData(drugName, drugPrescription)
{
  var row = "<tr><td>" + drugName + "</td><td>"+ drugPrescription.dosage + 
      "</td><td>"+ drugPrescription.intervalTime + "</td><td>"+ drugPrescription.term + "</td><td>" + 
      drugPrescription.observation + "</td><td><a class='btn btn-danger remove-button' data-index" + 1 +
            " onclick='removeDrugPrescription(this)'>" +
            "<i class='glyphicon glyphicon-remove icon-white'></i> Quitar</a></td></tr>";
    $("#createDrugsPrescriptionsTable").append(row);
}

function removeDrugPrescription(e)
{
  var index = $("#createDrugsPrescriptionsTable  tbody tr").index(e.parentElement.parentElement);
  drugsPrescriptions.splice(index, 1);
  $(e.parentElement.parentElement).remove();
}

$("#saveAllButton").click(function(e) {
  $("#confirmPrescriptionModal").modal('show');
});

$("#confirmPrescriptionAccept").click(function(e) {
  var medicalHistory = new Object({adr: $('.cpAdr').val(), morbid: $('.cpMorbid').val(),
                                           gynecological: $('.cpGynecological').val(), family: $('.cpFamily').val(),
                                           habit: $('.cpHabit').val(), other: $('.cpOther').val()});
  var medicalSheet = new Object({generalExamination: $('.cpGeneral').val(),
                                 bloodPressure: $('.cpBloodPressure').val(),
                                 observation: $('.cpSheetObservation').val(),
                                 temperature: $('.cpTemperature').val(),
                                 sat: $('.cpSat').val(),
                                 segmentary: $('.cpSegmentary').val(),
                                 complementary: $('.cpComplementary').val(),
                                 diagnostic: $('.cpDiagnostic').val()});
         
  $.ajax({
    url: "/dashboard/doctor/savePrescriptionAndMedicalSheet",
    type: "POST",
    dataType: "json",
    data: { 'rut': patientSelected.rut, 'idHour' : idPatientHourSelected,
          'adr': medicalHistory.adr, 'morbid': medicalHistory.morbid, 'gynecological': medicalHistory.gynecological,
          'family': medicalHistory.family, 'habit': medicalHistory.habit, 'other': medicalHistory.other, 
          'generalExamination': medicalSheet.generalExamination, 'bloodPressure': medicalSheet.bloodPressure, 
           'observation': medicalSheet.Observation,
          'temperature': medicalSheet.temperature, 'sat': medicalSheet.sat, 'segmentary': medicalSheet.segmentary,
          'complementary': medicalSheet.complementary, 'diagnostic': medicalSheet.diagnostic,
          'drugsPrescriptions' : drugsPrescriptions
          },
    success: function(){
      $.each(hospital.patients, function(index, patient){
        if(patient.rut == patientSelected.rut)
        {
          $.each(patient.patientHours, function(i, patientHour){
            if (patientHour.idHour == idPatientHourSelected)
            {
              patientHour.medicalSheet = medicalSheet;
              if (drugsPrescriptions !== null)
              {
                patientHour.prescription = new Object({drugs : drugsPrescriptions});
              }
            }
          });
          patient.userInfo.medicalHistory = medicalHistory;
          patientsMagicSuggest.setSelection(patient);
        }
      });
      $("#createPrescriptionModal").modal('hide');
      //location.reload();
    },
    error: function(xhr){
      console.log(xhr);
    }
  });
});