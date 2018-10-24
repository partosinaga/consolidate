var Login = function () {

    var handleLogin = function (loginSubmitUrl) {

        $('.login-form').on('submit', function () {
            var username = $('input[name="username"]').val().trim();
            var password = $('input[name="password"]').val().trim();
            var valid = true;

            toastr.clear();

            if (password == '') {
                toastr["warning"]("Please fill password", "Warning.");
                $('input[name="password"]').focus();
                valid = false;
            }
            if (username == '') {
                toastr["warning"]("Please fill username", "Warning.");
                $('input[name="username"]').focus();
                valid = false;
            }

            if (valid) {
                $('.login-form').block({
                    message: '<div class="loading-message loading-message-boxed"><span>&nbsp;&nbsp;Loging In...</span></div>',
                    css: {
                        top: '10%',
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: '#555',
                        opacity: 0,
                        cursor: 'wait'
                    }
                });

                var form_data = $('.login-form').serializeArray();

                $.ajax({
                        type: "POST",
                        url: loginSubmitUrl,
                        dataType: "json",
                        data: form_data
                    })
                    .done(function (msg) {
                        if (msg.err == '0' || msg.err == '1') {
                            if (msg.err == '0') {
                                window.location.assign(msg.link);
                            } else {
                                toastr["error"](msg.message, "Error.");
                                $('.login-form').unblock();
                            }
                        } else {
                            toastr["error"]("Something has wrong, please try again later.", "Error.");
                            $('.login-form').unblock();
                        }
                    })
                    .fail(function (e) {
                        toastr["error"]("Something has wrong, please try again later.", "Error.");
                        $('.login-form').unblock();
                    });
            }

        });
    }


    return {
        //main function to initiate the module
        init: function () {
            handleLogin(loginSubmitUrl);
        }
    };

}();

jQuery(document).ready(function () {
    Login.init(loginSubmitUrl);
});