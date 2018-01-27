//categories module
var categories = (function( $ ){
  let categories = {};
  categories.init = function(){
    categories.url = '/ajax/ajaxcategories.php';
    categories.bind();
  }
  categories.bind = function(){
    //bind listeners
    categories.load();
  }
  categories.load = function () {
    //make an ajax request
    let req = categories.request( categories.url, categories.render() );
    
    let listelement = categories.getTemplate('#catnav-template');
    
    //on success
    //load templates
    //merge data
    //
  }
  categories.request = function ( ReqUrl, callback ) {
    let ReqData = { categories : "all" };
    $.ajax({
      type: 'post',
      url: ReqUrl,
      data: ReqData,
      dataType: 'json',
      encode: true
    })
    .done( (response) => {
      console.log(response.data);
      if(response.success == true){
        
        callback( response.data );
      }
      else{
        return false;
      }
    });
  }
  
  categories.getTemplate = function (id) {
    $( document ).ready( () => {
      let template = $('#catnav-item').html().trim();
      let clone = $(template);
      return clone;  
    } );
    
  }
  
  categories.render = function ( data ){
    console.log(data);
  }
  return categories;
}( $ ));

$(document).ready( () => { categories.init(); }) ;