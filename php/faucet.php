<header class="card-panel  align center hoverable <?=$c_Panel?>">
<div class="card-panel <?=$c_btnd1?> z-depth-2 <?=$c_Text?>"> WIN <?php echo $startb;?> - 5000 satoshis</div>
<div class="card-panel <?=$c_btnd2?> z-depth-3 <?=$c_Text?>"> Every <?php printf("%d",  $tBC); ?> <small>min</small> </div>
<div class="card-panel <?=$c_btnd1?> z-depth-4 <?=$c_Text?>"><b><?php echo $faucetbal2." BTC "; ?></b><?php echo $claimMsg; ?></div>
<?php
if(isset($_GET["r"])){
	$r=$_GET["r"];
}else{
 $r="";
}
if(isset($_SESSION["diceMsg"])){
	print "<br>".$_SESSION["diceMsg"]."<br>";
}
?>
</header>
<?php
if(isset($_SESSION["error"])){
	print "<p class='card-panel white-text red lighten-2 align center'><b>".$_SESSION["error"]."</b></p>";
}
if(isset($_SESSION["cashout"])){
	$cash=$_SESSION["cashout"];
	print "<div class='card-panel blue lighten-3 white-text align center'>".$cash."</div>";
}
if(isset($_SESSION["cow"])){
	$host= $_SERVER["HTTP_HOST"];
	print "<p class='align center'>your refer</p><div class='card-panel ".$c_Panel." align center' style='overflow: scroll;'>".$host."/?r=".$_SESSION["cow"]."</div>";
}
?>
<div class="card-panel z-depth-3">
<?php if(!isset($_SESSION["r-pass"])&&!isset($_SESSION["Ruser"])&&!$sesion->estadoLogin()&&!$sesion->estadoV()):?><!--no exite estado login no existe estado verificacion-->
<div id="login">
	<h5 class="align center">
		LOGIN
	</h5>
	<form id="form1" method="POST" action="php/valida.php" name="form1">
    	<div class="row">
    	<div class="input-field col s12">
		<input id="icon_prefix" type="email" class="validate" name="usuario" required />
		<label for="icon_prefix">Email</label>
		</div>
		<div class="input-field col s12">
		<input id="clave" type="password" class="validate" name="clave" required />
		<label for="clave">Password</label>
		</div>
		</div>
		<input type="hidden"  value="1" name="login"/>
			<button type="submit" class="waves-effect btn <?=$c_btn1?>">Login</button><a  href="#" id="registrobtn" class="right btn <?=$c_btn2?>">Sign up</a>
	</form>
	<br>
	<a id="r-passbtn">Forgot Password?</a>
</div>
<div id="registro">
	<h5 class="align center">
		REGISTER
	</h5>
	<form method="POST" action="php/valida.php" name="form2">
	<div class="row">
    	<div class="input-field col s12">
		<input id="icon_prefix" type="email" class="validate" name="usuario" required />
		<label for="icon_prefix">Email</label>
		</div>
		<div class="input-field col s12">
		<input  id="icon_prefix" type="email"  class="validate" name="usuario2" required />
		<label for="icon_prefix">Confirm Email</label>
		</div>
		<div class="input-field col s12">
		<input id="icon_prefix" type="password" class="validate" name="clave" required />
		<label for="icon_prefix">Password <small>(Minimum 8 characters)</small></label>
		</div>
		<div class="input-field col s12">
		<input id="icon_prefix" type="password" class="validate" name="clave2" required/>
		<label for="icon_prefix">Confirm Password</label>
		</div>
		<div class="input-field col s12">
		<input id="icon_prefix" type="text" class="validate" name="refer" value="<?php if(isset($r)){print $r;} ?>" <?php if($r!=""){print "readonly";}?> />
		<label for="icon_prefix">Your Referred</label>
		</div>
	</div>
		<input type="hidden"  value="1" name="registro"/>
		<button type="submit" class="waves-effect btn <?=$c_btn1?>">REGISTER</button> <a href="#" id="loginbtn" class="right btn <?=$c_btn2?>">Login</a>
	</form>
</div>
<div id="r-pass">
	<h5 class="align center">
		FORGOT PASSWORD
	</h5>
	<form method="post" action="php/valida.php" name="form3">
		<input type="hidden" name="r-pass" value="1" />
		<div class="row">
		<div class="input-field col s12">
		<input id="icon_prefix" class="validate" type="email" name="correo" required/>
		<label for="icon_prefix">Email</label>
		</div>
		</div>
		<button type="submit" name="enviar" class="btn <?=$c_btn1?>" value="enviar">send</button> <a href="#" onclick="onLogin()" id="loginbtn" class="right btn <?=$c_btn2?>">Login</a>
	</form>
</div>
<?php elseif(!isset($_SESSION['Ruser'])&&!isset($_SESSION["r-pass"])&&!$sesion->estadoLogin()&&$sesion->estadoV()):?><!--no existe estado login si existe estado verificacion-->
	<div id="check" class="text center" name="form4">
	<h5>CONFIRM YOUR EMAIL</h5>
	<form method="post" action="php/valida.php">
	<input type="text" name="hash" required />
	<button type="submit" name="envia" class="btn <?=$c_btn1?> left" value="Enviar">send</button> 
	<input type="hidden" name="check" value="1"/>
</form>

<p class="clearfix">Enter the code sent to your email to verify your account</p>
</div>
<?php elseif(isset($_SESSION['Ruser'])&&!isset($_SESSION["r-pass"])&&!$sesion->estadoLogin()&&!$sesion->estadoV()):?><!--si existe  recuperar contraseña no exite estado login no existe estado verificacion-->
<div id="check-r-pass" class="text center">
	<h5>PASSWORD RECOVERY</h5>
	<form method="post" action="php/valida.php" name="form5">
	<input type="hidden" name="check-pass" value="1"/>
	<input type="text" name="hash" required />
	<button type="submit" name="envia" class="btn <?=$c_btn1?> left" value="Enviar">send</button> 
	 <a href="php/logout2.php?set=1" class="btn right <?=$c_btn2?>" >cancel</a>
</form>
<?php //if(isset($_SESSION['hash'])){ print "<br><b>".$_SESSION['hash']."</b><br>"; } ?>
<p class="clearfix">Enter the code sent to your email to recover your account</p>
</div>
<?php elseif(isset($_SESSION['Ruser'])&&isset($_SESSION['r-pass'])&&!$sesion->estadoLogin()&&!$sesion->estadoV()):?>
	<div id="c-pass">
		<h5 class="align center">	
		PASSWORD RECOVERY
		</h5>
		<form method="post" action="php/valida.php" name="form6">
		
		<div class="row">
		<div class="input-field col s12">
			<input id="icon_prefix" class="validate" type="password" name="clave1" required/>
			<label for="icon_prefix">Password <small>(Minimum 8 characters)</small></label>
		</div>
		<div class="input-field col s12">	
			<input id="icon_prefix" class="validate" type="password" name="clave2" required/>
			<label for="icon_prefix">Confirm Password</label>
		</div>
		</div>	
			<button type="submit" class="btn <?=$c_btn1?>">SEND</button><a href="php/logout2.php?set=2" class="btn right <?=$c_btn2?>" >cancel</a>
			<input type="hidden" name="c-pass" value="1"/>
		</form>
	
	</div>
	
<?php elseif(!isset($_SESSION['cow'])&&$sesion->estadoLogin()&&!$sesion->estadoV()):?><!--no existe session cow existe estado login no existe verificacion-->
	<div id="C-wallet">
		<h5 class="align center">
	SOLVES THE CAPTCHA
	</h5>
	<form method="post" action="" name="form_valida">
	<div class="row">
	<div class="input-field col s12">
	<input id="icon_prefix" class="validate" type="text" name="addy"/>
	<label for="icon_prefix">Tu Wallet</label>
	</div>
	</div>
	<!--ADS ADS ADS -->
	<div class="g-recaptcha" data-sitekey="<?php echo $rkey ?>"></div>
	<button type="submit" name="envia" id="envia" value="1" class="waves-effect btn <?=$c_btn1?>">send</button>
	<input type="hidden" name="vc" value="1" />
	</form>
	</div>	
<?php elseif(isset($_SESSION['cow'])&&$sesion->estadoLogin()&&!$sesion->estadoV()):?>
<div id="faucet_dice" class="card z-depth-2">
	<h5 class="card-panel z-depth-4 align center <?=$c_Panel?>">
		<?php
		if(isset($calcBal)){
		print $calcBal."<br><i class=''>Satoshis</i>.";
		} 
		?>
	</h5>
	<?php
	if(isset($diceMsg)){
	print "<p class='card white black-text align center z-depth-4'><b>".$diceMsg."</b></p>";
	}
	?>
	<!---->
	<div id="claimCont"class="align center red-text"><?php if(isset($message)) echo $message; ?></div>
	<!---->
    <form method="post" name="form_dados">
		<div class="card-panel z-depth-5">
    <div class="row">
    	<div class="col s6">
				<input type="number" min="2" max="97" id="multiplier" name="multiplier" value="<?php if(!isset($_POST['multiplier'])){ echo "49"; } else { echo $_POST['multiplier']; } ?>" placeholder="49" onchange="btcConvert(this); noteLimit(this, 4)" onkeyup="btcConvert(this); noteLimit(this, 4)" onkeydown="noteLimit(this, 4);"/>
				<label>WIN % CHANCE</label>
			</div>
			<div class="col s6">
				<input type="text" id="profit" readonly style="border:solid 1px black;text-align:center;font-size:2em;">
				<label>PROFIT ON WIN</label>
			</div>
		</div>
	<div class="row">
		<div class="col s6">
			<input type="number" min="1" name ="bet" id="bet" value="<?php if(!isset($_POST['bet'])){ echo "50"; } else { echo $_POST['bet']; } ?>" onchange="btcConvert(this); noteLimit(this, 4)" onkeyup="btcConvert(this); noteLimit(this, 4)" onkeydown="noteLimit(this, 4);"/>
			<label>BET AMOUNT</label>
		</div>
		<div class="col s6 align center">
			<span class="btn-floating waves-effect waves-light <?=$c_btn1?>"id="doubleBtn" onClick="double();" >2x</span>
			<span class="btn-floating waves-effect waves-light <?=$c_btn2?>" id="halfBtn" onClick="half();" >/2</span>
		</div>
	</div>
</div>				
	<div class="row align center">
		<div class="col s6">
			<div id="btmLblL"></div>	
			<button type="submit" name="rollLo" id="rollLo" value="Roll Lo" class="btn-floating btn-large hoverable waves-effect waves-light <?=$c_btnd1?>" ><i class="material-icons">navigation</i></button>
		</div>
		<div class="col s6 ">
			<div id="btmLblR"></div>
			<button type="submit" name="rollHi" id="rollHi" value="Roll Hi" class="btn-floating btn-large hoverable waves-effect waves-light <?=$c_btnd2?>"><i class="material-icons">navigation</i></button>	
		</div>
	</div>
	
	 
	</form>
		<!--ADS ADS ADS -->

</div>
	<!--COBRO-->
		<form method="post" class="align center"bjm name="form_cobro">
		<button type="submit" name="cashout" id="cashout" class="btn waves-effect <?=$c_btncobro;?> "><?=$botoncobro;?></button>
		</form>
<?php endif;?>
</div>
