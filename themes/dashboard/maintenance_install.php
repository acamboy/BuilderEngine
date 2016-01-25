<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 25/02/2015
 * Time: 01:49 PM
 */

echo get_header() ?>


<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="<?=base_url('/admin')?>">Home</a></li>
        <li class="active">Update</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">BuilderEngine Installation <small>Administration Control Panel</small></h1>
    <!-- end page-header -->


    <!-- begin row -->
    <div class="row">
        <!-- begin col-+1 -->
        <div class="col-md-10">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Install</h4>
                </div>
                <div class="panel-body panel-form">
                            <div class="row">
                                <div class="col-xs-5 col-xs-offset-1">
                                    <?=form_fieldset('Site Information');?>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_sitename">Site Name</label>
                                        <input type="text" class="form-control be_verify" id="txt_sitename" name="txt_sitename" placeholder="Enter Site Name">
                                    </div>

                                    <?=form_fieldset_close();?>
                                    <br>

                                    <?=form_fieldset('Administrator Information');?>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_admin_username">Username</label>
                                        <input type="text" class="form-control be_verify" id="txt_admin_username" name="txt_admin_username" placeholder="Enter Administrator Username">
                                    </div>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_admin_email">Email Address</label>
                                        <input type="text" class="form-control be_verify" id="txt_admin_email" name="txt_admin_email" placeholder="Enter admin email address">
                                    </div>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_admin_password">Admin user Password</label>
                                        <input type="password" class="form-control be_verify" id="txt_admin_password" name="txt_admin_password" placeholder="Enter admin password">
                                    </div>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_admin_passwordconf">Confirm password</label>
                                        <input type="password" class="form-control be_verify" id="txt_admin_passwordconf" name="txt_admin_passwordconf" placeholder="confirm password">
                                    </div>

                                    <?=form_fieldset_close();?>

                                </div>


                                <div class="col-xs-4 col-xs-offset-1">

                                    <?=form_fieldset('Database Information');?>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_db_host">MySQL Host</label>
                                        <input type="text" class="form-control be_verify" id="txt_db_host" name="txt_db_host" placeholder="MySQL host name or IP">
                                    </div>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_db_user">MySQL Username</label>
                                        <input type="text" class="form-control be_verify" id="txt_db_user" name="txt_db_user" placeholder="Enter MySQL Username">
                                    </div>


                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_db_password">MySQL Password</label>
                                        <input type="password" class="form-control be_verify" id="txt_db_password" name="txt_db_password" placeholder="Enter MySQL password">
                                    </div>

                                    <div class="form-group" style="max-width:240px">
                                        <label for="txt_db_name">MySQL Database</label>
                                        <input type="text" class="form-control be_verify" id="txt_db_name" name="txt_db_name" placeholder="Enter DataBase name">
                                    </div>

                                    <?=form_fieldset_close();?>

                                </div>

                            </div>

                            <div class="text-center">
                                <p>When you feel you are ready, please click the install button.</p>

                                <div id="zone_progressbar" class="hidden">
                                    <div id="status_message" class="text-center"></div>
                                    <?=get_progress()?>
                                </div>

                                <button id="install-button" style="margin-left: -80px; margin-top: 10px; margin-bot: 20px; font-weight: bold;margin-bottom: 20px;" class="btn btn-primary rounded">Begin Installation</button>
                            </div>

                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col -->


    </div>
    <!-- end row -->








    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->
<!-- end #content -->
<?php echo get_footer()?>




<script>
    var validations = {
        db_credentials: false,
        txt_admin_email: false,
        txt_admin_password: false,
        txt_admin_passwordconf: false,
        txt_admin_username: false,
        txt_db_host: false,
        txt_db_name: false,
        txt_sitename: false
    };

    var installation_completed = false;
    var test = false;
    var test_dbdata = {
        host: 'localhost',
        user: 'cmstestb_46363',
        password: 'password',
        db: 'cmstestb_gsdg'
    };
    var test_site = {
        sitename: 'cmstest.builderengine.net',
        host: test_dbdata.host,
        user: test_dbdata.user,
        password: test_dbdata.password,
        db: test_dbdata.db
    };
    var test_admin ={
        admin_username: 'artiz',
        admin_password: '1024',
        admin_email: 'andresmg85@gmail.com'
    };


    function install_db()
    {
        $( "#status_message p:last").html(
            $('<p>').append($('<s>', {text: 'Preparing installation...'}))
        );

        $('#status_message').append(
            $('<p>', {text: '1. Installing Database'})
        );
        _data = {
            host: $("#txt_db_host").val(),
            user: $("#txt_db_user").val(),
            password: $("#txt_db_password").val(),
            db: $("#txt_db_name").val(),
        };

        $.post("<?=base_url()?>index.php/admin/install/install_db/",
            (test) ? test_dbdata : _data ,
            function (data) {
                if(data == "success"){
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '1. Installing Database'}))
                    );
                    set_progress(40);
                    setTimeout(function(){configure_website();}, 1250);
                }else {
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '1. Installing Database > error'}))
                    );
                    $('#status_message').append(
                        $('<p>', {text: data, style: 'color:red;'})
                    );
                    $("#install-button").prop( "disabled", false );
                }
            });
    }

    function configure_website()
    {

        $('#status_message').append(
            $('<p>', {text: '2. Configuring Website'})
        );

        $.post("<?=base_url()?>index.php/admin/install/configure/",
            (test) ? test_site :
            {
                sitename: $("#txt_sitename").val(),
                host: $("#txt_db_host").val(),
                user: $("#txt_db_user").val(),
                password: $("#txt_db_password").val(),
                db: $("#txt_db_name").val()
            }, function (data) {
                if(data.result){
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '2. Configuring Website'}))
                    );
                    set_progress(60);
                    setTimeout(function(){create_admin();}, 1250);
                }
                else{
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '2. Configuring Website > error'}))
                    );
                    $('#status_message').append(
                        $('<p>', {text: data, style: 'color:red;'})
                    );
                    $("#install-button").prop( "disabled", false );
                }
            }, 'json');
    }



    function create_admin()
    {

        $('#status_message').append(
            $('<p>', {text: '3. Creating Administrator Account'})
        );



        $.post("<?=base_url();?>index.php/admin/install/create_admin",
            (test) ? test_admin :
            {
                admin_username: $("#txt_admin_username").val(),
                admin_password: $("#txt_admin_password").val(),
                admin_email: $("#txt_admin_email").val()

            }, function (data) {

                if(data == "success"){
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '3. Creating Administrator Account'}))
                    );
                    set_progress(80);
                    setTimeout(function(){finishing();}, 1250);
                }else {
                    $( "#status_message p:last").html(
                        $('<p>').append($('<s>', {text: '3. Creating Administrator Account > error'}))
                    );
                    $('#status_message').append(
                        $('<p>', {text: data, style: 'color:red;'})
                    );
                    $("#install-button").prop( "disabled", false );
                }

            });
    }


    function finishing()
    {
        $('#status_message').append(
            $('<p>', {text: '4. Finishing Installation'})
        );

        $.get("<?=base_url()?>index.php/admin/install/finish", function (data) {

            if(data == "success"){
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '4. Finishing Installation'}))
                );
                set_progress(100);
                setTimeout(function(){
                    installation_completed = true;
                    $('#status_message').append(
                        $('<p>', {text: 'Congratulations! Your website installation is successfully completed.', style: 'color:blue;'})
                    );
                    $("#install-button").html("Redirect to Website");
                    $("#install-button").prop( "disabled", false );
                    if(test)
                        window.location = "/index.php/admin/update/index";

                }, 1750);
            }else {
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '4. Finishing Installation > error'}))
                );
                $('#status_message').append(
                    $('<p>', {text: data, style: 'color:red;'})
                );
                $("#install-button").prop( "disabled", false );
            }

        });
    }



    set_progress = function(payload){
        $('#zone_progressbar > .progress > .progress-bar').attr({
            style: "min-width: 2em; width: " +payload+ "%;",
            "aria-valuenow": payload
        });

        $('#zone_progressbar > .progress > .progress-bar').text(payload+'%');
    };


    //TODO:Need to be moved to jquery document redady function
    (function(){

        $("#install-button").prop( "disabled", true );
        $("#install-button").click(function(){
            if(installation_completed) window.location = "<?=base_url('/admin')?>";else{
                $(this).prop( "disabled", true );
                $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
                set_progress(0);
                $('#status_message').html(
                    $('<p>', {text: 'Preparing installation...'})
                );

                setTimeout(function(){
                    set_progress(5);
                    install_db();
                }, 1250);
            }

        });

        if(test){
            $("#install-button").click();
        }else{
            $( ".be_verify" ).blur(function(){
                _data = {
                    input: $(this).attr('name'),
                    value: _value = $(this).val()
                };

                if(_data.input == 'txt_admin_passwordconf'){
                    _data.password = $('#txt_admin_password').val();
                }
                if(_data.input == 'txt_db_user' || _data.input == 'txt_db_password'){
                    if($('#txt_db_user').val() == '' || $('#txt_db_password').val() == '' || $('#txt_db_host').val() == ''){
                        return;
                    }else{
                        _data.input = 'db_credentials';
                        _data.username = $('#txt_db_user').val();
                        _data.passowrd = $('#txt_db_password').val();
                        _data.host = $('#txt_db_host').val();
                    }

                }
                if(_data.input == 'txt_db_name'){
                    if($('#txt_db_user').val() == '' || $('#txt_db_password').val() == '' || $('#txt_db_host').val() == ''){
                        return;
                    }else{
                        _data.username = $('#txt_db_user').val();
                        _data.passowrd = $('#txt_db_password').val();
                        _data.host = $('#txt_db_host').val();
                    }
                }

                _url = "<?php echo  base_url(); ?>index.php/admin/install/ajax_validate";

                $.post( _url, _data, function( data ) {

                    if(data.result){//feedback correct
                        validations[data.input] = true;
                        if(data.input == 'db_credentials'){
                            _parent = $('#txt_db_user, #txt_db_password').parent();
                        }else {
                            _parent = $('#' + data.input).parent();
                        }
                        _parent.removeClass( "has-error" ).addClass( "has-success has-feedback" );
                        _parent.children("span").remove();
                        _parent.append(
                            $('<span>',{class:'glyphicon glyphicon-ok form-control-feedback', "aria-hidden":'true'})
                        );
                        _parent.append(
                            $('<span>',{id:data.input, class:'sr-only', text:'(success)'})
                        );
                    }else{
                        validations[data.input] = false;
                        if(data.input == 'db_credentials'){
                            _parent = $('#txt_db_user, #txt_db_password').parent();
                        }else {
                            _parent = $('#' + data.input).parent();
                        }
                        _parent.removeClass( "has-success" ).addClass( "has-error has-feedback" );
                        _parent.children("span").remove();
                        _parent.append(
                            $('<span>',{class:"help-block",style:'color:red;' , text:data.error_message})
                        );
                        _parent.append(
                            $('<span>',{class:'glyphicon glyphicon-remove form-control-feedback', "aria-hidden":'true'})
                        );
                        _parent.append(
                            $('<span>',{id:data.input, class:'sr-only', text:'(error)'})
                        );
                    }
                }, 'json').always(function(){
                    clear = true;
                    $.each(validations,function(index, value){
                        if(!value){
                            clear = false;
                        }
                    });
                    if(clear){
                        $("#install-button").prop( "disabled", false );
                    }else{
                        $("#install-button").prop( "disabled", true );
                    }
                });
            });
        }

    })();














</script>

