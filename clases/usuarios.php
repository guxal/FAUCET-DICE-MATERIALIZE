<?php 
include "../php/db.php";
class Usuarios {
	private $clave;
	private $correo;
	function __construct(){
		
	}
	function __destruct(){
		//print "adios desde la clase usuarios<br>";
	}
	public static function buscaUsuario($n,$c,$p=true){
		$db=new dbMySQL();
		if($p) $data=$db->query("SELECT * FROM user WHERE correo='".$n."' AND clave='".$c."' AND valido=1");
		if(!$p) $data=$db->query("SELECT * FROM user WHERE correo='".$n."' AND clave='".$c."' AND valido=0");
		$db->close();
		unset($db);
		return isset($data[0]);
	}
	public static function buscaCorreo($n){
		$db=new dbMySQL();
		$data=$db->query("SELECT * FROM user WHERE correo='".$n."'");
		$db->close();
		unset($db);
		return isset($data[0]);
	}
}
?>