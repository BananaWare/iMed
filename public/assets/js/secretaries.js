// Document ready
//var selectHospitalCombo = $('#selectHospitalCombo');
var secretarysRutInput = $('#secretarysRutInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese rut de secretaria y presione enter. (Ejemplo: 12345678-9 o 12.345.678-9)';
var dataTable;

$(function() {
  //Iniciamos datatable para que pesque los textos inicialmente en español.
  
  dataTable = $('#secretariesTable').dataTable({
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
  
  //patientsMagicSuggest.clear();
  loadSecretariesTable();
  
    if (typeof hospitalSelected !== "undefined")
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
  
});

var eventClickEvent = function(calEvent, jsEvent, view) {
  //TODO: cargar la información pertinente antes de abrir el modal
        //$('#secretariesModal').modal('show');
}

var removeSecretaryDoctor = function (e){
  var id = e.dataset.idSecretaryDoctor;
  $.ajax({
    url: "/dashboard/doctor/unassignSecretary",
    type: "POST",
    data: {'idSecretaryDoctor': id},
    success: function(){
      var key = indexOfHospitalSelected();
      var key2 = indexOfSecretary(e.dataset.rut);
      
      hospitals[key].secretaries.splice(key2,1);
      //hospitalSelected.secretaries.splice(key2,1);
      selectHospitalComboBox.magicSuggest().setData(hospitals);
      //hospitalsComboSelectionChange();
      loadSecretariesTable();
    },
    error: function(){
      
    }
  });
}
var loadSecretariesTable = function (){
  dataTable.DataTable().clear().draw();
  dataTable.DataTable().destroy();  
  
  
  if (undefined === hospitalSelected.secretaries)
    hospitalSelected.secretaries = [];
  
  dataTable = $('#secretariesTable').dataTable({
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
          return "<a class='btn btn-danger' data-rut=" + row["rutFormated"] +
            " data-id-secretary-doctor=" + row["pivot"].idSecretaryDoctor +
            " onclick='removeSecretaryDoctor(this)'>" +
            "<i class='glyphicon glyphicon-remove icon-white'></i> Quitar</a>";
        },
        "aTargets": [ 6 ]
      }
    ],
    "sPaginationType": "full_numbers",
    "aaData": hospitalSelected.secretaries,
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
secretarysRutInput.on("keypress", function(e) {
  // Si presiona enter.
  if (e.keyCode == 13) {
    $.ajax({
      url: "/dashboard/doctor/assignSecretary",
      type: "POST",
      data: {'rut': secretarysRutInput.val(), 'idHospital': hospitalSelected.idHospital},
      success: function(xhr, textStatus, error){
        secretarysRutInput.val('');
        console.log(xhr);
        alert('asigno');
        var newSecretary = $.parseJSON(xhr);
        //var newSecretary = $.parseJSON(xhr.user);
        var key = indexOfHospitalSelected();
        
        if (typeof hospitals[key].secretaries === "undefined")
        {
          hospitals[key].secretaries = [];
          hospitalSelected.secretaries = [];
        }
        hospitals[key].secretaries.push(newSecretary);
        //hospitalSelected.secretaries.push(newSecretary);
        selectHospitalComboBox.magicSuggest().setData(hospitals);
        
        //hospitalsComboSelectionChange();
        loadSecretariesTable();
      },
      error: function(){
        alert('no se pudo agregar la secretaria');
      }
    });
    return false; // prevent the button click from happening
  }
});

indexOfHospitalSelected = function()
{
  temp = $.grep(hospitals, function( n, i ) {
    return (n.idHospital==hospitalSelected.idHospital);
  });
  return key = $.inArray(temp[0], hospitals);
}

indexOfSecretary = function(secretaryRut)
{
  secretaryRut = secretaryRut.split("-")[0].replace(/\./g, '');
  temp = $.grep(hospitalSelected.secretaries, function( n, i ) {
    return (n.rut==secretaryRut);
  });
  return key = $.inArray(temp[0], hospitalSelected.secretaries);
}
