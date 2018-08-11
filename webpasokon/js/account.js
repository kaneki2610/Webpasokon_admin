$(document).ready(function(){

	$(".btn-displayAccount").click(function()
	{	
		/*$("#btnUpdateBill").addClass("gonbutton");
		$("#btnAddBill").removeClass("gonbutton");*/
		DisplayBill();
	});
	function DisplayBill()
	{
		$(".addAccount").removeClass("gonbutton");
		$(".displayAccount").fadeOut();
		$(".addAccount").fadeIn();
	}
	function DisplayListBill()
	{
		$(".displayAccount").fadeIn();
		$(".addAccount").fadeOut();
	}
	$(".btn-displayListAccount").click(function()
	{
		DisplayListBill();
	});
			//-------------------Add account for employee--------------------------
	$("#btnAddAccount").click(function(){
		var name=$.trim($("#edtNameNV").val());
		var email=$.trim($("#edtEmailNV").val());
		var pass=123;
		var address=$("#edtAddressNV").val();
		var phone=$.trim($("#edtPhoneNV").val());
		var day_of_birth=$.trim($("#edtNS").val());
		var kindOfCustomer_id=3;

		statusName=document.getElementById("statusName");
		statusEmail=document.getElementById("statusEmail");
		if(name==""&&email=="")
		{
			statusName.style.display="block";
			statusName.innerHTML="Vui lòng nhập tên!";
			statusEmail.style.display="block";
			statusEmail.innerHTML="Vui lòng nhập email!";

		}else if(name!=null&&email==""){
			statusName.style.display="none";
			statusEmail.style.display="block";
			statusEmail.innerHTML="Vui lòng nhập email!";
		}else if(name==null&&email!=""){
			statusName.style.display="block";
			statusName.innerHTML="Vui lòng nhập tên!";
			statusEmail.style.display="none";
		}else if(email!=""&&name!="")
		{
			//check email 
			var email_regular=/^([\w\.])+@([a-zA-Z0-9\-])+\.([a-zA-_Z]{2,4})(\.[a-zA-_Z]{2,4})?$/;
			if(email.match(email_regular))
			{
				statusEmail.style.display="none";
				$.ajax({
				url : "../html/page_product2/accountM.php",
				type : "POST",
				data : {
					action: "AddAccount",
					customer_name : name,
					email:email,
					password:pass,
					address:address,
					date_of_birth:day_of_birth,
					phone:phone,
					kindOfCustomer_id:kindOfCustomer_id,
				},
				success:function(data){
					alert(data);
				} 
			});
				
			}else{
				statusEmail.style.display="block";
				statusEmail.innerHTML="Vui lòng nhập email hợp lệ!";
			}
		}
		
		
	});
	$("body").delegate(".btn-delete","click",function(){
		var Product_id=$(this).parent().attr("dataID");
		This=$(this);
		$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "deleteProduct",
					Product_id : Product_id,
				},
				success:function(data){
					if(data==1)
					{
						This.closest("tr").remove();
					}else{
						alert(data);
					}
				} 
			});
	});

});