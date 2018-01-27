// text editor module
var texteditor = (function(){
  var module = {};
  module.init = function(element_id){
    module.element = element_id;
    $(element_id).trumbowyg({
      removeformatPasted: true,
      btns: [
        ['viewHTML'],
        ['undo', 'redo'], // Only supported in Blink browsers
        ['formatting'],
        ['strong', 'em', 'del'],
        ['superscript', 'subscript'],
        ['link'],
        // ['insertImage'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
      ]
    });
    module.bind( $(element_id).parents('form') );
  }
  module.bind = (form_elm) => {
    $(form_elm).on('reset', () => {
      $( module.element ).trumbowyg('empty');
    });
  }
  return module;
}( $ ));

texteditor.init('#description');