<?php
	  include("../../config.php");

    $fun=$_POST["action"];

    switch ($fun) {
    	case 'getBillDetail':
    		$fun();
    		break;
    	case 'updateBill':
    		$fun();
    		break;
      
    }
    // fun-ajax
    function updateBill()
    {
    	global $conn;
    	$bill_id = $_POST["bill_id"];
		$customer = $_POST["customer_name"];
		$address = $_POST["address"];
		$phone = $_POST["phone"];
		$day_of_purchase = $_POST["day_of_purchase"];
		$delivery_day = $_POST["delivery_day"];
		$status = $_POST["status"];
		$transfer = $_POST["transfer"];
		$array_productID = $_POST["array_productID"];
		$array_productName = $_POST["array_productName"];
		$array_quantity = $_POST["array_quantity"];

		$tamp=count($array_productID);
		$test=false;
		$info="Các sản phẩm sau có số lượng tồn kho không đủ cho hóa đơn: ";
		for($i=0;$i<$tamp;$i++)
		{
			$product_id=$array_productID[$i];
			$quantity=$array_quantity[$i];
			$product_name=$array_productName[$i];

			$inventory_products=get_inventory_products($product_id);
			if($inventory_products<$quantity)
			{
				$info .= "Product name : ".$product_name." - Quantity : ".($inventory_products - $quantity);
				$test = true;
			}
		}

		if(!$test)
		{
			if($status=="wait for censorship" || $status=="complete")
			{
				update_bill_fun($day_of_purchase,$delivery_day,$status,$customer,$phone,$address,$transfer,$bill_id);
				delete_bill_detail($bill_id);

				for ($i=0; $i < $tamp; $i++) { 
					$product_id=$array_productID[$i];
					$quantity=$array_quantity[$i];
					add_bill_detail($bill_id,$product_id,$quantity);
				}

			}else if($status=="cancel")
			{
				for ($i=0; $i < $tamp; $i++) { 
					$product_id=$array_productID[$i];
					$quantity=$array_quantity[$i];
					update_bill_fun($day_of_purchase,$delivery_day,$status,$customer,$phone,$address,$transfer,$bill_id);
					update_inventory_products($product_id,$quantity,true);
				}
			}else if($status=="being delivered")
			{
				for ($i=0; $i < $tamp; $i++) { 
					$product_id=$array_productID[$i];
					$quantity=$array_quantity[$i];
					update_bill_fun($day_of_purchase,$delivery_day,$status,$customer,$phone,$address,$transfer,$bill_id);
					update_inventory_products($product_id,$quantity,false);
				}
			}

		}else{
			echo $info;
		}

    }
    //update bill_fun
    function update_bill_fun($day_of_purchase,$delivery_day,$status,$customer,$phone,$address,$transfer,$bill_id){
		global $conn;
		$query_bill = "UPDATE bill SET Day_of_purchase	='".$day_of_purchase."',Delivery_date='".$delivery_day."', 	Status='".$status."',Name='".$customer."',Phone='".$phone."', Address='".$address."', Transfer='".$transfer."' WHERE Bill_id='".$bill_id."'";
		$result = mysqli_query($conn,$query_bill);
	}
	// delete bill detail
	function delete_bill_detail($bill_id){
		global $conn;
		$query_delete_bill_detail = "DELETE FROM bill_detail WHERE Bill_id='".$bill_id."'";
		mysqli_query($conn,$query_delete_bill_detail);
	}
	// add bill detail
	function add_bill_detail($bill_id,$product_id,$quantity){
		global $conn;
		$query_add_bill_detail = " INSERT INTO bill_detail(Bill_id,Product_id,Quantity) VALUES('".$bill_id."','".$product_id."','".$quantity."')";
		mysqli_query($conn,$query_add_bill_detail);
	}
	//get inventory product 
	function get_inventory_products($product_id){
		global $conn;
		$query = "SELECT * FROM product WHERE Product_id='".$product_id."'";
		$result = mysqli_query($conn,$query);
		$inventory_products = 0;
		if($result){
			while ($line = mysqli_fetch_array($result)) {
				$inventory_products = $line["Quantity"];
			}
		}

		return $inventory_products;
	}
	//update inventory product
	function update_inventory_products($product_id,$quantity,$check){
		global $conn;
		$inventory_products = get_inventory_products($product_id);
		//check true: cancel   false: complete
		if($check){
			$inventory_products += $quantity;
		}else{
			$inventory_products -= $quantity;
		}
 
		$query = "UPDATE product SET Quantity='".$inventory_products."' WHERE Product_id='".$product_id."'";
		mysqli_query($conn,$query);
	}

	//get bill detail 
    function getBillDetail()
    {
    	global $conn;
        $bill_id=$_POST["bill_id"];
        $query="SELECT B.Bill_id,B.Product_id,P.Product_name,B.Quantity FROM bill_detail AS B,product AS P WHERE B.Bill_id='".$bill_id."' AND B.Product_id=P.Product_id";
        $result=mysqli_query($conn,$query);
        if($result)
        {
            while ($dong=mysqli_fetch_array($result)) {
                # code...
                echo '<tr>
                        <th>   
                            Product name: <input type="text" disabled style="margin:5px; padding: 5px; width: 60%" data-productID="'.$dong["Product_id"].'" name="array_SP[]" value="'.$dong["Product_name"].'" >
                        </th>
                        <th>
                            Quantity: <input type="text" disabled style="margin:5px; padding: 5px; width: 60%" data-productID="'.$dong["Product_id"].'" name="array_quantity[]" value="'.$dong["Quantity"].'">
                            <a class="btn btn-primary gonbutton btnAddDigital">Add</a> <a class="btn btn-danger btndelteDigital">Delete</a>    
                        </th>
                    </tr>';
            }
        }
    }
?>