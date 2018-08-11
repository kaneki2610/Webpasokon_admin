<?php 
	$file_id = "";
	if(isset($_FILES["big_img"])){

		$file_id = $_FILES["big_img"];

	}else if(isset($_FILES["small_img"])){
		$file_id = $_FILES["small_img"];
	}

	$file_dir = "../product_image/";
	$filename = $file_id["name"];
	$file_tmp = $file_id["tmp_name"];
	
	if(move_uploaded_file($file_tmp, $file_dir.$filename)){
		$output = array("Upload thành công");
	}else{
		$output = array("Upload thất bại");
	}

	echo json_encode($output);
?>