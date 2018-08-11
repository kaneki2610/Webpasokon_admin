
	<?php
	  include_once("config.php"); 	

	  $fun=$_POST["fun"];
		switch ($fun) {
		case 'getListTrademark':
			$fun();
			break;
		case 'getListTopPhoneAndLaptop':
			$fun();
			break;
		
		case 'getProduct':
			$fun();
			break;
		
		case 'getProductDetail':
			$fun();
			break;
		case 'getDigitalInfo':
			$fun();
			break;
		case 'getListProductCategories':
			$fun();
			break;
		}
		//get list trademark
		function getListTrademark()
		{
	
			  global $conn;	
			  $truyvan="SELECT *FROM trademark T,detail_trademark  D WHERE T.Trademark_id=D.Trademark_id";
			  $ketqua=mysqli_query($conn,$truyvan);
			  $chuoi_json=array();
			  echo "{";
			  echo "\"Trademark\":";
			  if($ketqua)
			  {
				  	 while($dong=mysqli_fetch_array($ketqua))
				  {
						array_push($chuoi_json, array('TRADEMARK_ID'=>$dong["Trademark_id"],'TRADEMARK_NAME'=>$dong["Trademark_name"]
				  	    	,"image"=>"http://".$_SERVER['SERVER_NAME'].":82"."/webpasokon".$dong["Image"]));
				  		
				  	    	
				  }
			  	echo json_encode($chuoi_json,JSON_UNESCAPED_UNICODE);
			  }
			  echo "}";
		}

	  	//get list top phone and laptop
		function getListTopPhoneAndLaptop(){
			global $conn;

			//query phone
			$truyvancha = "SELECT *  FROM categories c, product p WHERE c.Category_name LIKE 'Điện thoại%' AND c.Category_id = p.Category_id ORDER BY p.Count_buy DESC LIMIT 10";
			$ketqua = mysqli_query($conn,$truyvancha);
			$chuoijson = array();

			echo "{";
			echo "\"TOPPHONELAPTOP\":";
			if($ketqua){
				while ($dong=mysqli_fetch_array($ketqua)) {
				
					
					//cách 2
			array_push($chuoijson, array("Product_id"=>$dong["Product_id"]
				,'Product_name' => $dong["Product_name"]
				,'Price'=>$dong["Price"]
				,'Image'=>"http://".$_SERVER['SERVER_NAME'].":82"."/webpasokon".$dong["Big_Image"]));
					//end cách 2
				}

				
			}

			//query laptop
			$truyvancha = "SELECT *  FROM categories c, product p WHERE c.Category_name LIKE 'Laptop%' AND c.Category_id = p.Category_id ORDER BY p.Count_buy DESC LIMIT 10";
			$ketquamtb = mysqli_query($conn,$truyvancha);
			
			if($ketquamtb){
				while ($dongmtb=mysqli_fetch_array($ketquamtb)) {
				
				
					
					array_push($chuoijson, array("Product_id"=>$dong["Product_id"]
						,'Product_name' => $dong["Product_name"]
						,'Price'=>$dong["Price"]
						,'Image'=>"http://".$_SERVER['SERVER_NAME'].":82"."/webpasokon".$dong["Big_Image"]));
					
				}

				
			}

			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
		}

		//get list product --with trademark_id
		function getProduct()
		{
			global $conn;
			if(isset($_POST["trademarkID"]) || isset($_POST["limit"]))
			{
				$trademark_id=$_POST["trademarkID"];
				$limit=$_POST["limit"];
			}
			$query="SELECT * FROM product P, trademark T WHERE T.Trademark_id =".$trademark_id." AND T.Trademark_id=P.Trademark_id ORDER BY P.Count_buy DESC LIMIT ".$limit.",20";
			$kq=mysqli_query($conn,$query);
			$chuoijson=array();
			echo "{";
			echo "\"PRODUCT\":";
			if($kq)
			{
				while($dong=mysqli_fetch_array($kq))
				{
					array_push($chuoijson, array("Product_id"=>$dong["Product_id"]
					,'Product_name'=>$dong["Product_name"]
					,'Price'=>$dong["Price"]
					,'Image'=>"http://".$_SERVER['SERVER_NAME'].":82"."/webpasokon".$dong["Big_Image"]));
					
				}
			}
			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
		}
	    //get product detail
	    function getProductDetail()
	    {
	    	global $conn;
	    	if(isset($_POST["product_id"]))
	    	{
	    		$product_id=$_POST["product_id"];
	    	} 
	    	$current_date=date("Y/m/d");
	    	$query="SELECT * FROM product as P WHERE P.Product_id = ".$product_id."";
	    	$kq=mysqli_query($conn,$query);

	    	 $query_discount="SELECT *,DATEDIFF(D.Date_close,'".$current_date."') AS DT FROM discount as D,discount_detail as DT WHERE D.Discount_id=DT.Discount_id AND DT.Product_id='".$product_id."'";
	    	 $kq_discount=mysqli_query($conn,$query_discount);
	    	 
	    	 $percent_discount=0;
	    	 if($kq_discount)
	    	 {
	    	 	while ($line=mysqli_fetch_array($kq_discount)) {
	    	 		$time_discount=$line["DT"];
	    			if($time_discount>0)
	    			{ 
	    				$percent_discount=$line["Percent"];
	    			}	

	    	 	}
	    	 }

	    	
	    	$chuoijson=array();
	    	echo "{";
			echo "\"Product Detail\":";
	    	if($kq)
	    	{
	    		
	    		while ($dong=mysqli_fetch_array($kq)) {

	    			
	    			
	    			array_push($chuoijson, array("Product_id"=>$dong["Product_id"]
					,'Product_name'=>$dong["Product_name"]
					,'Price'=>$dong["Price"]
					,'Image'=>$dong["Small_Image"]
					,'Description'=>$dong["Description"]
					,'Quantity'=>$dong["Quantity"]
					,'Category_id'=>$dong["Category_id"]
					,'TRADEMARK_ID'=>$dong["Trademark_id"]
					,'Percent'=>$percent_discount
					,'COUNT_BUY'=>$dong["Count_buy"]));	
	    		}
	    	}
	    	echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
	    }
	    //get digital information of product
	     function getDigitalInfo()
	    {
	    	global $conn;
	    	if(isset($_POST["product_id"]))
	    	{
	    		$product_id=$_POST["product_id"];
	    	} 
	    	$query="SELECT Name,Value FROM product P,detail_product D WHERE P.Product_id =".$product_id." AND 
	    			P.Product_id=D.Product_id";
	    	$kq=mysqli_query($conn,$query);
	    	$chuoijson=array();
	    	echo "{";
			echo "\"DigitalInfo\":";
	    	if($kq)
	    	{
	    		while ($dong=mysqli_fetch_array($kq)) {
	    			array_push($chuoijson, array("Name"=>$dong["Name"]
					,'Value'=>$dong["Value"]));	
	    		}
	    	}
	    	echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
	    }
	    function getListProductCategories()
	    {
	    	global $conn;
			if(isset($_POST["Category_id"]) || isset($_POST["limit"]))
			{
				$Category_id=$_POST["Category_id"];
				$limit=$_POST["limit"];
			}
			$query="SELECT * FROM product P, categories C WHERE C.Category_id =".$Category_id." AND C.Category_id=P.Category_id ORDER BY P.Count_buy DESC LIMIT ".$limit.",20";
			$kq=mysqli_query($conn,$query);
			$chuoijson=array();
			echo "{";
			echo "\"PRODUCT\":";
			if($kq)
			{
				while($dong=mysqli_fetch_array($kq))
				{
					array_push($chuoijson, array("Product_id"=>$dong["Product_id"]
					,'Product_name'=>$dong["Product_name"]
					,'Price'=>$dong["Price"]
					,'Image'=>"http://".$_SERVER['SERVER_NAME'].":82"."/webpasokon".$dong["Big_Image"]));
					
				}
			}
			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
	    }
	    
	 
?>

