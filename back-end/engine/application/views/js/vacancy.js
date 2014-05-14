
bkLib.onDomLoaded(function() {

    var buttonList = ['indent','outdent', 'bold','italic','underline','strikeThrough',
        'subscript','superscript','ul','ol'];
 
    new nicEditor({buttonList : buttonList}).panelInstance('vacancy_responsibilities'); 
    new nicEditor({buttonList : buttonList}).panelInstance('vacancy_requirements');
    new nicEditor({buttonList : buttonList}).panelInstance('vacancy_conditions');
 
}); 