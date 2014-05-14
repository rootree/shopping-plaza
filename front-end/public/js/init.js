//<![CDATA[



this.screenshotPreview = function(){
    /* CONFIG */

    xOffset = 10;
    yOffset = 30;

    // these 2 variable determine popup's distance from the cursor
    // you might want to adjust to get the right result

    /* END CONFIG */
    $("span.screenshot").hover(function(e){

        var rel = $(this).attr('rel');
        var title = $(this).attr('title');
        var c;
        if(title){
            c = (title != "") ? "<br/>" + title : "";
        }
        $("body").append("<p id='screenshot'><img id='screenshotIMG' src='"+ rel +"' alt='url preview' />"+ c +"</p>");

        $("#screenshot")
                .css("top",(e.pageY - xOffset) + "px")
                .css("left",(e.pageX + yOffset) + "px")
                .fadeIn("fast");
    },
            function(){
                $("#screenshot").remove();
            });
    $("span.screenshot").mousemove(function(e){
        $("#screenshot")
                .css("top",(e.pageY - xOffset) + "px")
                .css("left",(e.pageX + yOffset) + "px");
    });
};



SPHandler = {

    selectedItem : 0,
    menuHeight : 110,
    charBlock : null,
    isLoading : false,
    isCounterMessageOpened : false,
    prevTable : '',
    prevDeliveryDesc : '',
    prevPayWayDesc : '',

    prevTable2: '',
    prevType : '',

    deleteItem:function(item_id){
        var url= '/bin/trash/itemid/'+item_id;
        $.get(url,function(data){
            document.location.href = '/bin';
            $('#item_id_'+item_id).css('display','none');
        });return false;
    },

    editItems:function(mode){
        if(mode){
            $("div.count_it_edit").css('display','none');
            $("div.count_it").fadeIn();
            $("#count_button").slideUp();
            $("div.allPrice").show();
        }else{
            $("div.count_it_edit").fadeIn();
            $("div.count_it").css('display','none');
            $("#count_button").fadeIn();
            $("div.allPrice").hide();
        }
    },

    changeCounter:function(increment, textEdit){

        if(SPHandler.isLoading){
            return false;
        }

        if(!textEdit){
            textEdit = "#itemCount";
        }

        var currentValue = parseInt($(textEdit).val());

        if(increment){
            $(textEdit).attr('value', (currentValue + 1));
        }else{
            if(currentValue <= 1){
                return;
            }
            $(textEdit).attr('value', (currentValue - 1));
        }
    },

    showCounterMessage:function(selectedItem, event , MC ){

        if(SPHandler.isLoading){
            return false;
        }

        SPHandler.selectedItem = 0;
        SPHandler.isCounterMessageOpened = true;

        SPHandler.hideCounterMessage();

        $('#takeOrderLoading').hide();
        $('#takeOrderComplete').hide();
        $('#counterMessageProgress').hide();
        $('#counterMessageButtons').show();

        $("#itemCount").attr('value', 1);

        SPHandler.selectedItem = selectedItem;

        charBlock = $('#' + MC);

        var IE = document.all?true:false;

        if (IE) { // grab the x-y pos.s if browser is IE
            tempX = event.clientX + $(window).scrollLeft(); ;
            tempY = event.clientY + $(window).scrollTop();;
        } else {  // grab the x-y pos.s if browser is NS 
            var offset = $(event.target).offset();
            tempY =  offset.top + 25 ;
            tempX = offset.left + 50;
        }

        /*

         */

        // catch possible negative values in NS4
        if (tempX < 0){tempX = 0}
        if (tempY < 0){tempY = 0}

        $("#counterMessage").css( 'left', tempX -  + $("#counterMessage").width() + 25);
        $("#counterMessage").css( 'top', tempY + $("#counterMessage").height() - 50);

        $("#counterMessage").show();

        $('#takeOrderComplete').hide();
        $('#takeOrderLoading').hide();
        $('#takeOrderQuentaty').show();

    },

    hideCounterMessage:function(){

        if(SPHandler.isLoading || SPHandler.isCounterMessageOpened){
            return false;
        }

        $('#counterMessageButtons').show();
        $('#counterMessageProgress').hide();

        $("#itemCount").attr('value', 1);
        $("#counterMessage").fadeOut();

        SPHandler.isCounterMessageOpened = false;
        // SPHandler.selectedItem = 0;
    },

    sendOrder:function(){

        $('#takeOrderQuentaty').hide();
        $('#takeOrderLoading').show();

        $('#counterMessageButtons').hide();
        $('#counterMessageProgress').show();
        $('#counterMessageProgress').attr('innerHTML', 'Загрузка...');

        SPHandler.isLoading = true;

        var url = '/bin/store/itemid/' + SPHandler.selectedItem + '/counter/' + parseInt($("#itemCount").val());

        $.getJSON(url, function(data){

            if($('#satellites')){
                SPHandler.goToSatellites();
            }

            $('#charCountItems').attr('innerHTML',  data.itemsCount);
            $('#charPriceItems').attr('innerHTML',  data.totalSum);

            $('#binSide').show('fast');
    
         
            $('#charCountItemsSide').attr('innerHTML',  data.itemsCount);
            $('#charPriceItemsSide').attr('innerHTML',  data.totalSum);

            charBlock.attr('innerHTML',  'Уже в корзине');

            SPHandler.isLoading = false;
            SPHandler.isCounterMessageOpened = false;

            $('#counterMessageProgress').attr('innerHTML',  'Товар сохранён! [ <a onclick="SPHandler.hideCounterMessage();">x</a> ]');

            $('#takeOrderLoading').hide();
            $('#takeOrderComplete').hide();
            $('#RcatalogItemID').hide();
            $('#mainChar').hide();

            SPHandler.hideCounterMessage();

            // var timerOnce = window.setTimeout("SPHandler.hideCounterMessage();", 13500);

            window.location.hash  = '#satellites';


        });

    },

    checkFeedback: function(){

        $('#title').val();
        $('#name').val();
        $('#mail').val();
        $('#msg').val();

        if($('#title').val() && $('#name').val() && $('#mail').val() && $('#msg').val()){
            return true;
        }

        alert('Перед отправкой сообщения обязательно заполните все поля.');

        return false;

    },

    checkRegistration: function(){

        if($('#nameREG').val() && $('#passREG').val() && $('#mailREG').val()){
            return true;
        }

        alert('Для регистрации надо указать все поля.');

        return false;

    },

    checkLogin: function(){

        if($('#mailLogin').val() && $('#wordLogin').val() ){
            return true;
        }

        alert('Для регистрации надо указать все поля.');

        return false;

    },

    showAddonForm: function(type){

        if(SPHandler.prevTable){
            $('#' + SPHandler.prevTable).hide();
        }

        var table = "delivery_type_" + type;

        $('#' + table).show();

        SPHandler.prevTable = table;

        $('#type_base').val(type);
    },

    showDeliveryDesc: function(delivery){

        if(SPHandler.prevDeliveryDesc){
            $('#' + SPHandler.prevDeliveryDesc).hide();
        }

        var table = delivery;

        $('#' + table).show();

        SPHandler.prevDeliveryDesc = table;

    },

    showPayWayDesc: function(delivery){

        if(SPHandler.prevPayWayDesc){
            $('#' + SPHandler.prevPayWayDesc).hide();
        }

        var table = delivery;

        $('#' + table).show();

        SPHandler.prevPayWayDesc = table;

    },

    showAddonFormClient : function (type){

        if(SPHandler.prevTable){
            $('#' + SPHandler.prevTable).hide();
        }

        if(SPHandler.prevTable2){
            $('#' + SPHandler.prevTable2).hide();
            $('#radio_' + SPHandler.prevTable2).removeAttr("checked");
        }

        var table = "client_type_" + type;
        $('#' + table).show();

        SPHandler.prevTable = table;

    },
    showAddonFormNext : function (type){

        if(SPHandler.prevTable2){
            $('#' + SPHandler.prevTable2).hide();
        }
        if(SPHandler.prevType){
            SPHandler.prevType.checked = false;
        }

        $('#field_type').val(type);

        var table = "pay_type_" + type;
        $('#' + table).show();


        SPHandler.prevTable2 = table;

    },
    onFocusSearchForm : function (){

        if($('#lookingFor').val() == 'Поиск по сайту...'){
            $('#lookingFor').val('');
            $('#lookingFor').css('color','#000');
        }

    },
    onBlurSearchForm : function (){

        if($('#lookingFor').val() == ''){
            $('#lookingFor').val('Поиск по товарам...');
            $('#lookingFor').css('color','#B9B9B9');
        }

    },
    onResizeWindow : function (){


        // $('#mainContent').width($(window).width() - 207);

        var turnOn = false;

        $("#mainMenu > li").each(function(i, el) {

            var elem = $(this);
            var pos = elem.offset();

            // elem.show();

            //   if(pos.top > 180){
            if(pos.top > SPHandler.menuHeight){
                turnOn = true;
            }
            if(turnOn){
                elem.hide();
            }
        });

        $("#morePages").show();

    },


    showCallback:function(selectedItem, event , MC ){

        $("#callbackMessage").show();

        $('#callbackComplete').hide();
        $('#callbackLoading').hide();
        $('#callbackForm').show();

    },

    hideCallback:function(){

        $('#callbackButtons').show();
        $('#callbackForm').show();

        $('#callbackComplete').hide();
        $('#callbackLoading').hide();

        $("#callbackMessage").fadeOut();

    },

    sendCallback:function(){

        if($("#numberCallback").val() == ''){
            return;
        }

        $('#callbackForm').hide();
        $('#callbackButtons').hide();

        $('#callbackLoading').show();

        var url = '/savephone/index/phone/' + ($("#numberCallback").val()) + '/';

        $.getJSON(url, function(data){

            $('#callbackLoading').hide();
            $('#callbackComplete').show();

            $('#phone-callback-block').hide();

            var timerOnce = window.setTimeout("SPHandler.hideCallback();", 6500);

        });

    },

    sendQuickOrder: function(item_id){

        if(!$('#quick_user').val() || !$('#quick_phone').val() ){
            alert('Для оформления быстрого заказа надо указать ваше имя и номер телефона.');
            return false;
        }
        if($('#quick_user').val() == 'Ваше имя' || $('#quick_phone').val() == 'Ваш номер телефона' ){
            alert('Для оформления быстрого заказа надо указать ваше имя и номер телефона.');
            return false;
        }
        document.location.href = '/bin/quickorder?name=' + $('#quick_user').val() + '&phone=' + $('#quick_phone').val() + '&id=' + item_id;

        return false;

    },
    goToSatellites:function(){
        /*
         var divOffset = $('#satellites').offset().top;
         var pOffset = $('#satellites p:eq(2)').offset().top;
         var pScroll = pOffset - divOffset;
         $('#satellites').animate({scrollTop: '+=' + pScroll + 'px'}, 1000 );
         */
    }



};


try{document.execCommand("BackgroundImageCache",false,true);}catch(e){}
function fixPNG(element){if(/MSIE (5\.5|6).+Win/.test(navigator.userAgent)){var src;if(element.tagName=='IMG'){if(/\.png$/.test(element.src)){src=element.src;element.src="./i/e.gif";}
    src=element.currentStyle.backgroundImage.match(/url\("(.+\.png)"\)/i)
    if(src){src=src[1];element.runtimeStyle.backgroundImage="none";}}else{src=element.currentStyle.backgroundImage.match(/url\("(.+\.png)"\)/i)
    if(src){src=src[1];element.runtimeStyle.backgroundImage="none";}}
    var re_scale_mode=/iesizing\-(\w+)/;var m=re_scale_mode.exec(element.className);var scale_mode=(m)?m[1]:'crop';if(src)
        element.runtimeStyle.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"
                +src+"',sizingMethod='"+scale_mode+"')";}}

hs.registerOverlay({
    html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
    position: 'top right',
    fade: 2 // fading the semi-transparent overlay looks bad in IE
});
hs.outlineType = 'outer-glow';
hs.wrapperClassName = 'outer-glow';
hs.fadeInOut = true;
//]]>

$(document).ready(function() {

    var pos = $('#logo').position();

    // .outerWidth() takes into account border and padding.
    var width = $('#logo').outerHeight();

    SPHandler.menuHeight = pos.top + width + 57;

    SPHandler.hideCounterMessage();
    SPHandler.onResizeWindow();

    if ($.browser.msie) {
        // $("#logo a").textShadow();
    }



    screenshotPreview();
});

$(window).resize(function() {
    SPHandler.onResizeWindow();

});


$(function () {

    var msie6 = $.browser == 'msie' && $.browser.version < 7;

    if (!msie6) {

        var testCrash = false;
        try
        {
            var categwory = $('#RcatalogItemID').offset().top - parseFloat($('#RcatalogItemID').css('margin-top').replace(/auto/, 0));

        }catch(e){
            testCrash = true;
        }

        var category = $('#sidebar').offset().top - parseFloat($('#sidebar').css('margin-top').replace(/auto/, 0));
        if(!testCrash){
            var bin = $('#RcatalogItemID').offset().top - parseFloat($('#RcatalogItemID').css('margin-top').replace(/auto/, 0));
            var fullBin = $('#mainChar').offset().top - parseFloat($('#mainChar').css('margin-top').replace(/auto/, 0));
        }
        $(window).scroll(function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= category) {
                // if so, ad the fixed class
                $('#sidebar').addClass('fixed');
            } else {
                // otherwise remove it
                $('#sidebar').removeClass('fixed');
            }            // whether that's below the form

            if(!testCrash){
                if (y >= bin) {
                    // if so, ad the fixed class
                    $('#RcatalogItemID').addClass('fixed');
                } else {
                    // otherwise remove it
                    $('#RcatalogItemID').removeClass('fixed');
                }            // whether that's below the form

                if (y >= fullBin) {
                    // if so, ad the fixed class
                    $('#mainChar').addClass('fixed');
                } else {
                    // otherwise remove it
                    $('#mainChar').removeClass('fixed');
                }
                }

        });


    }
});
