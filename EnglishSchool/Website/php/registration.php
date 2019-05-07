<meta charset="UTF-8">
<?php

registration_form();

function registration_form(){
		$conf = fopen("../tmpl/registration.tmpl","r") or die;
		$size = filesize("../tmpl/registration.tmpl");
		$data = fread($conf,$size);
		fclose($conf);
		$data = str_replace("!option!", "registCheck", $data);
		$data = str_replace("!name!", "", $data);
		$data = str_replace("!kana!", "", $data);
		$data = str_replace("!birthday!", "", $data);
		$data = str_replace("!phone!", "", $data);
		$data = str_replace("!postal_code!", "", $data);
		$data = str_replace("!address!", "", $data);
  
  
		echo $data;
		exit;
}

?>