<?php
	include_once("config.php"); 	
	$fun=$_POST["fun"];
	switch ($fun) {
		case 'addEvaluate':
			$fun();
			break;
		case 'showEvaluate':
			$fun();
			break;	
	
	}
	function addEvaluate()
	{
		global $conn;
		$EVALUATION_DATE=date("d/m/Y");
		if(isset($_POST["EVALUATE_ID"])||isset($_POST["Product_id"])||isset($_POST["TITLE"])||isset($_POST["CONTENT"])|| isset($_POST["DEVICE_NAME"])|| isset($_POST["NUMBER_STAR"]))
		{
				$EVALUATE_ID=$_POST["EVALUATE_ID"];
				$Product_id=$_POST["Product_id"];
				$TITLE=$_POST["TITLE"];
				$CONTENT=$_POST["CONTENT"];
				$DEVICE_NAME=$_POST["DEVICE_NAME"];
				$NUMBER_STAR=$_POST["NUMBER_STAR"];
		}


		$query="INSERT INTO evaluate (Evaluate_id,Product_id,Title,Content,Device_name
		,Evaluation_date,Number_star) 
		VALUES('".$EVALUATE_ID."'
				,'".$Product_id."'
				,'".$TITLE."'
				,'".$CONTENT."'
				,'".$DEVICE_NAME."'
				,'".$EVALUATION_DATE."'
				,'".$NUMBER_STAR."')";
		
	    if(mysqli_query($conn, $query))
	    {
	    	echo "{result:true}";

	    }else{
	    	echo "{result:false}";
	    }
	    mysqli_close($conn);
	}
	function showEvaluate()
	{
		  global $conn;	
		  if(isset($_POST["Product_id"]) || isset($_POST["limit"]))
			{
				$Product_id=$_POST["Product_id"];
				$limit=$_POST["limit"];
			}
			$query="SELECT * FROM evaluate  WHERE Product_id =".$Product_id." ORDER BY Evaluation_date LIMIT ".$limit.",10";
			$kq=mysqli_query($conn,$query);
			$chuoijson=array();
			echo "{";
			echo "\"LIST Evaluate\":";
			if($kq)
			{
				while($dong=mysqli_fetch_array($kq))
				{
					array_push($chuoijson, array("EVALUATE_ID"=>$dong["Evaluate_id"]
					,'Product_id'=>$dong["Product_id"]
					,'TITLE'=>$dong["Title"]
					,'DEVICE_NAME'=>$dong["Device_name"]
					,'CONTENT'=>$dong["Content"]
					,'NUMBER_STAR'=>$dong["Number_star"]
					,'EVALUATION_DATE'=>$dong["Evaluation_date"]));
					
				}
			}
			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";

	}
?>