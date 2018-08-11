<?php
	include_once("config.php");

	$fun=$_POST["fun"];
	switch ($fun) {
		case 'ProcessRegister':
			$fun();
			break;
		case 'CheckAccount':
			$fun();
			break;
		case 'ProcessLogin':
			$fun();
			break;
	}

	
	function ProcessRegister()
	{
		global $conn;
		if(isset($_POST["name"])||isset($_POST["email"])||isset($_POST["pass"])||isset($_POST["kind_staff"]))
		{
				$name=$_POST["name"];
				$email=$_POST["email"];
				$password=$_POST["pass"];
				$kindofstaff=$_POST["kind_staff"];
		}


		$query="INSERT INTO customer (Customer_name,Email,Password,KindOfCustomer_id) 
		VALUES('".$name."','".$email."','".$password."','".$kindofstaff."')";
		
	    if(mysqli_query($conn, $query))
	    {
	    	echo "{result:true}";

	    }else{
	    	echo "{result:false}";
	    }
	    mysqli_close($conn);
	}
	function CheckAccount()
	{
		global $conn;

		if(isset($_POST["email"]))
		{
			$email=$_POST["email"];
			
		}
		$query="SELECT * FROM customer WHERE Email = '".$email."'";
		$result=mysqli_query($conn,$query);
		$num=mysqli_num_rows($result);

			if($num>=1)
			{
				echo "{result:true}";
			}else{
				echo "{result:false}";
			}
		 mysqli_close($conn);
	}
	function ProcessLogin()
	{
		global $conn;
		$name = '';
		$password = '';
		if(isset($_POST["name"]) || isset($_POST["password"]))
		{
			$name = $_POST['name'];
			$password = $_POST['password'];
			
		}
   $query="SELECT * FROM customer WHERE Email="$name" AND Password="$password"";
		
		$kq=mysqli_query($conn,$query);
		$num=mysqli_num_rows($kq);
		if($num>0)
		{
			echo "{result:true}";

		}else{
			echo "{result:false}";
		}
		mysqli_close($conn);
	}

?>