/**
 * Created by krastevd on 12/10/14.
 */
    $('.login-buttons button').click(function(event){
        event.preventDefault();

        var btn = $(this);
        btn.removeClass('btn-primary');
        btn.addClass('btn-warning');
        btn.text('Authenticating');
        btn.attr('disabled', 'disabled');

        setTimeout(function() {
            $.post(site_root + '/admin/ajax/verify_login/',
                {
                    user: encodeURIComponent($("#user").val()),
                    pass: encodeURIComponent($("#password").val())
                }, function (data) {
                    btn.removeClass('btn-warning');

                    if (data == "success") {
                        btn.addClass('btn-success');
                        btn.text('Authenticated');
                        setTimeout(function() {
                            window.location.href = site_root + "/admin/main/dashboard";
                        },1500);
                    } else {
                        btn.addClass('btn-danger');
                        btn.text('Invalid username or password');

                        setTimeout(function() {
                            btn.removeAttr('disabled');
                            btn.text('Login');
                            btn.removeClass('btn-danger');
                            btn.addClass('btn-primary');

                        },2000);
                    }
                });



        }, 1500);
    })