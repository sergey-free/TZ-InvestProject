<?php

function connect_db() {
	$server = 'localhost';
	$user = 'root';
	$pass = '';
	$database = 'mydata';
	$connection = new mysqli($server, $user, $pass, $database);
	return $connection;
}

?>