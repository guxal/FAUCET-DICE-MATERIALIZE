<?php
	class controlUsers{
		var $ipp;
		var $time;

		function __construct(){
			$this->ipp = $_SERVER['REMOTE_ADDR'];
			$this->time=time();
		}
	}
?>