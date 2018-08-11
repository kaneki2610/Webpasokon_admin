$(document).ready(function(){
	$(".btn-displayBill").click(function()
	{	
		$("#btnUpdateBill").addClass("gonbutton");
		$("#btnAddBill").removeClass("gonbutton");
		DisplayBill();
	});
	function DisplayBill()
	{
		$(".addBill").removeClass("gonbutton");
		$(".displayBill").fadeOut();
		$(".addBill").fadeIn();
	}
	function DisplayListBill()
	{
		$(".displayBill").fadeIn();
		$(".addBill").fadeOut();
	}
	$(".btn-displayListBill").click(function()
	{
		DisplayListBill();
	});
	// process button update of line bill
	$("body").delegate(".btn_updatebill","click",function(){
		DisplayBill();
		$("#btnUpdateBill").removeClass("gonbutton");
		$("#btnAddBill").addClass("gonbutton");
		transfer=0;
		bill_id=$(this).parent().attr("data_id");
		$("#btnUpdateBill").attr("data_id",bill_id);
		$(this).closest("tr").find("th").each(function(){
			if($(this).attr("dataCustomer")){
				customer=$(this).attr("dataCustomer");
			}else if($(this).attr("dataAddress")){
				address=$(this).attr("dataAddress");
			}else if($(this).attr("dataPhone")){
				phone=$(this).attr("dataPhone");
			}else if($(this).attr("dataNM")){
				day_of_purchase=$(this).attr("dataNM");
			}else if($(this).attr("dataNG")){
				delivery_day=$(this).attr("dataNG");
			}else if($(this).attr("dataTransfer")){
				transfer=$(this).attr("dataTransfer");
			}else  if($(this).attr("dataStatus")){
				status=$(this).attr("dataStatus");
			}
		});
		    $("#edtCustomer").val(customer);
			$("#edtAddress").val(address);
			$("#edtPhone").val(phone);
			$("#edtNM").val(day_of_purchase);
			$("#edtNG").val(delivery_day);
			$("#status_biil").val(status).trigger("change");
			$("#tranfer").val(transfer).trigger("change");
			$.ajax({
				url : "../html/page_product2/funbill.php",
				type : "POST",
				data : {
					action: "getBillDetail",
					bill_id : bill_id
					
				},
				success:function(data){
					$("#container_bill").find("tbody").prepend(data);
				} 
			});
		
	});
	//add bill detail 
	$(".btnAddBillDetail").click(function(){
	
		product_id=$("#selectProductName").val();
		product_name=$("#selectProductName :selected").text();
		quantity=$("#edtQuantity").val();
		check=false;
		$("input[name='array_quantity[]']").each(function(){
			
			if($(this).attr("data-productID")==product_id){
				
				quantity = parseInt(quantity) + parseInt($(this).val());
				$(this).val(quantity);
				check = true;
				
			}
		});
		var content = '<tr><th>Product name : <input name="array_SP[]" data-productID="'+product_id+'" value="'+product_name+'" style="margin:5px; padding:5px; width:60%"  disabled type="text"  /></th><th>Quantity : <input data-productID="'+product_id+'" name="array_quantity[]"  disabled value="'+quantity+'" style="margin:5px; padding:5px; width:60%" type="text"  /><a class="btn btn-danger btnDeleteBillDetail">Delete</a></th></tr>';
			
			if(!check)
			{
				$("#container_bill").find("tbody").append(content);

			}
			
		
		
	});
	// delete bill detail
	$("body").delegate(".btnDeleteBillDetail","click",function()
	{
		$(this).closest("tr").remove();
	});
	// update bill and product quantity
	$("#btnUpdateBill").click(function()
	{ 		
			bill_id=$(this).attr("data_id");
			customer_name=$("#edtCustomer").val();
			address=$("#edtAddress").val();
			phone=$("#edtPhone").val();
			day_of_purchase=$("#edtNM").val();
			delivery_day=$("#edtNG").val();
			status=$("#status_biil").val();
			transfer=$("#tranfer").val();

			var array_productID = [];
			var array_productName = [];
			$("input[name='array_SP[]']").each(function(){
				var value = $.trim($(this).attr("data-productID"));
				var product_name = $.trim($(this).val());
				if(value.length > 0){
					array_productID.push(value);
					array_productName.push(product_name);
				}
				
			});

			var array_quantity = [];
			$("input[name='array_quantity[]']").each(function(){
				var value = $.trim($(this).val());

				if(value.length > 0){
					array_quantity.push(value);
					
				}
				
			});

			$.ajax({
				url : "../html/page_product2/funbill.php",
				type : "POST",
				data : {
					action: "updateBill",
					bill_id : bill_id,
					customer_name :customer_name,
					address :address,
					phone :phone,
					day_of_purchase :day_of_purchase,
					delivery_day :delivery_day,
					status :status,
					transfer :transfer,
					array_productID :array_productID,
					array_productName :array_productName,
					array_quantity :array_quantity,
				},
				success:function(data){
					alert(data);
					//$("#container_bill").find("tbody").prepend(data);
				} 
			});
	});
});