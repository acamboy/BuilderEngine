/**
 * Created by krastevd on 12/10/14.
 */
$("#asd").validate({
    rules: {
        password: { 
            required: true,
            minlength: 6,
            maxlength: 10,

        },
        confirm_password: { 
            equalTo: "#password",
            minlength: 6,
            maxlength: 10
        }
    },
    messages:{
        password: { 
            required:"the password is required"

        }
    }
});

$('.registration-buttons button').click(function(event){
    event.preventDefault();

    var btn = $(this);
    btn.removeClass('btn-primary');
    btn.addClass('btn-warning');
    btn.text('Authenticating');
    btn.attr('disabled', 'disabled');

    setTimeout(function() {
        $.post(site_root + '/admin/ajax/registration/',
            {
                username: $("#username").val(),
                email: $("#email").val(),
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                password: $("#password").val(),
                confirm_password: $("#confirm_password").val()
            }, function (data) {
                btn.removeClass('btn-warning');
                if(data == 'register with email'){
                    btn.addClass('btn-danger');
                    btn.text('You are registered, please activate with email.');

                    setTimeout(function() {
                        btn.removeAttr('disabled');
                        btn.text('Registration');
                        btn.removeClass('btn-danger');
                        btn.addClass('btn-primary');
                        window.location.href = site_root + "/login";
                    },3000); 
                } else if(data == 'register with admin'){
                    btn.addClass('btn-danger');
                    btn.text('You are registered, but not approved.');

                    setTimeout(function() {
                        btn.removeAttr('disabled');
                        btn.text('Registration');
                        btn.removeClass('btn-danger');
                        btn.addClass('btn-primary');
                        window.location.href = site_root + "/login";
                    },3000);
                }else{
                    data = $.parseJSON(data);
                    $.each(data, function(i,v){
                        $('[data-name='+i+']').html('');
                        $('[data-name='+i+']').html(v);
                    })
                    btn.addClass('btn-danger');
                    btn.text('Registration is not valid');

                    setTimeout(function() {
                        btn.removeAttr('disabled');
                        btn.text('Registration');
                        btn.removeClass('btn-danger');
                        btn.addClass('btn-primary');

                    },2000);
                }
            });
    }, 1500);
})