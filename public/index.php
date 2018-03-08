<?php
//Файл подключен из корня
//echo '<pre>',print_r($data),'</pre>';

//Slim
require 'vendor/autoload.php';
$app = new Slim\App([
	'mode'=>'development',
	'debug'=>true,
]);

//bd
require 'lib/db_mysql.php';
//$db = connect_db();

//main
$app->get('/', function ($req, $res) {
    ?>
	<html>
		<head>
			<link  rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/assets/css/style.css"></link>
			<script src="http://<?=$_SERVER['HTTP_HOST']?>/assets/js/jquery-1.9.1.js"></script>
			<script src="http://<?=$_SERVER['HTTP_HOST']?>/assets/js/my_api.js"></script>
		</head>
		<body>
			<div class="red">
				Данная страница строго для тестирования API
			</div>
			<div class="red">
				<input placeholder="Номер ( если UPDATE )" id="number"><br>
				<input placeholder="Фамилия" id="family"><br>
				<input placeholder="Имя" id="name"><br>
				<input placeholder="Отчество" id="middle_family"><br>
				<input placeholder="Телефон ( 7-20 цифр )" id="tel"><br>
				<input placeholder="E-mail ( *@*.* )" id="email"><br>
				<div type="submit" id="submit_create">Create</div>
				<div type="submit" id="submit_read">Read</div>
				<div type="submit" id="submit_update">Update</div>
				<div type="submit" id="submit_delete">Delete</div>
			</div>
			<div class="red">
				<div id="read_output">
				</div>
			</div>
		</body>
	</html>
	<?
});

//create
$app->post('/create', function ($req, $res) {
	
	try{
	
		if(
			$_POST
			&& $_POST['family']
			&& $_POST['name']
			&& $_POST['middle_family']
			&& strlen(preg_replace("/[^0-9]/", '', $_POST['tel'])) > 7
			&& strlen(preg_replace("/[^0-9]/", '', $_POST['tel'])) < 20
			&& filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
		){
			
			$sql = "
				INSERT INTO `users` (
					`family`,
					`name`,
					`middle_family`,
					`tel`,
					`email`
				) VALUES (
					'".htmlspecialchars($_POST['family'])."',
					'".htmlspecialchars($_POST['name'])."',
					'".htmlspecialchars($_POST['middle_family'])."',
					'".preg_replace("/[^0-9]/", '', $_POST['tel'])."',
					'".filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)."'
				);
			";
			
			$db = connect_db();
			$db->query($sql);
			return $res->withStatus(201);
			
		}else{
			return $res->withStatus(400);
		}
	
	}catch(Exception $e){
	
	}

});

//read
//$app->get('/read/:id' - можно узать GET, можно POST, можно оба ( меня чаще POST просили )
$app->post('/read', function ($req, $res) {
    
	try{
		
		if(preg_replace("/[^0-9]/", '', $_POST['id']) > 0){
			
			$sql="
				SELECT *
				FROM `users`
				WHERE `id` = '".preg_replace("/[^0-9]/", '', $_POST['id'])."'
			";
			
			$db = connect_db();
			$result = $db->query($sql);
			while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
				$data[] = $row;
			}
			return $res->withJson($data[0], 200)->withHeader('Content-type', 'application/json');
		
		}else{
			return $res->withStatus(400);
		}

	}catch(Exception $e){
	
	}
	
});

//update
$app->put('/update', function ($req, $res) {
	
	try{
		
		if(
			$_POST
			&& preg_replace("/[^0-9]/", '', $_POST['id'])
			&& $_POST['family']
			&& $_POST['name']
			&& $_POST['middle_family']
			&& strlen(preg_replace("/[^0-9]/", '', $_POST['tel'])) > 7
			&& strlen(preg_replace("/[^0-9]/", '', $_POST['tel'])) < 20
			&& filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
		){
			
			$sql = "
				UPDATE `users` SET
					`family` = '".htmlspecialchars($_POST['family'])."',
					`name` = '".htmlspecialchars($_POST['name'])."',
					`middle_family` = '".htmlspecialchars($_POST['middle_family'])."',
					`tel` = '".preg_replace("/[^0-9]/", '', $_POST['tel'])."',
					`email` = '".htmlspecialchars(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))."'
				WHERE `id` = '".preg_replace("/[^0-9]/", '', $_POST['id'])."'
			";

			$db = connect_db();
			$db->query($sql);
			return $res->withStatus(202);
			
		}else{
			return $res->withStatus(400);
		}
	
	}catch(Exception $e){
	
	}
	

});

//delete
$app->delete('/delete', function ($req, $res) use($app) {
	
	try{
		
		if(preg_replace("/[^0-9]/", '', $_POST['id']) > 0){
		
			$sql="
				DELETE FROM `users`
				WHERE `id` = '".preg_replace("/[^0-9]/", '', $_POST['id'])."'
			";
			
			$db = connect_db();
			$db->query($sql);
			return $res->withStatus(200);
			
		}else{
			return $res->withStatus(400);
		}

	}catch(Exception $e){
	
	}
	
});

$app->run();

?>