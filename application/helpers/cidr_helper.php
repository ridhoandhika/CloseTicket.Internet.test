<?php
function cidrToRange($x) {
	$range = array();
	$cidr = explode('/', $x);
	//echo $x.PHP_EOL;
	$range[0] = long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
	$range[1] = long2ip((ip2long($range[0])) + pow(2, (32 - (int)$cidr[1])) - 1);
	return $range;
}