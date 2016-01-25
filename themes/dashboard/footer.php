<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php //echo get_theme_path()?>assets/crossbrowserjs/html5shiv.js"></script>
<script src="<?php //echo get_theme_path()?>assets/crossbrowserjs/respond.min.js"></script>
<script src="<?php //echo get_theme_path()?>assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo get_theme_path()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo get_theme_path()?>assets/plugins/morris/raphael.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/morris/morris.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/gritter/js/jquery.gritter.js"></script>

<script src="<?php echo get_theme_path()?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/masked-input/masked-input.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/js/form-plugins.demo.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/DataTables-1.10.2/js/jquery.dataTables.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/DataTables-1.10.2/js/data-table.js"></script>

<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<script src="<?php echo get_theme_path()?>assets/js/form-multiple-upload.demo.min.js"></script>

<script src="<?php echo get_theme_path()?>assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/lightbox/js/lightbox-2.6.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/js/gallery.demo.min.js"></script>


<script>
    function capitaliseFirstLetter(string)
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
<?php
$notification_timer = 0;
$notification_timer_step = 1500;

if($user)
    foreach($this->user->get_notifications() as $notification): ?>

$(window).load(function() {
    setTimeout(function() {
        $.gritter.add({
            title: capitaliseFirstLetter('<?php echo $notification['type']?>'),
            text: '<?php echo $notification['message']?>',
            image: '<?php echo $this->user->get_avatar()?>',
            sticky: false,
            time: '',
            class_name: 'my-sticky-class'
        });
    }, <?=$notification_timer?>);
});
<?php $notification_timer += $notification_timer_step ?>
<?php endforeach;?>



</script>
<script src="<?php echo get_theme_path()?>assets/js/dashboard-v2.js?2"></script>
<script src="<?php echo get_theme_path()?>assets/js/apps.min.js"></script>

<script src="<?php echo get_theme_path()?>assets/plugins/file_manager.js?v2"></script>


<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
		FormMultipleUpload.init();
		Gallery.init();
        // handleVisitorsLineChart();
    });
</script>

	<!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
                <td class="col-md-1">
                    <span class="preview"></span>
                </td>
                <td>
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                </td>
                <td>
                    <p class="size">Processing...</p>
                    <div class="progress progress-striped active"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                </td>
                <td>
                    {% if (!i && !o.options.autoUpload) { %}
                        <button class="btn btn-primary btn-sm start" disabled>
                            <i class="fa fa-upload"></i>
                            <span>Start</span>
                        </button>
                    {% } %}
                    {% if (!i) { %}
                        <button class="btn btn-white btn-sm cancel">
                            <i class="fa fa-ban"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                <td>
                    <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td>
                    {% if (file.deleteUrl) { %}
                        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
    </script>

</body>
</html>
