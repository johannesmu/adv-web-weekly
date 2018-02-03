var categorymanager = ( function() {
  var module = {};
  module.init = function () {
    module.bind();
  }
  module.bind = function () {
    $('.category-manage').on('submit',(event) => {
      event.preventDefault();
      let button = $(event.target).find('.btn[type="submit"]');
      $(button).attr('disabled','');
      module.spinner('add' , button );
      module.submit(event);
    });
    $('.category-edit').on('click', module.enableEdit);
  }
  
  module.enableEdit = ( event ) => {
    let id = $(event.target).attr('data-id');
    $('input[data-id="' + id + '"]').removeAttr('readonly').select();
  }
  
  module.submit = ( event ) => {
    //get values from the form
    let dataobj = new Object();
    dataobj.id = $(event.target).attr('id');
    dataobj.name = $('input[data-id="'+dataobj.id+'"]').val();
    let active = $('input[type="checkbox"][data-id="'+dataobj.id+'"]:checked').val();
    if(active !== undefined){
      dataobj.active = true;
    }
    else{
      dataobj.active = false;
    }
    //send data as an ajax request
    let host = window.location.protocol +'//'+window.location.hostname+'/';
    console.log(host);
    let ajaxpath = 'ajax/categories/manage/ajx.categories_manage.php';
    
    // let req = module.request(host+'/'+ajaxpath,dataobj);
    // console.log(req);
    
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
  
  module.request = ( target_url, payload ) => {
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
} ( $ ) );

categorymanager.init();