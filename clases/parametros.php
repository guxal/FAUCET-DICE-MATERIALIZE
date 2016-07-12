<?php
require_once("controluser.php");
class Parametros{
	private $api_key;
	private $startBal;
	private $reefAmount;
	private $timeBetweenClaims;
	private $recaptchaKey;
	private $recaptchaSecret;
	private $currenci="BTC";

	function __construct(){
		$db=new dbMySQL();
		$q="SELECT * FROM admonfaucet WHERE id=1";
		$data=$db->query($q,false);
		$this->api_key=$data->api;
		$this->startBal=$data->balance;
		$this->reefAmount=$data->refbalance;
		$this->timeBetweenClaims=$data->timeClaims;
		$this->recaptchaKey=$data->rkp;
		$this->recaptchaSecret=$data->rsk;
		$db->close();
		unset($db);
	}

	public function set_startBal(){
		return $this->startBal;
	}
	public function set_api_key(){
		return $this->api_key;
	}
	public function set_reefAmount(){
		return $this->reefAmount;
	}
	public function set_tBC(){
		return $this->timeBetweenClaims;
	}
	public function set_rKey(){
		return $this->recaptchaKey;
	}
	public function set_rSecret(){
		return $this->recaptchaSecret;
	}
	public function set_currenci(){
		return $this->currenci;
	}
	public function vTime($n){
		if($n < $this->timeBetweenClaims){
			$q=true;
		}else{
			$q=false;
		}
		return $q;
	}
	public function verificaCaptcha($c){
		$control=new controlUsers();
		$ping=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$this->set_rSecret()."&response=$c&remoteip=".$control->ipp);
		$json=json_decode($ping,TRUE);
		$success=$json["success"];
		return $success;
	}
	public function vWallet($n){
		$control=new controlUsers();
		$db=new dbMySQL();
		$db->set_charset("utf8");
		$userAddy=$db->set_escape($n);
		$q="SELECT * FROM faucetbox WHERE addy= '$userAddy'";
		if($db->query2($q) > 0){//si la wallet es mayor a 0 
			$data=$db->query($q,false);
			$tDif=$control->time - $data->time;
			if($this->vTime($tDif)){
			  $e=false;
			  $t=$this->set_tBC()/60;
			  $_SESSION["diceMsg"]="Wait ".$t." min";
			}else{
				$us=$_SESSION["usuario"];
				$r="SELECT refer FROM user WHERE correo='".$us."'";
				$row=$db->query($r,false);
				$q="UPDATE faucetbox SET bbb='".$this->startBal."', time='".$control->time."', reefer='".$row->refer."' WHERE addy='".$userAddy."'";
				$db->abc($q);
				$e=true;
				$_SESSION['cow']=$userAddy;
			}
		}//fin de mayor a 0 en la wallet
		else if($db->query2($q) == 0){//si la wallet es igual a 0 
		$q="SELECT * FROM faucetbox WHERE ipp= '".$control->ipp."'";//chekamos la ip
			if($db->query2($q) > 0){//si la ip existe 
				//traemos los datos que tenga esa ip 
				$data=$db->query($q,false);
				$tDif=$control->time - $data->time;
				if($this->vTime($tDif)){
			  	$e=false;
			  	$t=$this->set_tBC()/60;
			  	$_SESSION["diceMsg"]="Wait ".$t." min";
				}else{
				$us=$_SESSION["usuario"];
				$r="SELECT refer FROM user WHERE correo='".$us."'";
				$row=$db->query($r,false);
				$q="UPDATE faucetbox SET addy='$userAddy',bbb='$this->startBal', time='".$control->time."', reefer='".$row->refer."' WHERE ipp='".$control->ipp."'";
				$db->abc($q);
				$e=true;
				$_SESSION['cow']=$userAddy;
				}
			}else if($db->query2($q) == 0){
				$us=$_SESSION["usuario"];
				$r="SELECT refer FROM user WHERE correo='".$us."'";
				$row=$db->query($r,false);
				$q="INSERT INTO faucetbox(addy,time,bbb,ipp,reefer) values ('$userAddy','$control->time','$this->startBal','$control->ipp','$row->refer')";
				$db->abc($q);
				$e=true;
				$_SESSION['cow']=$userAddy;
			}	
		}//
			$db->close();
			unset($db);
			return $e;
	}
}
?>