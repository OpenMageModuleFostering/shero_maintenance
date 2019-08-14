jQuery(function() {
    var url = jQuery('#maintenance_alert_url').text();
    jQuery.ajax({
        type: "POST",
        url: url,
        success: function (result) {
            var results = result.split(',');
            if (results[0] == '' || results[0] == 'inactive') {
                return;
            } else {
                var alert = '<div class="alert-div"><strong>'+ results[0] +'</strong><button class="trigger" onclick="jQuery(\'#alert\').hide();"><strong>X</strong></button></div>';
                jQuery('#alert').html(alert);
                jQuery('.alert-div').css({"background-color": "#"+results[1], "textAlign": "center", "color": "#"+results[2]});
                jQuery('.trigger').css({"background-color": "#"+results[1], "float": "right", "border":"none","margin-right":"5px"});
                jQuery(window).scroll(function(){
                    var alertdiv = jQuery('.alert-div');
                    var scroll = jQuery(window).scrollTop();
                    console.log(scroll);
                    if (scroll >= 1)
                    {
                        alertdiv.addClass('fixed');
                    }
                    else {
                        alertdiv.removeClass('fixed');
                    }
                });
            }
        }
    });
});