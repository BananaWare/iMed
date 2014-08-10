// Document ready
var secretarysRutInput = $('#secretarysRutInput');
const PLACEHOLDER_NO_HOSPITAL = "Debe seleccionar un hospital primero.";
const PLACEHOLDER_HOSPITAL = 'Ingrese un rut y presione enter para crear una secretaria. (Ejemplo: 12345678-9 o 12.345.678-9)';
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
    data: {'idSecretaryDoctor': id}
  })
  .done(function(){
      var key = indexOfHospitalSelected();
      var key2 = indexOfSecretary(e.dataset.rut);
      
      hospitals[key].secretaries.splice(key2,1);
      //hospitalSelected.secretaries.splice(key2,1);
      selectHospitalComboBox.magicSuggest().setData(hospitals);
      //hospitalsComboSelectionChange();
      loadSecretariesTable();
    
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_SUCCESS,
        title: 'Enhorabuena',
        message: 'La secretaria se ha eliminado correctamente.',
        buttons: [{
          label: 'Aceptar',
          cssClass: 'btn-primary',
          action: function(dialogRef){
            dialogRef.close();
          }
        }]
      });
    })
    .fail(function(){
    
      BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Ha ocurrido un error',
          message: 'Ocurrió un error al eliminar la secretaria.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      
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
          return "<a class='btn btn-danger remove-button' data-rut=" + row["rutFormated"] +
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
    $("#assignSecretaryModal").modal('show');
    $("#rutDialog").html(secretarysRutInput.val());
  }
});

$("#assignSecretaryAccept").click(function(e) {
  $.ajax({
    url: "/dashboard/doctor/assignSecretary",
    type: "POST",
    data: {'rut': secretarysRutInput.val(), 'idHospital': hospitalSelected.idHospital},
    success: function(xhr, textStatus, error){
      console.log(xhr);
      secretarysRutInput.val('');
      var exist = xhr.exist;
      var newSecretary = $.parseJSON(xhr.secretary);
      console.log(newSecretary);
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

      if (exist === true)
        {
          BootstrapDialog.show({
            type: BootstrapDialog.TYPE_SUCCESS,
            title: 'Enhorabuena',
            message: 'La secretaria se ha añadido correctamente.<br /><br /> Ahora la secretaria puede iniciar sesion con su rut y la contraseña que ella ha establecido previamente en el sistema.',
            buttons: [{
              label: 'Aceptar',
              cssClass: 'btn-primary',
              action: function(dialogRef){
                dialogRef.close();
              }
            }]
          });
        }
      else
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Enhorabuena',
          message: "La secretaria se ha añadido correctamente.<br /><br /> Ahora la secretaria puede iniciar sesión utilizando:<br /><br /><b>Nombre de usuario:</b> " + newSecretary.rut + "-" + newSecretary.dv +"<br /><b>Contraseña:</b> " + newSecretary.rut + "<br /><br />Cuando inicie sesión deberá completar sus datos y cambiar su contraseña.",
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
    },
    error: function(xhr, textStatus, error){
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_DANGER,
        title: 'Tenemos un problema',
        message: "Ha ocurrido un error creando la nueva secretaria, inténtelo nuevamente.",
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
