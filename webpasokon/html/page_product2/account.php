	
<div>
	<a class="btn-displayAccount btn btn-success">
		<span class="glyphicon glyphicon-plus"></span> Thêm nhân viên 
	</a>
	<a class="btn-displayListAccount  btn btn-success">
			<span class="glyphicon glyphicon-th-list"></span>  Danh sách nhân viên
	</a>
</div>

	<div class="displayAccount" >
		<div class="card">
			<!-- search -->
			<div id="col-right2">
				<table id="tb-search">
					<tr>
						<td><input type="text" class="form-control" id="txtNameA" placeholder="Input name"/></td>
						<td><button id="btnSearchAccount" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button></td>

					</tr>
				</table>
			</div>
			<table class="table1">
				<thead>
					<tr>
						<th>Tên</th>
						<th>Email</th>
						
						<th>Địa chỉ</th>
						<th>Ngày sinh</th> 
						<th>Số điện thoại</th>
						<th>Loại</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody> 
						<?php 
							getListAccount();
						?>
				</tbody>
			</table>
				
				
		</div>
	</div> 
	<div class="col-product gonbutton addAccount">
		<div class="page-title form-style">
			<div class="description"></div>
				<table>

					<tr>
						<th>
							<label for="edtNameNV">Tên nhân viên</label>
							<input type="text" class="form-control" id="edtNameNV" placeholder="Nhập tên nhân viên">	
							<p id="statusName" style="color: red"></p>
						</th>
						<th>
							<label for="edtEmailNV">Email</label>
							<input type="text" class="form-control" id="edtEmailNV" placeholder="Nhập email ">	
							<p id="statusEmail" style="color: red"></p>
						</th>
						
					</tr>
					<tr>
						<th>
							<label for="edtPhoneNV">Số điện thoại</label>
							<input type="number" class="form-control" id="edtPhoneNV" placeholder="Nhập số điện thoại " maxlength="11">	
						</th>
						<th>
							<label for="edtAddressNV">Địa chỉ</label>
							<input type="text" class="form-control" id="edtAddressNV" placeholder="Nhập đỉa chỉ ">	
						</th>
					</tr>
					<tr>
						
						<th>
							<label for="edtNS">Ngày sinh</label>
							<input type="date" class="form-control" id="edtNS" placeholder="Nhập ngày sinh ">	
						</th>
					</tr>
					

		
					

				</table>
				
				
				<br>
				<input type="button" id="btnAddAccount" value="Add" class="btn btn-success">
				<input type="button" id="btnUpdateAccount" value="Update" class="btn btn-success gonbutton">
				<div class="alert_error"></div>
				
		</div> 
	</div>

	
	
	


<?php
	
	
	
	function getListAccount()
	{
		global $conn;
		$truyvan = "SELECT * FROM customer AS C,kindofcustomer AS K WHERE
		C.KindOfCustomer_id=K.KindOfCustomer_id ";
		$ketqua = mysqli_query($conn,$truyvan);

		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
				
				echo "<tr>";
				echo '<th dataName="'.$dong["Customer_name"].'">'.$dong["Customer_name"].'</th>';
				echo '<th dataEmail="'.$dong["Email"].'">'.$dong["Email"].'</th>';
				echo '<th dataAddress="'.$dong["Address"].'">'.$dong["Address"].'</th>';
				echo '<th dataNS="'.$dong["Date_of_birth"].'">'.$dong["Date_of_birth"].'</th>';
				echo '<th dataPhone="'.$dong["Phone"].'">'.$dong["Phone"].'</th>';
				echo '<th dataKind="'.$dong["KindOfCustomer_name"].'">'.$dong["KindOfCustomer_name"].'</th>';
				echo '<th data_id="'.$dong["Customer_id"].'"><a class="btn btn-info btn_updateAccount">Update</a>
						  <a class="btn btn-danger btn_deleteAccount">Delete</a></th>';
				echo "</tr>";
			}
		}
	}
	
	
	
?>

 