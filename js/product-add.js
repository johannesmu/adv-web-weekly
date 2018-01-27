var addproduct = ( function( $ ){
  let module = {};
  module.init = function(){
    //initialise module
    module.bind();
  }
  module.bind = function(){
    $(document).ready( () => {
      $('#product-add').on('submit',(event) => { 
        // console.log(event);
        event.preventDefault(); 
      });
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
        module.processImage(event);
      });
    });
  }
  module.processImage = function(evt){
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
      //clear the text inside element
      $(element).text('');
      //display information about the file
      let fileinfo = name + size + 'KB';
      $(element).siblings('.image-upload-info').text(fileinfo);
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
  return module;
}( $ ));

addproduct.init();
