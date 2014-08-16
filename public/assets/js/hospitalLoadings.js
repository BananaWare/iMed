var hospitalMagicSuggest;
var selectHospitalComboBox = $('#selectHospitalComboBox');
var hospitalSelected;
var primeraCarga = true;
var hospitals;
$(function() {
  $.ajax({
    url: "/dashboard/getHospitals",
    type: "POST",
    success: function(xhr){
      console.log(xhr);
      hospitals = JSON.parse(xhr);
      localStorage.setItem('hospitals', xhr);
      
      
  /*
  if (typeof hospitals === "undefined") // test, borrar despues
    return;
  if (typeof hospitals !== "undefined")
    localStorage.setItem('hospitals', JSON.stringify(hospitals));
  else
    hospitals = JSON.parse(localStorage.hospitals);
  */
  var idSelected = [];
  if (localStorage.idHospitalSelected !== undefined)
  {
    //idSelected.push(parseInt($.cookie('idHospitalSelected')));
    hospitalSelected = hospitals[indexOfHospital(localStorage.idHospitalSelected)];
    idSelected.push();
  }
  else{
    //idSelected = null;
    hospitalSelected = hospitals[0];
  }
  idSelected.push(hospitalSelected.idHospital);
  //console.log(hospitals);
  
  hospitalMagicSuggest = selectHospitalComboBox.magicSuggest({
    width: 'auto',
    sortOrder: 'name',
    groupBy: 'city',
    valueField: 'idHospital',
    maxSelection: 1,
    highlight: false,
    data: hospitals,
    //selectionRenderer: hospitalsComboSelectionRenderer,
    //renderer: hospitalsComboRenderer,
    toggleOnClick: true,
    placeholder: 'Escriba o seleccione un elemento',
    infoMsgCls: 'hide',
    editable: false,
    noSuggestionText: '',
    allowFreeEntries: false
  });
  
  $(hospitalMagicSuggest).on('selectionchange', hospitalsComboSelectionChange);
  
  hospitalMagicSuggest.setSelection(hospitalSelected);
    }
  });
});
var hospitalsComboSelectionRenderer = function (a){
  return a.name;
}

var hospitalsComboRenderer = function(v){
  return '<div>' +
    '<div style="padding-top: 20px;font-style:bold;font-size:120%;color:#333">' + v.name + '</div>' +
    '<div style="color: #999">' + v.address + '</div>' +
    '</div>' +
    '</div><div style="clear:both;"></div>';
}

var hospitalsComboSelectionChange = function(event, combo, selection){
  
  hospitalSelected = selectHospitalComboBox.magicSuggest().getSelection()[0];
  
  if (typeof hospitalSelected == "undefined")
  {
    location.reload();
  }
  else
    idHospital = hospitalSelected.idHospital;
  
  localStorage.setItem('idHospitalSelected', hospitalSelected.idHospital);
  
  $.ajax({
    url: "/dashboard/selectHospital",
    type: "POST",
    data: {'idHospital': hospitalSelected.idHospital},
    success: function(xhr){
      localStorage.setItem('userRole', xhr);
      if (!primeraCarga)
        location.reload();
      primeraCarga = false;
    },
     error: function(xhr){
       console.log(xhr);
    }
  });
}

indexOfHospital = function(idHospital)
{
  temp = $.grep(hospitals, function( n, i ) {
    return (n.idHospital==idHospital);
  });
  if(temp.length === 0)
    return 0;
  return key = $.inArray(temp[0], hospitals);
}