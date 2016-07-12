<?php
session_start();
if(isset($_GET["set"])&&$_GET["set"]=="1"){
	//print "estamos dentro";
	unset($_SESSION["Ruser"]);
	//session_destroy();
	header("location:../index.php");
	exit;
}
if(isset($_GET["set"])&&$_GET["set"]=="2"){
	//print "estamos dentro";
	unset($_SESSION["Ruser"]);
	unset($_SESSION["r-pass"]);
	//session_destroy();
	header("location:../index.php");
	exit;
}
if(isset($_GET["set"])&&$_GET["set"]=="3"){
	unset($_SESSION["admin"]);
	header("location:../admon/index.php");
}
?>