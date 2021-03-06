var contact = $(".contact-errors");
var personal = $(".personal-errors");
$(function () {
  $(".dp").datepicker();/*({
    format: 'DD/MM/YYYY',
    singleDatePicker: true,
    showDropdowns: true,
    startDate: moment(),
    maxDate: moment()
  });*/
});                    
$("#modifySecretaryAccept").click(function(e) {
  if ( $('.password1').val() != $('.password2').val() )
  {
    $('#modal').modal('show');
    return;
  }
  var values = $('.birthdate').val().split("/");
  var birthdate = values[2] + '-' +  values[1] + '-' + values[0];
  $.ajax({
    url: "/dashboard/secretary/modifySecretary",
    type: "POST",
    data: {'name': $('.name').val(), 'lastname': $('.lastname').val(),
           'password': $('.password2').val(),
           'birthdate': birthdate, 'email': $('.email').val(), 'phone': $('.phone').val(),
           'city': $('.city').val(), 'address': $('.address').val(), 'gender': 
           $('input[name=gender]:checked').val()},
    success: function(xhr){
      console.log(xhr);
      
      try
      {
        var modifiedSecretary = $.parseJSON(xhr);
        location.reload();
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
});

checkAttributes = function(errors)
{
  if (errors.email || errors.phone || errors.city || errors.address)
    contact.addClass("alert alert-danger");
  else
    contact.removeClass("alert alert-danger");
  if (errors.password || errors.name || errors.lastname || errors.birthdate || errors.gender)
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
  
  if (errors.password)
    personal.append(errors.password[0] + ". ");
  if (errors.name)
    personal.append(errors.name[0] + ". ");
  if (errors.lastname)
    personal.append(errors.lastname[0] + ". ");
  if (errors.birthdate)
    personal.append(errors.birthdate[0] + ". ");
  if (errors.gender)
    personal.append(errors.gender[0] + ". ");
}
/*
$('#createPatientModal').on('shown.bs.modal', function (e) {
  $(".rut").prop('disabled', false);
  $('.rut').val($('#patientsRutInput').val());
  
  $('.name').val(''); $('.lastname').val('');
  $('.birthdate').val(''); $('.email').val(''); $('.phone').val('');
  $('.city').val(''); $('.address').val(''); 
  
  $(".btn-group .btn").removeClass("active");
  $('input[name=gender]:checked').removeAttr("checked");
//  $(':input:checked').parent('.btn').removeClass('active');
  
  contact.empty();
  contact.removeClass("alert alert-danger");
  personal.empty();
  personal.removeClass("alert alert-danger");
})*/