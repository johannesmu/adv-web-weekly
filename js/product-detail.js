//detail page module
var productDetail = (function(){
  let module = {};
  module.init = function(){
    //initialise the module variables when document is loaded
    $( document ).ready(() =>{
      module.input = $('input[name="quantity"]');
      module.quantity = $(module.input).val();
      module.product_id = _get_id;
      module.bind();
    });
  }
  module.bind = function () {
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
    module.loadProductData();
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
  module.request = ( ReqUrl, ReqData ) => {
    return $.ajax({
      type: 'post',
      url: ReqUrl,
      data: ReqData,
      dataType: 'json',
      encode: true
    });
  }
  module.loadProductData = function(){
    let product_id = module.product_id;
    let url = 'ajax/products/get/ajx.productdetails.php';
    let data = { id : product_id };
    //make a request for product data
    let req = module.request( url, data )
    .done( (response) => {
      if(response.success == true){
        let len = response.data.length;
        
        if( len > 1 ){
          module.renderCarousel( response.data );
        }
        else{
          module.renderImage( response.data );
        }
        module.renderProductData( response.data );
      }
    });
  }
  module.renderCarousel = function( data ){
    let template = module.getTemplate('#image-carousel');
    //populate the template
    data.forEach( (item,index) => {
      //carousel indicators
      let indicator = module.getTemplate('#carousel-indicator-template');
      $(indicator).attr('data-slide-to', index );
      if( index == 0 ){
        $(indicator).addClass('active');
      }
      $(template).find('.carousel-indicators').append(indicator);
      //carousel items and images
      let carouselItem = module.getTemplate('#carousel-item-template');
      if( index == 0){
        $(carouselItem).addClass('active');
      }
      let productImg = 'images/products/'+ item.image;
      $(carouselItem).find('img').attr('src', productImg );
      $(carouselItem).find('img').attr('alt', item.name );
      $(carouselItem).find('.carousel-caption').text( item.name );
      $(template).find('.carousel-inner').append( carouselItem );
    });
    $('.product-detail-image').append( template );
    //initialise the carousel
    $('#product-image-carousel').carousel({interval: 5000 });
  }
  
  module.renderImage = function( data ){
    let item = data[0];
    let template = module.getTemplate('#single-image');
    let productImg = 'images/products/'+ item.image;
    $( template ).attr('src', productImg );
    $( template ).attr('alt', item.name );
    $('.product-detail-image').append( template );
  }
  
  module.renderProductData = function( data ){
    item = data[0];
    $('.product-detail-title').text( item.name );
    $('.product-detail-price').text( item.price );
    $('.product-detail-description').text( item.description );
    $('[data-function="cart"]').attr("data-id", item.id );
    $('[data-function="wish"]').attr("data-id", item.id );
  }
  
  module.getTemplate = function( template_id ) {
    let template = $(template_id).html().trim();
    let clone = $(template);
    return clone; 
  }
  return module;
}( $ ));

productDetail.init();


