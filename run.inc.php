<?php
function _runtime(){
	$mitime = explode(' ',microtime());
	return $mitime[0] + $mitime[1];
}
define('START_TIME',_runtime());

if (strstr($_SERVER['PHP_SELF'],'run.inc.php')) exit;

if (version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('ROOT_PATH',dirname(__FILE__));
//define('APP_DEBUG',true);
define('APP_PATH',ROOT_PATH.'/Application/');
require ROOT_PATH.'/ThinkPHP/ThinkPHP.php';