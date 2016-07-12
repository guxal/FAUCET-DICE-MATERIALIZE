<?php
 require_once "../php/db.php";
 $db=new dbMySQL();
 $user1="";//USER
 $pass="";//PASSWORD
 if(isset($_POST["admin"])){
 	if(isset($_POST["user"])&&isset($_POST["clave"])){
 		$user=$_POST["user"];
 		$clave=$_POST["clave"];
 		if($user==$user1&&$clave==$pass){
 			session_start();
 			$_SESSION["admin"]=true;
 			header("location:admin.php");
 			exit;
 		}else{
 			$error="error sus credenciales no son validas";
 		}
 	}else{
 		$error="no se aceptan campos vacios";
 	}
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>administracion</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 maximun-scale=1.0, user-scalable=no"/>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/materialize.min.css" media="screen,projection">
</head>
<style type="text/css">
   html,body{
   	min-height: 100%;
   	background:#f2f2f2;
   }
	footer{	
    position: absolute;
    bottom: 0;
    min-width: 100%;
	}
	.valign-wrapper{
		position: absolute;
		min-height: 80%;
		min-width: 100%;
	}
	.valign{
		    margin: 0 auto;
    		max-width: 50%;
	}
	@media (max-width: 500px) {
 .valign{
 			margin-top: 100px;
    		max-width: 100%;
	}
}
	</style>
<body>
<div class="valign-wrapper ">
<div class="container ">
	<div class="valign card-panel hoverable col s12 m6 l5">
	
		<section class="container">
		<div class="align center">
		<b>Faucet Admin</b>
		</div>
		<form method="post" class="col s12">
		<div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input id="icon_prefix" type="text" name="user" class="validate" required/>
          <label for="icon_prefix">User</label>
        </div>
        </div>
        <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">lock_outline_circle</i>
			<input id="icon_prefix" type="password" name="clave" class="validate" required />
			<label for="icon_prefix">Password</label>
		</div>
        </div>	
			<input type="submit" name="enviar" value="send" class="btn blue"/> 
			<input type="hidden" name="admin" value="1"/>
		</form>
		</section>
		<?php
		if(isset($error)){
			print "<p class='align center red-text'>$error</p>";
		}
		?>
	</div>
</div>
</div>
	<footer class="page-footer light-blue darken-4">
        <div class="footer-copyright">
            <div class="container">
            <small class="white-text">Produced by Front-Design Inc. &copy</small>
            <a class="white-text right" href="https://github.com/guxal/FAUCET-DICE-MATERIALIZE/" target="_blank" >Open Source</a>	
            </div>
          </div>
	</footer>
	<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>