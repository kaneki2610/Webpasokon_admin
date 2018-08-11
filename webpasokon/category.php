
	<?php
	  include_once("config.php"); 	
	 // $parent_id=$_GET["parent_id"];
	  $parent_id=$_POST["parent_id"];
	  $truyvan="SELECT *FROM categories WHERE Parent_id=".$parent_id;
	  $ketqua=mysqli_query($conn,$truyvan);
	  $chuoi_json=array();
	  echo "{";
	  echo "\"Category\":";
	  if($ketqua)
	  {
		  	 while($dong=mysqli_fetch_array($ketqua))
		  {
		  	   //cách 1:
		  		//$chuoi_json[]=$dong;
  
		  	   //cách 2:
		  	    array_push($chuoi_json, array('Category_id'=>$dong["Category_id"],'Category_name'=>$dong["Category_name"],"Parent_id"=>$dong["Parent_id"]));	
		  }
	  	echo json_encode($chuoi_json,JSON_UNESCAPED_UNICODE);
	  }
	  echo "}";
?>

