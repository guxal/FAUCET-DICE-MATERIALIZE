<?php
class Sesion{
		private $login=false;
		private $usuario;
		private $check;
		private $verificacion=false;

		function __construct(){
			session_start();
			$this->verificaLogin();
			if($this->login){
				//
			}else{
				//
			}
		}
		private function verificaLogin(){
			if(isset($_SESSION["usuario"])){
				$this->usuario=$_SESSION["usuario"];
				$this->login=true;
			}elseif(isset($_SESSION["check"])){
				$this->check=$_SESSION["check"];
				$this->verificacion=true;
			}else{
				unset($this->usuario);
				$this->login=false;

				unset($this->check);
				$this->verificacion=false;
			}
		}
		public function inicioLogin($n){
			if($n!=""){
				$this->usuario=$_SESSION["usuario"]=$n;
				$this->login=true;
			}
		}
		public function finLogin(){
			unset($this->usuario);
			unset($_SESSION["usuario"]);
			$this->login=false;
			session_destroy();
		}
		public function estadoLogin(){
			return $this->login;
		}
		public function getUsuario(){
			return $this->usuario;
		}
		public function getCheck(){
			return $this->check;
		}
		//
		public function inicioV($n){
			if($n!=""){
				$this->check=$_SESSION["check"]=$n;
				$this->verificacion=true;
			}		
		}
		public function estadoV(){
		    return $this->verificacion;
		}
	}
?>