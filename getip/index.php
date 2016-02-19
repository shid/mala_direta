<?php

if ($_GET["s"]=="sec"){
	
	$file = "ip/".$_SERVER["REMOTE_ADDR"];
	$expire = $_GET["t"];
	
	if(file_exists($file)){
		
		if (time() > filectime($file)+$expire){
			unlink($file);
			$myfile = fopen($file, "a+") or die("Unable to open file!");
			fclose($myfile);
			
			echo "true";
		} else {
			echo "false";
		}
		
	} else {
		
		$myfile = fopen($file, "a+") or die("Unable to open file!");
		fclose($myfile);
		echo "false";
		
	}
	
	if (isset($_GET["d"])){
		echo "<br>";
		echo date("Y.m.d H:i:s",time())."<br>";
		echo $file."<br>";
		echo date("Y.m.d H:i:s",filectime($file)+$expire)."<br>";
	}
	
}
	
?>

