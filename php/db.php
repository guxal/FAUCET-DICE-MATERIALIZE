<?php
class dbMySQL{
	//parametros de conexion a la db
	private $host = "localhost";
	private $usuario="regazmpq_duser";
	private $clave = "cy(N7g8%Iq-a";
	private $db = "regazmpq_dice";
	private $conn;
		//funcion constructora
	public function __construct (){
		$this->conn=mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
		if(mysqli_connect_error()){
			printf("error en la conexion:%d\n",mysqli_connect_error());
			exit;
		}else{
			//print "conexion Exitosa<br>";
		}
	}
	//
	public function numItems($n){
		$query="SELECT COUNT(*) as items FROM ".$n;
		$r = mysqli_query($this->conn,$query);
		$obj=mysqli_fetch_object($r);
		return $obj->items;
	}
	//query
	public function query($q,$p=true){
		if($q!=""){
				if($r=mysqli_query($this->conn,$q)){
					if($p) $data = mysqli_fetch_row($r);
					if(!$p) $data = mysqli_fetch_object($r);
				}
		}
		return $data;
	}
	//query num row
	public function query2($q){
		if($q!=""){
				if($r=mysqli_query($this->conn,$q)){
					$data = mysqli_num_rows($r);
				}
		}
		return $data;
	}
	//
	public function abc($q){
		$r=false;
		if($q!=""){
			$r=mysqli_query($this->conn, $q);
		}
		return $r;
	}
	//funcion de salida de la base de datos
	public function close(){
		mysqli_close($this->conn);
	}
	public function leeTabla($q){
		$data = array();
		if($q!=""){
				if($r=mysqli_query($this->conn,$q)){
					while($row=mysqli_fetch_object($r))
					array_push($data,$row);
				}
		}
		return $data;
	}
	public function set_charset($n){
		if(mysqli_set_charset($this->conn,$n)){
			$q=true;
		}else{
			$q=false;
		}
		return $q;
	}
	public function set_escape($n){
		$r=mysqli_real_escape_string($this->conn,$n);
		return $r;
	}
	public function Avalido(){
		$q="SELECT valido FROM admonfaucet WHERE id=1";
		if($r=mysqli_query($this->conn,$q)){
			$data = mysqli_fetch_object($r);
			if($data->valido==1){
				$d=true;
			}else{
				$d=false;
			}
		}
		return $d;
	}
	public function design($n){
		$q="SELECT valor FROM ajustes WHERE nombre='".$n."' ";
		if($r=mysqli_query($this->conn,$q)){
		  $data = mysqli_fetch_object($r);
  	}
		return $data->valor;
}
}
?>