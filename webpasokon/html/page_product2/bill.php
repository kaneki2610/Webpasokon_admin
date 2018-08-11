	
<div>
	<a class="btn-displayBill btn btn-success">
		<span class="glyphicon glyphicon-plus"></span> Add bill 
	</a>
	<a class="btn-displayListBill  btn btn-success">
			<span class="glyphicon glyphicon-th-list"></span>  List bills 
	</a>
</div>

	<div class="displayBill" >
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
						<th>Customer</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Day_of_purchase</th>
						<th>Delivery_day</th> 
						<th>Status</th>
						<th>Transfer</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody> 
						<?php 
							getListBill();
						?>
				</tbody>
			</table>
				
				
		</div>
	</div> 
	<div class="col-product gonbutton addBill">
		<div class="page-title form-style">
			<div class="description"></div>
				<table>

					<tr>
						<th>
							<label for="edtCustomer">Customer</label>
							<input type="text" class="form-control" id="edtCustomer" placeholder="Input customer name">	
							<span class="name_error"></span>
						</th>
						<th>
							<label for="edtAddress">Address</label>
							<input type="text" class="form-control" id="edtAddress" placeholder="Input address ">	
						</th>
						
					</tr>
					<tr>
						<th>
							<label for="edtPhone">Phone</label>
							<input type="number" class="form-control" id="edtPhone" placeholder="Input phone ">	
						</th>
						<th>
							<label for="edtTranfercode">Tranfer code (if have)</label>
							<input type="text" class="form-control" id="edtTranfercode" placeholder="Input tranfer code ">	
						</th>
					</tr>
					<tr>
						<th>
							<label for="edtNM">Day_of_purchase</label>
							<input type="text" class="form-control" id="edtNM" placeholder="Input Day_of_purchase ">	
						</th>
						<th>
							<label for="edtNG">Delivery_day</label>
							<input type="text" class="form-control" id="edtNG" placeholder="Input Delivery_day ">	
						</th>
					</tr>
					<tr>
						<th>
							<label for="status_biil">Status</label>
							<select id="status_biil">
								<optgroup>
									<option value="wait for censorship">wait for censorship</option>
									<option value="cancel">cancel</option>
									<option value="being delivered">being delivered</option>
									<option value="complete">complete</option>
								</optgroup>
							</select>
						</th>
						<th>
							<label for="tranfer">Tranfer</label>
							<select id="tranfer">
								<option value="1">paid</option>
								<option value="0">unpaid</option>
							</select>
						</th>
					</tr>

					<tr>
						<th colspan="2">
							<h3>Bill detail</h3>
							<div>
								<label>List product</label>
								<select id="selectProductName">
									<?php
										 getListProduct();
									?>
								</select>
								<input type="number" min="0" value="1" name="" id="edtQuantity">
								<a class="btn btn-success btnAddBillDetail">Add bill detail</a>
							</div>
							
							<div id="container_bill">
								
								<table>
									<tbody>
										
									</tbody>
								</table>
							</div>
							
						</th>
					</tr>
					

				</table>
				
				
				<br>
				<input type="button" id="btnAddBill" value="Add" class="btn btn-success">
				<input type="button" id="btnUpdateBill" value="Update" class="btn btn-success gonbutton">
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
	
	function getListProduct()
	{
		global $conn;
		$truyvan = "SELECT * FROM product";
		$ketqua = mysqli_query($conn,$truyvan);
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				echo "<option value='".$dong["Product_id"]."'>".$dong["Product_name"]."</option>";
			}
		}
	}
	
	function getListBill()
	{
		global $conn;
		$truyvan = "SELECT * FROM bill LIMIT 0,10";
		$ketqua = mysqli_query($conn,$truyvan);

		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				$transfer=$dong["Transfer"]!=null && $dong["Transfer"]!='0' ? 'paid' : 'unpaid';
				echo "<tr>";
				echo '<th dataCustomer="'.$dong["Name"].'">'.$dong["Name"].'</th>';
				echo '<th dataAddress="'.$dong["Address"].'">'.$dong["Address"].'</th>';
				echo '<th dataPhone="'.$dong["Phone"].'">'.$dong["Phone"].'</th>';
				echo '<th dataNM="'.$dong["Day_of_purchase"].'">'.$dong["Day_of_purchase"].'</th>';
				echo '<th dataNG="'.$dong["Delivery_date"].'">'.$dong["Delivery_date"].'</th>';
				echo '<th dataStatus="'.$dong["Status"].'">'.$dong["Status"].'</th>';
				echo '<th dataTransfer='.$dong["Transfer"].'>'.$transfer.'</th>';
				echo '<th data_id="'.$dong["Bill_id"].'"><a class="btn btn-success btn_updatebill">Update</a>
						  <a class="btn btn-warning btn_deletebill">Delete</a></th>';
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
	
?>

 