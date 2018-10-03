<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use GuzzleHttp\Client;
use ThibaudDauce\Mattermost\Mattermost;
use ThibaudDauce\Mattermost\Message;
use ThibaudDauce\Mattermost\Attachment;

$last_run = mktime(0, 0, 0, 1, 1, 1970);
if( file_exists(__DIR__ . '/last_run') ){
	$last_run = filemtime(__DIR__ . '/last_run');
}

foreach($rss_feeds as $rfeed){

	$RSS_URL = $rfeed['rss_url'];
	$RSS_IMAGE_URL = $rfeed['rss_image_url'];

	echo "Fetch RSS $RSS_URL \n";

	$rss = Feed::loadRss($RSS_URL);

	$mattermost = new Mattermost(new Client);

	//reverse items
	$rss_items = array();
	foreach ($rss->item as $item) {
		$rss_items[] = $item;
	}
	$rss_items = array_reverse($rss_items);

	//post
	$new_post_count = 0;
	foreach ($rss_items as $item) {
		
		if( $item->timestamp > $last_run ) {
			$message = (new Message)
				->channel($MATTERMOST_CHANNEL)
				->username($MATTERMOST_USERNAME)
				->iconUrl($RSS_IMAGE_URL)
				->text(''.$item->link);
			
			echo "POST $item->title \n";
			
			$mattermost->send($message, $MATTERMOST_WEBHOOK);
			
			$new_post_count++;
		}

	}
	
}

echo "New posts added: $new_post_count\n";

touch(__DIR__ . '/last_run');