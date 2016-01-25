<?php
/***********************************************************

* BuilderEngine v3.1.0

* ---------------------------------

* BuilderEngine CMS Platform - Radian Enterprise Systems Limited

* Copyright Radian Enterprise Systems Limited 2012-2015. All Rights Reserved.

*

* http://www.builderengine.com

* Email: info@builderengine.com

* Time: 2015-08-31 | File version: 3.1.0

*

***********************************************************/

?>

<link href="<?=base_url('themes/dashboard/assets/plugins/bootstrap-3.2.0/css/tables.css')?>" rel="stylesheet" />
<link href="<?=base_url('themes/dashboard/assets/plugins/font-awesome-4.2.0/css/font-awesome.min.css')?>" rel="stylesheet" />
<link href="<?=base_url('themes/dashboard/assets/plugins/DataTables-1.10.2/css/data-table.css')?>" rel="stylesheet" />
<script src="<?=base_url('themes/dashboard/assets/js/form-plugins.demo.min.js')?>"></script>
<script src="<?=base_url('themes/dashboard/assets/plugins/DataTables-1.10.2/js/jquery.dataTables.js')?>"></script>
<script src="<?=base_url('themes/dashboard/assets/plugins/DataTables-1.10.2/js/data-table.js')?>"></script>

    <style>
	
.panel-default > .panel-heading {
  background: #fafafa;
}
.panel-heading {
  padding: 10px 15px;
  border: none;
}
.panel-heading-btn {
  float: right;
}
.btn.btn-danger {
  color: #fff;
  background: #ff5b57;
  border-color: #ff5b57;
}
.btn-icon.btn-xs {
  width: 16px;
  height: 16px;
  font-size: 8px;
  line-height: 16px;
}
.btn-circle, .btn.btn-circle {
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
}

.btn-icon, .btn.btn-icon {
  display: inline-block;
  width: 28px;
  height: 28px;
  padding: 0;
  border: none;
  line-height: 28px;
  text-align: center;
  font-size: 14px;
}

.panel-heading-btn > a {
  margin-left: 8px;
}
.panel-title {
  line-height: 20px;
  font-size: 12px;
}
.panel-body {
  padding: 15px;
}
label {
  font-weight: 500;
  color: #242a30;
}
.dataTables_length select {
  margin-right: 10px;
  height: 34px !important;
  width: auto !important;
}
.dataTables_length select, .dataTables_filter input {
  border: 1px solid #bec0c4;
  background: #edf0f5;
  font-size: 12px;
  padding: 6px 12px;
  line-height: 1.42857143;
  color: #555;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.dataTables_filter input {
  border-color: #edf0f5;
  height: 34px;
  margin-left: 10px;
}
.table {
  border-color: #e2e7eb;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  border-color: #e2e7eb;
  padding: 10px 15px;
}
.table > thead > tr > th {
  color: #242a30;
  font-weight: 600;
  border-bottom: 2px solid #e2e7eb !important;
}
.table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
  background: #f0f3f5;
}
.m-b-0 {
  margin-bottom: 0px !important;
}
.m-t-0 {
  margin-top: 0px !important;
}

#block-editor .tip {
  width: 26px;
  padding: 0 5px;
  font-size: 19px;
  z-index: 99999999 !important;
}
.red {
  color: #f40a0a;
}

    </style>

    <div id="block-editor" style="position:relative; width: 740px;">

<script>

    

    $("#admin-window").css('display','block');

    $("#admin-window").draggable();

    $(".tip").css("float", "left");
    var site_root = "<?=base_url()?>"


    $(".delete-version").click(function () {

        version_id = $(this).attr("version-id");





        version_name = $("#version-name-" + version_id).html();



        if($("#activate-version-" + version_id).attr("active") == "true")

        {

            alert("You cannot delete a currently active version.");

            return;

        }

        confirmed = confirm("Are you sure you want to delete version '" + version_name + "'");

        

        if(!confirmed)

            return;



        oTable = $('#dataTable').dataTable();

        $(this).parents("TR").fadeOut("fast", function () {

        var pos = oTable.fnGetPosition(this);

        oTable.fnDeleteRow(pos);

        });



        $.get(site_root + "layout_system/ajax/delete_version/" + version_id, function(data){});

        

        //$(this).parent().parent().parent().remove();

        var iframe = document.getElementById("content-frame");

            iframe.src = iframe.src;

    });



    $(".rename-version").click(function () {

        version_id = $(this).attr("version-id");



        version_name = $("#version-name-" + version_id).html();

        $("#version-name-" + version_id).html("<input type='text' id='version-new-name-" + version_id + "' value='"+version_name+"'>");

        $("#version-name-" + version_id).addClass("nolink");

        $("#rename-version-" + version_id).css("display", "none");

        $("#save-version-" + version_id).css("display", "block");

        

        //$("#save-version-" + version_id).css("width", "14px");

        



        $("#save-version-" + version_id).click(function () {



            new_name = $("#version-new-name-" + version_id).val();

            $.post(site_root + 'layout_system/ajax/version_set_name',

            {

                'id'        : version_id,

                'new_name'  : encodeURIComponent(new_name)

            },

            function(data) {

                $("#version-name-" + version_id).html(new_name);

                $("#save-version-" + version_id).css("display", "none"); 

                $("#rename-version-" + version_id).css("display", "block");  

                

            });

            



        });

        

    });



    $('.toggle-version-activate').click(function () {

        if($(this).attr("approved") != "true")

            return;



        version_id = $(this).attr("version-id");

        $.get(site_root+"admin/ajax/version_activate/" + version_id, function(data){

            var iframe = document.getElementById("content-frame");

            iframe.src = iframe.src;

        });  

        $( ".toggle-version-activate" ).each(function( index ) {

            $(this).removeClass("green");

            $(this).attr("active", "false");

            if($(this).attr("approved") == "true")

                $(this).attr("data-original-title", "Switch to this version.");



            

        });



        $(this).addClass("green");

        $(this).attr("active", "true");

        $(this).attr("data-original-title", "This version is already active.");

    });



    $('.toggle-version-approve').click(function () {



        version_id = $(this).attr("version-id");



        if($("#activate-version-" + version_id).attr("active") == "true")

        {

            alert("You cannot disapprove a currently active version.");

            return;

        }

        $.get(site_root+"/admin/ajax/toggle_version_approved/" + version_id, function(data){});  

        

        if($(this).attr("approved") == "true")

        {

            $(this).attr("approved", "false"); 

            $(this).attr("data-original-title", "Version is not approved");  

           





            $(this).removeClass("i-thumbs-up-3");

            $(this).removeClass("green");



            $(this).addClass("i-thumbs-up-4");

            $(this).addClass("red");



            $("#activate-version-" + version_id).removeClass("green");

            $("#activate-version-" + version_id).addClass("red");

            $("#activate-version-" + version_id).attr("data-original-title", "This version is not approved.");

            $("#activate-version-" + version_id).attr("approved", "false");







        }

        else

        {

            $(this).attr("approved", "true");

            $(this).attr("data-original-title", "Version is approved");  

           

            $(this).removeClass("i-thumbs-up-4");

            $(this).removeClass("red");



            $(this).addClass("i-thumbs-up-3");

            $(this).addClass("green");



            $("#activate-version-" + version_id).removeClass("red");

            $("#activate-version-" + version_id).attr("data-original-title", "Switch to this version.");

            $("#activate-version-" + version_id).attr("approved", "true");



        }



    });







    $(".tip").css('cursor', "pointer");

    $(".save-version").css('display', "none");



    $(".tip").tooltip ({placement: 'top'}); 



    $(".tooltip").css('position','absolute');

    $("#admin-window").mousemove(function(e) {

        var x_offset = - parseInt($('.tooltip').css('width'))/2;

        var y_offset = -60;

        left = e.pageX + x_offset - parseInt($("#admin-window").css('left'));

        $('.tooltip').css('left', left).css('top', e.pageY + y_offset- parseInt($("#admin-window").css('top')) );

    });

        //------------- Data tables -------------//

    $('#dataTable').dataTable( {

        "sDom": "<'row-fluid'flt <'#paging'pi>>",

        "sPaginationType": "full_numbers",

        "bJQueryUI": true,

        "bAutoWidth": false,

        "bSort": false,

        "oLanguage": {

            "sSearch": "<span>Filter:</span> _INPUT_",

            "sLengthMenu": "<span>_MENU_ entries</span>",

            "oPaginate": { "sFirst": "First", "sLast": "Last" },

        }

    });



    

    </script>

<style>

.pagination li {

    border: none !important;

    padding: 0px !important;

}

.tooltip {

    margin-top: -8px !important;

    position: absolute;

}


</style>

    <div class="block-editor"  style="width: 840px; position: absolute">

        <div class="row" style="position:relative">

            <div class="col-md-12">
			
			  <div class="panel panel-default">

                        <div class="panel-heading">

                            <div class="panel-heading-btn">

                                <a href="javascript:;" id="versions-close" class="btn btn-xs btn-icon btn-circle btn-danger close" data-click="panel-remove"><i class="fa fa-times"></i></a>

                            </div>

                            <h4 class="panel-title"> <?php if($mode == "layout"):?>

                        <h4>Global Versions</h4>

                        <?php else:?>

                        <h4>Page Versions</h4>

                        <?php endif;?></h4>

                        </div>

               <div class="panel-body">

                            <div class="table-responsive">

                                <table id="data-table" class="table table-striped table-bordered">

                                    <thead>

                                        <tr><th>Name</th><th>Creator</th><th>Approver</th><th>Date</th><th>Actions</th></tr>

                                    </thead>

                                    <tbody>

                                         <?php foreach($page_versions as $version): ?>

                                        <tr class="odd gradeX">

                                            <td id="version-name-<?=$version->id?>"><?=$version->name?></td>

                                                    <td><?=$version->author?></td>

                                                    <td><?=$version->approver?></td>

                                                    <td><?=date("j/n/Y",$version->time_created)." at ".date("g:i A",$version->time_created);?></td>

                                                    <td>

                                                        <div style="width:104px; ">

                                                        <?php if($version->approver == "N/A"): ?>

                                                            <span class="tip fa fa-thumbs-down red toggle-version-approve" approved="false" version-id="<?=$version->id?>" data-original-title="Version is rejected" style="float: left; cursor: pointer;"></span>

                                                        <?php else:?>

                                                        <span class="tip fa fa-thumbs-up green toggle-version-approve" approved="true" version-id="<?=$version->id?>" data-original-title="Version is approved" style="float: left; cursor: pointer;"></span>

                                                        <?php endif;?>

                                                        <?php if($version->approver == "N/A"): ?>

                                                        <span id="activate-version-<?=$version->id?>" class="tip fa fa-close red toggle-version-activate" version-id="<?=$version->id?>" active="false" approved="false" data-original-title="Version not approved" style="float: left; cursor: pointer;"></span>



                                                        <?php elseif($version->active == "yes"):?>

                                                        <span id="activate-version-<?=$version->id?>" class="tip fa fa-check green toggle-version-activate" version-id="<?=$version->id?>" active="true" approved="true" data-original-title="This version is already active" style="float: left; cursor: pointer;"></span>

                                                        <?php else:?>

                                                        <span id="activate-version-<?=$version->id?>" class="tip fa fa-check toggle-version-activate" version-id="<?=$version->id?>" active="false" approved="true" data-original-title="Switch to this version" style="float: left; cursor: pointer;"></span>

                                                        <?php endif;?>

                                                        <span class="tip fa fa-trash delete-version" version-id="<?=$version->id?>" data-original-title="Delete version" style="float: left; cursor: pointer;"></span>

                                                        <span id="rename-version-<?=$version->id?>" version-id="<?=$version->id?>" class="rename-version fa fa-pencil-square-o tip" data-original-title="Rename version" style="float: left; cursor: pointer;"></span>

                                                        <span id="save-version-<?=$version->id?>" version-id="<?=$version->id?>" class="save-version fa fa-floppy-o tip" data-original-title="Save" style="float: left; cursor: pointer;"></span>

                                                        </div>

                                                    </td>

                                                </tr>

                                                <?php endforeach; ?>



                                    </tbody>

                                </table>

                            </div>

                        </div>


                </div><!-- End .widget -->

            </div><!-- End .span6  -->

        </div>

    </div>

</div>