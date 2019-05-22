 $(document).ready(function(){
        $("#towers").addClass("disabled");
        $("input[name='common']").click(function(){
            var radioValue = $("input[name='common']:checked").val();
            if(radioValue === "0")
            {
              $("#div1").hide("slow");
              $("#div2").hide("slow");
              $("#towers").prop( "disabled", true);
              $("#apartments").prop( "disabled", true);
            }
            if(radioValue === "1")
            {
              $("#div1").show("fast");
              $("#div2").hide("fast");
              $("#towers").prop( "disabled", false);
              $("#apartments").prop( "disabled", true);
            }
            if (radioValue === "2")
            {
              $("#div1").hide("fast");
              $("#div2").show("fast");
              $("#towers").prop( "disabled", true);
              $("#apartments").prop( "disabled", false);
            }
        });
});

$(document).ready(function(){
  if($("input[name='common']").is(':checked'))
  {
    var radioValue = $("input[name='common']:checked").val();
    if (radioValue === "0")
    {
      $("#towers").prop( "disabled", true);
      $("#apartments").prop( "disabled", true);
    }
    if (radioValue === "1")
    {
      $("#div1").show("fast");
      $("#towers").prop( "disabled", false);
      $("#apartments").prop( "disabled", true);
    }
    if(radioValue === "2")
    {
      $("#div2").show("fast");
      $("#towers").prop( "disabled", true);
      $("#apartments").prop( "disabled", false);
    }
  }
});

function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {
              return true;
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
}


/********************************************/
function filterAliquot(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter_aliquot(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {
              return true;
          }else if(key == 46){
                if(filter_aliquot(tempValue)=== false){
                    return false;
                }else{
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter_aliquot(__val__){
    var preg = /^([0-9]{1}[.]?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
}