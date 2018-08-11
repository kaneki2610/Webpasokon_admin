<?php
	include_once("config.php"); 	
	$fun=$_POST["fun"];
	switch ($fun) {
		case 'getListDiscount':
			$fun();
			break;
	
	
	}
		function getListDiscount()
		{
	
			  global $conn;	
			  $chuoi_json=array();
			  $date_current=date("Y/m/d");
			  $query="SELECT *FROM discount d,categories c WHERE DATEDIFF(d.Date_close,'".$date_current."')>=0 AND d.Category_id=c.Category_id ";	
			  $result=mysqli_query($conn,$query);

			  echo "{";
			  echo "\"ListDiscount\":";
			  if($result)
			  {
				  	 while($dong=mysqli_fetch_array($result))
				  {
				  		 $query1="SELECT *FROM discount_detail d,product p WHERE d.Discount_id='".$dong["Discount_id"]."' AND d.Product_id=p.Product_id ";	
			 			 $result1=mysqli_query($conn,$query1);

			 			 $chuoi_json2=array();	
			 			 if($result1)
			 				 {
			 				 	 while($dongKM=mysqli_fetch_array($result1))
			 				 	 {
			 				 	 		 $chuoi_json2[]=$dongKM;
			 				 	 }
			 				 }
				  		array_push($chuoi_json, array("Discount_id"=>$dong["Discount_id"]
				  			,"NAME"=>$dong["Name"]
				  			,"Category_name"=>$dong["Category_name"]
				  			,"IMAGE"=>$dong["Image"]
				  			,"ListProduct"=>$chuoi_json2));
				  	    	
				  }
			  	echo json_encode($chuoi_json,JSON_UNESCAPED_UNICODE);  
;			  }
			  echo "}";
		}

?>