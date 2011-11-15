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
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/tmp/events.inc'); ?>
</div>	
</body>
</html>
