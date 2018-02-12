var products = ( function ()  {
  var module = {};
  module.init = () => {
    //initialise module variables
    module.url = 'ajax/products/get/ajx.products.php';
    module.detailLink = 'detail.php';
    //call module.bind()
    module.bind();
    
  }
  module.bind = () => {
    //bind event listeners
    //load products
    module.getProducts();
  }
  module.getProducts = function () {
    //set request data
    let reqdata = { products: 'all'};
    //run request to get products
    let req = module.request( module.url, reqdata )
    .done( (response) => {
      if(response.success){
        //count the total results and store it in total variable
        module.total = response.data.length;
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
  module.renderProducts = ( data ) => {
    data.forEach( (item) => {
      //get the template for the category
      let template = module.getTemplate('#product-template');
      //fill template with data
      $(template).find('.product-title').text( item.name );
      $(template).find('.product-image').attr('src','images/products/'+item.image_file_name);
      $(template).find('.product-price').text( item.price );
      $(template).find('.product-description').text( item.description );
      let link = module.detailLink + '?id=' + item.id;
      $(template).find('.product-detail-link').attr('href', link );
      //add it to view
      $('.products-row').append( template );
    });
    module.decorateResults(module.total);
  }
  module.decorateResults = (total) => {
    $('#products-results-total').text( module.total +' items in total');
  }
  return module;
  
} ($));


//call products.init when document has finished loading
$(document).ready( () => {
  products.init(); 
});