var addproduct = ( function( $ ){
  let module = {};
  module.init = function(){
    //initialise module variables
    //call module bind
    module.bind();
  }
  module.bind = function(){
    //bind listeners and handlers
    $(document).ready( () => {
      $('#product-add').on('submit',(event) => { 
        // console.log(event);
        event.preventDefault(); 
      });
      $('#new-category-btn').click( (event) => {
        module.addCategory(event); 
      } );
      $('#add-uploader').click( (event) => {
        module.addUploader();
      });
      $('.image-upload-group').click( (event) => {
        if( $(event.target).attr('for') ){
          let elmid = $(event.target).attr('for');
          let img = $(elmid).val();
        }
      });
      $('.image-upload-group').on('change', (event) => {
        module.previewImage(event);
      });
    });
  }
  module.previewImage = function(evt){
    let input = evt.target;
    let file = input.files[0];
    //calculate size in kilobytes
    let size = Math.ceil(file.size/1024);
    //show first few characters of the file name (limited space)
    let name = file.name.substr(0,6) + '...';
    //file reader object to read file and load a preview on web page
    let reader = new FileReader();
    reader.addEventListener('load', (event) => {
      //the result of the file reader loading the image
      let img = event.target.result;
      //we now have an image and we will apply as a background
      //get id of the input that triggers the event
      let id = $(evt.target).attr('id');
      //get the label with a 'for' attribute with same value
      let element = $('[for="'+ id +'"]');
      let style = 'background-image: url('+img+');';
      $(element).attr('style',style);
      //add 'has-image' class
      $(element).addClass('has-image');
      //display information about the file
      let fileinfo = name + '\n' + size + 'KB';
      $(element).find('.image-upload-info').text(fileinfo);
    });
    //activate the reader
    reader.readAsDataURL(file);
  }
  module.addUploader = function(){
    // create new id
    let elmid = module.createId();
    //select the html template
    let template = $('#file-upload-template').html().trim();
    //copy the html template
    let elem = $(template);
    //link the for and id attributes
    $(elem).find('label').attr('for',elmid);
    $(elem).find('input').attr('id',elmid);
    //duplicate the uploader template
    $('.image-upload-group').append(elem);
  }
  module.createId = function(){
    //use timestamp for id
    let ts = new Date().getTime();
    return ts;
  }
  module.addCategory = (event) => {
    let input = $('#new-category').val();
    if( input.length > 0 ){
      let template = $('#category-template').html().trim();
      let elem = $(template);
      $(elem).find('.checkbox-text').text( input );
      console.log(elem);
      $('.checkbox-group').append( elem );
      $('#new-category').val('');
    }
  }
  return module;
}( $ ));

addproduct.init();
