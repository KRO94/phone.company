<?php 	
		$servername = 'localhost';
	    $username = 'root';
	    $password = "";
	    $database = "phone_company_db";
	    $db = new mysqli($servername, $username, $password);

	    $db->query('CREATE DATABASE '.$database);
	    $db->select_db($database);

		$users = "CREATE TABLE users (
								u_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
								email VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								password VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								u_name VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								surname VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								gender VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci,
								card_number VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci
								) CHARACTER SET utf8 COLLATE utf8_general_ci;";

		$tariffs = "CREATE TABLE tariffs (
								t_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
								t_name VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								minut_price INT(10),
								connect_price INT(10)
								) CHARACTER SET utf8 COLLATE utf8_general_ci;";	

		$calls = "CREATE TABLE calls (
								c_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
								u_id INT,
								city VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci,
								date VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci,
								duration INT(10),
								t_id INT,
								FOREIGN KEY (u_id) REFERENCES users(u_id),
								FOREIGN KEY (t_id) REFERENCES tariffs(t_id)
								) CHARACTER SET utf8 COLLATE utf8_general_ci;";


		if ($db->query($users) && $db->query($tariffs) && $db->query($calls)) {
			$w_string = '<?php
							define ("DB_SERVER",   "'.$servername.'"); 
							define ("DB_LOGIN",    "'.$username.'"); 
							define ("DB_PASSWORD", "'.$password.'"); 
							define ("DB_NAME",     "'.$database.'");
						?>';
			$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/config.php", "w");
			fwrite($fp, $w_string);
			fclose($fp);
		}
		$users_data_json = file_get_contents($_SERVER['DOCUMENT_ROOT']."/data/users_data.json");
		$calls_data_json = file_get_contents($_SERVER['DOCUMENT_ROOT']."/data/calls_data.json");
		$tariffs_data_json = file_get_contents($_SERVER['DOCUMENT_ROOT']."/data/tariffs_data.json");

		$users_data = json_decode($users_data_json, true);
		$calls_data = json_decode($calls_data_json, true);
		$tariffs_data = json_decode($tariffs_data_json, true);

		insertToDB($users_data, 'users', $db);
		insertToDB($tariffs_data, 'tariffs', $db);
		insertToDB($calls_data, 'calls', $db);

	function insertToDB($data, $table, $db) {
		$str = "";
		for($i = 0, $l = count($data); $i < $l; $i++) {
			foreach($data[$i] as $key => $value) { 
				$str .= "'".$value."',";
			}
			$db->query("INSERT ".$table." VALUES (".trim($str, ",").")");
			echo trim($str, ",")."</br>";
			$str = "";
		} 
	}

?>