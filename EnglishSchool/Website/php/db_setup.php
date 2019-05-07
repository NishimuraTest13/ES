<meta charset="UTF-8">
<?php

	#connect database
	$dsn = 'mysql:host=localhost; dbname=test; charset=utf8';
	$user = 'testuser';
	$pass = 'testpass';

	try{
		$dbh = new PDO($dsn, $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($dbh == null){
			#false...
		}else{
			echo "Success!";
			$SQL =<<<_SQL_
				CREATE TABLE ESCustomer (
				id INT PRIMARY KEY AUTO_INCREMENT,
				name VARCHAR(100),
				kana VARCHAR(100),
				birthday VARCHAR(100),
				gender VARCHAR(10),
				postal_code VARCHAR(100),
				address VARCHAR(100),
				phone VARCHAR(100),
				c_id VARCHAR(10),
				reserve VARCHAR(10)
				)
			_SQL_;
			$dbh->query($SQL);
			
			$SQL =<<<_SQL_
				CREATE TABLE ESUser (
				u_id INT PRIMARY KEY AUTO_INCREMENT,
				u_name VARCHAR(100),
				pass VARCHAR(100)
				)
			_SQL_;
			$dbh->query($SQL);
			
			$SQL =<<<_SQL_
				CREATE TABLE ESCourse (
				c_id VARCHAR(10) PRIMARY KEY,
				c_name VARCHAR(100)
				)
			_SQL_;
			$dbh->query($SQL);
			
			echo "Create Table";
			
			$SQL =<<<_SQL_
				INSERT INTO ESCustomer (
				name,kana,birthday,gender,
				postal_code,address,phone,
				c_id,reserve
				)
				VALUES(
				"西村鼓太郎","ニシムラコタロウ","2000/02/20","M",
				"200-0220","西日本西区西町2-22-2","020-2000-0220",
				"a","Mon"
				),(
				"東村栞","ヒガシムラシオリ","2000/02/20","F",
				"222-2222","東日本東区東町2-22-2","020-2202-2002",
				"c","Sun"
				)
			_SQL_;
			$dbh->query($SQL);
			
			$SQL =<<<_SQL_
				INSERT INTO ESUser (
				u_name,pass
				)
				VALUES(
				"test","test"
				),(
				"Jan","Jon"
				)
			_SQL_;
			$dbh->query($SQL);
			
			$SQL =<<<_SQL_
				INSERT INTO ESCourse (
				c_id,c_name
				)
				VALUES(
				"a","入門コース"
				),(
				"b","ビジネスコース"
				),(
				"c","エキスパートコース"
				)
			_SQL_;
			$dbh->query($SQL);
		}
	}catch(PDOException $e){
		echo "Failure...<br>";
		echo "Because of ". $e->getMessage();
		die();
	}
	$dbh = null;
?>