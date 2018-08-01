<?php
 //300 seconds = 5 minutes execution time
ini_set('max_execution_time', 300);
// overrides the default PHP memory limit.
ini_set('memory_limit', '-1');

// include pdo helper class to use common methods
error_reporting(E_ALL);
// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

require_once('class/function.php');
global $fn;

if(isset($_POST['commit'])){
	$fn->loginAdmin();
}
if(!$fn->checkLogin()){
	header('Location:'.URL_PATH.'login.php');
}else{
	header('Location:'.URL_PATH.'dashboard.php');
}
