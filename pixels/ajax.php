<?php

use \TijsVerkoyen\Twitter\Twitter;

require_once('Twitter.php');
require_once('Exception.php');
// require_once('LastFM.php');

(string)$lastid = ($_GET['lastid'] == 0 ? null : $_GET['lastid']);

if($lastid != 0)
{
	$lastnrs = substr($lastid, strlen($lastid) - 2, 2);
	//echo $lastnrs . "\n";
	$lastnrs = (int)$lastnrs - 1;
	$lastid = substr($lastid, 0, strlen($lastid) - 2) . $lastnrs;
	//echo "min one: " . substr($lastid, 0, strlen($lastid) - 2) . $lastnrs . "\n";
	//echo "normal: " . (string)$lastid;
}

$twitter = new Twitter('BmhruI92AJ2bHshjRRLzw', 'yZSzPvzOR4EKypNj0BHAg00zcsGOn8JwcxtySRoUMig');
$twitter->setOAuthToken('112475953-yFYjP4YBDaLix2JrIYZQ5X54Xm2YBG4n6dWShTVL');
$twitter->setOAuthTokenSecret('sGnnm3zGqMJmtAzmadwdEK3w56VtAMXD3uG0p0VE');

    //$tweets = $twitter->statusesUserTimeline(null, "ArcoMul", null, $lastid, $_GET['count']);
echo $lastid;
    $tweets = $twitter->statusesUserTimeline(null, "ArcoMul", null, $lastid);

$i = 0;
foreach($tweets as $tweet):
    if ($i > 5) break; ?>
	<li class="tweet" data-url="http://twitter.com/ArcoMul/status/<?=$tweet['id']?>" data-id="id<?=$tweet['id']?>">
		<span class="text"><?=preg_replace(array('"\b(http://\S+)"', '/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '/@([a-zA-Z0-9_]+)/'), array('<a href="$1">$1</a>', '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>', '<a href="http://twitter.com/$1">@$1</a>'), $tweet['text'])?></span>
		<span class="footer"><a class="user" href="http://twitter.com/ArcoMul">@ArcoMul</a> - <a href="http://twitter.com/ArcoMul/status/<?=$tweet['id']?>"><?=date("F j, Y", strtotime($tweet['created_at']))?></a></span>
	</li>
<?php $i++; endforeach;

/*
$stream = array();

$twitter = new Twitter('BmhruI92AJ2bHshjRRLzw', 'yZSzPvzOR4EKypNj0BHAg00zcsGOn8JwcxtySRoUMig');
$twitter->setOAuthToken('112475953-yFYjP4YBDaLix2JrIYZQ5X54Xm2YBG4n6dWShTVL');
$twitter->setOAuthTokenSecret('sGnnm3zGqMJmtAzmadwdEK3w56VtAMXD3uG0p0VE');
$tweets = $twitter->statusesUserTimeline();
foreach($tweets as $t)
{
	$item = array(
		"url" => "http://twitter.com/ArcoMul/status/" . $t['id'],
		"text" => '<a href="http://twitter.com/ArcoMul">@ArcoMul:</a> ' . $t['text'],
		"date" => strtotime($t['created_at']),
	);
	$stream[strtotime($t['created_at'])] = $item;
}

$lastfm = new LastFM('fa4fd9860f4323abe636e5d8f22c85c1', 'ArcoMul', 'c8d4daf706b407a22e1d0a22534bcd02');
$tracks = $lastfm->user('getRecentTracks', array("from"=>strtotime("-10 day")));
foreach($tracks['recenttracks']['track'] as $t)
{
	$item = array(
		"url" => "",
		"text" => $t['name'] . ' - ' . $t['artist']['#text'],
		"date" => strtotime($t['date']['#text']),
	);
	$stream[strtotime($t['date']['#text'])] = $item;
}

ksort($stream);
$stream = array_reverse($stream);

foreach($stream as $item): ?>
	<li class="tweet" data-url="<?=$item["url"]?>" data-id="id<?=$item['id']?>">
		<span class="text"><?=$item["text"]?></span>
		<span class="date"><?=date("d-m-y H:i", $item["date"])?></span>
	</li>
<?php endforeach; ?>
 */
