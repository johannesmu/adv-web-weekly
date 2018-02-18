var products = ( function ()  {
  var module = {};
  module.init = () => {
    //initialise module variables
    module.url = 'ajax/products/get/ajx.products.php';
    module.detailLink = 'detail.php';
    //get the get variables
    module.categories = module.getParams();
    //call module.bind()
    module.bind();
    //request data to send with ajax request
    module.requestData = {};
  }
  module.bind = () => {
    //bind event listeners
    //load products
    module.getProducts();
  }
  module.getProducts = function () {
    //set request data
    module.requestData = {categories: 0 };
    //run request to get products
    let req = module.request( module.url, module.requestData )
    .done( (response) => {
      if(response.success){
        //count the total results and store it in total variable
        module.total = response.total;
        //render the results
        module.renderProducts( response.data );
      }
    });
  }
  module.getTemplate = function (id) {
      let template = $(id).html().trim();
      let clone = $(template);
      return clone;  
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
  module.getParams = function (){
    let currentUrl = new URL(window.location);
    let params = currentUrl.searchParams;
    let categories = params.get('categories[]');
    
    //console.log(params);
    //this function gets the GET parameters and return JSON
    let urlparams = window.location.search.substr(1).split('&');
    let params_obj = {};
    let vars = urlparams.forEach( (item) => {
      let tmp_array = item.split('=');
      let obj_key = tmp_array[0];
      //check for % symbol in key and discard
      let index = obj_key.indexOf('%');
      if( index > -1){
        obj_key = obj_key.substr(0,index);
      }
      let obj_value = tmp_array[1];
      if( params_obj[obj_key] ){
        //assign to 
        let param =  params_obj[obj_key];
        if( param.constructor == Array ){
          param.push( obj_value );
        }
        else{
          params_obj[obj_key] = [ param ,obj_value];
        }
      }
      else{
        params_obj[ obj_key ] = obj_value;
      }
    });
    return params_obj;
  }
  module.renderProducts = ( data ) => {
    data.forEach( (item) => {
      //get the template for the category
      let template = module.getTemplate('#product-template');
      //fill template with data
      $(template).find('.product-title').text( item.name );
      $(template).find('.product-image').attr('data-image','images/products/'+item.image_file_name);
      $(template).find('.product-price').text( item.price );
      $(template).find('.product-description').text( item.description );
      let link = module.detailLink + '?id=' + item.id;
      $(template).find('.product-detail-link').attr('href', link );
      //add it to view
      $('.products-row').append( template );
    });
    module.decorateResults(module.total);
    module.loadImages();
  }
  module.decorateResults = (total) => {
    $('#products-results-total').text( module.total +' items in total');
  }
  module.loadImages = async function(){
    let images = $('[data-image]');
    for( item of images ){
      let imgPath = $( item ).data('image');
      await $(item).attr('src',imgPath);
    }
  }
  
  return module;
  
} ($));


//call products.init when document has finished loading
$(document).ready( () => {
  products.init(); 
});