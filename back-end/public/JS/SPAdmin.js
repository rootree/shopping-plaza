SPAdmin = {

    goToURL : function (url){
        document.location.href = url;
    },

    showAlertMessage : function (title, message ){

        $( "#dialog" ).html(  '<p>' + message + '</p>');
        $( "#dialog" ).dialog({
            modal: true,
            title: title,
            closeText: 'Закрыть',
            resizable: false,
            buttons:[
                {
                    text: 'Ok',
                    click: function() { $(this).dialog("close"); }
                }]
        });
    },

    /**
     *  onclick="SPAdmin.showConfirmMessage('Test', 'TEST', function(){
        alert('TTESTT');
    }); return false;"
     * @param title
     * @param message
     * @param callback
     */
    showConfirmMessage : function (title, message, callback ){

        $( "#dialog" ).html( '<p>' + message + '</p>');
        $( "#dialog" ).dialog({
            modal: true,
            title: title,
            closeText: 'Закрыть',
            resizable: false,
            buttons:[
                {
                    text: 'Да',
                    click: function() {
                         callback();
                         $(this).dialog("close");
                     }
                },
                {
                    text: 'Отмена',
                    click: function() { $(this).dialog("close"); }
                }]
        });

    },

    /**
     *  onclick="SPAdmin.showConfirmMessage('Test', 'TEST', function(){
        alert('TTESTT');
    }); return false;"
     * @param title
     * @param message
     * @param callback
     */
    showChangeProductMessage : function (title, id, price, counter){

        $( "#quickPrice" ).attr('value', price);
        $( "#quickCount" ).attr('value', counter);

        $( "#changeProductions" ).dialog({
            modal: true,
            title: title,
            closeText: 'Закрыть',
            resizable: false,
            buttons:[
                {
                    text: 'Изменить',
                    click: function() {
                       //  callback();

                        var url = "/products?updatePrice&idProduct=" + id + "&price=" + $( "#quickPrice" ).attr('value') +
                            "&counter=" + $( "#quickCount" ).attr('value');
 
                        var jqxhr = $.get(url, function(){
                            
                            $( "#htmlValuePrice" + id).html( $( "#quickPrice" ).attr('value'));
                            $( "#htmlValueCount" + id ).html( $( "#quickCount" ).attr('value'));
                        })
                        .error(function() { alert("При сохранении произошла ошибка."); });
 
                        $(this).dialog("close");
                     }
                },
                {
                    text: 'Отмена',
                    click: function() { $(this).dialog("close"); }
                }]
        }) ;

        $(this).dialog("open")
        return false;
    }

}


 