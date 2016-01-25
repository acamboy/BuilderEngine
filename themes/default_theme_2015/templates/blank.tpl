{get_header()}
<head>
	{$access_groups = explode(',', $page->groups)}
	{if !$user->is_member_of_any($access_groups)}
		{redirect('/', 'location')}
	{/if}
	<meta name="description" content="{$page->meta_desc}">
	<meta name="keywords" content="{$page->meta_keywords}">
	<meta name="robots" content="{$page->seo_index} {$page->seo_follow} {$page->seo_snippet} {$page->seo_archive} {$page->seo_img_index} {$page->seo_odp}">
</head>

{block type='page' name="blank-page"}
		{block type='row' class='container boxed-row' name="blank-page-row-1"}
			{block type='column' class='col-lg-12 col-md-12 col-sm-12 col-xs-12' name="blank-page-row-1-col-1"}
				{block type='generic' name="blank-page-row-1-col-1-block-1"}
					{content}
						<h2 class="content-title">This is an empty template. Feel free to construct any design you wish using our BuilderEngine Editor!</h2>
						<p class="content-desc">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi consectetur vestibulum risus, in pulvinar ante. <br>
							Etiam in velit vel ante egestas sodales. Pellentesque faucibus ut quam quis pellentesque. <br>
							Nunc sit amet ultrices nisl, quis tristique velit. Duis non turpis sed purus ultricies placerat vel ut purus.
						</p>
					{/content}
				{/block}
			{/block}
		{/block}
{/block}
	
{get_footer()}
{literal}
<script>
	$(document).ready(function(){
		$('#primary-website-title').html("{/literal}{$page->title}{literal}");
	});
</script>
{/literal}