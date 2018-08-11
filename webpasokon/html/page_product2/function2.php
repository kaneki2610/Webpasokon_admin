<?php
    include("../../config.php");

    $fun=$_POST["action"];

    switch ($fun) {
    	case 'AddCategory':
    		$fun();
    		break;
        case 'addProduct':
            $fun();
            break;
    	case 'getCategoryLimit':
            $fun();
            break;
        case 'getProductLimit':
            $fun();
            break;
        case 'deleteCategory':
            $fun();
                break;   
        case 'getPaging':
             $fun();
             break; 
        case 'SearchCategory':
                $fun();
                break;   
        case 'deleteProduct':
                $fun();
                break;   
        case 'getProductDetail_ProductID':
                 $fun();
                break;     
        case 'updateProduct':
                $fun();
                   break;   
        case 'checkLogin':
                $fun();
                   break;          
    	default:
    		# code...
    		break;
    }
    
     function checkLogin()
     {
        global $conn;
        session_start();
        $username=$_POST["username"];
        $password=$_POST["password"];
        $password2=md5($password);
        $missAccount=$_POST["missAccount"];
        $query="SELECT * FROM customer WHERE Email='".$username."' 
            AND Password='".$password2."'";
            
        $result=mysqli_query($conn,$query);

        if($missAccount)
        {
            setcookie("email",$username,time() + (86400 * 30),"/");
            setcookie("pass",$password,time() + (86400 * 30),"/");
        }

        if($result)
        {
            $line=mysqli_num_rows($result);
            if($line>0)
            {
                while ($line=mysqli_fetch_array($result)) {
                    # code...
                     $_SESSION["name"]=$line["Customer_name"];
                     $_SESSION["email"]=$line["Email"];
                     $_SESSION["Customer_id"]=$line["Customer_id"];
                     $_SESSION["KindOfCustomer_id"]=$line["KindOfCustomer_id"];
                      
                }
                echo 1;
               
            }else{
                echo 0;
            }
        }

     }
     function updateProduct()
     { 

        global $conn;
        $product_id=$_POST["product_id"];
        $product_name=$_POST["product_name"];
        $product_price=$_POST["product_price"];
        $category=$_POST["category"];
        $trademark=$_POST["trademark"];
        $quantity=$_POST["quantity"];
        $bigimage=$_POST["bigimage"];
        $smallimg=$_POST["smallimg"];
        $info=$_POST["info"];
        $array_digital_name=$_POST["array_digital_name"];
        $array_digital_value=$_POST["array_digital_value"];
        $array_detail_SP=$_POST["array_detail_SP"];
        $array_digital_name_bonus=$_POST["array_digital_name_bonus"];
        $array_digital_value_bonus=$_POST["array_digital_value_bonus"];
                                  
            $query="UPDATE product SET Product_name='".$product_name."', Price='".$product_price."', Quantity='".$quantity."', Category_id='".$category."', Trademark_id='".$trademark."', Big_Image='".$bigimage."', Small_Image='".$smallimg."', Description='".$info."' WHERE Product_id='".$product_id."'";
                                                    

            $result=mysqli_query($conn,$query);
            if($result)
            {
                    $cc=count($array_detail_SP);
                    for($i=0;$i<$cc;$i++)
                    {
                        $digital_name=$array_digital_name[$i];
                        $digital_value=$array_digital_value[$i];
                        $detail_product_id=$array_detail_SP[$i];
                        $query2="UPDATE detail_product SET Name='".$digital_name."', Value='".$digital_value."' WHERE ID='".$detail_product_id."'";
                       
                        $result2=mysqli_query($conn,$query2);
                          
                    }
                    $cc2=count($array_digital_value_bonus);
                    if($cc2>0)
                    {
                        for($i=0;$i<$cc2;$i++)
                        {
                            $query3="INSERT INTO detail_product(Product_id,Name,Value)
                            VALUES('".$product_id."','".$array_digital_name_bonus[$i]."'
                                ,'".$array_digital_value_bonus[$i]."')";
                            mysqli_query($conn,$query3);
                        }
                      
                    }

                            
                    echo "Add product success";
                    }else{
                        echo "Add product fail!";
                    }
            }
           
           
     
    // ajax
     function getProductDetail_ProductID()
     {
        global $conn;
        $product_id=$_POST["product_id"];
        $query="SELECT *FROM detail_product WHERE Product_id='".$product_id."'";
        $result=mysqli_query($conn,$query);
        if($result)
        {
            while ($dong=mysqli_fetch_array($result)) {
                # code...
                echo '<tr>
                        <th>
                            <input id="array_detailSP" name="array_detailSP[]" class="gonbutton" value="'.$dong["ID"].'" />
                            Digital name: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalname[]" value="'.$dong["Name"].'" >
                        </th>
                        <th>
                            Digital value: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalvalue[]" value="'.$dong["Value"].'">
                            <a class="btn btn-primary gonbutton btnAddDigital">Add</a> <a class="btn btn-danger btndelteDigital">Delete</a>                             
                          
                            
                        </th>
                    </tr>';
            }
        }
     }
    // function ajax
    function addProduct()
    {
        global $conn;
        $product_name=$_POST["product_name"];
        $product_price=$_POST["product_price"];
        $category=$_POST["category"];
        $trademark=$_POST["trademark"];
        $quantity=$_POST["quantity"];
        $bigimage=$_POST["bigimage"];
        $smallimg=$_POST["smallimg"];
        $info=$_POST["info"];
        $array_digital_name=$_POST["array_digital_name"];
        $array_digital_value=$_POST["array_digital_value"];
                                                          
            $query="INSERT INTO product(Product_name,Price,Quantity,Category_id,Trademark_id,Big_Image,Small_Image, Description,Count_buy) VALUES(
            '".$product_name."'
            ,'".$product_price."'
            ,'".$quantity."'
            ,'".$category."'
            ,'".$trademark."'
            ,'".$bigimage."'
            ,'".$smallimg."'
            ,'".$info."',0)";

            $result=mysqli_query($conn,$query);
            //cho mysqli_error($conn);
            $product_id=mysqli_insert_id($conn);
            $cc=count($array_digital_name);
            for($i=0;$i<$cc;$i++)
            {
                $digital_name=$array_digital_name[$i];
                $digital_value=$array_digital_value[$i];
                $query2="INSERT INTO detail_product(Product_id,Name,Value)
                VALUES('".$product_id."','".$digital_name."','".$digital_value."')";
                mysqli_query($conn,$query2);
            }
            if($result)
            {
                echo "Add product success";
            }else{
                echo "Add product fail!";
            }
        
    }
    // function ajax
    function AddCategory()
    {
        global $conn;
    	$category_name=$_POST["category_name"];
        $parent_id=$_POST["parent_id"];

    	$error="Có lỗi thêm dữ liệu";
        $success="<h5 style='color:red'> Add category success </h5>";
        if($category_name=="")
        {
            echo $error;
        }else{
            $query="INSERT INTO categories(Category_name,Parent_id) VALUES
            ('".$category_name."','".$parent_id."')";
            $result=mysqli_query($conn,$query);
            if($result)
            {

                echo $success;
            }else{
                echo $error;    
            }
        }
    }
    //function ajax--category
    function getCategoryLimit()
    {
        global $conn;
        $limit=$_POST["limit"];
        $page=($limit-1)*5;
        $truyvan = "SELECT * FROM categories LIMIT ".$page.",5";
        $ketqua = mysqli_query($conn,$truyvan);
        if($ketqua){
            while ($dong = mysqli_fetch_array($ketqua)) {
                echo "<tr>";
                echo '<th><div class="checkbox3 checkbox-round checkbox-check checkbox-light">
                                <input name="chk-mamg[]" data-id="'.$dong["Category_id"].'" type="checkbox" id="chkSelect-'.$dong["Category_id"].'">
                                <label for="chkSelect-'.$dong["Category_id"].'"></label>
                            </div></th>';
                echo '<th>'.$dong["Category_id"].'</th>';           
                echo '<th>'.$dong["Category_name"].'</th>';
                echo '<th>'.$dong["Parent_id"].'</th>';
                echo "</tr>";
            }
        }
    }
     //function ajax--product
    function getProductLimit()
    {
        global $conn;
        $limit = ($_POST["page_number"]-1)*10;
        $truyvan = "SELECT * FROM product P, categories C , trademark T WHERE P.Category_id=C.Category_id AND P.Trademark_id=T.Trademark_id LIMIT ".$limit.",10";
        $ketqua = mysqli_query($conn,$truyvan);

        if($ketqua){
            while ($dong = mysqli_fetch_array($ketqua)) {
                
                echo "<tr>";
                echo '<th class="gonbutton" dataSmallImage="'.$dong["Small_Image"].'"></th>';
                echo '<th class="gonbutton" dataInfo="'.$dong["Description"].'"</th>';
                echo '<th dataBigImage="'.$dong["Big_Image"].'"><img style="width:50px; height:50px" src="..'.$dong["Big_Image"].'"</img></th>';
                echo '<th dataName="'.$dong["Product_name"].'">'.$dong["Product_name"].'</th>';
                echo '<th dataCate="'.$dong["Category_id"].'">'.$dong["Category_name"].'</th>';
                echo '<th dataTra="'.$dong["Trademark_id"].'">'.$dong["Trademark_name"].'</th>';
                echo '<th dataPrice="'.$dong["Price"].'">'.$dong["Price"].'</th>';
                echo '<th dataSL="'.$dong["Quantity"].'">'.$dong["Quantity"].'</th>';
                echo '<th dataID='.$dong["Product_id"].'><a class ="btn btn-success btn-edit">Edit</a> <a class ="btn btn-danger btn-delete">Delete</a> </th';
                echo "</tr>";
            }
        }
    }
    // function ajax
    function getPaging()
    {
        global $conn;
        $truyvan = "SELECT * FROM categories";
        $ketqua =mysqli_query($conn,$truyvan);
        $total_page=ceil(mysqli_num_rows($ketqua)/5);
        
        echo '
                         <li>
                             <a href="#" aria-label="Previous">
                                     <span aria-hidden="true">&laquo;</span>
                             </a>
                          </li>';
        for($i=1;$i<=$total_page;$i++)
        {
            if($i==1)
            {
                echo '<li class="active"><a href="#">'.$i.'</a></li>';
            }else{
                echo '<li><a href="#">'.$i.'</a></li>';
            }
                
            
            

        }

        echo ' <li>
                              <a href="#" aria-label="Next">
                                      <span aria-hidden="true">&raquo;</span>
                              </a>
                         </li> ';      
                                      
        
    }
        // function ajax
       function deleteCategory()
    {
        global $conn;
        $array_chkbox=$_POST["array_chkbox"];
        $kt=false;
        for($i=0;$i<count($array_chkbox);$i++)
        {
            recursive_category($array_chkbox[$i]);
            deleteTable_relationship_category($array_chkbox[$i]);
           
        }
       
        
     }   
     //đệ quy xóa category_child 
     function recursive_category($Category_id)
     {
            global $conn;
             $query="SELECT * FROM categories WHERE Parent_id=".$Category_id;
             $result=mysqli_query($conn,$query);
             $category_id=0;
             if($result)
             {
                while ($dong=mysqli_fetch_array($result)) {
                    # code...
                    $category_id=$dong["Category_id"];
                    deleteTable_relationship_category($Category_id);
                    recursive_category($Category_id);
                }
             }else{

             }
     }

     //delete table có quan hệ vs category
     function deleteTable_relationship_category($Category_id)
     {  
        getProduct($Category_id);
        deleteDetail_trademark($Category_id);
        deleteDiscount_Detail($Category_id);
        deleteDiscount($Category_id);
        deleteCategory_Category_id($Category_id);

     }
     //delete category 
      function deleteCategory_Category_id($Category_id)
     {
            global $conn;
            $query="DELETE FROM categories WHERE Category_id=".$Category_id;
            mysqli_query($conn,$query);
     }

     // delete detail_trademark
     function deleteDetail_trademark($Category_id)
     {
            global $conn;
            $query="DELETE FROM detail_trademark WHERE Category_id=".$Category_id;
            mysqli_query($conn,$query);
     }
     // delete discount
     function deleteDiscount($Category_id)
     {
             global $conn;
             $query="DELETE FROM discount WHERE Category_id=".$Category_id;
             mysqli_query($conn,$query);
     }
     //delete discount_detail`
     function deleteDiscount_Detail($Category_id)
     {
             global $conn;
             $query="SELECT * FROM discount WHERE Category_id=".$Category_id;
             $result=mysqli_query($conn,$query);
             $Discount_id=0;
             if($result)
             {
                while ($dong=mysqli_fetch_array($result)) {
                    # code...
                    $Discount_id=$dong["Discount_id"];
                     $query1="DELETE FROM discount_detail WHERE Discount_id=".$Discount_id;
                     mysqli_query($conn,$query1);
                }
             }else{

             }
     }


     // get Product_id
     function getProduct($Category_id)
     {
             global $conn;
             $query="SELECT * FROM product WHERE Category_id=".$Category_id;
             $result=mysqli_query($conn,$query);
             $Product_id=0;
             if($result)
             {
                while ($dong=mysqli_fetch_array($result)) {
                    # code...
                    $Product_id=$dong["Product_id"];
                    deleteDiscount_detail_Product_id($Product_id);
                    deleteProduct_detail($Product_id);
                    deleteBill_detail($Product_id);
                    deleteEvaluate($Product_id);
                }
                
                $query1="DELETE FROM product WHERE Category_id=".$Category_id;
                mysqli_query($conn,$query1);
            }else{

            }
     }
     // delete discount_detail
     function deleteDiscount_detail_Product_id($Product_id)
     {
            global $conn;
            $query="DELETE FROM discount_detail WHERE Product_id=".$Product_id;
            mysqli_query($conn,$query);
     }
     //delete product_detail
     function deleteProduct_detail($Product_id)
     {
            global $conn;
            $query="DELETE FROM detail_product WHERE Product_id=".$Product_id;
            mysqli_query($conn,$query);
     }
     //delete bill_detail
     function deleteBill_detail($Product_id)
     {
            global $conn;
            $query="DELETE FROM bill_detail WHERE Product_id=".$Product_id;
            mysqli_query($conn,$query);
    }
    //delete evaluate
    function deleteEvaluate($Product_id)
     {
            global $conn;
            $query="DELETE FROM evaluate WHERE Product_id=".$Product_id;
            mysqli_query($conn,$query);
    }

    //search category-ajax
    function SearchCategory()
    {
        global $conn;
        $name=$_POST["name"];
        $truyvan = "SELECT * FROM categories WHERE Category_name 
        LIKE '%".$name."%'";
        $ketqua = mysqli_query($conn,$truyvan);
        if($ketqua){
            while ($dong = mysqli_fetch_array($ketqua)) {
                echo "<tr>";
                echo '<th><div class="checkbox3 checkbox-round checkbox-check checkbox-light">
                                <input name="chk-mamg[]" data-id="'.$dong["Category_id"].'" type="checkbox" id="chkSelect-'.$dong["Category_id"].'">
                                <label for="chkSelect-'.$dong["Category_id"].'"></label>
                            </div></th>';
                echo '<th>'.$dong["Category_id"].'</th>';           
                echo '<th>'.$dong["Category_name"].'</th>';
                echo '<th>'.$dong["Parent_id"].'</th>';
                echo "</tr>";
            }
        }
    }
    //function ajax- delete product
    function deleteProduct()
    {
            global $conn;
            $flag=0;
            $Product_id=$_POST["Product_id"];
            if(deleteDiscount_detail_Product_id($Product_id))
            {
                $flag=1;
            }else{
                $flag=0;
            }
            if(deleteProduct_detail($Product_id))
            {
                $flag=1;
            }else{
                $flag=0;
            }
            if(deleteBill_detail($Product_id))
            {
                $flag=1;
              
            }else{
                
                $flag=0;
            }
            if(deleteEvaluate($Product_id)){
                $flag=1;
            }else{
                $flag=0;
            }
             
              $query="DELETE FROM product WHERE Product_id=".$Product_id;
              $result=mysqli_query($conn,$query);
              if($result)
              {
                    $flag=1;
              }else{
                    $flag=0;
              }
              echo mysqli_error($conn);
              echo $flag;
            
            

    }
?>