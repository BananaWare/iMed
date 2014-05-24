var contact = $(".contact-errors");
var personal = $(".personal-errors");
function createPatient(fromPatientsView) {
  $.ajax({
    url: "/dashboard/" + localStorage.userRole + "/createPatient",
    type: "POST",
    data: {'rut': $('.rut').val(), 'name': $('.name').val(), 'lastname': $('.lastname').val(),
           'birthdate': $('.birthdate').val(), 'email': $('.email').val(), 'phone': $('.phone').val(),
           'city': $('.city').val(), 'address': $('.address').val(), 'gender': $('input[name=gender]:checked').val(),
           'idHospital': hospitalSelected.idHospital},
    success: function(xhr){
      console.log(xhr);
      //alert('asigno');
      try
      {
        var newPatient = $.parseJSON(xhr);
        if (fromPatientsView === true)
        {
          $.each(hospitals, function(key, hospital){
            if (hospital.idHospital == hospitalSelected.idHospital)
            {
              if (typeof hospitals[key].patients === "undefined")
              {
                hospitals[key].patients = [];
                hospitalSelected.patients = [];
              }
              hospitals[key].patients.push(newPatient);
              selectHospitalComboBox.magicSuggest().setData(hospitals);
              return false; // nos salimos antes del bucle each
            }
          });
          loadPatientsTable();
          patientsRutInput.val('');
        }
        else
        {
          hospitalWithPatients.patients.push(newPatient);
          patientsMagicSuggest.setData(hospitalWithPatients.patients);
          patientsMagicSuggest.setSelection(newPatient);
        }
        $('#createPatientModal').modal('hide');
      }
      catch(err){
        checkAttributes(xhr);
      }

    },
    error: function($sss){
      console.log($sss);
      alert('error');
    }
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
  $('.rut').val($('#patientsRutInput').val());
  
  $('.name').val(''); $('.lastname').val('');
  $('.birthdate').val(''); $('.email').val(''); $('.phone').val('');
  $('.city').val(''); $('.address').val(''); $('input[name=gender]:checked').removeAttr("checked");
  $(':input:checked').parent('.btn').removeClass('active');
  
  contact.empty();
  contact.removeClass("alert alert-danger");
  personal.empty();
  personal.removeClass("alert alert-danger");
})