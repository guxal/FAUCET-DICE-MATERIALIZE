<?php
	include "../clases/sesion.php";
	include "../clases/usuarios.php";
	$sesion= new Sesion();
//LOGIN-----------------------------------------------
	if(isset($_POST["login"])&&$_POST["login"]=="1"){
		$bandera=true;
		if($_POST["usuario"]=="" && $_POST["clave"]=="") $bandera=false;
		if(strlen($_POST["clave"])<8||strlen($_POST["clave"])>16) $bandera=false;
		
		if($bandera){
			$db=new dbMySQL();
			$usuario=$_POST["usuario"];
			$usuario=$db->set_escape($usuario);
			$clave=$_POST["clave"];
			$clave=$db->set_escape($clave);
			$clave=md5($clave);
			$db->close();
			//$result="falso";
			if(Usuarios::buscaUsuario($usuario,$clave)){
				$sesion->inicioLogin($usuario);
				//$result="valido";
				header("location:../index.php");
				//print "todo bien";
		}elseif(Usuarios::buscaUsuario($usuario,$clave,false)){
			$sesion->inicioV($usuario);
			//$result="valido2";
			header("location:../index.php");
		}else{
			$_SESSION["error"]="user or incorrect password";
			//$result="invalido";
			header("location:../index.php");
		}
		unset($db);
		exit;
	//print $result;
	}else{
		$_SESSION["error"]="wrong data";
		header("location:../index.php");
		exit;
	}
}
//REGISTRO--------------------------------------------
if(isset($_POST["registro"])&&$_POST["registro"]=="1"){
	$bandera=true;

	if($_POST["usuario"]=="" && $_POST["clave"]=="" && $_POST["clave2"]=="" && $_POST["usuario2"]=="") $bandera=false;
	if($_POST["usuario"]!=$_POST["usuario2"]&&$_POST["clave"]!=$_POST["clave2"]) $bandera=false;
	if(strlen($_POST["clave"])<8||strlen($_POST["clave"])>16) $bandera=false;
	if($bandera){
		$db=new dbMySQL();
		if($_POST["refer"]==""){
			if($db->Avalido()){
				$refer="1KhLHpMtAosbq1iSnNN5HCQTTXXgbFbmKS";
			}else{
				$refer="";	
			}
		}else{
			$refer=$_POST["refer"];
			$refer=$db->set_escape($refer);
		}
		$usuario=$_POST["usuario"];
		$clave=$_POST["clave"];
		$usuario=$db->set_escape($usuario);
		$clave=$db->set_escape($clave);
		$clave=md5($clave);
		$db->close();
		unset($db);

		$hash = hash('md5',$usuario);
					
		if(Usuarios::buscaCorreo($usuario)){
			$_SESSION["error"]="the user is already registered";
			header("location:../index.php");
			exit;
		}else{		
			$q="INSERT INTO user SET correo='".$usuario."', clave='".$clave."',hash='".$hash."',refer='".$refer."', valido=0";
			$sesion->inicioV($usuario);
			$db=new dbMySQL();
			$db->abc($q);
			$db->close();
			unset($db);
				//
			$host= $_SERVER["HTTP_HOST"];
			$mensaje="Successful registration \n\n";
			$mensaje.="your registration is:\n";
			$mensaje.="User: $usuario.\n";
			$mensaje.="Password :xxxxxx That you already know :D \n";
			$mensaje.="copy and paste this code into the verification\n";
			$mensaje.=$hash;
			$cabeceras = 'From: register@'.$host . "\r\n" .
    			'Reply-To: register@'.$host . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
			$asunto= "Activation of your account Faucet+Dice";
			if (mail($usuario, $asunto, $mensaje, $cabeceras)) {
				$_SESSION["error"]="It sent a message to your email with an activation code copy and paste to activate your account";
			}else{
				$_SESSION["error"]="an error has occurred in sending message";
			}
			//
			header("location:../index.php");
			exit;
			}	
	}else{
		$_SESSION["error"]="wrong data";
		header("location:../index.php");
		exit;
	}	
}
////////////////validacion usuario
if(isset($_POST["check"])&&$_POST["check"]=="1"){
  	$user=$sesion->getCheck();
  	$bandera=true;
  if($_POST["hash"]=="") $bandera=false;
  if(strlen($_POST["hash"]) < 32 || strlen($_POST["hash"]) > 40) $bandera=false;
	

  if($bandera){
	$db= new dbMySQL();
	$hash=$_POST["hash"];
	$hash=$db->set_escape($hash);
	$r="SELECT hash FROM user WHERE correo='".$user."'";
	$row=$db->query($r,false);
  	if($row->hash==$hash){
		$q="UPDATE user SET valido=1 WHERE correo='".$user."' AND hash='".$hash."'";
		$db->abc($q);
		unset($_SESSION["check"]);
		header("location:../index.php");
 	}else{
 		$_SESSION["error"]="the keys do not match";
		header("location:../index.php");
 	}
	$db->close();
	unset($db);
 	exit;	
 	}else{
 		$_SESSION["error"]="wrong data";
 		header("location:../index.php");
 		exit;
 	}	
}
/////////////////////////////////////////////////////////
if(isset($_POST["r-pass"])&&$_POST["r-pass"]=="1"){
	$bandera=true;
	if($_POST["correo"]=="") $bandera =false;
	
	if($bandera){
			$db=new dbMySQL();
			$correo=$_POST["correo"];
			$correo=$db->set_escape($correo);
			$db->close();
			unset($db);
			if(Usuarios::buscaCorreo($correo)){
				$usuario=uniqid();
				$usuario.=$correo;
				$hash = hash('md5',$usuario);
				$_SESSION["Ruser"]=$correo;
				$_SESSION["hash"]=$hash;
				$host= $_SERVER["HTTP_HOST"];
				$mensaje.="copy and paste this code into the verification\n";
				$mensaje.=$hash;	
				$cabeceras = 'From: register@'.$host . "\r\n" .
    			'Reply-To: register@'.$host . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
				$asunto= "Recover your account ";

				if (mail($correo, $asunto, $mensaje,$cabeceras)) {
					$_SESSION["error"]="It sent a message to your email with an activation code copy and paste to activate your account";
				}else{
					$_SESSION["error"]="an error has occurred in sending message";
				}

				header("location:../index.php");
				exit;	
			}else{
				$_SESSION["error"]="Error mail does not exist";
				header("location:../index.php");
				exit;
			}
		}else{
			$_SESSION["error"]="wrong data";
			header("location:../index.php");
			exit;
		}
}	
//////////////////////////////////////
//verificar hash recuperar contraseña
////////////////////////////////////
if(isset($_POST["check-pass"])&&$_POST["check-pass"]=="1"){
	$bandera=true;
	if($_POST["hash"]=="") $bandera=false;
	if($_POST["hash"]!=$_SESSION["hash"]) $bandera=false;
	if(strlen($_POST["hash"])<32||strlen($_POST["hash"])>40) $bandera=false;
	
	if($bandera){
		$_SESSION['r-pass']=true;
		header("location:../index.php");
		exit;
	}else{
		$_SESSION["error"]="wrong data";
		header("location:../index.php");
		exit;
	}
}
//////////////////////////////////////
//cambiar contraseña
////////////////////////////////////
if(isset($_POST["c-pass"])&&$_POST["c-pass"]=="1"){
	$bandera=true;
	if($_POST["clave1"]==""&&$_POST["clave2"]=="") $bandera=false;
	if($_POST["clave1"]!=$_POST["clave2"]) $bandera=false;
	if(strlen($_POST["clave1"])<8||strlen($_POST["clave2"])>16) $bandera=false;
	
	if($bandera){
		$db=new dbMySQL();
		$clave1=$_POST['clave1'];
		$clave1=$db->set_escape($clave1);
		$clave=md5($clave1);

		$q="UPDATE user SET clave='".$clave."' WHERE correo='".$_SESSION["Ruser"]."'";
		if($db->abc($q)){
			unset($_SESSION["Ruser"]);
			unset($_SESSION["r-pass"]);
			$_SESSION["error"]="your password was changed successfully";
			header("location:../index.php");
		}
		$db->close();
		unset($db);
		exit;
	}else{
		$_SESSION["error"]="wrong data";
		header("location:../index.php");
		exit;
	}
}
?>