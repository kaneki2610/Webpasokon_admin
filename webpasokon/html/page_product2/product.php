	

	
	<div>
		<a class="btn-displayProduct btn btn-success">
			<span class="glyphicon glyphicon-plus"></span> Add product 
		</a>
		<a class="btn-displayListProduct  btn btn-success">
				<span class="glyphicon glyphicon-th-list"></span>  List product 
		</a>
	</div>

	<div class="displayProduct" >
		<div class="card">
			<!-- search -->
			<div id="col-right2">
				<table id="tb-search">
					<tr>
						<td><input type="text" class="form-control" id="txtNameProduct" placeholder="Input product name"/></td>
						<td><button id="btnSearchProduct" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button></td>

					</tr>
				</table>
			</div>
			<table class="table1">
				<thead>
					<tr>
						<th>Image</th>
						<th>Product_name</th>
						<th>Category_name</th>
						<th>Trademark</th>
						<th>Price</th> 
						<th>Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> 
					<?php
							getProductLimit(0);
						?>
				</tbody>
			</table>
				<div style="text-align: center" id="paging_product22" data_totalpage=<?php getTotalPage() ?>>
					
				</div>
				
		</div>
	</div> 
	<div class="col-product gonbutton addProduct ">
		<div class="page-title form-style">
			<div class="description"></div>
				<table>

					<tr>
						<th>
							<label for="edtCNameProduct">Product name</label>
							<input type="text" class="form-control" id="edtCNameProduct" placeholder="Input product name">	
							<span class="name_error"></span>
						</th>
						<th>
							<label for="edtPrice">Price</label>
							<input type="number" class="form-control" id="edtPrice" placeholder="Input product price">	
						</th>
					</tr>

					<tr>
						<th>
							<label>Category</label><br> 
							<select id="chkCategory">
									<optgroup label="Category_name">
									
										<?php
											getCategory();
										?>
										
									</optgroup>
									
							</select>
						</th>
						<th>
							<label for="edtSL">Quantity</label>
							<input type="number" class="form-control" id="edtSL" placeholder="Input product quantity">	
						</th>
					</tr>
					<tr>
						<th>
							<label for="chkTrademark">Trademark</label><br> 
							<select id="chkTrademark">
									<optgroup label="Trademark">
										
										<?php
											getTrademark();
										?>
										
									</optgroup>
									
							</select>
						</th>
						<th rowspan="2">
							<label for="edtInfo">Information</label>
							<textarea rows="10" class="form-control" id="edtInfo"></textarea>
						</th>
					</tr>	
					<tr>
						<th id="container_big">	
							<label for="big_img">Big image</label>
							<div class="form-group">
	                   		 <input id="big_img" name="big_img" class="file" type="file" data-preview-file-type="any" data-upload-url="uploadimage.php">

	               			 </div>
						</th>	

					</tr>	
					 <tr>
						<th id="container_small">	
							<label for="small_img">Small image</label>
							<div class="form-group">
	                   		 <input id="small_img" name="small_img" class="file" type="file"multiple data-preview-file-type="any" 
	                   		 data-upload-url="uploadimage.php">

	               			 </div>
						</th>	
						
					</tr>
					<tr>
						<th>
							<h3>Digital Infomation</h3>
							<div id="container_digital">
								
								<table>
									<tr>
										<th>
											Digital name: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalname[]">
										</th>
										<th>
											Digital value: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalvalue[]">
											                             

											
										</th>
										<th>
											<a class="btn btn-primary btnAddDigital">Add</a> 
											<a class="btn btn-danger gonbutton btndelteDigital">Delete</a>         
										</th>
									</tr>
								</table>
							</div>
							
						</th>
					</tr>
					

				</table>
				
				
				<br>
				<a class="btn-displayBill btn btn-success" id="btnAddProduct">
					<span class="glyphicon glyphicon-plus"></span> Add 
				</a>
				<!-- <input type="button" id="btnAddProduct" value="Add" class="btn btn-success"> -->
				<input type="button" id="btnUpdateProduct" value="Update" class="btn btn-success" >
				<div class="alert_error"></div>
				<div class="gonClass">
					<table>
							<tr>
								<th>
									Digital name: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalname[]">
								</th>
								<th>
									Digital value: <input type="text" style="margin:5px; padding: 5px; width: 60%" name="arraydigitalvalue[]">
									                             

									
								</th>
								<th>
									<a class="btn btn-primary  btnAddDigital">Add</a> 
									<a class="btn btn-danger gonbutton btndelteDigital">Delete</a>         
								</th>
							</tr>
						</table>
				</div>
		</div> 
	</div>

	
	
	


<?php
	
	//get trademark
	function getTrademark()
	{
		global $conn;
		$truyvan = "SELECT * FROM trademark";
		$ketqua = mysqli_query($conn,$truyvan);
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				echo "<option value='".$dong["Trademark_id"]."'>".$dong["Trademark_name"]."</option>";
			}
		}
	}
	function getCategory()
	{
		global $conn;
		$truyvan = "SELECT * FROM categories";
		$ketqua = mysqli_query($conn,$truyvan);
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				echo "<option value='".$dong["Category_id"]."'>".$dong["Category_name"]."</option>";
			}
		}
	}
	function getProductLimit($limit)
	{
		global $conn;
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
				echo '<th dataID='.$dong["Product_id"].'><a class ="btn btn-success btn-edit"><span class="glyphicon glyphicon-pencil"></span> Edit </a> 
				<a class ="btn btn-danger btn-delete"><span class="glyphicon glyphicon-trash"></span>  Delete</a> </th';
				echo "</tr>";
			}
		}
	}
	function getTotalPage()
	{
		global $conn;
		$truyvan = "SELECT * FROM product";
		$ketqua =mysqli_query($conn,$truyvan);
		$total_page=ceil(mysqli_num_rows($ketqua)/10);
		echo $total_page;
	}
	/*function getPaging()
	{
		global $conn;
		$truyvan = "SELECT * FROM product";
		$ketqua =mysqli_query($conn,$truyvan);
		$total_page=ceil(mysqli_num_rows($ketqua)/10);
		
		echo ' <nav> 
				<ul class="pagination paging_P">
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
                         </li>
                    </ul>
                    </nav>';                         
		
	}*/
?>

