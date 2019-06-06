<?php

//phpinfo();
	$host = 'localhost';
	$username = 'charles';
	$password = 'charles2019';
	$dbname = 'charlesDB';

	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

	try{

	//	$connection = new PDO('mysql:host={$host};dbname={$dbname};charset=utf8', $username, $password);
	$connection = new PDO('mysql:host=localhost;dbname=charlesDB;charset    =utf8', 'charles', 'charles2019');

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		echo "db 연결 성공";
	}
	catch(PDOException $e){
		die("Failed to connect to the database: " . $e->getMessage());
	}


	if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()){
		function undo_magic_quotes_gpc(&$array){
			foreach($array as &$value){
				if(is_array($value)){
				   unco_magic_quotes_gpc($value);
				}
				else{
				   $value = stripslashes($value);
				}
			}
		}
	undo_magic_quotes_gpc($_POST);
	undo_magic_quotes_gpc($_GET);
	undo_magic_quotes_gpc($_COOKIE);
	}

	header('Content-Type: text/html; charset=utf-8');

?>
