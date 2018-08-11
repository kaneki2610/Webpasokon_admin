<?php
	define("DBSERVER","localhost");
	define("DBUSERNAME","root");
	define("DBPASSWORD","");
	define("DBNAME","dbpasokon");
   
   //set timezone
	date_default_timezone_get("Asia/Ho_Chi_Minh");
   //Check connection
	$conn=mysqli_connect(DBSERVER,DBUSERNAME,DBPASSWORD,DBNAME);
	mysqli_set_charset($conn,"utf8");
	if(!$conn)
	{
		die("connect fail!".mysqli_connect_errno());
	}
?>
