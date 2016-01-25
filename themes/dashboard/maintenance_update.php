<?php

echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content"> 
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="/admin">Home</a></li>
        <li class="active">Update</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">BuilderEngine Update Facility <small>Administration Control Panel</small></h1>
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
                    <h4 class="panel-title">Update / Progress Console</h4>
                </div>
                <div class="panel-body panel-form">

                    <h2 class="text-center">Updates</h2>
                    <p class="text-center">
                        New Updates are available for your system. We recommend that you select update to get bug fixes and improvements.
                    </p>

                    <div id="zone_progressbar" class="hidden">
                        <div id="status_message" class="text-center"></div>
                        <?=get_progress()?>
                    </div>



                    <p class="text-center">
                        <button id="btn_proceed" type="button" class="btn btn-primary">Start Update</button>
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
                    <h4 class="panel-title">New Updates Information</h4>
                </div>
                <div class="panel-body panel-form">

                    <h3 class="text-center">Update information</h3>
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


<!-- #modal-without-animation -->
<div class="modal" id="backupModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create a back up for recovery.</h4>
            </div>
            <div class="modal-body" id="modal_body">
                <h4>Update Facility...</h4>
                <p>has found that some files with Custom Code Changes / Code Edits from Original Versions that will be overwritten, if you continue the current process this will remove your custom code changes of these files affected.</p>
                <p><strong>We strongly recommend that you create a recovery point right now.</strong></p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal">Skip</a>
                <button id="btn_backup" class="btn btn-success">Backup-Files</button>
            </div>
        </div>
    </div>
</div>




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

    $(document).on('click','#btn_backup',function(){
        do_backup = true;
        $('#backupModal').modal('hide');
    });

    //finish update
    function update_phase_six(){

        $('#status_message').append(
            $('<p>', {text: '6. Cleaning up & checking integrity.'})
        );

        _update = updates.cursor.get_current();
        _data = {ver: _update.goal};

        $.post("http://" + document.domain + '/index.php/admin/update/finish', _data, function (data) {
            if(data.result){
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '6. Cleaning up & checking integrity.'}))
                );
                setTimeout(function(){ set_progress(100); }, 200);

                _update = updates.cursor.get_current();
                clearInterval(_update.clear);

                $('#'+_update._li).addClass( "active" );

                _goal = _update.goal;

                if(updates.cursor.get_next()){
                    setTimeout(function(){ set_progress(100); }, 200);
                    setTimeout(function(){ begin_update(); }, 1500);
                }else{
                    $('#status_message').html(
                        $('<p>', {text: 'Update completed, welcome to version ' + _goal})
                    );
                }
            }

        },'json');


    }

    //Database update
    function update_phase_five(){
        $('#status_message').append(
            $('<p>', {text: '5. Updating database.'})
        );

        $.get("http://" + document.domain + '/index.php/admin/update/update_db', function (data) {
            if(data.result){
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '5. Updating database.'}))
                );
                setTimeout(function(){ set_progress(80); }, 200);
                setTimeout(function(){ update_phase_six(); }, 1250);
            }else {
                $('#status_message').append(
                    $('<p>', {text: 'An error occurred during the database update.', style: 'color: red;'})
                );
            }

        });

    }

    //Files update
    function update_phase_four(){
        _update = updates.cursor.get_current();

        $('#status_message').append(
            $('<p>', {text: '4. Applying update ( ' +_update.goal+ ' ).'})
        );

        $.get("http://" + document.domain + '/index.php/admin/update/update_files', function (data) {
            if(data.result){
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '4. Applying update ( ' +_update.goal+ ' ).'}))
                );
                setTimeout(function(){set_progress(60);}, 200);
                setTimeout(function(){update_phase_five()}, 1250);                }
            else
                $('#status_message').append(
                    $('<p>', {text: 'An error occurred during the patch applying.', style: 'color: red;'})
                );
        });
    }

    $('#backupModal').on('hidden.bs.modal', function (e) {
        if(do_backup){
            do_backup = false;
            $.post("http://" + document.domain + '/index.php/admin/update/set_backup',{file_set: JSON.stringify(files)} , function (data) {
                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '3. Back-up files.'}))
                );
                if(data.result){
                    setTimeout(function(){set_progress(45);}, 400);
                    setTimeout(function(){update_phase_four()}, 1250);
                }else{
                    $('#status_message').append(
                        $('<p>', {text: 'An error occurred during the back up phase...', style: 'color: red;'})
                    );
                }
            }, 'json');
        }else{
            $( "#status_message p:last").html(
                $('<p>').append($('<s>', {text: '3. Back-up files (skipped).'}))
            );
            setTimeout(function(){set_progress(45);}, 400);
            setTimeout(function(){update_phase_four()}, 1250);
        }
    });

    //ask for backup
    function update_phase_three(_files){
        files = [];

        $('#status_message').append(
            $('<p>', {text: '3. Back-up files.'})
        );

        var table = $('<table>',{class:'table table-condensed table-striped'});
        var tr = $('<tr>');
        tr.append($('<th>',{text:'Back up?'}));
        tr.append($('<th>',{text:'File name'}));

        table.append($('<thead>').append(tr));
        var tbody = $('<tbody>');

        $.each(_files,function(){

            tr = $('<tr>');
            tr.append($('<td>').append($('<input />', { type: 'checkbox', value: this })));
            tr.append($('<td>',{text:this}));
            tbody.append(tr);

        });

        table.append(tbody);
        $('#modal_body > table').remove();
        $('#modal_body').append(table);

        $( "input[type='checkbox']" ).change(function() {
            if($(this).prop('checked')){
                files.push($(this).val());
            }else{
                if(files.indexOf($(this).val()) != -1) {
                    files.splice(files.indexOf($(this).val()), 1);
                }
            }
        });

        $('#backupModal').modal('show');

    }



    //download
    function update_phase_two(){
        $( "#status_message p:last").html(
            $('<p>').append($('<s>', {text: '1. Preparing update.'}))
        );

        $('#status_message').append(
            $('<p>', {text: '2. Downloading update.'})
        );

        _update = updates.cursor.get_current();
        $.post("http://" + document.domain + '/index.php/admin/update/download/',{ver: _update.goal, asked: JSON.stringify(asked_files)} , function (data) {
            if(data.result){
                set_progress(30);

                $( "#status_message p:last").html(
                    $('<p>').append($('<s>', {text: '2. Downloading update.'}))
                );

                asked_files = data.asked;

                if(data.files.length > 0){
                    setTimeout(function(){update_phase_three(data.files)}, 1250);
                }else{

                    $('#status_message').append(
                        $('<p>').append($('<s>', {text: '3. Back-up files ( not needed ).'}))
                    );
                    setTimeout(function(){set_progress(45);}, 400);
                    setTimeout(function(){update_phase_four()}, 1250);
                }
            }
        }, 'json');

    }





    function update_phase_one(){

        $( "#status_message p:last").html(
            $('<p>', {text: 'updating now...'})
        );

        $('#status_message').append(
            $('<p>', {text: '1. Preparing update.'})
        );

        set_progress(10);

        setTimeout(function(){update_phase_two();}, 1250);

    }

    function begin_update(){
        set_progress(0);
        $('#status_message').html(
            $('<p>', {text: 'Fetching update server files.'})
        );

        _update = updates.cursor.get_current();

        $('#'+_update._li).toggleClass( "active" );

        _update.clear = setInterval(function(){
            $('#'+_update._li).toggleClass( "active" );
        },400);

        setTimeout(function(){update_phase_one();}, 1250);

    }



    window.onload = function(){

        (function(){
            $.get(http_root + '/admin/update/check_updates', function (data) {
                updates = data;
                console.log('here');

                var _t = $('#updatezone_detail');

                _t.append(
                    $('<p>',{class:'text-center', text:'Update facility has found updates available for your system...'})
                ).append('<br>');

                _t.append(
                    $('<p>',{class:'text-center', text:'Current (detected) version is: '}).append(
                        $('<span>', {class:'badge', text: updates.current})
                    )
                );

                _t.append(
                    $('<p>',{class:'text-center', text:'Latest version available is: '}).append(
                        $('<span>', {class:'badge', text: updates.last})
                    )
                );

                _t.append(
                    $('<p>',{class:'text-center', text:'Total number of updates: '}).append(
                        $('<span>', {class:'badge', text: updates.available_updates})
                    )
                );

                if(updates.hasOwnProperty('updates') && updates.updates.length > 0){



                    var _update_block = $('<ul>',{class:'list-group'});

                    $.each(updates.updates, function(){
                        this._li = "update_" + $.inArray(this, updates.updates);
                        var _update_item = $('<li>', {id:this._li, class:'list-group-item'});


                        _update_item.append(
                            $('<h4>', {class:'list-group-item-heading', text: 'Release date: ' + this.info.release})
                        );

                        _update_item.append(
                            $('<p>', {class:'list-group-item-text', text: 'Description: ' + this.info.description})
                        );

                        _update_item.append(
                            $('<p>', {class:'list-group-item-text', text: 'Update size: ' + this.info.filezise + ' bytes'})
                        );

                        _update_item.append(
                            $('<p>', {class:'list-group-item-text', text: 'From : ' + this.target + ' -- TO --> ' + this.goal})
                        );


                        if(this.info.hasOwnProperty('details')){
                            _update_item.append( $('<p>',{class:'text-left', text:'Details:'}));
                            var _details = $('<ul>');
                            $.each(this.info.details, function(){
                                _details.append($('<li>', {class:'list-unstyled', text: this}));
                            });
                            _update_item.append(
                                $('<p>', {class:'list-group-item-text'}).append(_details)
                            );
                        }

                        _update_block.append(_update_item);

                    });

                    _t.append(_update_block);

                }


            }, 'json');
        })();
        $(this).prop( "disabled", false );


        $('#btn_proceed').click(function(){
            $(this).prop( "disabled", true );
            $('#zone_progressbar').removeClass( "hidden" ).addClass( "show" );
            set_progress(0);

            updates.cursor = {
                current: 0,
                get_current: function(){
                    return updates.updates[this.current];
                },
                get_next: function(){
                    if(this.current+1 < updates.updates.length ){
                        this.current++;
                        return true;
                    }else{
                        return false;
                    }
                }
            };

            $('#status_message').html(
                $('<p>', {text: 'Initiating process... please wait...'})
            );

            $.get("http://" + document.domain + '/index.php/admin/update/prepare_update', function (data) {
                if(data.result){
                    setTimeout(function(){begin_update();}, 1250);
                }
            }, 'json');

        });

    };
</script>

