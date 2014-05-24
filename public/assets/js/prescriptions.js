// Document ready
var selectHospitalCombo = $('#selectHospitalComboBox');
var selectPatientCombo = $('#selectPatientCombo');
var patientsInput = $('#patientsInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese el rut, nombre o apellido del paciente para seleccionarlo de la lista';
var dataTable;
//var hospitalMagicSuggest;
var patientsMagicSuggest;
var patientSelected;

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
  /**** POR ESTA LINEA FALLA ****/
  //hospitalSelected = selectHospitalCombo.magicSuggest().getSelection()[0];
  //if (typeof patientsMagicSuggest !== "undefined")
    //patientsMagicSuggest.clear();
  
  dataTable.DataTable().clear().draw();
  dataTable.DataTable().destroy();
  
  
  if (typeof hospital === "undefined" || "undefined" === typeof hospital.patients)
  {
    //hospitalSelected.patients = [];
    return;
  } 
  patientsMagicSuggest = selectPatientCombo.magicSuggest({
    width: 'auto',
    sortOrder: 'name',
    groupBy: 'userInfo.city',
    maxSelection: 1,
    highlight: false,
    data: hospital.patients,
    selectionRenderer: patientsComboSelectionRenderer,
    renderer: patientsComboRenderer,
    valueField: 'rut',
    placeholder: 'Escriba o seleccione un elemento',
    noSuggestionText: 'No hay resultados para su búsqueda',
    allowFreeEntries: false
  });
  patientsMagicSuggest.enable();
  $(patientsMagicSuggest).on('selectionchange', patientsComboSelectionChange);
  
});

var eventClickEvent = function(calEvent, jsEvent, view) {
  //TODO: cargar la información pertinente antes de abrir el modal
        //$('#secretariesModal').modal('show');
}


var patientsComboSelectionChange = function(event, combo, selection){
  patientSelected = selectPatientCombo.magicSuggest().getSelection()[0];
  
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
  
  if ("undefined" === typeof patientSelected)
    return;
  
  dataTable = $('#medicalSheetsTable').dataTable({
    "order": [[ 1, "desc" ]],
    "aoColumnDefs": [
      {
        // Columna oculta utilizada para ordenar las fechas ya que no se pueden ordenar como tipo fecha.
        "mData": "dateHidden",
        "mRender": function ( data, type, row ) {
          return new Date(row['dateTimeAssign']);
        },
        "bVisible": false,
        "aTargets": [ 0 ]
      },
      {
        "mData": "date",
        "iDataSort": 0,
        "sWidth" : "20%",
        "mRender": function ( data, type, row ) {
          var d = new Date(row['dateTimeAssign']);
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
        "mData": "prescription",
        "mRender": function ( data, type, row ) {
          if (row['prescription'] !== null)
          {
            return "<a class='btn btn-info' data-rut=" + row["rutFormated"] +
              " data-id-hour=" + row["idHour"] +
              " onclick='seeDetails(this)'>" +
              "<i class='glyphicon glyphicon-list-alt icon-white'></i> Ver detalles</a>";
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
  
  $("#tdiagnostic").html(patientSelected.patientHours[indice].medicalSheet.diagnostic);
  
  
  $('#drugsPrescriptionsTable tbody tr').remove();
  
  var newrows;
  $(patientSelected.patientHours[indice].prescription.drugs).each(function(index, element)
  {
    newrows += "<tr><td>" + element.name + "</td><td>" + element.pivot.dosage + "</td><td>" + element.pivot.intervalTime 
      + "</td><td>" + element.pivot.term + "</td><td>" + element.pivot.observation + "</td></tr></tr>";
  });
  $('#drugsPrescriptionsTable').append(newrows);
  
  $('#seeDetailsModal').modal('show');
}

$('#seeDetailsModal').on('shown.bs.modal', function (e) {
  
})

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
  return '<big><span class="label label-danger">' + text + '</span></big>';
}