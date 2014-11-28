<?php

session_start();
header('content-type: text/html; charset: utf-8');

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('Twitter.php');
require_once('LastFM.php');

$hostname = "localhost";
$username = "arcomul_site";
$password = "K869NrhF";
$mysql = new PDO("mysql:host=$hostname;dbname=arcomul_website", $username, $password);

$execute = array(
	"twitter"=>false,
	"lastfm"=>false,
);

if($execute["twitter"])
{
	$twitter = new Twitter('BmhruI92AJ2bHshjRRLzw', 'yZSzPvzOR4EKypNj0BHAg00zcsGOn8JwcxtySRoUMig');
	$twitter->setOAuthToken('112475953-yFYjP4YBDaLix2JrIYZQ5X54Xm2YBG4n6dWShTVL');
	$twitter->setOAuthTokenSecret('sGnnm3zGqMJmtAzmadwdEK3w56VtAMXD3uG0p0VE');
	$tweets = $twitter->statusesUserTimeline(null, null, null, null, 200);
	
	foreach($tweets as $t)
	{
		if(!dateExcists('twitter', strtotime($t['created_at'])))
		{
			echo "Insert data<br />"; 
			insert('twitter', array(
				"url" => "http://twitter.com/ArcoMul/status/" . $t['id'],
				"text" => '<a href="http://twitter.com/ArcoMul">@ArcoMul:</a> ' . $t['text'],
				"date" => strtotime($t['created_at']),
			));
		}
		else {
			echo "twitter Bestaat al<br />";
		}
	}
}

if($execute["lastfm"])
{
	$lastfm = new LastFM('fa4fd9860f4323abe636e5d8f22c85c1', 'ArcoMul', 'c8d4daf706b407a22e1d0a22534bcd02');
	$tracks = $lastfm->user('getRecentTracks', array('limit'=>200));
	foreach($tracks['recenttracks']['track'] as $t)
	{
		if(!empty($t['date']['#text']) && !dateExcists('lastfm', strtotime($t['date']['#text'])))
		{
			echo "Insert data<br />"; 
			insert('lastfm', array(
				"url" => "",
				"text" => $t['name'] . ' - ' . $t['artist']['#text'],
				"date" => strtotime($t['date']['#text']),
			));
		}
		else {
			echo "lastfm Bestaat al<br />";
		}
	}
}

function dateExcists($type, $date)
{
	global $mysql; 
	
	$query = "SELECT * FROM stream WHERE type=:type AND date=:date";
	$result = $mysql->prepare($query);
	$result->bindParam(":type", $type);
	$result->bindParam(":date", date("Y-m-d H:i:s", $date));
	echo $date;
	$result->execute();
	if($result->rowCount() == 0)
		return false;
	return true;
}

function insert($type, $values)
{
	global $mysql;
	
	$query = "INSERT INTO stream (type, date, url, text) VALUES (:type, :date, :url, :text)";
	$result = $mysql->prepare($query);
	$result->bindParam(":type", $type);
	$result->bindParam(":date", date("Y-m-d H:i:s", $values['date']));
	$result->bindParam(":url", $values['url']);
	$result->bindParam(":text", $values['text']);
	$result->execute();
}