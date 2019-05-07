<meta charset="UTF-8">
<?php

$db_data = "";
if($_POST["mode"] == "post"){
  search_dara();
}
show_db();

function search_dara(){
  
		#connect database
		$dsn = 'mysql:host=localhost; dbname=test; charset=utf8';
		$user = 'testuser';
		$pass = 'testpass';

    global $db_data;
  
		try{
			$dbh = new PDO($dsn, $user, $pass);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if($dbh == null){
				#false...
			}else{
        $SQL = "SELECT * FROM ESCustomer";
        $user_data = array(); //条件格納
        $num = 0; //条件の数
        $column = false; //カラム表示
        if($_POST["id"] != null){
          $SQL .= " where id= ?";
          $user_data += array($_POST["id"]);
        }else{
          $already = false;
          if($_POST["name"] != null){
            if(!$already){
              $SQL .= " where name= ?";
              $user_data += array($num => $_POST["name"]);
              $num++;
              $already = true;
            }else{ 
              $SQL .= " and name= ?"; 
              $user_data += array($num => $_POST["name"]);
              $num++;
            }
          }
          if($_POST["kana"] != null){
            if(!$already){
              $SQL .= " where kana= ?";
              $user_data += array($num => $_POST["kana"]);
              $num++;
              $already = true;
            }else{ 
              $SQL .= " and kana= ?"; 
              $user_data += array($num => $_POST["kana"]);
              $num++;
            }
          }
          if($_POST["c_id"] != null){
            if(!$already){
              $SQL .= " where c_id= ?";
              $user_data += array($num => $_POST["c_id"]);
              $num++;
              $already = true;
            }else{ 
              $SQL .= " and c_id= ?"; 
              $user_data += array($num => $_POST["c_id"]);
              $num++;
            }
          }
          if($_POST["reserve"] != null){
            if(!$already){
              $SQL .= " where reserve= ?";
              $user_data += array($num => $_POST["reserve"]);
              $num++;
              $already = true;
            }else{ 
              $SQL .= " and reserve= ?"; 
              $user_data += array($num => $_POST["reserve"]);
              $num++;
            }
          }
        }
        $stmt = $dbh -> prepare($SQL);
        //echo $SQL;
        //print_r($user_data);
        $res = $stmt -> execute($user_data);
        while($value = $stmt->fetch()){
          switch($value['gender']){
            case 'M':
              $gender = "男";
              break;
            case 'F':
              $gender = "女";
              break;
          }
          switch($value['c_id']){
            case 'a':
              $course = "入門コース";
              break;
            case 'b':
              $course = "ビジネスコース";
              break;
            case 'c':
              $course = "エキスパートコース";
              break;
          }
          switch($value['reserve']){
            case 'Sun':
              $reserve ="日曜日";
              break;
            case 'Mon':
              $reserve ="月曜日";
              break;
            case 'Tue':
              $reserve ="火曜日";
              break;
            case 'Wed':
              $reserve ="水曜日";
              break;
            case 'Thu':
              $reserve ="木曜日";
              break;
            case 'Fri':
              $reserve ="金曜日";
              break;
            case 'Sat':
              $reserve ="土曜日";
              break;
          }
          if(!$column){
            $db_data .= "<table border='1'><tr><th>id</th><th>名前</th><th>フリガナ</th><th>生年月日</th><th>性別</th>
              <th>郵便番号</th><th>住所</th><th>電話番号</th><th>コース</th><th>予約日</th></tr>";
            $column = true;
          }
          $db_data .= "<tr><td>$value[id]</td><td>$value[name]</td><td>$value[kana]</td><td>$value[birthday]</td><td>$gender</td>
            <td>$value[postal_code]</td><td>$value[address]</td><td>$value[phone]</td><td>$course</td><td>$reserve</td></tr>";
        }
        $db_data .= "</table>";
			}
		}catch(PDOException $e){
			echo "Failure...<br>";
			echo "Because of ". $e->getMessage();
			die();
		}
		$dbh = null;
}

function show_db(){
  global $db_data;
  
  $conf = fopen("../tmpl/search.tmpl","r") or die;
  $size = filesize("../tmpl/search.tmpl");
  $data = fread($conf,$size);
  fclose($conf);
  session_start();
  $data = str_replace("!function!", "検索", $data);
  $data = str_replace("!option!", "search", $data);
  $data = str_replace("!db_data!", $db_data, $data);
  echo $data;
  exit;
}

?>