<?php if(!$embedded):?>
<?php echo get_header() ?>
<script>
    var site_root = "<?php echo home_url("")?>";
</script>
    <!-- Plugins stylesheets -->
<?php 
/*<link href="<?php echo get_theme_path()?>css/builderengine-theme/jquery.ui.genyx.css" rel="stylesheet" />*/?>
<!-- Plugins stylesheets -->
<link href="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/css/elfinder.min.css" rel="stylesheet" />
<link href="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/css/theme.css" rel="stylesheet">

<link href="<?php echo get_theme_path()?>assets/plugins/upload/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" /> 


<style>
.elfinder-button {
    width: 24px !important;
    height: 24px !important;
}
</style>




<!-- Init plugins -->



<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content" style="min-height:800px">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">Files</a></li>
	  <li class="active">File Manager</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">File Manager <small>Administration Control Panel</small></h1>
<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
                <!-- begin col-8 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			        </div>
			        <h4 class="panel-title">Upload Multiple Files</h4>
			    </div>
			    <div class="panel-body">			
                    <blockquote class="f-s-14">
                        <p>File Upload with multiple files selection by using the Add Files button or Drag &amp; Drop files to this box. Preview images, audio and video before Uploading.</p>
                    </blockquote>
                    <form id="fileupload" action="<?php echo get_theme_path();?>assets/plugins/jquery-file-upload/server/php/" method="POST" enctype="multipart/form-data">
                        <div class="row fileupload-buttonbar">
                            <div class="col-md-7">
                                <span class="btn btn-success fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span>Add files...</span>
                                    <input type="file" name="files[]" multiple>
                                </span>
                                <button type="submit" class="btn btn-primary start" style="margin-left:5px">
                                    <i class="fa fa-upload"></i>
                                    <span>Start upload</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="fa fa-ban"></i>
                                    <span>Cancel upload</span>
                                </button>
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Delete</span>
                                </button>
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-md-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <!-- The table listing the files available for upload/download -->
                        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                    </form>
                    <!-- <div class="note note-info">
                        <h4>Demo Notes - Dimitar, can you fix this to be set to unlimited for files & the removal of deleting files after 5 minutes. Remove this info box then </h4>
                        <ul>
                            <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
                            <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
                            <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
                        </ul>
                    </div> -->
			    </div>
			</div>
                    <!-- end panel -->
					
					<div class="panel panel-inverse">
			    <div class="panel-heading">
			        <div class="panel-heading-btn">
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			        </div>
			        <h4 class="panel-title">File Manager</h4>
			    </div>
			    <div class="panel-body">
                    <div id="elfinder"></div>
			    </div>
			</div>
                </div>
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
		
<?php echo get_footer()?>

<script src="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/js/elfinder.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/upload/plupload/plupload.full.js"></script>

<script src="<?php echo get_theme_path()?>assets/plugins/upload/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script>
$(document).ready(function () {
    setTimeout("initialize_file_manager();", 500);
});
</script>
<!-- Init plugins -->

<script src="<?php echo get_theme_path()?>assets/plugins/file_manager.js"></script>
<?php else:?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>BuilderEngine File Manager</title>
        <script>
            var site_root = "<?php echo home_url("")?>";
        </script>
        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link href="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/css/elfinder.min.css" rel="stylesheet" />
        <link href="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/css/theme.css" rel="stylesheet">
        <!-- elFinder JS (REQUIRED) -->
        <script src="<?php echo get_theme_path()?>assets/plugins/upload/elfinder/js/elfinder.min.js"></script>

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Helper function to get parameters from the query string.
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;

                return (match && match.length > 1) ? match[1] : '' ;
            }

            $(document).ready(function() {
                var funcNum = getUrlParam('CKEditorFuncNum');

                var elf = $('#elfinder').elfinder({
                    url : site_root + '/admin/files/connector/',
                    getFileCallback : function(file) {
                        if(typeof window.opener.CKEDITOR != "undefined")
                            window.opener.CKEDITOR.tools.callFunction(funcNum, file);
                        <?php if(isset($_GET['target'])):?>
                        if ( typeof window.opener.file_selected == 'function' ) {
                            window.opener.file_selected( file,'<?php echo $_GET['target']?>');
                        }
                        <?php endif;?>

                        window.close();
                    },
                    resizable: false
                }).elfinder('instance');
            });
        </script>


    </head>
    <body>

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

    </body>
    </html>
<?php endif?>
<!-- Upload plugins -->
