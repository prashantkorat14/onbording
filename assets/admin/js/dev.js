$(document).ready(function () {

});

function ajaxCall(method, url, requestData, callbackFunction, showLoader) {

    var varShowLoader = (showLoader || showLoader === false) ? showLoader : true;

    $.ajax({url: url,
        async: true,
        dataType: 'json',
        method: method,
        data: requestData,
        success: function (data) {
            if (jQuery.type(data.is_logged_out) === "undefined") {
                console.log(callbackFunction);
                eval(callbackFunction + '(data)');
            } else {
                //auto logout
                console.log(data.redirect_url);
                window.location = data.redirect_url;
            }
        },
        beforeSend: function () {
//            if (varShowLoader)
//                pageLoadingFrame("show");

        },
        complete: function () {


        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('something going wrong');
            console.log(textStatus);
//            window.location = window.location.href;
        }
    });
}

