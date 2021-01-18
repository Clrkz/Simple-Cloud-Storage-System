<?php
ob_start();
error_reporting(E_ALL);
if(file_exists('install.php')){
	header("Location: ./install.php");
	exit;
}
session_start();
require '_libs/BUILD.php';
$Build = new Build;

if(isset($_GET['captcha'])){
	$Build->create_image();
}else{
  $Build->Headers_Operations();
  $Build->Open('main/index.php');
}
ob_end_flush();
?>