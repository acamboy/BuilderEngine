/**
 * Created by bugbuster on 26/10/15.
 */
$("#asd").validate({
    rules: {
        password: { 
            required: true,
            minlength: 6,
            maxlength: 10,

        },
        password_re: { 
            equalTo: "#password",
            minlength: 6,
            maxlength: 10
        }
    },
    messages:{
        password: { 
            required:"the password is required"
        }
        password_re: { 
            required:"you must confirm new password"
        }
    }
});
/*
$('.reset-buttons button').click(function(event){
    event.preventDefault();

    var btn = $(this);
    btn.removeClass('btn-primary');
    btn.addClass('btn-warning');
    btn.text('Processing..');
    btn.attr('disabled', 'disabled');

    setTimeout(function() {
        $.post(site_root + '/admin/ajax/reset_password/',
            {
                password: $("#password").val(),
                password_re: $("#password_re").val()
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
*/