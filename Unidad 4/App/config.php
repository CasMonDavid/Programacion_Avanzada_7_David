<?php 
	if (!isset($_SESSION)) {
		session_start();
	}
	
	if (!defined('BASE_PATH')) {
      define('BASE_PATH','http://localhost:8888/');
   	}

?>