
bkLib.onDomLoaded(function() {

    var buttonList = ['indent','outdent', 'bold','italic','underline','strikeThrough',
        'subscript','superscript','ul','ol'];
 
    new nicEditor({buttonList : buttonList}).panelInstance('partners_annonce');
 
});

