<?php
	// PONGSOCKET TWEET ARCHIVE
	// Front page feed
	
	require "inc/preheader.php";
	require "inc/feedcreator.class.php";
	$q = $db->query("SELECT `".DTP."tweets`.*, `".DTP."tweetusers`.`screenname`, `".DTP."tweetusers`.`realname`, `".DTP."tweetusers`.`profileimage` FROM `".DTP."tweets` LEFT JOIN `".DTP."tweetusers` ON `".DTP."tweets`.`userid` = `".DTP."tweetusers`.`userid` ORDER BY `".DTP."tweets`.`time` DESC LIMIT 25");

	while($tweet = $db->fetch($q)){
		$tweets[] = $tweet;
	}
	
	$pageHeader = "Recent tweets";
	$SearchFeed = new UniversalFeedCreator();
	$SearchFeed->title = $pageTitle;
	$SearchFeed->link = sprintf("http://%s%s",$_SERVER["HTTP_HOST"],$path);
	$SearchFeed->description = $pageTitle;
	
	foreach($tweets as $result){
		$item = new FeedItem();
		$item->title = $result['text'];
		$item->link = sprintf("http://twitter.com/%s/status/%s",$result['screenname'],$result['tweetid']);
		$item->date = $result['time'];
		$item->description = $result['text'];
		$SearchFeed->addItem($item);
	}

	$SearchFeed->outputFeed("ATOM1.0");