<meta charset="UTF-8">
<?php

	$toppage="./form.html";

	$name = $_POST["name"];
	$kana =$_POST["kana"];
	$birthday =$_POST["birthday"];
	$gender = $_POST["gender"];
	$postal_code = $_POST["postal_code"];
	$address =$_POST["address"];
	$phone =$_POST["phone"];
	$c_id = $_POST["c_id"];
	$reserve = $_POST["reserve"];

	/*
		iroiro
	*/

	if($_POST["mode"]=="post") { conf_form(); }
	else if($_POST["mode"]=="send") { send_form(); }

	function conf_form(){
		global $name;
		global $kana;
		global $birthday;
		global $gender;
		global $postal_code;
		global $address;
		global $phone;
		global $c_id;
		global $reserve;

		$conf = fopen("../tmpl/check.tmpl","r") or die;
		$size = filesize("../tmpl/check.tmpl");
		$data = fread($conf,$size);
		fclose($conf);

		$data = str_replace("!name!", $name, $data);
		$data = str_replace("!kana!", $kana, $data);
		$data = str_replace("!birthday!", $birthday, $data);
		$data = str_replace("!gender!", $gender, $data);
		$data = str_replace("!postal_code!", $postal_code, $data);
		$data = str_replace("!address!", $address, $data);
		$data = str_replace("!phone!", $phone, $data);
		$data = str_replace("!c_id!", $c_id, $data);
		$data = str_replace("!reserve!", $reserve, $data);
    switch($gender){
      case 'M':
		    $data = str_replace("!gender2!", "男", $data);
        break;
      case 'F':
		    $data = str_replace("!gender2!", "女", $data);
        break;
    }
    switch($c_id){
      case 'a':
		    $data = str_replace("!c_id2!", "入門コース", $data);
        break;
      case 'b':
		    $data = str_replace("!c_id2!", "ビジネスコース", $data);
        break;
      case 'c':
		    $data = str_replace("!c_id2!", "エキスパートコース", $data);
        break;
    }
    switch($reserve){
      case 'Sun':
		    $data = str_replace("!reserve2!", "日曜日", $data);
        break;
      case 'Mon':
		    $data = str_replace("!reserve2!", "月曜日", $data);
        break;
      case 'Tue':
		    $data = str_replace("!reserve2!", "火曜日", $data);
        break;
      case 'Wed':
		    $data = str_replace("!reserve2!", "水曜日", $data);
        break;
      case 'Thu':
		    $data = str_replace("!reserve2!", "木曜日", $data);
        break;
      case 'Fri':
		    $data = str_replace("!reserve2!", "金曜日", $data);
        break;
      case 'Sat':
		    $data = str_replace("!reserve2!", "土曜日", $data);
        break;
    }
		$data = str_replace("!function!", "登録", $data);
		$data = str_replace("!option!", "registCheck", $data);

		echo $data;
		exit;
	}

	function send_form(){
		global $name;
		global $kana;
		global $birthday;
		global $gender;
		global $postal_code;
		global $address;
		global $phone;
		global $c_id;
		global $reserve;

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
				//echo $name;
				$SQL =<<<_SQL_
					INSERT INTO ESCustomer (
					name,kana,birthday,gender,postal_code,address,phone,c_id,reserve
					)
					VALUES(
					'$name','$kana','$birthday','$gender','$postal_code','$address','$phone','$c_id','$reserve'
					)
				_SQL_;

				$dbh->query($SQL);
				echo "<h1>登録完了しました！</h1><br><a href='top.php'>戻る</a>";
			}

		}catch(PDOException $e){
			echo "Failure...<br>";
			echo "Because of ". $e->getMessage();
			die();
		}
		$dbh = null;

	}

?>