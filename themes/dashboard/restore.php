<?php

echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content"> 
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="/admin">Home</a></li>
        <li class="active">Restore</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">BuilderEngine Restore Facility <small>Administration Control Panel</small></h1>
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
                    <h4 class="panel-title">Restore / Progress Console</h4>
                </div>
                <div class="panel-body panel-form">

                    <h2 class="text-center">Restore</h2>
                    <p class="text-center">
					<?php if(!empty($update)):?>
                        Restore are available for your system.
					<?php else:?>
						You haven`t backed up your database yet.
					<?php endif;?>
                    </p>

                    <div id="zone_progressbar" class="hidden">
                        <div id="status_message" class="text-center"></div>
                        <?=get_progress()?>
                    </div>
                    <div class="panel-body panel-form">
                        <form class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="demo-form">
                            <?php foreach ($update as $key => $value) : ?>
                                <?php if($value != '.' && $value != '..') : ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4" for="websitetitle"><?= date("F j, Y, g:i a",$value) ?>:</label>
                                        <div class="col-md-8 col-sm-8">
                                                <button data-time="<?=$value?>" type="button" class="btn_file btn btn-primary">Restore files</button>
                                                <button data-time="<?=$value?>" type="button" class="btn_sql btn btn-primary">Restore SQL</button>
                                                <button data-time="<?=$value?>" type="button" class="btn_block btn btn-primary">Restore Blocks</button>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </form>
                    </div>

 
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
                    <h4 class="panel-title">Restore Information</h4>
                </div>
                <div class="panel-body panel-form">

                    <h3 class="text-center">Restore information</h3>
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

        $('.btn_sql').click(function(){
            $(this).prop( "disabled", true );
            $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
            set_progress(0);
            var _this = $(this);

            $('#status_message').html(
                $('<p>', {text: 'Initiating process... please wait...'})
            );

            var time = $(this).attr('data-time');

            $.get( site_root + '/admin/backup/restore_sql', 
            {
                time : time
            },
            function (data) {
                if(data.result){
                    set_progress(100);
                    $('#status_message').html(
                        $('<p>', {text: 'SQL restore completed.'})
                    );
                    _this.prop( "disabled", false );
                }
            }, 'json');
        });

        $('.btn_block').click(function(){
            $(this).prop( "disabled", true );
            $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
            set_progress(0);
            var _this = $(this);

            $('#status_message').html(
                $('<p>', {text: 'Initiating process... please wait...'})
            );

            var time = $(this).attr('data-time');

            $.get( site_root + '/admin/backup/restore_sql/be_blocks/be_blocks', 
            {
                time : time
            },
            function (data) {
                if(data.result){
                    set_progress(100);
                    $('#status_message').html(
                        $('<p>', {text: 'Block restore completed.'})
                    );
                    _this.prop( "disabled", false );
                }
            }, 'json');
        });

        $('.btn_file').click(function(){
            $(this).prop( "disabled", true );
            $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
            set_progress(0);
            var _this = $(this);

            $('#status_message').html(
                $('<p>', {text: 'Initiating process... please wait...'})
            );

            var time = $(this).attr('data-time');

            $.get( site_root + '/admin/backup/restore_files', 
            {
                time : time
            },
            function (data) {
                if(data.result){
                    set_progress(100);
                    $('#status_message').html(
                        $('<p>', {text: 'Block restore completed.'})
                    );
                    _this.prop( "disabled", false );
                }
            }, 'json');
        });
    };
</script>

    