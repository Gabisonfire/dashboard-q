function initializeJS() {

    //Speed at which to toggle the menu in milliseconds
    var menuSpeed = 1000;

    //sidebar menu toggle function
    function toggleSideBar(toggleSpeed){
        var wSize = jQuery(window).width();
        //menu close
        if (wSize <= 768) {
            toggleSpeed = 0;
        };
        if (jQuery('#sidebar > ul').is(":visible") === true && jQuery('#theframe').hasClass("sidebar-closed") === false) {
            jQuery('#theframe').animate({
                'width': '100%',
                'margin-left': '0px'
            }, toggleSpeed);

            jQuery('#sidebar').animate({
                'margin-left': '-180px'
            }, toggleSpeed, function() {
                jQuery('#sidebar > ul').hide();
            });

            jQuery("#container").addClass("sidebar-closed");
            jQuery('#theframe').addClass("sidebar-closed");

            //menu open
        } else if (jQuery('#sidebar > ul').is(":visible") === false && jQuery('#theframe').hasClass("sidebar-closed") === true) {
            if (wSize > 768) {
                jQuery('#theframe').animate({
                    'margin-left': '180px',
                    'width': '100%',
                    'width': '-=180px'
                }, toggleSpeed);
            }
            jQuery('#sidebar').animate({
                'margin-left': '0'
            }, toggleSpeed);

            jQuery('#sidebar > ul').show();
            jQuery("#container").removeClass("sidebar-closed");
            jQuery('#theframe').removeClass("sidebar-closed");
        };
    };

    //tool tips
    jQuery('.tooltips').tooltip();

    //popovers
    jQuery('.popovers').popover();

    //custom scrollbar
    //for html
    jQuery("html").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '6', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: '', zindex: '1000'});
    //for sidebar
    jQuery("#sidebar").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
    // for scroll panel
    jQuery(".scroll-panel").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});

    //sidebar dropdown menu
    jQuery('#sidebar .sub-menu > a').click(function () {
        var last = jQuery('.sub-menu.open', jQuery('#sidebar'));
        jQuery('.menu-arrow').removeClass('arrow_carrot-right');
        jQuery('.sub', last).slideUp(200);
        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.menu-arrow').addClass('arrow_carrot-right');
            sub.slideUp(200);
        } else {
            jQuery('.menu-arrow').addClass('arrow_carrot-down');
            sub.slideDown(200);
        }
        var o = (jQuery(this).offset());
        diff = 200 - o.top;
        if(diff>0)
            jQuery("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            jQuery("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });

    // sidebar menu toggle

    jQuery(function() {
        function responsiveView() {
            var wSize = jQuery(window).width();
            //menu closed
            if (wSize <= 768) {
                jQuery('#container').addClass('sidebar-closed');
                jQuery('#theframe').addClass('sidebar-closed');
                jQuery('#sidebar > ul').hide();
                jQuery('#theframe').css({
                    //'width': 'calc(100% - 180px)'
                    'width': '100%',
                    'margin-left': '0px'
                });
                jQuery('#sidebar').css({
                    'margin-left': '-180px'
                });
                //jQuery('#main-content').css({
                //    'width': 'calc(100% - 180px)'
                //});

                //toggleSideBar();
            }

            //menu opened
            if (wSize > 768) {

                jQuery('#container').removeClass('sidebar-closed');
                jQuery('#theframe').removeClass('sidebar-closed');
                jQuery('#sidebar > ul').show();
                jQuery('#theframe').css({
                    'margin-left': '180px',
                    'width': 'calc(100% - 180px)'
                });
                jQuery('#sidebar').css({
                    'margin-left': '0px'
                });
                //jQuery('#main-content').css({
                //    'width': '100%'
                //});

                //toggleSideBar(0);
            }
        }
        jQuery(window).on('load', responsiveView);
        jQuery(window).on('resize', responsiveView);
    });

    jQuery('.toggle-nav').click(function () {
        toggleSideBar(menuSpeed);
    });

    //bar chart
    if (jQuery(".custom-custom-bar-chart")) {
        jQuery(".bar").each(function () {
            var i = jQuery(this).find(".value").html();
            jQuery(this).find(".value").html("");
            jQuery(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }

}

jQuery(document).ready(function(){
    initializeJS();
});