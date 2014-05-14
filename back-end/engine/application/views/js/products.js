document.errorOnPage = 0;

$('#file_upload').uploadify({
  'uploader'  : '<?php echo url::site(); ?>SWF/uploadify.swf',
  'script'    : '?firmID=<?=$this->firmID?>',
  'scriptData': {'<?=Kohana::Config("session.name")?>': '<?php echo Session::instance()->id(); ?>', 'firmID': <?=$this->firmID?>},
  'cancelImg' : '<?php echo url::site(); ?>IMG/cancel.png',
  'folder'    : '<?php echo IMAGES_STORE_IN_WWW ; ?>',
  'fileExt'   : '*.jpg;*.png',
  'auto'      : true,
  'multi'     : true,
  'onComplete': function(event, ID, fileObj, response, data) {
      if (response != '1') {
          SPAdmin.showAlertMessage('Ошибка при загрузке', response);
          document.errorOnPage = 1;
      } /* else {

      }*/
    },
  'onAllComplete': function(event, ID, fileObj, response, data) {
       if(!document.errorOnPage){
             location.reload();
          }
  
    },
    'onError' : function (event,ID,fileObj,errorObj) {
        SPAdmin.showAlertMessage('Ошибка при загрузке', errorObj.type + ' Error: ' + errorObj.info);
          document.errorOnPage = 1;
      }
});


new nicEditor({uploadURI:SPAdmin.uploadURI }).panelInstance('product_desc');


 