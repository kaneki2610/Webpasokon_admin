<?php
	include("../../config.php");
	  $fun=$_POST["action"];

    switch ($fun) {
    	case 'AddAccount':
    		$fun();
    		break;
    	}
     // function ajax
    function AddAccount()
    {
        global $conn;
        $name=$_POST["customer_name"];
        $email=$_POST["email"];
        $pass=$_POST["password"];
        $address=$_POST["address"];
        $date_of_birth=$_POST["date_of_birth"];
        $phone=$_POST["phone"];
        $kindOfCustomer_id=$_POST["kindOfCustomer_id"];
       	
       	$pass2=md5($pass);
                                                          
            $query="INSERT INTO customer(Customer_name,Email,Password,Address,Date_of_birth,Phone,KindOfCustomer_id) VALUES(
            '".$name."'
            ,'".$email."'
            ,'".$pass2."'
            ,'".$address."'
            ,'".$date_of_birth."'
            ,'".$phone."'
            ,'".$kindOfCustomer_id."')";

            $result=mysqli_query($conn,$query);
            //cho mysqli_error($conn);
          
           if($result)
           {
           		echo "Thêm tài khoản thành công";
           }else{
           		echo "Thêm tài khoản thất bại";
           }
        
    }
?>