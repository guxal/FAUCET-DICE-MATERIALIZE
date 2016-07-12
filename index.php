<?php
if(isset($_GET['pos'])){
 	$inicio=$_GET['pos'];
 }else{
 	$inicio=1;
 }
require_once "clases/sesion.php";
$sesion=new Sesion();
require_once "clases/faucetbox.php";
$canArt=4;
function limite($n,$c){
	if($n==1){
		$n=0;
		return $n;
	}else{
		$n=$n-1;
		$n=$n*$c;
		return $n;
	}
}
$inicio2=limite($inicio,$canArt);
$q="SELECT * FROM articulos ORDER BY id DESC LIMIT $inicio2,$canArt";
$r=$db->abc($q);
$n=$db->numItems("articulos");
$v=$n/$canArt;
$v=ceil($v);



$botoncobro=$db->design("botoncobro");
$titulo=$db->design("titulo");
$subtitulo=$db->design("subtitulo");
$footerTitulo=$db->design("footerT");
$footerContent=$db->design("footerC");

//colores

$c_Header=$db->design("c_Header");
$c_Subheader=$db->design("c_Subheader");;
$c_Footer=$db->design("c_Footer");
$c_Text=$db->design("c_Text");
$c_TextS=$db->design("c_TextS");
$c_btn1=$db->design("c_btn1");
$c_btn2=$db->design("c_btn2");
$c_btncobro=$db->design("c_btncobro");
$c_Panel=$db->design("c_Panel");
$c_btnd1=$db->design("c_btnd1");
$c_btnd2=$db->design("c_btnd2");
?>
<!doctype html>
<html>
<head>
	<title>Faucet + Dice</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 maximun-scale=1.0, user-scalable=no"/>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/materialize.min.css" media="screen,projection">
	<script type="text/javascript" src="js/validacion.js"></script>
	
  <style type="text/css">
  	html,body{
      height: 100%;
    }
    #content{
      min-height: 71%;
    }
    .modal-content,.mo,.mo>.small{
  		margin:0!important;
  		padding:0!important;
  	}
  	.mo>.card,.mo>.small{
  		height: 180px!important;
  	}
  	.mo .card-image{
  		max-height: 100%!important;
  	}
  	.card-title{
  		font-size:1em!important;
  	}
    #contenedor-principal{
      overflow: auto;
      padding-bottom:258px;
      padding:0;
    }
		#rollHi>i{
			transform:rotate(180deg);					
			}
    footer{
      position: relative;
    }
		iframe{
			width:270px;
		}
		.g-recaptcha div{
			width:270px!important;
		}
	</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="content" id="content">
<header><?php include "php/navegacion.php" ?></header>
<section id="contenedor-principal" class="col s12">
	<div class="row">
	<section class="col s12 m12 l9" id="content1">
		<div class="card-panel <?=$c_Subheader?> align center">
			<h6 style="font-size:2em;"><?php print $subtitulo; ?></h6>
		</div>
		<div class="align center">
			<?php
	if($n!=0){
		print "<ul class='pagination'>";
		$anterior=$inicio-1;
    $p="<li "; 
		if($inicio==1) $p.= "class='disabled'";
		$p.=" >";
		$p.="<a href='/?pos=".$anterior."'><i class='material-icons'>chevron_left</i></a></li>";
	for($i=1;$i<=$v;$i++){
		$p.="<li ";
		if($inicio==$i){
				$p.="class='active ".$c_Header."'";
		} 
		$p.=" >";
		$p.="<a href='/?pos=".$i."'>".$i."</a></li>";
		}
    $p.="<li class='waves-effect";
		if($inicio==$v) $p.=" disabled";
		$proximo=$inicio+1;
		$p.=" '><a href='/?pos=".$proximo."'><i class='material-icons'>chevron_right</i></a></li>";
		print $p;
  	print "</ul>";
		}else{
		print "No articles";
		print "<br><a href ='admon/'>Admin</a>";
	}
		print "</div>";
	
			print "<div class='row'>";
			$loop=0;
			while($data=mysqli_fetch_object($r)){
			$q ="<div class='col s12 m6'>";
            $q.="<div class='card medium z-depth-2'>";
            $q.="<div class='card-image'>";
            $q.="<img src='images/p_".$data->img.".jpg'>";
            $q.="</div>";
            $q.="<div class='card-content'>";
            $q.="<p>".$data->descripcion."</p>";
            $q.="</div>";
            $q.="<div class='card-action'>";
            $q.="<a href='#modal".$loop."' class='modal-trigger'><span class='card-title activator black-text'>".$data->titulo."<i class='material-icons right'>more_vert</i></span></a>"; 
            $q.="</div>";
            $q.="</div>";
            $q.="</div>";
            $q.="<div id='modal".$loop."' class='modal'>";
            $q.="<div class='modal-content'>";
            $q.="<div class='col s12 mo'>";
            $q.="<div class='card small'>";
            $q.="<div class='card-image hoverable'>";
            $q.="<img src='images/p_".$data->img.".jpg'>";
            $q.="</div>";
            $q.="</div>";
            $q.="<div class='text center black-text'><h4>".$data->titulo."</h4></div>";
            $q.="<div class='container text justify black-text'><p>".$data->contenido."</p></div>";
            $q.="</div>";
            $q.="</div>";
            $q.="<div class='modal-footer'>";
            $q.="<a href='#' class='modal-action modal-close waves-effect waves-green btn-flat'>Close</a>";
            $q.="</div>";
            $q.="</div>";
				print $q;
                $loop++;
			}
			print "</div>";
		?>
	</section>
	<aside class="col s12 m12 l3">
	<div class=""><?php include "php/faucet.php" ?></div><hr>
  <div class="card">
	<!---->	
	</div>
	</aside>
	</div>
</section>
</div>
<footer class="page-footer <?=$c_Footer?>">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="<?=$c_Text?>"><?=$footerTitulo ?></h5>
                <p><?=$footerContent ?></p>
              </div>
              <div class="col l4 offset-l2 s12">
                <!--<h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>-->
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            <small class="<?=$c_Text?>">Produced by Front-Design Inc. &copy</small>
            <a class="<?=$c_Text?> right" href="https://github.com/guxal/FAUCET-DICE-MATERIALIZE/" target="_blank" >Open Source</a>
							
            </div>
          </div>
</footer>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript">
		$(document).ready(inicio);
	function inicio(){
		$(".modal-trigger").leanModal();
		$("#registro").hide();
    $("#r-pass").hide();
    $("#loginbtn").click(onLogin);
    $("#r-passbtn").click(onPass);
		$("#registrobtn").click(onRegistro);
		}
  function onRegistro(){
    $("#login").hide();
    $("#registro").show(1000);
  }
  function onPass(){
    $("#login").hide();
    $("#r-pass").show(1000);
  }
  function onLogin(){
    $("#registro").hide();
    $("#r-pass").hide();
    $("#login").show(1000);    
  }
</script>
</body>
</html>
<?php 
	if(isset($_SESSION["error"])) unset($_SESSION["error"]);
	if(isset($_SESSION["diceMsg"])) unset($_SESSION["diceMsg"]);
	if(isset($_SESSION["sb"])) unset($_SESSION["sb"]);
	if(isset($_SESSION["cashout"])) unset($_SESSION["cashout"]);
?>
