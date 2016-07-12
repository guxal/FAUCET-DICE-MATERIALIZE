<?php
//conexiones
	require_once ("php/db.php");
	require_once ("clases/parametros.php");
	require_once ("libs/faucetbox.php");//libreria
//iniciamos variables
	$db=new dbMySQL();
	$parametros = new Parametros();
	$faucetbox = new Faucetbox($parametros->set_api_key(),$parametros->set_currenci());
	$claimMsg="BALANCE";
	$faucetbal=$faucetbox->getBalance();
	$faucetbal2=$faucetbal["balance_bitcoin"];
	$rkey=$parametros->set_rKey();
	$skey=$parametros->set_rSecret();
	$startb=$parametros->set_startBal();
	$tBC=$parametros->set_tBC()/60;
//si envian el captcha
	if(isset($_POST["vc"])&&$_POST["vc"]=="1"&&$_POST["envia"]){
		if($_POST['addy']==""){//verifica que la wallet no este vacia
			$_SESSION["error"]="Empty fields are not valid";
			header("location:index.php");
			exit;
		}
		if(isset($_POST['g-recaptcha-response'])){//verifica si existe el envio del captcha
			$cap=$_POST['g-recaptcha-response'];
			if($parametros->verificaCaptcha($cap)=="true"){
				$addy=$_POST['addy'];
				if($parametros->vWallet($addy)){
					header("location:index.php");
					exit;
				}else{
					$_SESSION["error"]="Unauthorized Error";
					header("location:index.php");
					exit;
				}
			}else{
		  	$_SESSION["error"]="CAPTCHA invalid";
		  	header("location:index.php");
		  	exit;
				}	
		}else{
			$_SESSION["error"]="invalid captcha";
			header("location:index.php");
			exit;
		}
}
///////////////////////////////////////////////////

//FAUCETBOXGAME////////////////////////////////////
if(isset($_SESSION['cow'])){

	$userAddy = $_SESSION['cow'];
	$q="SELECT * FROM faucetbox WHERE addy='$userAddy'";
	$data=$db->query($q,false);
	$balance=$data->bbb;
	$reefer=$data->reefer;
	$diceMsg="welcome to fauce + dice ";
	$calcBal=$balance;
	$p="SELECT refbalance FROM admonfaucet WHERE id=1";
	$row=$db->query($p,false);
	$refAmount=$row->refbalance;


	//
	

//////////////////////////////////////////////////

if(isset($_POST['rollHi'])){
	//auto cashout if bal over 9999
	if($balance > 6000){
	    $amount = $data->bbb;
		$result = $faucetbox->send($userAddy, $amount);
		  if($result["success"] === true){
		  $_SESSION['cashout'] = $result["html"];
		  //reset balance to zero
		  $q="UPDATE faucetbox SET bbb = 0 WHERE addy = '$userAddy'";
		  $db->abc($q);
		  header('Location: ../index.php');
		  exit;
		}
	}
	/////////////////////
	$betAmt = $_POST['bet'];
	$probability = $_POST['multiplier'];
	if(!is_numeric($betAmt) || !is_numeric($probability)){
	$message = "Invalid Input";
	} else {
	//filter var
	$betAmt = filter_var($betAmt, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$probability = filter_var($probability, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$multi = 100 / $probability;
	$multi2 = $multi - 0.02;  //house edge
	$grossProfit = $betAmt * $multi2;
	$netProfit = $grossProfit - $betAmt;
	$dbPrize = $netProfit;
	$dbBet = $betAmt;
	$target = 100 / $multi;
		if($dbBet > $balance){
		$message = "Insufficient Funds<br>";
		} else if ($target > 97 || $target < 2){
		$message = "Win Chance must be between 2 - 97<br>";
		} else if ($dbBet < 1 || $dbBet > 5000){
		$message = "Bets must be between 1 - 5,000 Satoshi<br>";
		} else {
		$latestGame = 	 "SELECT * FROM faucetboxgames 
					 WHERE addy = '$userAddy' AND open = 0 
					 ORDER BY count DESC LIMIT 1";
			$latestQ =  $db->abc($latestGame);
			$latestR = mysqli_fetch_assoc($latestQ);
			$luckyNum = $latestR['roll'];
			$gmID = $latestR['gid'];
			$luckySecret = $latestR['salt'];
			$target2 = 100 / $multi;
		    $calcHiRoll = 100 - $target2;
			$db->abc("UPDATE faucetboxgames SET ltgt = 2, bet = $dbBet, uuu = $calcHiRoll, open = 1 WHERE gid = '$gmID'");
			
			if($luckyNum > $calcHiRoll && $dbBet <= $balance){
			//user wins
			$diceMsg = "You Won +".sprintf('%.0F',$netProfit)." Satoshis!";
			//verify game was legit
			$vgQuery = $db->abc("SELECT * FROM faucetboxgames WHERE gid = '$gmID'");
			$vgResult = mysqli_fetch_assoc($vgQuery);
			$vgBet = $vgResult['bet'];
			$vgBatb = $vgResult['batb'];
				if($vgBet > $vgBatb || $vgBet != $dbBet || $dbBet < 1){
				    
					die("A fatal error has occurred");
				} else {
				$db->abc("UPDATE faucetboxgames SET profit = '$dbPrize' WHERE gid = '$gmID'");
				$db->abc("UPDATE faucetbox SET bbb = bbb + '$dbPrize' WHERE addy = '$userAddy'");
			
				//display updated balance
				$balQuery = $db->abc("SELECT bbb FROM faucetbox WHERE addy = '$userAddy'");
				$rowAssoc = mysqli_fetch_assoc($balQuery);
				$balance = $rowAssoc['bbb'];
	            $calcBal = $balance;
				}
			} else if($luckyNum < $calcHiRoll && $dbBet <= $balance){
			//user loses
			$lossBet = $dbBet * -1;
			$diceMsg = "You Lost -".sprintf('%.0F',$betAmt)." Satoshis";
			//verify game was legit
			$vgQuery = $db->abc("SELECT * FROM faucetboxgames WHERE gid = '$gmID'");
			$vgResult = mysqli_fetch_assoc($vgQuery);
			$vgBet = $vgResult['bet'];
			$vgBatb = $vgResult['batb'];
				if($vgBet > $vgBatb || $vgBet != $dbBet || $dbBet < 1){
				    die("A fatal error has occurred");
				} else {
			$db->abc("UPDATE faucetbox SET bbb = bbb - '$dbBet' WHERE addy = '$userAddy'");
			$db->abc("UPDATE faucetboxgames SET profit = '$lossBet' WHERE gid = '$gmID'");
				//display updated balance
				$balQuery = $db->abc("SELECT bbb FROM faucetbox WHERE addy = '$userAddy'");
				$rowAssoc = mysqli_fetch_assoc($balQuery);
				$balance = $rowAssoc['bbb'];
	            $calcBal = $balance;
				}
			} // ends if lost else
			else {
			$diceMsg = "An error occurred";
			}
		} // ends bet validate else
	} //ends is numeric else
} //ends post
	
	if(isset($_POST['rollLo'])){
	//auto cashout if bal over 9999
	if($balance > 6000){
	    $amount = $rowAssoc['bbb'];
	   	$currency = "BTC";
		$faucetbox = new Faucetbox($api_key, $currency);
		$result = $faucetbox->send($userAddy, $amount);
		  if($result["success"] === true){
		  $_SESSION['cashout'] = $result["html"];
		  //reset balance to zero
		  $db->abc("UPDATE faucetbox SET bbb = 0 WHERE addy = '$userAddy'");
		  		header('Location: ../faucetbox');
	}
	}
	$betAmt = $_POST['bet'];
	$probability = $_POST['multiplier'];
	if(!is_numeric($betAmt) || !is_numeric($probability)){
	$message = "Invalid Input";
	} else {
	//filter var
	$betAmt = filter_var($betAmt, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$probability = filter_var($probability, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$multi = 100 / $probability;
	$multi2 = $multi - 0.02;
	$grossProfit = $betAmt * $multi2;
	$netProfit = $grossProfit - $betAmt;
	$dbPrize = $netProfit;
	$dbBet = $betAmt;
	$target = 100 / $multi;
	
	if($dbBet > $balance){
		$message = "Insufficient Funds<br>";
		} else if ($target > 97 || $target < 2){
		$message = "Win Chance must be between 2 - 97<br>";
		} else if ($dbBet < 1 || $dbBet > 5000){
		$message = "Bets must be between 1 - 5,000 Satoshi<br>";
		} else {
		$latestGame = 	 "SELECT * FROM faucetboxgames 
					 WHERE addy = '$userAddy' AND open = 0 
					 ORDER BY count DESC LIMIT 1";
			$latestQ = $db->abc($latestGame);
			$latestR = mysqli_fetch_assoc($latestQ);
			$luckyNum = $latestR['roll'];
			$gmID = $latestR['gid'];
			$luckySecret = $latestR['salt'];
			$target2 =  100 / $multi;
			$userTarget =  100 / $multi;
			$db->abc("UPDATE faucetboxgames SET ltgt = 1, bet = $dbBet, uuu = $userTarget, open = 1 WHERE gid = '$gmID'");
			
			if($luckyNum < $target2 && $dbBet <= $balance){
			//user wins
			$diceMsg = "You Won +".sprintf('%.0F',$netProfit)." Satoshis!";
			
			
			//verify game was legit
			$vgQuery = $db->abc("SELECT * FROM faucetboxgames WHERE gid = '$gmID'");
			$vgResult = mysqli_fetch_assoc($vgQuery);
			$vgBet = $vgResult['bet'];
			$vgBatb = $vgResult['batb'];
				if($vgBet > $vgBatb || $vgBet != $dbBet || $dbBet < 1){
				    die("A fatal error has occurred");
				} else {
				$db->abc("UPDATE faucetboxgames SET profit = '$dbPrize' WHERE gid = '$gmID'");
				$db->abc("UPDATE faucetbox SET bbb = bbb + '$dbPrize' WHERE addy = '$userAddy'");
				
				//display updated balance
				$balQuery = $db->abc("SELECT bbb FROM faucetbox WHERE addy = '$userAddy'");
				$rowAssoc = mysqli_fetch_assoc($balQuery);
				$balance = $rowAssoc['bbb'];
	            $calcBal = $balance;
				}
			} else  if($luckyNum > $target2 && $dbBet <= $balance){
			//user loses
			$lossBet = $dbBet * -1;
			$diceMsg = "You Lost -".sprintf('%.0F',$betAmt)." Satoshis";
			$userTarget =  100 / $multi;
			
			//verify game was legit
			$vgQuery = $db->abc("SELECT * FROM faucetboxgames WHERE gid = '$gmID'");
			$vgResult = mysqli_fetch_assoc($vgQuery);
			$vgBet = $vgResult['bet'];
			$vgBatb = $vgResult['batb'];
				if($vgBet > $vgBatb || $vgBet != $dbBet || $dbBet < 1){
				    die("A fatal error has occurred");
				} else {
				$db->abc("UPDATE faucetbox SET bbb = bbb - '$dbBet' WHERE addy = '$userAddy'");
				$db->abc("UPDATE faucetboxgames SET profit = $lossBet WHERE gid = '$gmID'");
				//display updated balance
				$balQuery = $db->abc("SELECT bbb FROM faucetbox WHERE addy = '$userAddy'");
				$rowAssoc = mysqli_fetch_assoc($balQuery);
				$balance = $rowAssoc['bbb'];
	            $calcBal = $balance;
				}
			} // ends if lost else
			else {
			$diceMsg = "An error occurred";
			}
		} // ends bet validate else
	} //ends is numeric else
} //ends post

  //generate roll id
    $gameid = uniqid();
  //generate salt
  $genSalt = time();
  $genSalt2 = mt_rand(1111111, 3333333);
  $genSalt3 = $genSalt2 / 1000;
  $genSalt4 = $genSalt3 * $genSalt;
  $salt = sha1($genSalt4);
  $spacer = "+";
   //generate roll 
	$pick = mt_rand(0, 10000);
	
	$pick2 = $pick / 100;
	$proof = sha1($salt.$spacer.$pick2);
  //check balance
  $verifyQuery = $db->abc("SELECT * FROM faucetbox WHERE addy = '$userAddy'");
  $verifyResult = mysqli_fetch_assoc($verifyQuery);
  $verifyBalance = $verifyResult['bbb'];
	$db->abc("INSERT INTO faucetboxgames (gid, addy, salt, roll, batb) VALUES ('$gameid', '$userAddy', '$salt', '$pick2', '$verifyBalance')");
//////////////////////////////////////////////////



	if(isset($_POST['cashout'])){
		if($balance>7000){
			unset($_SESSION["cow"]);
			die("Stop warning");
		}else if($balance<1){
			$diceMsg= "You neet at least 1 satoshi to cashout";
		}else if($reefer==$userAddy){
			unset($_SESSION["cow"]);
			die("stop Error");
		}else{
			$result=$faucetbox->send($userAddy,$balance);
			if($result["success"]=== true){
				if(isset($reefer)){
				$r=$faucetbox->sendReferralEarnings($reefer,$refAmount);
				}
				$_SESSION['cashout'] = $result["html"];
				//
				$q="UPDATE faucetbox SET bbb=0 WHERE addy='".$userAddy."'";
				$db->abc($q);
				unset($_SESSION["cow"]);
				header("location:index.php");
				exit;
			}else{
				$_SESSION["diceMsg"]="Error".$result["html"];
				unset($_SESSION["cow"]);
				header("location:index.php");
				exit;
			}
				
				
		}
	}

if($balance==0){
		$_SESSION["error"]="YOUR BALANCE IS 0";
		unset($_SESSION["cow"]);
		header("location:/");
		exit;
	}

////////////////////////////////////////	
}

?>