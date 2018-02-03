$(document).ready(function(){
  //capture the submit event of the login form
  $('#login-form').on("submit", function(event){
    //prevent default behaviour, eg refreshing of page
    event.preventDefault();
    //get form values
    let userid = $('#userid').val();
    let password = $('#password').val();
    //check if values exist
    if( userid.length == 0 || password.length == 0){
      showAlert('warning','cannot be empty');
      //stop subsequent lines
      return;
    }
    let user = new Object();
    user.userid = userid;
    user.password = password;
    //send the object to the ajax handler (ajaxlogin.php)
    $.ajax({
      beforeSend:addSpinner($('button[name="login-button"]')),
      type: 'post',
      url: 'ajax/auth/ajx.auth.php',
      data: user,
      dataType: 'json',
      encode: true
    })
    .done( function(response){
      //handle response
      removeSpinner( $('button[name="login-button"]') );
      if(response.success == true){
        //create alert with success message
        showAlert('success','login successful');
      }
      else{
        //create alert with error message
        showAlert('warning',response.error);
      }
    });
    
    
    
  });
});

function addSpinner(target){
  let spinner = 'images/graphics/loading.gif';
  let img = document.createElement('img');
  img.setAttribute('src',spinner);
  img.setAttribute('width',20);
  $(target).append(img);
}
function removeSpinner(target){
  $(target).find('img').remove();
}

function showAlert(type,msg){
  //if there is an existing alert
  if( $('.alert').length ){
    //remove it
    $(".alert").remove();
  }
  //get the html inside the alert template and remove spaces using trim
  let template = $("#alert-template").html().trim();
  //create clone of the html
  let clone = $(template);
  //add message
  $(clone).find('.alert-message').text(msg);
  
  if(type == "success"){
    $(clone).addClass('alert-success');
  }
  else{
    $(clone).addClass('alert-danger');
  }
  $('#login-form').append(clone);
}


var login = ( function ()  {
  let module = {};
  module.init = () => {
    //initialise module
  }
  module.bind = () => {
    //bind listeners
  }
  module.showAlert = () => {
    
  }
  module.spinner = ( cmd, targetelement ) => {
    let template = $('#template-spinner').html().trim();
    let spinner = $(template);
    if( cmd == 'add'){
      $(targetelement).append( spinner );
    }
    else if( cmd == 'remove'){
      $(targetelement).find('.spinner').remove();
    }
  }
  return module;
}( $ ));

login.init();