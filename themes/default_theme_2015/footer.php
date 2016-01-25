	<footer>
	    <div id="footer" class="footer" style="color: #707478;">
			{block type='footer' name="ffooter-section" global="true"}
                {block type='row' class='container boxed-row' global="true" name="ffooter-section-container-row-1"}
                    {block type='column' class='col-lg-12 col-md-12 col-sm-12 col-xs-12' global="true" name="ffooter-section-container-row-1-col-1"}
                        {block type='generic' global="true" name="ffooter-section-container-row-1-col-1-block-1"}
                            {content}
                                <div class="footer-brand">
                                    <img src="{get_theme_path()}images/logo.png" alt="" />
                                    BuilderEngine
                                </div>
                                <p>
                                    Welcome to your footer area, use this to put important links or social network links for your website. Click edit on this block and change details.</a>
                                </p>
                                <p class="social-list">
                                    <a href="#"><i class="fa fa-facebook fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-instagram fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-twitter fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-google-plus fa-fw"></i></a>
                                    <a href="#"><i class="fa fa-linkedin fa-fw"></i></a>
                                </p>
                            {/content}
                        {/block}
                        {block type='generic' global="true" name="ffooter-section-container-row-1-col-1-block-2"}
                            {content}
                                <div class="copy-right">
                                    <p> Copyright &copy; <a href="/">Your Website</a> | Powered by <a href="http://www.builderengine.com">BuilderEngine</a> | <a href="/admin">Dashboard</a></p>
                                </div>
                            {/content}
                        {/block}
                    {/block}
                {/block}
			{/block}
		</div>
	</footer>
</div> <!-- End page container -->

{$BuilderEngine->get_option('google_analytics_code')}
<!-- JS -->
<!-- BuilderEngine JS -->
{$BuilderEngine->handle_foot()}

<script src="{get_theme_path()}js/bootstrap.min.js"></script>
<script src="{get_theme_path()}js/jquery.cookie.js"></script>

<!-- BE Plugins JS -->
<script src="{get_theme_path()}plugins/pace/pace.js"></script>
<script src="{get_theme_path()}plugins/scrollMonitor/scrollMonitor.js"></script>
<script src="{get_theme_path()}js/custom.js"></script>

<!-- BE CSS Custom Overrides -->
<link href="{get_theme_path()}css/be_navbar_tir.css" rel="stylesheet">
<link href="{get_theme_path()}css/styles-responsive.css" rel="stylesheet">

{if {$BuilderEngine->get_option('theme_color_pattern')} != ''}
		<link href="{get_theme_path()}css/color_patterns/{$BuilderEngine->get_option('theme_color_pattern')}.css" rel="stylesheet">
	{else}
		<link href="{get_theme_path()}css/color_patterns/green.css" rel="stylesheet">
	{/if}

<!-- JS Scripts -->
{literal}
<script>
	CKEDITOR.on('instanceReady',
	   	function( evt ) {
	   		setTimeout(function(){
	      		$('#ck-loading').fadeOut();
	      	}, 100);
	   	}
	);
    $(document).ready(function() {
        Loader.init();
    });
</script>
{/literal}