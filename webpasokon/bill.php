<?php
	include_once("config.php"); 		
		$fun=$_POST["fun"];
		switch ($fun) {
		case 'addBill':
			$fun();
			break;
		
		}
		function addBill()
	{
		global $conn;
		
		if(isset($_POST["ListProduct"])||isset($_POST["NAME"])||isset($_POST["PHONE"])||isset($_POST["ADDRESS"])|| isset($_POST["TRANSFER"]))
		{
				$ListProduct=$_POST["ListProduct"];
				$NAME=$_POST["NAME"];
				$PHONE=$_POST["PHONE"];
				$ADDRESS=$_POST["ADDRESS"];
				$TRANSFER=$_POST["TRANSFER"];
				
		}
		$date_current=date("d-m-Y");
		$date_delivery = date_create(date("d-m-Y"), timezone_open("Asia/Ho_Chi_Minh"));
		$date_delivery = date_modify($date_delivery, "+3 days");
		$date_delivery = date_format($date_delivery, "d/m/Y") ;

		$status="đang chờ kiểm duyệt";

		$query="INSERT INTO bill (Day_of_purchase,Delivery_date,Status,Name,Phone
		,Address,Transfer) 
		VALUES('".$date_current."'
				,'".$date_delivery."'
				,'".$status."'
				,'".$NAME."'
				,'".$PHONE."'
				,'".$ADDRESS."'
				,'".$TRANSFER."')";
		$result=mysqli_query($conn,$query);
		if($result)
		{
				
	    	$bill_id=mysqli_insert_id($conn);
	    	$json_android=json_decode($ListProduct);
	    	$array_listproduct=$json_android->ListProduct;
	    	$dem=count($array_listproduct);
	    	for($i=0;$i<$dem;$i++)
	    	{
	    		$json_object=$array_listproduct[$i];
	    		$Product_id=$json_object->Product_id;
	    		$Quantity=$json_object->Quantity;

	    		$query="INSERT INTO bill_detail(Bill_id,Product_id,Quantity) VALUES('".$bill_id."'
						,'".$Product_id."'
						,'".$Quantity."')";
				
				
				$result1=mysqli_query($conn,$query);
			}
			echo "{result:true}";
		}	

	    else{
	    	echo "{result:false}";
	    	echo mysqli_error($conn);
	    }
	    mysqli_close($conn);
	}
?>