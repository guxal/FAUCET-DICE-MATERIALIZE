<?php
	session_start();
	if(!$_SESSION["admin"]){
		header("location:index.php");
		exit;
	}
	require_once "../php/db.php";
	$db=new dbMySQL();
	$q="SELECT * FROM articulos ORDER BY id DESC";
	$q2="admonfaucet";
	$q3="SELECT * FROM admonfaucet";
	$row=$db->numItems($q2);
	if($row==1){
		$data=$db->query($q3,false);
		$balance=$data->balance;
		$referbalance=$data->refbalance;
		$timeClaim=$data->timeClaims;
		$api=$data->api;
		$r1=$data->rkp;
		$r2=$data->rsk;
		$v=$data->valido;
	}elseif($row==0){
		$balance=100;
		$referbalance=100;
		$timeClaim=1800;
		$api="";
		$r1="";
		$r2="";
		$v="";
	}
	$r=$db->abc($q);
	//
if(isset($_POST["df"])&&$_POST["df"]=="1"){
	if($_POST["balance"]!=""&&$_POST["rb"]!=""&&$_POST["time"]!=""&&$_POST["api"]!=""&&$_POST["rp"]!=""&&$_POST["rs"]!=""&&$_POST["valido"]!=""){
		$valido=$_POST["valido"];
		$balance=$_POST["balance"];
		$rb=$_POST["rb"];
		$time=$_POST["time"];
		$api=$_POST["api"];
		$rp=$_POST["rp"];
		$rs=$_POST["rs"];	
		if($row==1){
			$p="UPDATE admonfaucet SET balance=$balance, refbalance=$rb, timeClaims=$time, api='".$api."', rkp='".$rp."', rsk='".$rs."',valido=".$valido." WHERE id=1";
			$db->abc($p);
			header("location:admin.php");
			exit;
		}elseif($row==0){
			$p="INSERT INTO admonfaucet SET id=1 , balance=$balance, refbalance=$rb, timeClaims=$time, api='".$api."', rkp='".$rp."', rsk='".$rs."',valido=".$valido;
			$db->abc($p);
			header("location:admin.php");
			exit;
	}
		
	}	
}
//
	if(isset($_POST["cArticulo"])&&$_POST["cArticulo"]=="1"){

		if($_POST["titulo"]!=""&&$_POST["descripcion"]!=""&&$_POST["contenido"]!=""){
			$titulo=$_POST["titulo"];
			$descripcion=$_POST["descripcion"];
			$contenido=$_POST["contenido"];
			$row=time();
			$b=false;
			if(is_uploaded_file($_FILES['foto']['tmp_name'])){
				$foto="p_".$row.".jpg";
				copy($_FILES['foto']['tmp_name'], "../images/$foto");
			}else{
				$b=true;
			}

			if($b==false){
				$q="INSERT INTO articulos SET ";
				$q.="titulo='".$titulo."', ";
				$q.="descripcion='".$descripcion."', ";
				$q.="contenido='".$contenido."', ";
				$q.="img='".$row."' ";

				$t=$db->abc($q);
				header("location:admin.php");
				exit;
			}
		}
	}

	if(isset($_GET["id"])){
		$id = $_GET["id"];
		if(isset($_GET["m"])){
			$m=$_GET["m"];
			if($m==1){
				$q = "DELETE FROM articulos WHERE id=".$id;
				if($db->abc($q)){
                    header("location:admin.php");
                    exit;
				} else {
					print "ERROR al borrar";
				}
			}
		} 
	}

if(isset($_POST["uArticulo"])&&$_POST["uArticulo"]=="1"){
    if($_POST["titulo"]!=""&&$_POST["descripcion"]!=""&&$_POST["contenido"]!=""){
      $id=$_POST["id"];
      $titulo=$_POST["titulo"];
      $descripcion=$_POST["descripcion"];
      $contenido=$_POST["contenido"];
      $row=time();
      $b=false;
      if(is_uploaded_file($_FILES['foto']['tmp_name'])){
        $foto="p_".$row.".jpg";
        copy($_FILES['foto']['tmp_name'], "../images/$foto");
      }else{
        $b=true;
      }
      if($b==true){
        $q="UPDATE articulos SET ";
        $q.="titulo='".$titulo."', ";
        $q.="descripcion='".$descripcion."', ";
        $q.="contenido='".$contenido."' ";
        $q.="WHERE id=".$id;

        $t=$db->abc($q);
        header("location:admin.php");
        exit;
      }

      if($b==false){
        $q="UPDATE articulos SET ";
        $q.="titulo='".$titulo."', ";
        $q.="descripcion='".$descripcion."', ";
        $q.="contenido='".$contenido."', ";
        $q.="img='".$row."' ";
        $q.="WHERE id=".$id;

        $t=$db->abc($q);
        header("location:admin.php");
        exit;
      }
    }
}
$botoncobro=$db->design("botoncobro");
$titulo=$db->design("titulo");
$subtitulo=$db->design("subtitulo");
$footerTitulo=$db->design("footerT");
$footerContent=$db->design("footerC");

//ajustes
if(isset($_POST["ajustes"])&&$_POST["ajustes"]=="1"){
	if($_POST["titulo"]!=""&&$_POST["subtitulo"]!=""&&$_POST["botoncobro"]!=""&&$_POST["footerT"]!=""&&$_POST["footerC"]!=""){
		$titulo=$_POST["titulo"];
		$subtitulo=$_POST["subtitulo"];
		$botoncobro=$_POST["botoncobro"];
		$footerT=$_POST["footerT"];
		$footerC=$_POST["footerC"];
	
		$q ="UPDATE ajustes ";
    $q.="SET valor = CASE nombre ";
    $q.="WHEN 'titulo' THEN '".$titulo."' ";
    $q.="WHEN 'subtitulo' THEN '".$subtitulo."' ";
    $q.="WHEN 'botoncobro' THEN '".$botoncobro."' ";
    $q.="WHEN 'footerT' THEN '".$footerT."' ";
		$q.="WHEN 'footerC' THEN '".$footerC."' ";
    $q.="END ";
		$q.="WHERE nombre IN ('titulo','subtitulo','botoncobro','footerT','footerC')";
		$db->abc($q);
		header('location:admin.php');
		exit;
	}
}
//colors
$c_Header=$db->design("c_Header");
$c_Subheader=$db->design("c_Subheader");
$c_Footer=$db->design("c_Footer");
$c_Text=$db->design("c_Text");
$c_TextS=$db->design("c_TextS");
$c_btn1=$db->design("c_btn1");
$c_btn2=$db->design("c_btn2");
$c_btncobro=$db->design("c_btncobro");
$c_Panel=$db->design("c_Panel");
$c_Text=$db->design("c_Text");
$c_btnd1=$db->design("c_btnd1");
$c_btnd2=$db->design("c_btnd2");

//explotar header y color principal
list($cG,$ch_1,$cht_1)=explode(" ",$c_Header);
list($ch1,$ch2)=explode("-",$ch_1);
list($cht,$x)=explode("-",$cht_1);
//explotar subheader
list($x,$cSh_1,$cSht_1)=explode(" ",$c_Subheader);
list($cSh1,$cSh2)=explode("-",$cSh_1);
list($cSht,$x)=explode("-",$cSht_1);
//explotar footer
list($x,$cf_1,$cft_1)=explode(" ",$c_Footer);
list($cf1,$cf2)=explode("-",$cf_1);
list($cft,$x)=explode("-",$cft_1);
//explotar btn1
list($x,$cb_1,$cbt_1)=explode(" ",$c_btn1);
list($cb1_1,$cb2_1)=explode("-",$cb_1);
list($cbt_1,$x)=explode("-",$cbt_1);
//explotar btn2
list($x,$cb_2,$cbt_2)=explode(" ",$c_btn2);
list($cb1_2,$cb2_2)=explode("-",$cb_2);
list($cbt_2,$x)=explode("-",$cbt_2);
//explotar subheader
list($x,$cp_1,$cpt_1)=explode(" ",$c_Panel);
list($cp1,$cp2)=explode("-",$cp_1);
list($cpt,$x)=explode("-",$cpt_1);

function cadenas($g,$n,$r,$p){
	if($n=="solido"){
		$t=$g." ".$p."-text";
	}else if($n=="white"){
		if($p=="white"){
			$t=$n." black-text";	
		}else{
			$t=$n." ".$p."-text";
		}
	}else if($n=="black"){
		if($p=="black"){
			$t=$n." white-text";	
		}else{
			$t=$n." ".$p."-text";
		}
	}else{
		$t=$g." ".$n."-".$r." ".$p."-text";
	}
	return $t;
}
//
function cadenas2($g,$n,$r){
		switch ($n) {
    case "solido":
        $n=$g;
        break;
    case "white":
        $n=$n;
        break;
    case "black":
        $n=$n;
        break;
    default:
      $n=$g." ".$n."-".$r;
	}
	return $n;
}
//
if(isset($_POST["color"])&&$_POST["color"]=="1"){
		//tomar los valores del formulario
		$g=$_POST["c_General"];
		$cbtn=$_POST["c_Colorbtn"];
		
		//c_header
		$ch1=$_POST["c_Header_1"];//darken-4
		$ch2=$_POST["c_Header_2"];//numero -4
		$cht=$_POST["c_Header_Text"];//white-text
		$ch1=cadenas($g,$ch1,$ch2,$cht);
		//c_Subheader
		$cSh1=$_POST["c_Subheader_1"];
		$cSh2=$_POST["c_Subheader_2"];
		$cSht=$_POST["c_Subheader_Text"];
		$cSh1=cadenas($g,$cSh1,$cSh2,$cSht);
		//c_footer
		$cf1=$_POST["c_Footer_1"];
		$cf2=$_POST["c_Footer_2"];
		$cft=$_POST["c_Footer_Text"];
		$cf1=cadenas($g,$cf1,$cf2,$cft);
		//c_panel
		$cp1=$_POST["c_Panel_1"];
		$cp2=$_POST["c_Panel_2"];
		$cpt=$_POST["c_Panel_Text"];
		$cp1=cadenas($g,$cp1,$cp2,$cpt);
		//c_btn1
		$cb1_1=$_POST["c_btn1_1"];
		$cb1_2=$_POST["c_btn1_2"];
		$cb1_t=$_POST["c_btn1_Text"];
		$cb1_1=cadenas($g,$cb1_1,$cb1_2,$cb1_t);
		//c_btn2
		$cb2_1=$_POST["c_btn2_1"];
		$cb2_2=$_POST["c_btn2_2"];
		$cb2_t=$_POST["c_btn2_Text"];
		$cb2_1=cadenas($g,$cb2_1,$cb2_2,$cb2_t);
		//texto
		$cT=$_POST["c_Text"];
		//boton de cobro
		$cbtn1=$_POST["c_Colorbtn_1"];
		$cbtn2=$_POST["c_Colorbtn_2"];
		$cbtnt=$_POST["c_Colorbtn_Text"];
		$cbtn1=cadenas($cbtn,$cbtn1,$cbtn2,$cbtnt);
		//btnd1
		$c_gbtnd1=$_POST["c_gbtnd1"];//color 
		$c_btnd1_1=$_POST["c_btnd1_1"];//solido white black
		$c_btnd2_1=$_POST["c_btnd2_1"];//numero "-"
		$c_btnd1_1=cadenas2($c_gbtnd1,$c_btnd1_1,$c_btnd2_1);
		
		//btnd2
		$c_gbtnd2=$_POST["c_gbtnd2"];
		$c_btnd1_2=$_POST["c_btnd1_2"];
		$c_btnd2_2=$_POST["c_btnd2_2"];
		$c_btnd1_2=cadenas2($c_gbtnd2,$c_btnd1_2,$c_btnd2_2);
		//construir las cadenas
		
		$c_Header=$ch1;
		$c_Subheader=$cSh1;
		$c_Footer=$cf1;
		$c_btncobro=$cbtn1;
		$c_Text=$cT."-text";
		$c_btn1=$cb1_1;
		$c_btn2=$cb2_1;
		$c_Panel=$cp1;
		$c_btnd1=$c_btnd1_1;
		$c_btnd2=$c_btnd1_2;
		//actualizar la db
		$q ="UPDATE ajustes ";
    $q.="SET valor = CASE nombre ";
    $q.="WHEN 'c_Header' THEN '".$c_Header."' ";
    $q.="WHEN 'c_Subheader' THEN '".$c_Subheader."' ";
    $q.="WHEN 'c_Footer' THEN '".$c_Footer."' ";
    $q.="WHEN 'c_Text' THEN '".$c_Text."' ";
		$q.="WHEN 'c_btn1' THEN '".$c_btn1."' ";
		$q.="WHEN 'c_btn2' THEN '".$c_btn2."' ";
		$q.="WHEN 'c_btnd1' THEN '".$c_btnd1."' ";
		$q.="WHEN 'c_btnd2' THEN '".$c_btnd2."' ";
		$q.="WHEN 'c_btncobro' THEN '".$c_btncobro."' ";
		$q.="WHEN 'c_Panel' THEN '".$c_Panel."' ";
    $q.="END ";
		$q.="WHERE nombre IN ('c_Header','c_Subheader','c_Footer','c_Text','c_btn1','c_btn2','c_btnd1','c_btnd2','c_btncobro','c_Panel')";
		//$q="UPDATE ajustes SET valor ='".$c_Header."' WHERE nombre='c_Header'";
		$db->abc($q);
		//
		header('location:admin.php');
		exit;
}
//template
$atenuacion=["solido","lighten","darken","accent","white","black"];
$g_Color=["1","2","3","4","5"];
$t_Color=["white","black","grey"];
$cg=["red","pink","purple","deep-purple","indigo","blue","light-blue","cyan","teal","green","light-green","lime","yellow","amber","orange","deep-orange","brow","grey","blue-grey"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>admin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 maximun-scale=1.0, user-scalable=no"/>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/materialize.min.css" media="screen,projection">
	<style type="text/css">
    html,body{
      height: 99%;
    }
    .valign-wrapper{
      min-height: 92%;
    }
		#titulo{
			opacity:0.5;
		}
		.princ{
       overflow: auto;
		}
		#titulo{
			display:inline-block;
		}
    .truncate{
      display: table-cell;
      max-width: 100px;
    }
    .collapsible-header{
      line-height: 6em;
    }
    .market{
      margin:20px;
    }
    .logout{
      position:absolute;
      margin:12px;
      right:0;
    }
    .header{
      min-width: 100%;
      position:absolute;
    }
    @media (max-width: 500px) {
 .princ{
      margin-top: 100px;
       
  }
}
	</style>
</head>
<body>
<div class="header">
<a href="../php/logout2.php?set=3" class="waves-effect grey logout btn-floating"><i class="material-icons">close</i></a>
</div>
<div class="valign-wrapper">
<div class="container">
	 <ul class="collapsible popout valign princ hoverable" data-collapsible="accordion">
		 <!--TEXTO FAUCET-->
		 <li>
      <div class="collapsible-header grey lighten-4 align center"><i class="material-icons">settings</i><b>TEXTO FAUCET</b></div>
      <div class="collapsible-body container">
				<form method="post">
					<div class="row">
						<div class="col s12 m6 l6">
					<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">titles</i>
          <input id="icon_prefix" type="text" name="titulo"  value="<?=$titulo ?>" />
          <label for="icon_prefix">Titulo</label>
        	</div>
							<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">subtitles</i>
          <input id="icon_prefix" type="text" name="subtitulo"  value="<?=$subtitulo ?>" />
          <label for="icon_prefix">Titulo Segundario</label>
        	</div>
				<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">loyalty</i>
          <input id="icon_prefix" type="text" name="botoncobro"  value="<?=$botoncobro ?>" />
          <label for="icon_prefix">Boton de Cobro</label>
        	</div>
				
						</div>
						<!--columna2-->
						<div class="col s12 m6 l6">
							<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">spellcheck</i>
          <input id="icon_prefix" type="text" name="footerT"  value="<?=$footerTitulo ?>" />
          <label for="icon_prefix">Footer Titulo</label>
        	</div>
							<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">subject</i>
								<textarea id="textarea1" class="materialize-textarea" name="footerC"><?=$footerContent ?></textarea>
          <label for="textarea1">Footer Contenido</label>
        	</div>
				
						</div>
					</div>
					<input type="submit" value="enviar" class="btn right" />
					<input type="hidden" name="ajustes" value="1" />
					<br>
					<br>
				</form>
			</div> 
		 </li>	 
		 <!--STYLE FAUCET-->
		 <li>
      <div class="collapsible-header grey lighten-3 align center"><i class="material-icons">invert_colors</i><b>STYLE FAUCET</b></div>
      <div class="collapsible-body container">
				<form method="post">
					<div class="row">
						<div class="col s12 m12 l12">
							<!--COLOR GENERAL-->
							<div class="col s12">
							<div  class="col s6" style="margin-top:30px;">
									<label>Color General</label>
							</div>	
					  	<div class=" col s6">
							<label>Selecciona el Color</label>
    <select class="browser-default" size="4" name="c_General">
			<?php
				for($i=0;$i<count($cg);$i++){
					$l ="<option value='".$cg[$i]."'";
					if($cg[$i]==$cG) $l.="selected";									
					$l.=">".$cg[$i]."</option>";
					print $l;
			}
			?>  
		</select>
							</div>
						</div>
							<!--C HEADER-->
			<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
									<label>Header</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_Header_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$ch1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
							<label>Grado Color</label>
							<select name="c_Header_2">
								<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$ch2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_Header_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cht) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
						</select>
							</div>
			</div>
							<!--C SUB HEADER-->
							<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
									<label>Sub-Header</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_Subheader_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$cSh1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
								<label>Grado Color</label>
							<select name="c_Subheader_2">
     						<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$cSh2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_Subheader_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cSht) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
							</select>
							</div>
			</div>
							<!--Footer-->
			<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Footer</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_Footer_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$cf1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
								<label>Grado Color</label>
							<select name="c_Footer_2">
     						<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$cf2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_Footer_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cft) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
							</select>
							</div>
			   </div>
							<!--C PANEL-->
					<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Panel</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_Panel_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$cp1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
								<label>Grado Color</label>
							<select name="c_Panel_2">
     						<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$cp2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_Panel_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cpt) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
							</select>
							</div>
			   </div>
						<!--btn1-->
							<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Button 1</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_btn1_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$cb1_1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
								<label>Grado Color</label>
							<select name="c_btn1_2">
     						<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$cb2_1) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_btn1_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cbt_1) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
							</select>
							</div>
			   </div>
				<!--btn2-->
							<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Button 2</label>
				</div>
				<div class="col s3 l3" style="margin-top:30px;">
					<label>Atenuacion</label>
							<select name="c_btn2_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$cb1_2) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s2 l2" style="margin-top:30px;">
								<label>Grado Color</label>
							<select name="c_btn2_2">
     						<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$cb2_2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_btn2_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cbt_2) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
							</select>
							</div>
			   </div>
			<!--texto general-->
							<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
									<label>Texto</label>
				</div>
							<div class="col s2 l2" style="margin-top:30px;">
							<label>Color Texto</label>
							<select name="c_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cht) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
						</select>
							</div>
							</div>
							
				<!--boton reclamar-->
			<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Boton Cobro</label>
				</div>
				<div class=" col s2 l2" style="margin-top:30px;">
					<label>Selecciona el Color</label>
    			<select class="browser-default" size="4" name="c_Colorbtn">
					<?php
						for($i=0;$i<count($cg);$i++){
						$l ="<option value='".$cg[$i]."'";
						if($cg[$i]==$cG) $l.="selected";									
						$l.=">".$cg[$i]."</option>";
						print $l;
						}
						?>  
					</select>
				</div>
				<div class="col s2 l2" style="margin-top:30px;">
					<label>Atenuacion</label>
					<select name="c_Colorbtn_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$ch1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s1 l1" style="margin-top:30px;">
							<label>Grado</label>
							<select name="c_Colorbtn_2">
								<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$ch2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							<div class="col s2 l2" style="margin-top:30px;">
						<label>Color Texto</label>
							<select name="c_Colorbtn_Text">
								<?php 	
								for($i=0;$i<count($t_Color);$i++){
									$l="<option value='".$t_Color[$i]."'";
									if($t_Color[$i]==$cht) $l.="selected";
									$l.=">".$t_Color[$i]."</option>";
									print $l;
								}
								?>
						</select>
							</div>
			</div>
								<!--botones juego-->
									<!--btnd1-->
			<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Boton 1</label>
				</div>
				<div class=" col s2 l2" style="margin-top:30px;">
					<label>Selecciona el Color</label>
    			<select class="browser-default" size="4" name="c_gbtnd1">
					<?php
						for($i=0;$i<count($cg);$i++){
						$l ="<option value='".$cg[$i]."'";
						if($cg[$i]==$cG) $l.="selected";									
						$l.=">".$cg[$i]."</option>";
						print $l;
						}
						?>  
					</select>
				</div>
				<div class="col s2 l2" style="margin-top:30px;">
					<label>Atenuacion</label>
					<select name="c_btnd1_1">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$ch1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
				  </select>
				</div>
							<div class="col s1 l1" style="margin-top:30px;">
							<label>Grado</label>
							<select name="c_btnd2_1">
								<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$ch2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							
			</div>
									<!--btnd2-->
			<div class="col s12">
				<div  class="col s5" style="margin-top:50px;">
					<label>Boton 2</label>
				</div>
				<div class=" col s2 l2" style="margin-top:30px;">
					<label>Selecciona el Color</label>
    			<select class="browser-default" size="4" name="c_gbtnd2">
					<?php
						for($i=0;$i<count($cg);$i++){
						$l ="<option value='".$cg[$i]."'";
						if($cg[$i]==$cG) $l.="selected";									
						$l.=">".$cg[$i]."</option>";
						print $l;
						}
						?>  
					</select>
				</div>
				<div class="col s2 l2" style="margin-top:30px;">
					<label>Atenuacion</label>
					<select name="c_btnd1_2">
								<?php	
										for($i=0;$i<count($atenuacion);$i++){
											$l ="<option value='".$atenuacion[$i]."'";
											if($atenuacion[$i]==$ch1) $l.="selected";	
											$l.=">".$atenuacion[$i]."</option>";
											print $l;
										}
								?>
							</select>
							</div>
							<div class="col s1 l1" style="margin-top:30px;">
							<label>Grado</label>
							<select name="c_btnd2_2">
								<?php
								for($i=0;$i<count($g_Color);$i++){
									$l="<option value='".$g_Color[$i]."'";
									if($g_Color[$i]==$ch2) $l.="selected";	
									$l.=">".$g_Color[$i]."</option>";
									print $l;
								}
								?>	
  					 </select>
  			     </div>
							
			</div>
						</div>
					</div>
					<input type="submit" value="enviar" class="btn right" />
					<input type="hidden" name="color" value="1" />
					<br>
					<br>
				</form>
			</div>
    </li>
		 <!--CREAR ARTICULO-->
    <li>
      <div class="collapsible-header align center grey lighten-2
"><i class="material-icons">library_books</i><b>CREAR ARTICULO</b></div>
      <div class="collapsible-body">
      	<div class="container">
      	<div class="row">
      	<form class="col s12" method="post" enctype="multipart/form-data">
      	<input type="hidden" name="cArticulo" value="1"/>	
      		<div class="row">
      	<div class="input-field col s12">
            <input id="titulo" type="text" name="titulo" class="validate">
          <label for="titulo">Titulo</label>
        </div>

      		<!---->
      	<div class="input-field col s12">
      		<input type="text" name="descripcion" class="validate"/>
      			<label for="Descripcion">Descripcion</label>
      		</div>
      		</div>
      		
      		<!---->
     	<div class="row"> 
    	<div class="input-field col s12">
        	 <textarea id="textarea1" class="materialize-textarea" name="contenido"></textarea>
             <label for="textarea1">Contenido</label>
        </div>
        </div>
      		<!---->
      		
      			<div class="file-field input-field">
      				<div class="btn grey lighten-1">
      		  <span>File</span>
       		 <input type="file" name="foto" id="foto">
      		</div>
    		  <div class="file-path-wrapper">
     		   <input class="file-path validate" type="text" id="foto">
     		 </div>
    		</div>
      		<!---->
      			<input type="submit" name="enviar" value="enviar" class="right btn grey lighten-1"/>
      		<br>
      	</form>
      	 </div>
      	</div>
      </div>
    </li>
		 <!--ADMINISTRAR ARTICULOS-->
    <li>
      <div class="collapsible-header align center grey darken-1 white-text"><i class="material-icons">description</i><b>ADMIN ARTICULOS</b></div>
      <div class="collapsible-body">
      <div class="container">
      <div class="row">
      <table class="col s12 striped responsive-table centered">
      	<thead>
          <tr>
              <th data-field="id">ID</th>
              <th data-field="name">TITULO</th>
              <th data-field="price">DESCRIPCION</th>
              <th data-field="price">CONTENIDO</th>
              <th data-field="price">BORRAR</th>
              <th data-field="price">MODIFICAR</th>
              <th data-field="price">IMAGEN</th>
          </tr>
        </thead>
        <tbody>
        <?php
        	
		
			
  			
		
        	$loop=0;
        	$loop2=100;
        	while($obj = mysqli_fetch_object($r)){
        	print "<div id='modal$loop' class='modal'>";
    		  print "<div class='modal-content'>";
      		print "<h4>Borrar articulo</h4>";
      		print "<p>Si esta seguro del articulo que desea borrar siga con esta accion si no de a cancelar</p>";
    		  print "</div>";
    		  print "<div class='modal-footer'>";
    		  print "<a href='admin.php?id=".$obj->id."&m=1' class='btn align left grey lighten-1'>borrar</a>";
      		print "<a href='#' class='modal-action modal-close waves-effect white btn-flat'>Cancelar</a>";
    		  print "</div>";
  			  print "</div>";
  			  print "<div id='modal".$loop2."' class='modal'>";
          print "<form method='post' enctype='multipart/form-data'>";
    		  print "<div class='modal-content'>";
      		print "<h4>Modificar</h4>";
      		print "<input type='hidden' name='uArticulo' value='1'/>
                  <input type='hidden' name='id' value='".$obj->id."'/>  
                 <div class='row'>
                 <div class='input-field col s12'>
                 <input id='titulo' type='text' name='titulo' class='validate' value='".$obj->titulo."'/>
                 <label for='titulo'>Titulo</label>
                 </div>
                 <div class='input-field col s12'>
                 <input type='text' name='descripcion' class='validate' value='".$obj->descripcion."'/>
                 <label for='Descripcion'>Descripcion</label>
                 </div>
                 </div>
                 <div class='row'> 
                 <div class='input-field col s12'>
                 <textarea id='textarea1' class='materialize-textarea' name='contenido'>".$obj->contenido."</textarea>
                 <label for='textarea1'>Contenido</label>
                 </div>
                 </div>
                 <div class='file-field input-field'>
                 <div class='btn grey lighten-1'>
                 <span>File</span>
                 <input type='file' name='foto' id='foto'>
                 </div>
                 <div class='file-path-wrapper'>
                 <input class='file-path validate' type='text' id='foto'>
                 </div>
                 </div>";
    		print "</div>";
    		print "<div class='modal-footer'>";
    		print "<button class='btn align left grey lighten-1' type='submit' >crear</button>";
      	print "<a href='#' class='modal-action modal-close waves-effect white btn-flat'>Cancelar</a>";
    		print "</div>";
        print "</form>";
  			print "</div>";
			  print "<tr>";
			  print "<td>".$obj->id."</td>";
    		print "<td>".$obj->titulo."</td>";
    		print "<td class='truncate'>".$obj->descripcion."</td>";
    		print "<td class='truncate'>".$obj->contenido."</td>";
			  print "<td><a class='modal-trigger' href='#modal$loop'><i class='material-icons red-text'>
not_interested</i></a></td>";
			  print "<td><a class='modal-trigger' href='#modal".$loop2."'><i class='material-icons'>mode_edit</i></a></td>";
			  print "<td><img src='../images/p_".$obj->img.".jpg' width='100'></td>";
			  print "</tr>";
			  $loop++;
			  $loop2++;
		}

	?>
	</tbody>
	</table>
	</div>
	</div>
      </div>
    </li>
		 <!--ADMINISTRAR FAUCET-->
    <li>
      <div class="collapsible-header align center grey darken-3 white-text"><i class="material-icons">dashboard</i><b>ADMINISTRAR FAUCET</b></div>
      <div class="collapsible-body container">
				<form method="post">
					<div class="row">
						<div class="col s12 l6">
							<div class="col s12">
							<div  class="col s6" style="margin-top:30px;">
								<label>Ganancia Inicial </label>
							</div>	
					  	<div class="input-field col s6">
							<i class="material-icons prefix" style="margin-top:13px">verified_user</i>
							<input type="number" name="balance" value="<?php print $balance ?>"/>
							</div>
						</div>
							<!---->
						<div class="col s12">
							<div  class="col s6" style="margin-top:30px;">
								<label>Ganancia Referido </label>
							</div>	
					  	<div class="input-field col s6">
							<i class="material-icons prefix" style="margin-top:13px">supervisor_account</i>
							<input type="number" name="rb" value="<?php print $referbalance ?>"/>
							</div>
						</div>
							<!---->
						<div class="col s12">
							<div  class="col s6" style="margin-top:30px;">
								<label>Tiempo de Cobro <small>seg</small></label>
							</div>	
					  	<div class="input-field col s6">
							<i class="material-icons prefix" style="margin-top:13px">av_timer</i>
							<input type="number" name="time" value="<?php print $timeClaim ?>"/>
							</div>
						</div>
							
						<div class="col s12">
							<div  class="col s6" style="margin-top:30px;">
								<label>Apoyar Desarrollo</label>
							</div>	
					  	<div class="input-field col s6">
								<div class="switch">
    							<label>
      						No
								  <input name="valido" type="hidden" value="0"/>
     	 						<input type="checkbox" name="valido" <?php if($v=="") print "checked";else if($v==1) print "checked";else print ""; ?>  value="1"/>
      						<span class="lever"></span>
      						Si
    							</label>
  							</div>
							</div>
						</div>
				
						</div>
						<!--columna2-->
						<div class="col s12 l6">
							<div class="row">
								<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">vpn_key</i>
          <input id="icon_prefix" type="text" name="api"  value="<?php print $api ?>" />
          <label for="icon_prefix">API <i>Faucetbox</i></label>
        	</div>
								<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">lock_outline</i>
          <input id="icon_prefix" type="text" name="rs" class="validate" value="<?php print $r2 ?>">
          <label for="icon_prefix">Recaptcha Key Secret</label>
        	</div>
								<div class="input-field col s10">
          <i class="material-icons prefix" style="margin-top:13px">lock_open</i>
          <input id="icon_prefix" type="text" name="rp" class="validate" value="<?php print $r1 ?>">
          <label for="icon_prefix">Recaptcha Key Public</label>
        	</div>
							</div>
						</div>
					</div>
					<input type="submit" value="enviar" class="btn right grey" />
					<input type="hidden" name="df" value="1" />
					<br>
					<br>
				</form>
			</div>
    </li>
  </ul>
</div>
</div>
<footer class="page-footer  blue-grey darken-4">
           <div class="footer-copyright">
            <div class="container">
            <small class="white-text">Produced by Front-Design Inc. &copy</small>
            <a class="white-text right" href="https://github.com/guxal/FAUCET-DICE-MATERIALIZE/" target="_blank" >Open Source</a>
            </div>
          </div>
</footer>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
 	//$("#modal10").openModal();
 	$(".modal-trigger").leanModal();
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
	 $('select').material_select();
  });
 </script>
</body>
</html>