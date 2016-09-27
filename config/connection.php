<?php
	$server ="localhost";
	$username ="root";
	$pass = "";
	$db = "android_database";
	
	$conn = mysqli_connect($server,$username,$pass,$db);
	if(!$conn){
		die("CONNECTION ERROR");
	}
    echo "<script>
            alert(\"Connection Successfull\");
         </script>";
?>