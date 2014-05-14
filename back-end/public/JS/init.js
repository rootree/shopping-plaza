$(document).ready(function() {
 
    hs.registerOverlay({
        html: '<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>',
        position: 'top right',
        fade: 2 // fading the semi-transparent overlay looks bad in IE
    });
    hs.outlineType = 'outer-glow';
    hs.wrapperClassName = 'outer-glow';

    hs.fadeInOut = true;


    //  $( "input:submit, a" ).button({ });
 
    $( "#mainMenu" ).tabs({});
    $( "input:submit" ).button({ });


    $( "a.viewBtn" ).button({
        icons: {
            primary: "ui-icon-zoomin"
        },
        text: false
    });
    $( "a.largeBtnText" ).button({
        icons: {
            primary: "ui-icon-zoomin"
        }
    });
    $( "a.largeBtn" ).button({
        icons: {
            primary: "ui-icon-zoomin"
        },
        text: false
    });
    $( "a.editBtn" ).button({
        icons: {
            primary: "ui-icon-wrench"
        },
        text: false
    });
    $( "a.deleteBtn" ).button({
        icons: {
            primary: "ui-icon-trash"
        },
        text: false
    });
    $( "a.deleteTextBtn" ).button({
        icons: {
            primary: "ui-icon-trash"
        } 
    });



    $( "a.backBtn" ).button({
        icons: {
            primary: "ui-icon-arrowreturnthick-1-w"
        }
    });
    $( "a.cancelBtn" ).button({
        icons: {
            primary: "ui-icon-cancel"
        }
    });


    $( "a.editBtnText" ).button({
        icons: {
            primary: "ui-icon-wrench"
        }
    });

    $( "a.viewOnSiteBtnText" ).button({
        icons: {
            primary: "ui-icon-image"
        }
    });

    $( "a.addImageBtnText" ).button({
        icons: {
            primary: "ui-icon-circle-plus"
        }
    });

    $( "a.addImageBtn" ).button({
        icons: {
            primary: "ui-icon-circle-plus"
        },
        text: false
    });
    $( "a.satelliteBtn" ).button({
        icons: {
            primary: "ui-icon-link"
        },
        text: false
    });
    $( "a.satelliteBtnText" ).button({
        icons: {
            primary: "ui-icon-link"
        }
    });
    $( "a.recommendBtn" ).button({
        icons: {
            primary: "ui-icon-lightbulb"
        },
        text: false
    });
    $( "a.recommendBtnText" ).button({
        icons: {
            primary: "ui-icon-lightbulb"
        }
    });

    $( "a.viewOnSiteBtn" ).button({
        icons: {
            primary: "ui-icon-image"
        },
        text: false
    });

    $( "a.searchBtn" ).button({
        icons: {
            primary: "ui-icon-search"
        },
        text: false
    });

    $( "a.favoriteBtn" ).button({
        icons: {
            primary: "ui-icon-heart"
        },
        text: false
    });

    $( "a.openBtn" ).button({
        icons: {
            primary: "ui-icon-arrowreturn-1-e"
        },
        text: false
    });

    $( "a.copyBtn" ).button({
        icons: {
            primary: "ui-icon-copy"
        },
        text: false
    });

    $( "a.fieldsBtn" ).button({
        icons: {
            primary: "ui-icon-note"
        },
        text: false
    });

    $( "a.addFieldBtn" ).button({
        icons: {
            primary: "ui-icon-plus"
        },
        text: false
    });

    $( "a.addFieldBtnText" ).button({
        icons: {
            primary: "ui-icon-plus"
        }
    });

    $( "a.mainCatBtn" ).button({
        icons: {
            primary: "ui-icon-home"
        },
        text: false
    });



    $( "a.orderOkBtn" ).button({
        icons: {
            primary: "ui-icon-check"
        },
        text: false
    });
    $( "a.orderDeliveredBtn" ).button({
        icons: {
            primary: "ui-icon-cart"
        },
        text: false
    });
    $( "a.orderPayedBtn" ).button({
        icons: {
            primary: "ui-icon-person"
        },
        text: false
    });

    $( "a.orderOkBtnText" ).button({
        icons: {
            primary: "ui-icon-check"
        }
    });
    $( "a.orderDeliveredBtnText" ).button({
        icons: {
            primary: "ui-icon-cart"
        }
    });
    $( "a.orderPayedBtnText" ).button({
        icons: {
            primary: "ui-icon-person"
        } 
    });
    $( "a.commentTextBtn" ).button({
        icons: {
            primary: "ui-icon-comment"
        }
    });
    $( "a.upTextBtn" ).button({
        icons: {
            primary: "ui-icon-arrowstop-1-n"
        }
    });
    $( "a.printTextBtn" ).button({
        icons: {
            primary: "ui-icon-print"
        }
    });
    $( "a.printBtn" ).button({
        icons: {
            primary: "ui-icon-print"
        },
        text: false
    });


    $( "a.powerTextBtn" ).button({
        icons: {
            primary: "ui-icon-power"
        }
    });
    $( "a.powerBtn" ).button({
        icons: {
            primary: "ui-icon-power"
        },
        text: false
    });

    $( "a.powerOfTextBtn" ).button({
        icons: {
            primary: "ui-icon-cancel"
        }
    });
    $( "a.powerOfBtn" ).button({
        icons: {
            primary: "ui-icon-cancel"
        },
        text: false
    });


    $( "a.cartBtn" ).button({
        icons: {
            primary: "ui-icon-suitcase"
        },
        text: false
    });

    $( "a.viewMode" ).button({
        icons: {
            primary: "ui-icon-refresh"
        }
    });
    $( "a.blockBtn" ).button({
        icons: {
            primary: "ui-icon-locked"
        },
        text: false
    });

    $( "a.blockTextBtn" ).button({
        icons: {
            primary: "ui-icon-locked"
        }
    });


    $( "table#bin tr" ).mouseenter(function () { 
        $(this).addClass("mouseOver");
    }).mouseleave(function () {
			$(this).removeClass("mouseOver");
        });

    $( "table#bin tr" ).click(function () {

        $( "table#bin tr" ).each(function () {
            $(this).removeClass("clicker");
        });

        if(this.className.match('clicker')) {
            $(this).removeClass("clicker");
        }else{
            $(this).addClass("clicker");
        }
    });


    $('a ').tooltip({
        track: true,
        delay: 0,
        showURL: false,  
        top:  15,
        left: 5,
    fade: 250 
    });
    $('input').tooltip({
        track: false,
        delay: 0,
        showURL: false ,top:  5,
    fade: 250
    });
    $('div').tooltip({
        track: false,
        delay: 0,
        showURL: false ,top:  5,
    fade: 250
    });

    jQuery('form').each(function(formIndex) {
        jQuery(this).submit(function() {
            jQuery('input:submit').eq(formIndex).attr('disabled', 'disabled');
            return true;
        });
    });

    $('#sidebar').portamento({wrapper: $('#wrapper')});	// set #wrapper as the bottom boundary
 
   $('#content').width($('#content').width() - $('#portamento_container').width() - 1);


	$.datepicker.setDefaults($.extend(
		$.datepicker.regional["ru"])
	);


});