<?php
/**
if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
	$_GET['action'] = 'notify';
} else {
	$_GET['action'] = 'search';
}
$_GET['by'] = 'notification';
*/
$_GET['action'] = 'v2/transactions/notifications';
require realpath(dirname(__FILE__).'/../../../index.php');
?>