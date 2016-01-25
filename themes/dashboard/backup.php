<?php

echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content"> 
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="/admin">Home</a></li>
        <li class="active">Backup</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">BuilderEngine Backup Facility <small>Administration Control Panel</small></h1>
    <!-- end page-header -->


    <!-- begin row -->
    <div class="row">
        <!-- begin col-+1 -->
        <div class="col-md-7">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Backup / Progress Console</h4>
                </div>
                <div class="panel-body panel-form">

                    <h2 class="text-center">Backup</h2>
                    <p class="text-center">
                        Backup are available for your system. We don't recommend you create backup very often. 
                    </p>

                    <div id="zone_progressbar" class="hidden">
                        <div id="status_message" class="text-center"></div>
                        <?=get_progress()?>
                    </div>



                    <p class="text-center">
                        <button id="btn_proceed" type="button" class="btn btn-primary">Start Backup</button>
                    </p>

                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col -->

        <!-- begin col-+1 -->
        <div class="col-md-5">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Backup Information</h4>
                </div>
                <div class="panel-body panel-form">

                    <h3 class="text-center">Backup information</h3>
                    <div id="updatezone_detail"><br></div>

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

<script type="text/javascript">
    var http_root = "<?php echo home_url("")?>", updates;
    var do_backup = false;
    var files = [];
    var asked_files = [];

    set_progress = function(payload){
        $('#zone_progressbar > .progress > .progress-bar').attr({
            style: "min-width: 2em; width: " +payload+ "%;",
            "aria-valuenow": payload
        });

        $('#zone_progressbar > .progress > .progress-bar').text(payload+'%');
        $('#zone_progressbar > .progress > .progress-bar').addClass( 'progress-bar-striped' );
    };

    window.onload = function(){

        $('#btn_proceed').click(function(){
            $(this).prop( "disabled", true );
            $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
            set_progress(0);

            $('#status_message').html(
                $('<p>', {text: 'Initiating process... please wait...'})
            );

            setTimeout(function(){begin_backup();}, 1250);

        });

        function backup_phase_five(){
            $( "#status_message p:last").html(
                $('<p>').append($('<s>', {text: '4. Creating blocks content backup.'}))
            );

            $('#status_message').html(
                $('<p>', {text: 'Backup completed.'})
            );

            $('#btn_proceed').parent().html('<a href="'+http_root+'/admin" class="btn btn-primary">Go to Dashboard</a>');
        }

        function backup_phase_four(time){
            $( "#status_message p:last").html(
                $('<p>').append($('<s>', {text: '3. Creating DB backup.'}))
            );

            $('#status_message').append(
                $('<p>', {text: '4. Creating blocks content backup.'})
            );

            $.get( site_root + '/admin/backup/backup_db/be_blocks/be_blocks', 
            {
                time : time
            },
            function (data) {
                if(data.result){
                    set_progress(100);
                    backup_phase_five();
                }
            }, 'json');
        }

        function backup_phase_three(time){

            $( "#status_message p:last").html(
                $('<p>').append($('<s>', {text: '2. Creating files backup.'}))
            );

            $('#status_message').append(
                $('<p>', {text: '3. Creating DB backup.'})
            );

            $.get( site_root + '/admin/backup/backup_db', 
            {
                time : time
            },
            function (data) {
                if(data.result){
                    set_progress(90);
                    backup_phase_four(data.time);
                }
            }, 'json');
        }

        function backup_phase_two(){
            $( "#status_message p:last").html(
                $('<p>').append($('<s>', {text: '1. Preparing backup.'}))
            );

            $('#status_message').append(
                $('<p>', {text: '2. Creating files backup.'})
            );


            $.get( site_root + '/admin/backup/backup_files', function (data) {
                if(data.result){
                    set_progress(50);
                    backup_phase_three(data.time);
                }
            }, 'json');
        }

        function backup_phase_one(){

            $( "#status_message p:last").html(
                $('<p>', {text: 'backuping now...'})
            );

            $('#status_message').append(
                $('<p>', {text: '1. Preparing backup.'})
            );

            set_progress(10);

            setTimeout(function(){backup_phase_two();}, 1250);

        }

        function begin_backup()
        {
            set_progress(0);

            setTimeout(function(){backup_phase_one();}, 1250);
        }

    };
</script>

    