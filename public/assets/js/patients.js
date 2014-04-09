// Document ready
var selectHospitalCombo = $('#selectHospitalCombo');
var patientsRutInput = $('#patientsRutInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese rut de paciente y presione enter. (Ejemplo: 12345678-9 o 12.345.678-9)';

$(function() {
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
    $('#patientsTable tbody tr').remove();
    selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
    
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
    
    if ( typeof selection.patients === "undefined" || selection.patients.length == 0)
      return;
    var rows;
    $.each(selection.patients, function(key, patient) {
        
        rows += '<tr>' +
                  '<td>' + patient.fullName + '</td>' +
                  '<td>' + patient.rutFormated + '</td>' +
                  '<td>' + patient.age + '</td>' +
                  '<td>' + patient.userInfo.email + '</td>' +
                  '<td>' + patient.userInfo.phone + '</td>' +
                  '<td>' + patient.userInfo.city + '</td>' +
                  '<td><a class="btn btn-primary" href="#" onclick="removePatient(this)" ' + 
                  'data-rut="' + patient.rut + '" ' +
                  'data-index="' + key +
                  '"><i class="glyphicon glyphicon-remove icon-white"></i> Desactivar</a></td>' +
                '</tr>';
    });
    $('#patientsTable').append(rows);
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
    /*
    $.ajax({
      url: "/assignSecretary",
      type: "POST",
      data: {'rut': secretarysRutInput.val(), 'idHospital': hospital.idHospital},
      success: function(xhr, textStatus, error){
        secretarysRutInput.val('');
        alert('asigno');
        var newSecretary = $.parseJSON(xhr);
        var selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
        $.each(hospitals, function(key, hospital){
          if (hospital.idHospital == selection.idHospital)
          {
            if (typeof hospitals[key].secretaries === "undefined")
            {
               hospitals[key].secretaries = [];
               selection.secretaries = [];
            }
            hospitals[key].secretaries.push(newSecretary);
            selection.secretaries.push(newSecretary);
            selectHospitalCombo.magicSuggest().setData(hospitals);
            return false; // nos salimos antes del bucle each
          }
        });        
        hospitalsComboSelectionChange();
      },
      error: function(){
        alert('no se pudo agregar la secretaria');
      }
    });
    */
    return false; // prevent the button click from happening
  }
});