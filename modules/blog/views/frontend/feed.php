<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title><?php echo $feed_name; ?></title>
		<link><?php echo $feed_url; ?></link>
		<description><![CDATA[ <?php echo $page_description; ?> ]]></description>
		<dc:language><?php echo $page_language; ?></dc:language>
		<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
		<?php foreach($posts as $post):?>
		<item>
			<title><?=$post->title?></title>
			<link><?=base_url('blog/post/'.$post->slug)?></link>
			<guid><?=base_url('blog/post/'.$post->slug)?></guid>
			<description><![CDATA[
				<?php
				$text_without_slashes = strip_tags(ChEditorfix($post->text));
				if(strlen($post->text) > 300)
				{
					$text = substr($text_without_slashes, 0, 300).'...';
					echo $text;
				}
                else{
                    $text = $text_without_slashes;
			echo $text;
                }
				?> ]]>
			</description>
			<enclosure url="<?=base_url()?><?=$post->image?>" type="image/jpeg"/>
			<pubDate><?=date('d.M.Y - h:i',$post->time_created)?></pubDate>
		</item>
		<?php endforeach; ?>
	</channel>
</rss>