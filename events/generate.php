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
$feed->enable_cache(TRUE);
$feed->set_cache_location('../tmp');
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
	
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/tmp/events.inc', $output);
}