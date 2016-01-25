        <?php echo get_header() ?>
		
		<?php echo get_sidebar() ?>
		
		<!-- begin #content --> 
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="#">Home</a></li>
				<li class="active">BuilderEngine Dashboard</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Dashboard <small>User Control Panel</small></h1>
			<div class="row">
			    <!-- begin col-4 -->
			    <div class="col-md-8">
			        <!-- begin panel -->
			        <h1>Welcome to BuilderEngine</h1>
			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			    <!-- begin col-4 -->
			    <div class="col-md-4">
			        <!-- begin panel -->
			        <div class="panel panel-inverse">
			            <div class="panel-heading">
			                <h4 class="panel-title">Weather Widget</h4>
			                <link href="/themes/dashboard/assets/css/icons.css" rel="stylesheet">
	                        <link href="<?php echo get_theme_path()?>/assets/css/custom.css" rel="stylesheet">
			            </div>
			            <div class="weather-container">
	                        <a href="#" class="minimize"></a>
	                        <div class="weather">
	                            <div class="center"><div class="location"><i class="icon16 i-location"></i> <?php echo $weather['location']?></div></div>
	                            <div class="center clearfix">
	                                 <div class="pull-left">
	                                    <div class="icon"><i class="icon64 <?php echo $weather['now']['icon_class']?>"></i></div>
	                                    <span class="today">currently</span>
	                                </div>
	                                <div class="pull-right"><span class="degree blue"><?php echo $weather['now']['temp']?>&deg;</span></div>
	                            </div>
	                            <ul class="clearfix" style="padding-left:0px">
	                            <?php for($i = 1; $i < 7; $i++): ?>
	                                <li>
	                                    <span class="day"><?php echo date("D", $weather[$i]['time'])?></span>
	                                    <span class="dayicon"><i class="icon24 <?php echo $weather[$i]['icon_class']?>"></i></span>
	                                    <span class="max"><?php echo $weather[$i]['temp']['max']?>&deg;</span>
	                                    <span class="min"><?php echo $weather[$i]['temp']['min']?>&deg;</span>
	                                </li>
	                                <?php endfor;?>
	                            </ul>
	                        </div>
	                    </div>
			        </div>
			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			    <!-- begin col-4 -->
			    
			    <!-- end col-4 -->
			</div>
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	
<!-- ================== BEGIN BASE JS ================== -->



<!-- <script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.11.2.min.js"></script>  -->
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script> 
<script src="<?php echo get_theme_path()?>assets/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/html5shiv.js"></script>
<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/respond.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/excanvas.min.js"></script>
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
<script src="<?php echo get_theme_path()?>assets/js/dashboard-v2.min.js"></script>


<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>

<script src="<?php echo get_theme_path()?>assets/js/apps.min.js"></script>

<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {

        App.init();
        var total_days = 32;
        $.ajax({
            type: 'GET',
            url: site_root + '/admin/ajax/dashboard_get_visitors_graph/' + total_days,
            dataType: 'json',
            success: function(data) {
                handleVisitorsLineChart(data);
            },
            data: {},
            async: false
        });

        $.ajax({
			url: site_root + '/admin/ajax/get_latest_news',
			dataType: 'json',
            success: function (data) {
            	$.each(data, function(i, elem){
            		var html = '<li class="media media-lg"> \
						<a href="' + elem.link[0] + '" target="_blank" class="pull-left"> \
							<img class="media-object" src="' + elem.image[0] + '" alt=""> \
						</a> \
						<div class="media-body"> \
							<h4 class="media-heading">' + elem.title[0] + '</h4> \
							' + elem.description[0] +'. \
						</div> \
					</li>';
            		$('#news-feed').append(html);
            	})
            },
            async: false
		})
    });
</script>
</body>
</html>