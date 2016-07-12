<?php
require_once ("../clases/sesion.php");

$sesion=new Sesion();
$sesion->finLogin();

header("location:../index.php");
exit;
?>