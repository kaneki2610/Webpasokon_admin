 <?php
	 include_once("config.php");
	    $fun=$_POST["fun"];
		switch ($fun) {
		case 'SearchProduct':
			$fun();
			break;
		}
		function SearchProduct()
		{
			global $conn;	
			$json=array();
			if(isset($_POST["Product_name"]) || isset($_POST["limit"]))
			{
				$Product_name=$_POST["Product_name"];
				$limit=$_POST["limit"];
			}
			$current_date=date("Y/m/d");
			$query="SELECT *  FROM product AS P WHERE P.Product_name like '%".$Product_name."%' ORDER BY P.Product_id LIMIT ".$limit.",10";

			$result=mysqli_query($conn,$query);
			


			
			echo "{";
			echo "\"ListProduct\":";
			if($result)
			{
				while ($dong=mysqli_fetch_array($result)) {

						
		    			$query_discount="SELECT *,DATEDIFF(D.Date_close,'".$current_date."') AS Duration FROM discount as D,discount_detail as DT WHERE D.Discount_id=DT.Discount_id AND DT.Product_id='".$dong["Product_id"]."'";
	    				  $kq_discount=mysqli_query($conn,$query_discount);
	    				  $percent_discount=0;
	    				 if($kq_discount)
	    				 {
	    				 		while ($line=mysqli_fetch_array($kq_discount)) {
	    				 			$time_discount=$line["Duration"];
					    			if($time_discount>0)
					    			{
					    				$percent_discount=$line["Percent"];
					    			}	
	    				 		}
	    					
	    				 }

							


		    			array_push($json, array("Product_id"=>$dong["Product_id"]
					,'Product_name'=>$dong["Product_name"]
					,'Price'=>$dong["Price"]
					,'Big_Image'=>$dong["Big_Image"]
					,'Small_Image'=>$dong["Small_Image"]
					,'Percent'=>$percent_discount));	
					
				}
			}
			echo json_encode($json,JSON_UNESCAPED_UNICODE);
			echo "}";
			
		}	



 ?>