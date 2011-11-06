<?php
error_reporting(0);

date_default_timezone_set('America/Los_Angeles');

require_once($_SERVER['DOCUMENT_ROOT'] . '/events/_includes/simplepie.inc');
require_once($_SERVER['DOCUMENT_ROOT'] . '/events/_includes/simplepie-gcalendar.php');

$email = '';
$query = '';
$start = '';

$url = 'http://www.google.com/calendar/feeds/9168ru6eke2frfvs5b8gf34n2s%40group.calendar.google.com/public/basic';
$show_past_events = 0;
$sort_ascending = 1;
$order_by = 1;
$expand_single_events = 1;
$language = en;
$max = '50';
$projection = 'full';
$timezone = 'America/Los_Angeles';

$feed = new SimplePie_GCalendar();
$feed->set_show_past_events($show_past_events==1);
$feed->set_sort_ascending($sort_ascending==1);
$feed->set_orderby_by_start_date($order_by==1);
$feed->set_expand_single_events($expand_single_events==1);
$feed->set_max_events($max);
$feed->set_cal_language($language);
$feed->set_projection($projection);
$feed->set_timezone($timezone);
$feed->enable_cache(true);
$feed->set_cache_duration(0);
$feed->set_cal_query($query);

$feed->set_feed_url($url);
$feed->enable_order_by_date(FALSE);
$feed->init();
$feed->handle_content_type();
$gcalendar_data = $feed->get_items();

$markup = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/events/_includes/partial.html');
$output = '';

for ($i = 0; $i < sizeof($gcalendar_data) ; $i++)
{
	$item = $gcalendar_data[$i];
	preg_match('/url:\s*?(.*)/i', $item->get_description(), $matches);
	
	if (count($matches) == 0)
	{
		continue;
	}
		
	$day = date("l, F d, Y", $item->get_start_date());
	$start_time = date("H:i", $item->get_start_date());
	$end_time = date("H:i", $item->get_end_date()) . ' PST';
	
	$description = preg_replace('/url:.*/i', '', $item->get_description());
	$description = ($description == "") ? '' : '<br />' . $description;
	
	if ($matches[1] && $item->get_title() != "")
	{
		$title = '<a href="' . $matches[1] . '" target="_parent">' . $item->get_title() . '</a>';
	}
	elseif ($item->get_title() != "")
	{
		$title = $item->get_title();
	}
	else 
	{
		$title = 'Busy';
	}
	
	$replacements = array(
		'%TITLE%' => $title,
		'%DAY%' => $day,
		'%START_TIME%' => $start_time,
		'%END_TIME%' => $end_time
	);
	
	$output .= str_replace(array_keys($replacements), $replacements, $markup);
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css" media="screen">
		html {
			background: url(_media/body_bg.png);
		}
		body {
			margin: 0;
			padding: 0;
			font-family: Arial,Verdana,sans-serif;
			font-size: 13.3333px;
			color: #333333;
		}
		strong {
			font-size: 14px;
		}
		a, a:active {
			color:#336699;
		}
		a:hover {
			color:#003366;
		}
		h2 {
			margin-top: 0;
			font-size: 16px;
		}
	</style>
</head>

<body>
<div class="container">
	<h2>Upcoming Events</h2>
	<?php print $output; ?>
</div>	
</body>
</html>
