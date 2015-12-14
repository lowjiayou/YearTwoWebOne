<?php
	define("HOST", "localhost");
	define("USERNAME", "root");
	define("PASSWD", "");
	define("DBNAME", "artsnents");
	$conn = mysqli_connect (HOST,USERNAME,PASSWD,DBNAME) // can accept 1 more var "dbname"
	or die("Could Not Connect to MySQL!");//.mysqli_error()
?>