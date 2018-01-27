//detail page module
var detailpage = (function(){
  let module = {};
  module.init = function(){
    //initialise the module variables when document is loaded
    $( document ).ready(() =>{
      module.input = $('input[name="quantity"]');
      module.quantity = $(module.input).val();
      module.bindListeners();
      //preload the spinner image
    });
  }
  module.bindListeners = function () {
    //---bind all the listeners
    //form
    $('#shop-form').on('submit', (event) => {
      event.preventDefault();
    });
    //plus button
    $('#plus').on('click',(event) => {
      module.quantity++;
      module.updateQuantity(module.quantity);
    });
    //minus button
    $('#minus').on('click', (event) => {
      //prevent quantity from going below 1
      if(module.quantity > 1){
        module.quantity--;
        module.updateQuantity(module.quantity);
      }
    });
    //cart button
    $('[data-function="cart"]').on('click',(event) => {
      const target = $('[data-function="cart"]')
      module.spinner('add', target );
      //disable target button
      $(target).attr('disabled','disabled');
      //add spinner
      //send ajax request
      //remove spinner
      //add confirmation check
      //display feedback
    });
    $('[data-function="wish"]').on('click',(event) => {
      const target = $('[data-function="wish"]')
      module.spinner('add', target );
      $(target).attr('disabled','disabled');
      //add spinner
      //send ajax request
      //remove spinner
      //add confirmation check
      //display feedback
    });
  }
  module.updateQuantity = function (qty) {
    $(module.input).val(qty);
  }
  module.spinner = function ( cmd, targetelement ) {
    let template = $('#template-spinner').html().trim();
    let spinner = $(template);
    if( cmd == 'add'){
      $(targetelement).append( spinner );
    }
    else if( cmd == 'remove'){
      $(targetelement).find('.spinner').remove();
    }
  }
  module.request = function ( target_url, payload ){
    $.ajax({
      type: 'post',
      url: target_url,
      data: payload ,
      dataType: 'json',
      encode: true
    })
    .done( (response) => {
      if( response.success ){
        return response;
      }
      else{
        return false;
      }
    });
  }
  return module;
}( $ ));

detailpage.init();


