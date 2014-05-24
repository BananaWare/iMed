//var selectHospitalCombo = $('#selectHospitalCombo');
var patientsRutInput = $('#patientsRutInput');

const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese rut de paciente y presione enter. (Ejemplo: 12345678-9 o 12.345.678-9)';
var dataTable;

// Document ready
$(function() {
  dataTable = $('#patientsTable').dataTable({
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
  //hospitalSelected = hospitals[indexOfHospital($.cookie('idHospitalSelected'))];
  hospitalSelected = hospitals[indexOfHospital(localStorage.idHospitalSelected)];
  
  loadPatientsTable();
});

var eventClickEvent = function(calEvent, jsEvent, view) {
  //TODO: cargar la información pertinente antes de abrir el modal
        //$('#secretariesModal').modal('show');
}


var removePatient = function (e){
  var rut = e.dataset.rut;
  var idHospital = hospital.idHospital;
  $.ajax({
    url: "/doRemovePatient",
    type: "POST",
    data: {'rut': rut, 'idHospital': idHospital},
    success: function(){
      $.each(hospitals, function(key, hospital){
        if (hospital.idHospital == hospital.idHospital)
        {
          hospitals[key].patients.splice(e.dataset.index,1);
          //hospital.patients.splice(e.dataset.index,1);
          selectHospitalCombo.magicSuggest().setData(hospitals);
          
          return false;
        }
      });
      //hospitalsComboSelectionChange();
      loadPatientsTable();
    },
    error: function(){
      
    }
  });
}
var loadPatientsTable = function (){
  dataTable.DataTable().clear().draw();
  dataTable.DataTable().destroy();  
  
  if (typeof hospitalSelected !== "undefined")
  {
    patientsRutInput.prop('placeholder', PLACEHOLDER_HOSPITAL);
    patientsRutInput.prop('disabled', false);
  }
  else
  {
    patientsRutInput.prop('placeholder', PLACEHOLDER_NO_HOSPITAL);
    patientsRutInput.prop('disabled', true);
    
    return;
  }
  
  
  if (undefined === hospital.patients)
    hospital.patients = [];
  console.log(hospital.patients);
  dataTable = $('#patientsTable').dataTable({
    "aoColumnDefs": [
      {
        // `data` refers to the data for the cell (defined by `mData`, which
        // defaults to the column being worked with, in this case is the first
        // Using `row[0]` is equivalent.
        "mData": "name",
        "mRender": function ( data, type, row ) {
          return row['fullName'];
        },
        "aTargets": [ 0 ]
      },
      {
        "mData": "rut",
        "mRender": function ( data, type, row ) {
          return row['rutFormated'];
        },
        "aTargets": [ 1 ]
      },
      {
        "mData": "age",
        "mRender": function ( data, type, row ) {
          return row['age'];
        },
        "aTargets": [ 2 ]
      },
      {
        "mData": "userInfo.email",
        "mRender": function ( data, type, row ) {
          return row['userInfo'].email;
        },
        "aTargets": [ 3 ]
      },
      {
        "mData": "userInfo.phone",
        "mRender": function ( data, type, row ) {
          return row['userInfo'].phone;
        },
        "aTargets": [ 4 ]
      },
      {
        "mData": "userInfo.city",
        "mRender": function ( data, type, row ) {
          return row['userInfo'].city;
        },
        "aTargets": [ 5 ]
      },
      {
        "mData": null,
        "mRender": function ( data, type, row ) {
          return "<a class='btn btn-warning' data-rut=" + row["rutFormated"] +
            " onclick='modifyPatient(this)'>" +
            "<i class='glyphicon glyphicon-pencil icon-white'></i> Modificar</a>";
        },
        "aTargets": [ 6 ]
      }
    ],
    "sPaginationType": "full_numbers",
    "aaData": hospital.patients,
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

  $('.btn').button();
  
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

patientsRutInput.on("keypress", function(e) {
  // Si presiona enter.
  if (e.keyCode == 13) {
    $('#createPatientModal').modal('show');
    return false; // prevent the button click from happening
  }
});

$.getScript('/assets/js/createPatientAccept.js');

$("#createPatientAccept").click(function(e) {
  createPatient(true);
});


var patientClickedIndex;
var modifyPatient = function (e){
  patientClickedIndex = dataTable.fnGetPosition(e.parentElement.parentElement);
  var index1 = indexOfHospitalSelected();
  var index2 = indexOfPatient(e.dataset.rut);
  
  var patient = hospitals[index1].patients[index2];
  
  $(".rut").prop('disabled', true);
  
  $('.genderMale').prop('checked', false);
  $('.genderFemale').prop('checked', false);
  
  $('#modifyPatientModal').modal('show');
  $('.rut').val(patient.rutFormated);
  $('.name').val(patient.name);
  $('.lastname').val(patient.lastname);
  $('.birthdate').val(patient.birthdate);
  $('.email').val(patient.userInfo.email);
  $('.phone').val(patient.userInfo.phone);
  $('.city').val(patient.userInfo.city);
  $('.address').val(patient.userInfo.address);
  
  if (patient.gender == "male")
    $('.genderMale').prop('checked', true);
  else if (patient.gender == "female")
    $('.genderFemale').prop('checked', true)
  $(':input:checked').parent('.btn').addClass('active');
  
  contact.empty();
  contact.removeClass("alert alert-danger");
  personal.empty();
  personal.removeClass("alert alert-danger");
}

$( "#modifyPatientAccept" ).click(function(e) {
  $.ajax({
    url: "/dashboard/doctor/modifyPatient",
    type: "POST",
    data: {'rut': $('.rut')[1].value, 'name': $('.name')[1].value, 'lastname': $('.lastname')[1].value,
           'birthdate': $('.birthdate')[1].value, 'email': $('.email')[1].value, 'phone': $('.phone')[1].value,
           'city': $('.city')[1].value, 'address': $('.address')[1].value, 'gender': 
           $('input[name=gender]:checked').val(), 'idHospital': hospital.idHospital},
    success: function($xhr){
      patientsRutInput.val('');
      
      try{
        var modifiedPatient = $.parseJSON($xhr);
      
        var key = indexOfHospitalSelected();
        if (typeof hospitals[key].patients === "undefined")
        {
          hospitals[key].patients = [];
          hospital.patients = [];
        }
        var key2 = indexOfPatient(modifiedPatient.rut);
        hospitals[key].patients[key2] = modifiedPatient;
        //hospital.patients[key2] = modifiedPatient;
        
        selectHospitalComboBox.magicSuggest().setData(hospitals);   
        //hospitalsComboSelectionChange();
        loadPatientsTable();
        $('#modifyPatientModal').modal('hide');
      }
      catch(err){
        checkAttributes($xhr);
      }
    },
    error: function($sss){
      console.log($sss);
      alert('error');
    }
  });
});

indexOfHospitalSelected = function()
{
  temp = $.grep(hospitals, function( n, i ) {
    return (n.idHospital==hospital.idHospital);
  });
  return key = $.inArray(temp[0], hospitals);
}

indexOfPatient = function(patientRut)
{
  if(typeof patientRut == "string")
    patientRut = patientRut.split("-")[0].replace(/\./g, '');
  temp = $.grep(hospital.patients, function( n, i ) {
    return (n.rut==patientRut);
  });
  return key = $.inArray(temp[0], hospital.patients);
}