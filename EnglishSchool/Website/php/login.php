<?php


  getID();

  function getID(){
    
    #connect database
    $dsn = 'mysql:host=localhost; dbname=test; charset=utf8';
    $user = 'testuser';
    $pass = 'testpass';

    try{
      global $dbh;
      $dbh = new PDO($dsn, $user, $pass);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if($dbh == null){
        #false...
      }else{
        session_start();
        $in = parse_form();
        $mode = $in["mode"];
        login($in["id"], $in["pass"]);
      }
    }catch(PDOException $e){
      echo "Failure...<br>";
      echo "Because of ". $e->getMessage();
      die();
    }
    $dbh = null;
  }


#-----------------------------------------------------------
#  フォーム受け取り
#-----------------------------------------------------------
function parse_form(){

    global $in;
  
    if(isset($_POST["mode"])){$post = $_POST;}
    if(isset($_GET["mode"])){$post = $_GET;}
    foreach($post as $key => $val) {
      # 2次元配列から値を取り出す
      if(is_array($val)){
         $val = array_shift($val);
      }

      # 文字コードの処理
      $enc = mb_detect_encoding($val);
      $val = mb_convert_encoding($val, "UTF-8", $enc);

      $in[$key] = $val;
    }
    return $in;
}
#-----------------------------------------------------------
#  ユーザーログイン
#-----------------------------------------------------------
  function login($id,  $pass){
    if ($id == null) { error("IDを入力してください"); }
    if ($pass == null){ error("PWを入力してください"); }
    global $dbh;

//ID[0001],PW[' OR 'A' = 'A]でインジェクションが可能
    $sql = "SELECT * FROM ESUser where u_id= ? and pass= ?";
    $stmt = $dbh -> prepare($sql);  
    $user_data = array($id, $pass);
    $stmt -> execute($user_data);
    $u_name = "";
    while($info = $stmt->fetch()) {
        $u_name = $info["u_name"];
        $u_id = $info["u_id"];
        $u_pass = $info["pass"];
    }
    if ($u_name == null ){error("正しいIDを入力してください。");}
    else{
      if($u_pass == $pass){
        $_SESSION['u_id'] = $u_id;
        $_SESSION['u_name'] = $u_name;
        $_SESSION['pass'] = $pass;
        # 表示
        echo "<p>ようこそ";
        echo $u_name;
        echo "先生</p>";
        echo <<<_FORM_
          <form action="top.php" method="post">
            <input type="submit" name="submit" value="マイページへ">
          </form>
          _FORM_;
        exit;
      }
      else{
        error("正しいPWを入力してください。");
      }

      
    }

  }
  function error($err){
    $msg = $err;
    # 表示
    echo $msg;
    echo <<<_FORM_
      <form action="../html/login.html" method="post">
        <input type="submit" name="submit" value="戻る">
      </form>
      _FORM_;
    exit;
  }
?>