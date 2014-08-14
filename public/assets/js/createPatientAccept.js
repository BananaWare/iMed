var contact = $(".contact-errors");
var personal = $(".personal-errors");
function createPatient(fromPatientsView) {
  var values = $('.birthdate').val().split("/");
  var birthdate = values[2] + '-' +  values[1] + '-' + values[0];
  $.ajax({
    url: "/dashboard/" + localStorage.userRole + "/createPatient",
    type: "POST",
    data: {'rut': $('.rut').val(), 'name': $('.name').val(), 'lastname': $('.lastname').val(),
           'birthdate': birthdate, 'email': $('.email').val(), 'phone': $('.phone').val(),
           'city': $('.city').val(), 'address': $('.address').val(), 'gender': 
           $('input[name=gender]:checked').val(),
           'idHospital': hospital.idHospital}
  })
  .done(function(xhr){
      console.log(xhr);
      try
      {
        var newPatient = $.parseJSON(xhr);
        if (fromPatientsView === true)
        {
          if (typeof hospital.patients === "undefined")
            hospital.patients = []; 
          hospital.patients.push(newPatient);
          
          loadPatientsTable();
          patientsRutInput.val('');
        }
        else
        {
          hospital.patients.push(newPatient);
          patientsMagicSuggest.setData(hospital.patients);
          patientsMagicSuggest.setSelection(newPatient);
        }
        $('#createPatientModal').modal('hide');
        BootstrapDialog.show({
          type: BootstrapDialog.TYPE_SUCCESS,
          title: 'Enhorabuena',
          message: 'El nuevo paciente se ha añadido correctamente.',
          buttons: [{
            label: 'Aceptar',
            cssClass: 'btn-primary',
            action: function(dialogRef){
              dialogRef.close();
            }
          }]
        });
      }
      catch(err){
        checkAttributes(xhr);
      }
    })
    .fail(function($sss){
      console.log($sss);
      $('#createPatientModal').modal('hide');
      BootstrapDialog.show({
        type: BootstrapDialog.TYPE_DANGER,
        title: 'Tenemos un problema',
        message: 'Un problema ha ocurrido al agregar pacientes, recargue la página e inténtelo nuevamente.',
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

checkAttributes = function(errors)
{
  if (errors.email || errors.phone || errors.city || errors.address)
    contact.addClass("alert alert-danger");
  else
    contact.removeClass("alert alert-danger");
  if (errors.rut || errors.name || errors.lastname || errors.birthdate || errors.gender)
    personal.addClass("alert alert-danger");
  else
    personal.removeClass("alert alert-danger");
  
  contact.empty();
  personal.empty();
  
  if (errors.email)
    contact.append(errors.email[0] + ". ");
  if (errors.phone)
    contact.append(errors.phone[0] + ". ");
  if (errors.city)
    contact.append(errors.city[0] + ". ");
  if (errors.address)
    contact.append(errors.address[0] + ". ");
  
  if (errors.rut)
    personal.append(errors.rut[0] + ". ");
  if (errors.name)
    personal.append(errors.name[0] + ". ");
  if (errors.lastname)
    personal.append(errors.lastname[0] + ". ");
  if (errors.birthdate)
    personal.append(errors.birthdate[0] + ". ");
  if (errors.gender)
    personal.append(errors.gender[0] + ". ");
}
$('#createPatientModal').on('shown.bs.modal', function (e) {
  $(".rut").prop('disabled', false);
  
  // lineas en testing
  if (typeof patientsMagicSuggest != 'undefined')
    $(".rut").val(patientsMagicSuggest.getRawValue());
  else
    $('.rut').val($('#patientsRutInput').val());
  
  $('.name').val(''); $('.lastname').val('');
  $('.email').val(''); $('.phone').val('');
  $('.city').val(''); $('.address').val(''); 
  $('.birthdate').val(''); 
  $(".btn-group .btn").removeClass("active");
  $('input[name=gender]:checked').removeAttr("checked");
//  $(':input:checked').parent('.btn').removeClass('active');
  
  contact.empty();
  contact.removeClass("alert alert-danger");
  personal.empty();
  personal.removeClass("alert alert-danger");
})