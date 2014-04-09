// Document ready
var selectHospitalCombo = $('#selectHospitalCombo');
var secretarysRutInput = $('#secretarysRutInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese rut de secretaria y presione enter. (Ejemplo: 12345678-9 o 12.345.678-9)';

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
  
    secretarysRutInput.prop('placeholder', PLACEHOLDER_NO_HOSPITAL);
    secretarysRutInput.prop('disabled', true);
  
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
    $('#secretariesTable tbody tr').remove();
    selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
  
    if (typeof selection !== "undefined")
    {
      secretarysRutInput.prop('placeholder', PLACEHOLDER_HOSPITAL);
      secretarysRutInput.prop('disabled', false);
    }
    else
    {
      secretarysRutInput.prop('placeholder', PLACEHOLDER_NO_HOSPITAL);
      secretarysRutInput.prop('disabled', true);
      return;
    }
  
    if ( typeof selection.secretaries === "undefined" || selection.secretaries.length == 0)
      return;
    var rows;
    $.each(selection.secretaries, function(key, secretary) {
        rows += '<tr>' +
                  '<td>' + secretary.fullName + '</td>' +
                  '<td>' + secretary.rutFormated + '</td>' +
                  '<td><a class="btn btn-primary" href="#" onclick="removeSecretaryDoctor(this)" ' + 
                  'data-id-Secretary-Doctor="' + secretary.pivot.idSecretaryDoctor + '" ' +
                  'data-index="' + key +
                  '"><i class="glyphicon glyphicon-remove icon-white"></i> Desactivar</a></td>' +
                '</tr>';
    });
    $('#secretariesTable').append(rows);
}

var removeSecretaryDoctor = function (e){
  var id = e.dataset.idSecretaryDoctor;
  $.ajax({
    url: "/unassignSecretary",
    type: "POST",
    data: {'idSecretaryDoctor': id},
    success: function(){
      var selection = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
      $.each(hospitals, function(key, hospital){
        if (hospital.idHospital == selection.idHospital)
        {
          hospitals[key].secretaries.splice(e.dataset.index,1);
          selection.secretaries.splice(e.dataset.index,1);
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
secretarysRutInput.on("keypress", function(e) {
  // Si presiona enter.
  if (e.keyCode == 13) {
    var hospital = selectHospitalCombo.magicSuggest().getSelectedItems()[0];
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
    return false; // prevent the button click from happening
  }
});