
<pre>
	<h2>Memcached</h2>
	
<?php

var_export(class_exists('Memcache'));

var_dump($get_result);

$i = 0;
foreach ($GLOBALS as $global_name => $global_value) 
{
	if ($i != 0 && 'i' != $global_name && 'global_value' != $global_name && 'global_name' != $global_name) 
	{
		print '<h2>' . $global_name . '</h2>';
		print '<pre>' . print_r($global_value, TRUE) . '</h2>';
		
		error_log(var_export($global_name . ' --------------------------------', TRUE));
		error_log(var_export($global_value, TRUE));
		
	}
	$i++;
}

?>
</pre>