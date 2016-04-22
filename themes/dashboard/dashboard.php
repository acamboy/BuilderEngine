        <?php echo get_header() ?>
		
		<?php echo get_sidebar() ?>
		
		<!-- begin #content --> 
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="#">Home</a></li>
				<li class="active">BuilderEngine Dashboard</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Dashboard <small>Administration Control Panel</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
                <?php if($update_available):?>
                <div class="row-fluid col-md-12">
                    <div class="alert alert-block alert-info fade in">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4 class="alert-heading"><i class="icon24 i-info"></i>Update available!</h4>
                        <p>We have an update for your website. Updates provide you with new features and security improvements. <br>We recommend you to always keep your website up to date.</p>
                        <p>
                            <a class="btn btn-success" href="<?=base_url('admin/update/index')?>">Update your website</a>
                        </p>
                    </div>
                </div>
                <?php endif;?>
			    <!-- begin col-3 -->
			   	<div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
			            <div class="stats-title">TODAY'S VISITS</div>
			            <div class="stats-number" id="todaysVisitorsCount"><?php echo $todayvisitorscount; ?></div>
			            <div class="stats-progress progress">
                            <?php
                                $p = 0;
                                if(intval($todayvisitorscount) != 0){
                                    $p = 100 - intval($lastweekvisitorscount) / intval($todayvisitorscount) * 100;
                                }
                                $p = intval($p);
                            ?>
                            <div class="progress-bar" style="width: <?php echo ($p >= 0) ? $p : (1)*$p;
                            ?>%;"></div>
                        </div>
                        <div class="stats-desc">
                            <?php
                            echo ($p >= 0)? $p."% Better then last week"  : (-1)*$p."% Worse than last week";
                            ?>
                        </div>
			        </div>
			    </div>
			    <!-- end col-3 -->
			    <!-- begin col-3 -->
			   	<div class="col-md-3 col-sm-6">
			        <div class="widget widget-stats bg-blue">
			            <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
			            <div class="stats-title">TODAY'S USER ACCOUNTS</div>
			            <div class="stats-number" id="userAccounts"><?php  echo $todays_users_count; ?></div>
                        <div class="stats-progress progress"></div>
                        <div class="stats-desc">View all members in the User Account Section</div>
			        </div>
			    </div>
			    <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-green">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
                        <div class="stats-title">TOTAL BLOGS</div>
                        <div class="stats-number" id="blogAccounts"><?=$statistics['total_blogs']?></div>
                        <div class="stats-progress progress"></div>
                        <div class="stats-desc">Total number of Blog Posts Created</div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-green">
                        <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
                        <div class="stats-title">BLOG COMMENTS</div>
                        <div class="stats-number" id="blogComments"><?=$statistics['total_comments']?></div>
                        <div class="stats-progress progress"></div>
                        <div class="stats-desc">Total number of Blog Posts Comments</div>
                    </div>
                </div>
                <!-- end col-3 -->
			</div>
			<!-- end row -->
			
			<!-- begin row -->
			<div class="row">
			    <div class="col-md-8">
			        <div class="widget-chart with-sidebar bg-black">
			            <div class="widget-chart-content">
			                <h4 class="chart-title">
			                    Visitors Analytics
			                    <small>Where do our visitors come from</small>
			                </h4>
			                <div id="visitors-line-chart" class="morris-inverse" style="height: 260px;"></div>
			            </div>
			            <div class="widget-chart-sidebar bg-black-darker">
			                <div class="chart-number">
			                	<font id="allVisitors">0</font>
			                    <small>visitors</small>
			                </div>
			                <div id="visitors-donut-chart" style="height: 160px"></div>
			                <ul class="chart-legend">
			                    <li><i class="fa fa-circle-o fa-fw text-success m-r-5"></i> <font id="newVisitors">0.0</font>% <span>New Visitors</span></li>
			                    <li><i class="fa fa-circle-o fa-fw text-primary m-r-5"></i><font id="returnVisitors">0.0</font>% <span>Return Visitors</span></li>
			                </ul>
			            </div>
			        </div>
			    </div>
			    <div class="col-md-4">
			        <div class="panel panel-inverse">
			            <div class="panel-heading">
			                <h4 class="panel-title">
			                    Visitors Origin
			                </h4>
			            </div>
			            <div id="visitors-map" class="bg-black" style="height: 181px;"></div>
			            <div class="list-group" id="countries_ip">
                            <?php  $num = 1; ?>
                            <?php foreach($arrCounts as $k=>$v ):  ?>
                                <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                    <span class="badge badge-success"><?php echo $v; ?></span>
                                    <?php echo $num.'. '.$k; ?>
                                </a>
                                <?php  $num++; ?>
                            <?php  endforeach;  ?>
                        </div>
			        </div>
			    </div>
			</div>
			<!-- end row -->
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-4 -->
			    <div class="col-md-8">
			        <!-- begin panel -->
			       <ul class="nav nav-tabs nav-tabs-inverse nav-justified nav-justified-mobile">
						<li class="active"><a href="#latest-post" data-toggle="tab"><i class="fa fa-picture-o m-r-5"></i> <span class="hidden-xs">BuilderEngine Latest News</span></a></li>
						<li class=""><a href="#system" data-toggle="tab"><i class="fa fa-info m-r-5"></i> <span class="hidden-xs">BuilderEngine System Version</span></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="latest-post">
							<div class="height-sm" data-scrollbar="true">
								<ul class="media-list media-list-with-divider" id="news-feed"></ul>
							</div>
						</div>
						<div class="tab-pane fade" id="system">
							<div class="height-sm" data-scrollbar="true">
								<table class="table">
									<thead>
										<tr>
											<th>Date</th>
											<th>Platform</th>
											<th>System Version</th>
											<th>Provider</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>22 / 02 / 2016</td>
											<td class="hidden-sm">
												<a href="#">
													<img src="<?=base_url('/themes/dashboard/assets/img/builderengine-icon.png')?>" alt="BuilderEngine"  />
												</a>
											</td>
											<td>
												<h6><a href="#">Version <?=$this->BuilderEngine->get_option('version');?></a></h6>
											</td>
											<td><a href="http://www.builderengine.org">BuilderEngine</a></td>
										</tr>
										<tr>
											<td>09 / 04 / 2015</td>
											<td class="hidden-sm">
												<a href="#">
													<img src="<?=base_url('/themes/dashboard/assets/img/builderengine-icon.png')?>" alt="BuilderEngine"  />
												</a>
											</td>
											<td>
												<h6><a href="#">Version 3.0</a></h6>
											</td>
											<td><a href="http://www.builderengine.org">BuilderEngine</a></td>
										</tr>
										<tr>
											<td>30 / 10 / 2013</td>
											<td class="hidden-sm">
												<a href="#">
													<img src="<?=base_url('/themes/dashboard/assets/img/builderengine-icon.png')?>" alt="BuilderEngine"  />
												</a>
											</td>
											<td>
												<h6><a href="#">Version 2.0</a></h6>
											</td>
											<td><a href="http://www.builderengine.org">BuilderEngine</a></td>
										</tr>
										<tr>
											<td>15 / 10 / 2012</td>
											<td class="hidden-sm">
												<a href="#">
													<img src="<?=base_url('/themes/dashboard/assets/img/builderengine-icon.png')?>" alt="BuilderEngine"  />
												</a>
											</td>
											<td>
												<h6><a href="#">Version 1.0</a></h6>
											</td>
											<td><a href="http://www.builderengine.org">BuilderEngine</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
			        <!-- end panel -->
			    </div>
			    <!-- end col-4 -->
			    <!-- begin col-4 -->
			    <div class="col-md-4">
			        <!-- begin panel -->
			        <div class="panel panel-inverse">
			            <div class="panel-heading">
			                <h4 class="panel-title">Weather Widget</h4>
			                <link href="<?=base_url('/themes/dashboard/assets/css/icons.css')?>" rel="stylesheet">
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
			<!-- end row -->
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	
<!-- ================== BEGIN BASE JS ================== -->



<!-- <script src="<?php //echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.11.2.min.js"></script>  -->
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

<!--<script src="<?php //echo get_theme_path()?>assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script> -->
<script src="<?php echo get_theme_path()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="<?php echo get_theme_path()?>assets/js/dashboard-v2.min.js"></script>


<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>

<script src="<?php echo get_theme_path()?>assets/js/apps.min.js"></script>

<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {

        handleVisitorsVectorMap(<?php  echo $countryNamesArr ?>)
        App.init();
        var total_days = 32;
        $.ajax({
            type: 'GET',
            url: site_root + '/admin/ajax/dashboard_get_visitors_graph/' + total_days,
            dataType: 'json',
            success: function(data) {
            	if(data['all'][2] != 0){
	                handleVisitorsLineChart(data);
            	}
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