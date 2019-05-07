<meta charset="UTF-8">
<?php

top_form();

function top_form(){
		$conf = fopen("../tmpl/top.tmpl","r") or die;
		$size = filesize("../tmpl/top.tmpl");
		$data = fread($conf,$size);
		fclose($conf);
    session_start();
		$data = str_replace("!name!", $_SESSION['u_name'], $data);
		echo $data;
		exit;
}

?>