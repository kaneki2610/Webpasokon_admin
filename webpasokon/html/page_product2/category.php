	
<div class="row">
	<div id="col-left1" class="col-sm-6 col-lg-6">
		<div class="page-title form-style">
			<span class="title">Category</span>
				</br>
			
				<label for="edtCName">Category name</label>
				<input type="text" class="form-control" id="edtCName" placeholder="Input category name">	
				<label >Parent id</label><br> 
				<select id="chkPa">
					<optgroup label="Category_name">
						<option value="0">Không</option>
						<?php
							getCategory();
						?>
						
					</optgroup>
					
				</select>
				<br>
				<a class="btn btn-success" id="btnAdd">
						<span class="glyphicon glyphicon-plus"></span> Add  
				</a>
				<!-- <input type="button" id="btnAdd" value="Add" class="btn btn-success"> -->
				<div class="alert_error"></div>
		</div> 
	</div>

	<div id="col-right1" class="col-sm-6 col-lg-6">
		<div class="card">
			<!-- delete -->
			<a class="btn btn-danger" id="btnDeP">
						<span class="glyphicon glyphicon-trash"></span>    Delete  
				</a>
			<!-- <input type="button" class="btn btn-danger" id="btnDeP" value="Delete"> -->
			<!-- search -->
			<div id="col-right2">
				<table id="tb-search">
					<tr>
						<td><input type="text" class="form-control" id="txtNameP" placeholder="Input category name"/></td>
						<td><button id="btnSearch" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button></td>

					</tr>
				</table>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>
							<div class="checkbox3 checkbox-round checkbox-check checkbox-light">
								<input type="checkbox" id="chkSelect" value="Add">
								<label for="chkSelect">All</label>
							</div>
						</th>
						<th>STT</th>
						<th>Category_name</th>
						<th>Parent_id</th>
					</tr>
				</thead>
				<tbody> 
					<?php
							getCategoryLimit(0);
						?>
				</tbody>
			</table>
					<?php
							getPaging();
						?>
		</div>
	</div> 

	
</div>
	
	
	


<?php
	
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
	function getCategoryLimit($limit)
	{
		global $conn;
		$truyvan = "SELECT * FROM categories LIMIT ".$limit.",5";
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
	function getPaging()
	{
		global $conn;
		$truyvan = "SELECT * FROM categories";
		$ketqua =mysqli_query($conn,$truyvan);
		$total_page=ceil(mysqli_num_rows($ketqua)/5);
		
		echo ' <nav> 
				<ul class="pagination">
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
		
	}
?>

