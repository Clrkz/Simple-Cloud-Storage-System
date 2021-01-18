<?php
ob_start();
error_reporting(E_ALL ^ E_DEPRECATED);
if(file_exists('../install.php')){
	header("Location: ../install.php");
}
session_start();
require '../_libs/ADMIN.php';
$Admin = new Admin;
$Admin->Headers_Operations();
$Admin->Open('admin/main/index.php');
ob_end_flush();
?>