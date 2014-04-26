// Document ready
var selectHospitalCombo = $('#selectHospitalCombo');
var patientsRutInput = $('#patientsRutInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese rut de paciente y presione enter. (Ejemplo: 12345678-9 o 12.345.678-9)';
var dataTable;

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
  var hospitalMagicSuggest = selectHospitalCombo.magicSuggest({
      width: 'auto',
      sortOrder: 'name',
      groupBy: 'hospital.city',
      maxSelection: 1,
      highlight: false,
      data: hospitals,
      selectionRenderer: hospitalsComboSelectionRenderer,
      renderer: hospitalsComboRenderer
    });
  
    patientsRutInput.prop('placeholder', PLACEHOLDER_NO_HOSPITAL);
    patientsRutInput.prop('disabled', true);
  
    $(hospitalMagicSuggest).on('selectionchange', hospitalsComboSelectionChange);
  
    if (hospitals.length == 1)
    {
      // Establece el unico valor de hospital por defecto.
      selectHospitalCombo.magicSuggest().setValue();
    }
  
});

var eventClickEvent = function(calEvent, jsEvent, view) {
  //TODO: cargar la información pertinente antes de abrir el modal
        //$('#secretariesModal').modal('show');
}

var hospitalsComboSelectionChange = function(event, combo, selection){
  selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
    dataTable.dataTable().fnDestroy();
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
              " data-name=" + (row["name"] == null ? "''" : row["name"]) +
              " data-lastname=" + (row["lastname"] == null ? "''" : row["lastname"]) +
              " data-gender=" + (row["gender"] == null ? "''" : row["gender"]) +
              " data-birthdate=" + (row["birthdate"] == null ? "''" : row["birthdate"]) +
              " data-email=" + (row["userInfo"].email == null ? "''" : row["userInfo"].email) +
              " data-phone=" + (row["userInfo"].phone == null ? "''" : row["userInfo"].phone) +
              " data-city=" + (row["userInfo"].city == null ? "''" : row["userInfo"].city) +
              " onclick='modifyPatient(this)'>" +
              "<i class='glyphicon glyphicon-pencil icon-white'></i> Modificar</a>";
          },
          "aTargets": [ 6 ]
        }
      ],
      "sPaginationType": "full_numbers",
      "aaData": selection.patients,
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
 
  
    if (typeof selection !== "undefined")
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
}

var removePatient = function (e){
  var rut = e.dataset.rut;
  var idHospital = selectHospitalCombo.magicSuggest().getSelectedItems()[0].idHospital;
  $.ajax({
    url: "/doRemovePatient",
    type: "POST",
    data: {'rut': rut, 'idHospital': idHospital},
    success: function(){
      var selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
      $.each(hospitals, function(key, hospital){
        if (hospital.idHospital == selection.idHospital)
        {
          hospitals[key].patients.splice(e.dataset.index,1);
          selection.patients.splice(e.dataset.index,1);
          selectHospitalCombo.magicSuggest().setData(hospitals);
          
          return false;
        }
      });
      hospitalsComboSelectionChange();
    },
    error: function(){
      
    }
  });
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
    var hospital = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
    $('#createPatientModal').modal('show');
    return false; // prevent the button click from happening
  }
});

$( "#createPatientAccept" ).click(function(e) {
  var hospitalSelected = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
  $.ajax({
    url: "/doctor/createPatient",
    type: "POST",
    data: {'rut': $('.rut').val(), 'name': $('.name').val(), 'lastname': $('.lastname').val(),
           'birthdate': $('.birthdate').val(), 'email': $('.email').val(), 'phone': $('.phone').val(),
           'city': $('.city').val(), 'address': $('.address').val(), 'gender': $('input[name=gender]:checked').val(),
           'idHospital': hospitalSelected.idHospital},
    success: function($xhr){
      patientsRutInput.val('');
      alert('asigno');
      console.log($xhr);
      var newPatient = $.parseJSON($xhr);
      $.each(hospitals, function(key, hospital){
        if (hospital.idHospital == hospitalSelected.idHospital)
        {
          if (typeof hospitals[key].patients === "undefined")
          {
            hospitals[key].patients = [];
            hospitalSelected.patients = [];
          }
          hospitals[key].patients.push(newPatient);
          hospitalSelected.patients.push(newPatient);
          selectHospitalCombo.magicSuggest().setData(hospitals);
          
          return false; // nos salimos antes del bucle each
        }
      });        
      hospitalsComboSelectionChange();
      $('#createPatientModal').modal('hide');
    },
    error: function($sss){
      console.log($sss);
      alert('error');
    }
  });
});

$('#createPatientModal').on('shown.bs.modal', function (e) {
  $('.rut').val($('#patientsRutInput').val());
  
  $('.name').val(''); $('.lastname').val('');
  $('.birthdate').val(''); $('.email').val(''); $('.phone').val('');
  $('.city').val(''); $('.address').val(''); $('input[name=gender]:checked').removeAttr("checked");
})

var patientClickedIndex;
var modifyPatient = function (e){
  patientClickedIndex = dataTable.fnGetPosition(e.parentElement.parentElement);
  $(".rut").prop('disabled', true);
  
  $('.genderMale').prop('checked', false);
  $('.genderFemale').prop('checked', false);
  
  $('#modifyPatientModal').modal('show');
  console.log(e.dataset);
  $('.rut').val(e.dataset.rut);
  $('.name').val(e.dataset.name);
  $('.lastname').val(e.dataset.lastname);
  $('.birthdate').val(e.dataset.birthdate);
  $('.email').val(e.dataset.email);
  $('.phone').val(e.dataset.phone);
  $('.city').val(e.dataset.city);
  $('.address').val(e.dataset.address);
  
  if (e.dataset.gender == "male")
    $('.genderMale').prop('checked', true);
  else if (e.dataset.gender == "female")
    $('.genderFemale').prop('checked', true)
}

$( "#modifyPatientAccept" ).click(function(e) {
  var hospitalSelected = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
  $.ajax({
    url: "/doctor/modifyPatient",
    type: "POST",
    data: {'rut': $('.rut')[1].value, 'name': $('.name')[1].value, 'lastname': $('.lastname')[1].value,
           'birthdate': $('.birthdate')[1].value, 'email': $('.email')[1].value, 'phone': $('.phone')[1].value,
           'city': $('.city')[1].value, 'address': $('.address')[1].value, 'gender': $('input[name=gender]:checked').val(),
           'idHospital': hospitalSelected.idHospital},
    success: function($xhr){
      patientsRutInput.val('');
      alert('asigno');
      console.log($xhr);
      var newPatient = $.parseJSON($xhr);
      $.each(hospitals, function(key, hospital){
        if (hospital.idHospital == hospitalSelected.idHospital)
        {
          if (typeof hospitals[key].patients === "undefined")
          {
            hospitals[key].patients = [];
            hospitalSelected.patients = [];
          }
          hospitals[key].patients.push(newPatient);
          hospitalSelected.patients.push(newPatient);
          selectHospitalCombo.magicSuggest().setData(hospitals);
          
          return false; // nos salimos antes del bucle each
        }
      });        
      hospitalsComboSelectionChange();
      $('#createPatientModal').modal('hide');
    },
    error: function($sss){
      console.log($sss);
      alert('error');
    }
  });
});
