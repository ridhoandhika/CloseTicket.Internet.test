<?php 
$output = array(
	'ip_addr' => ''
);

$output['ip_addr'] = $_SERVER['REMOTE_ADDR'];
echo json_encode($output);