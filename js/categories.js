//categories module
var categories = (function( $ ){
  let module = {};
  module.init = function(){
    module.url = '/ajax/categories/ajx.categories.php';
    module.bind();
  }
  module.bind = function(){
    //bind listeners
    //prevent category filter form from submitting
    $('#category-filter-form').on('submit', (event) => {
      //event.preventDefault();
    });
    module.load();
  }
  module.load = function () {
    //make an ajax request
    let reqdata = { categories: 'all'};
    
    let req = module.request( module.url, reqdata )
    .done( (response) => {
      if(response.success){
        module.renderList( response.data );
      }
    });
  }
  module.request = ( ReqUrl, ReqData ) => {
    return $.ajax({
      type: 'post',
      url: ReqUrl,
      data: ReqData,
      dataType: 'json',
      encode: true
    });
  }
  
  module.getTemplate = function (id) {
      let template = $(id).html().trim();
      let clone = $(template);
      return clone;  
  }
  
  module.renderList = ( data ) => {
    data.forEach( (item) => {
      //get the template for the category
      let template = module.getTemplate('#category-template');
      $(template).find('.checkbox-label').text( item.name );
      $(template).find('.badge').text( item.cat_count );
      let input = $(template).find('input[type="checkbox"]');
      $(input).val( item.id );
      if( item.class ){
        $(input).attr('checked','');
      }
      $('#category-filter').append(template);
    });
  }
    
  return module;
}( $ ));

$(document).ready( () => { categories.init(); }) ;