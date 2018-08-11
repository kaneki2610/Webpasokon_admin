$(document).ready(function(){

						//----------- event buttuon add product and list product --->fadeIn fadeOut--------------
	$(".btn-displayProduct").click(function()
	{	

		$("#btnUpdateProduct").addClass("gonbutton");
		$("#btnAddProduct").removeClass("gonbutton");
		DisplayProduct();
	});
	function DisplayProduct()
	{
		$(".addProduct").removeClass("gonbutton");
		$(".displayProduct").fadeOut();
		$(".addProduct").fadeIn();
	}
	function DisplayListProduct()
	{
		$(".displayProduct").fadeIn();
		$(".addProduct").fadeOut();
	}
	$(".btn-displayListProduct").click(function()
	{
		DisplayListProduct();
	});
						//---------------- pagging product---------------------------
	$('#paging_product22').bootpag({
	    total: $("#paging_product22").attr("data_totalpage"),
	    maxVisible: 5,
	    page:1
	}).on("page", function(event, trang){
	    $.ajax({ 
			url :"../html/page_product2/function2.php",
			type : "POST",
		
			data : {
				action : "getProductLimit",
				page_number : trang,
				
			},
			success:function(data){
				$("table.table1").find("tbody").empty();
				$("table.table1").find("tbody").append(data);
			}
		});
	});

						//---------------------yes-update product ande product detail--------------------------
	$("#btnUpdateProduct").click(function(){
		var product_id=$(this).attr("dataID");
		var product_name=$.trim($("#edtCNameProduct").val());
		var product_price=$.trim($("#edtPrice").val());
		var category=$.trim($("#chkCategory").val());
		var trademark=$("#chkTrademark").val();
		var quantity=$.trim($("#edtSL").val());
		var bigimage="/product_image/" + $("#container_big").find(".file-footer-caption").attr("title");
		var count_smallimage=$("#container_small").find(".file-footer-caption").length;
		var smallimg="";
		 $("#container_small").find(".file-footer-caption").each(function(index){
			if(count_smallimage-1==index)
			{
				smallimg+="/product_image/" +$(this).attr("title");
			}else{
				smallimg+="/product_image/" +$(this).attr("title") +",";
			}
		});
		 var info=tinymce.get("edtInfo").getContent();
		 var array_digital_name=[];
			$("input[name='arraydigitalname[]']").each(function(){
				var digital_name=$.trim($(this).val());
				if(digital_name.length>0)
				{
					array_digital_name.push(digital_name);
					
				}
				
			});
		var array_digital_value=[];
			$("input[name='arraydigitalvalue[]']").each(function(){
				var value=$.trim($(this).val());
				if(value.length>0)
				{
					array_digital_value.push(value);
					
				}
				
			});
		var array_detail_SP=[];
			$("input[name='array_detailSP[]']").each(function(){
				var value=$.trim($(this).val());
				if(value.length>0)
				{
					array_detail_SP.push(value);
				}
			});

		 var array_digital_name_bonus=[];
			$("input[name='arraydigitalname[]'][disabled]").each(function(){
				var digital_name=$.trim($(this).val());
				if(digital_name.length>0)
				{
					array_digital_name_bonus.push(digital_name);
					
				}
				
			});	
		var array_digital_value_bonus=[];
			$("input[name='arraydigitalvalue[]'][disabled]").each(function(){
				var value=$.trim($(this).val());
				if(value.length>0)
				{
					array_digital_value_bonus.push(value);
					
				}
				
			});


		$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "updateProduct",
					product_name : product_name,
					product_price :product_price,
					category :category,
					trademark :trademark,
					quantity  :quantity,
					bigimage  :bigimage,
					smallimg :smallimg,
					product_id: product_id,
					info  :info,
					array_digital_name  : array_digital_name,
					array_digital_value :array_digital_value,
					array_detail_SP :array_detail_SP,
					array_digital_name_bonus: array_digital_name_bonus,
					array_digital_value_bonus:array_digital_value_bonus
				},
				success:function(data){
					alert(data);
					
				} 
			});

	});


						//----------------------edit product------------------------
	$("body").delegate(".btn-edit","click",function(){
		
		DisplayProduct();
		$("#btnUpdateProduct").removeClass("gonbutton");
		$("#btnAddProduct").addClass("gonbutton");
		htmlBigImage='<label for="big_img">Big image</label><div class="form-group"><input id="big_img" name="big_img" class="file-loading" type="file" data-preview-file-type="any" data-upload-url="uploadimage.php"></div>';
		htmlSmallImage='<label for="small_img">Small image</label><div class="form-group"><input id="small_img" name="small_img" class="file-loading" type="file" multiple data-preview-file-type="any" data-upload-url="uploadimage.php"></div>';
		$("#container_big").empty();
		$("#container_big").append(htmlBigImage);

		$("#container_small").empty();
		$("#container_small").append(htmlSmallImage);

		bigimage="";
		smallimage="";
		product_name="";
		info="";
		cate_id=0;
		trademark_id=0;
		price=0;
		quantity=0;
		product_id=$(this).parent().attr("dataID");
		$("#btnUpdateProduct").attr("dataID",product_id);
		$(this).closest("tr").find("th").each(function(){
			if($(this).attr("dataSmallImage")){
				smallimage=$(this).attr("dataSmallImage");
			}else if($(this).attr("dataBigImage")){
				bigimage=$(this).attr("dataBigImage");
			}else if($(this).attr("dataName")){
				product_name=$(this).attr("dataName");
			}else if($(this).attr("dataInfo")){
				info=$(this).attr("dataInfo");
			}else if($(this).attr("dataCate")){
				cate_id=$(this).attr("dataCate");
			}else if($(this).attr("dataTra")){
				trademark_id=$(this).attr("dataTra");
			}else  if($(this).attr("dataPrice")){
				price=$(this).attr("dataPrice");
			}else  if($(this).attr("dataSL")){
				quantity=$(this).attr("dataSL");
			}
		});
		// load info of product into input: name,price...

		$("#edtCNameProduct").val(product_name);
		$("#edtPrice").val(price);
		$("#chkTrademark").val(trademark_id).trigger("change");
		$("#chkCategory").val(cate_id).trigger("change");
		$("#edtSL").val(quantity);
		tinymce.get("edtInfo").setContent(info);
		
		// load image into container inage---big image
		cut_position=bigimage.lastIndexOf("/");
		bigimage_name=bigimage.substring(cut_position+1);
		
		$("#big_img").fileinput({
			/*minFileCount: 1,
			maxFileCount: 1,*/
			overwriteInitial :true,
			initialPreview:[
				".." + bigimage
			],
			initialPreviewAsData:true,
			initialPreviewFileType: 'image',
			initialPreviewConfig: [
			{caption: bigimage_name},
			
			 
			],
		});

		// load image into container inage---small image
		array_smallimage_split=smallimage.split(",");
		array_smallimage=[];
		array_smallimage_name=[];
		for(i=0;i<array_smallimage_split.length;i++)
		{
			array_smallimage.push(".."+array_smallimage_split[i]);
			cut_position=array_smallimage_split[i].lastIndexOf("/");
			smallimage_name=array_smallimage_split[i].substring(cut_position+1);	
			array_smallimage_name.push({caption:smallimage_name});
		}
		$("#small_img").fileinput({
			overwriteInitial :false,
			initialPreview:array_smallimage,
			initialPreviewAsData:true,
			initialPreviewFileType: 'image',
			initialPreviewConfig: array_smallimage_name
		});

		//load product detail
		$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "getProductDetail_ProductID",
					product_id : product_id
					
				},
				success:function(data){
						$("#container_digital").empty();
						$("#container_digital").append($(".gonClass").clone().removeClass("gonClass"));
						$("#container_digital").find("tbody").prepend(data);
				} 
			});
		
	
	});
						//----------------- delete product--------------------
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
						//-----------------delete button delete----------------------------
	$("body").delegate(".btndelteDigital","click",function(){
		$(this).closest("tr").remove();
	});
						//---------------visable disable button add and delete digital info-----------------
	$("body").delegate(".btnAddDigital","click",function(){
		var container_digital=$(".gonClass").clone().removeClass("gonClass");
		$("#container_digital").append(container_digital);
		$(this).parent().find(".btndelteDigital").removeClass("gonbutton");
		$(this).closest("tr").find("input").attr("disabled",true);
		$(this).remove();
	});


						//----------------------add product------------------------------
	$("#btnAddProduct").click(function(){
		var product_name=$.trim($("#edtCNameProduct").val());
		var product_price=$.trim($("#edtPrice").val());
		var category=$.trim($("#chkCategory").val());
		var trademark=$("#chkTrademark").val();
		var quantity=$.trim($("#edtSL").val());
		var bigimage="/product_image/" + $("#container_big").find(".file-footer-caption").attr("title");
		var count_smallimage=$("#container_small").find(".file-footer-caption").length;
		var smallimg="";
		 $("#container_small").find(".file-footer-caption").each(function(index){
			if(count_smallimage-1==index)
			{
				smallimg+="/product_image/" +$(this).attr("title");
			}else{
				smallimg+="/product_image/" +$(this).attr("title") +",";
			}
		});

		var info=tinymce.get("edtInfo").getContent();
		//alert(category);
		
		
		var array_digital_name=[];
			$("input[name='arraydigitalname[]']").each(function(){
				var digital_name=$.trim($(this).val());
				if(digital_name.length>0)
				{
					array_digital_name.push(digital_name);
					
				}
				
			});
			var array_digital_value=[];
			$("input[name='arraydigitalvalue[]']").each(function(){
				var value=$.trim($(this).val());
				if(value.length>0)
				{
					array_digital_value.push(value);
					
				}
				
			});
			$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "addProduct",
					product_name : product_name,
					product_price :product_price,
					category :category,
					trademark :trademark,
					quantity  :quantity,
					bigimage  :bigimage,
					smallimg :smallimg,
					info  :info,
					array_digital_name  : array_digital_name,
					array_digital_value :array_digital_value,
				},
				success:function(data){
					alert(data);
					
				} 
			});
		
		
				
	});

							//------------------------- tinymce------------------------------
	tinymce.init({
		selector: 'textarea#edtInfo',
		height: 120,
  		toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
	});
	//file type upload image
	/*$("big_img").fileinput({
		'allowedFileExtensions' :['jpg','png','gif'],
	});
	$("small_img").fileinput({
		'allowedFileExtensions' :['jpg','png','gif'],
	});*/

								//----------------search category-------------------------------
	$("#btnSearch").click(function(){
		var name=$("#txtNameP").val();
		$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "SearchCategory",
					name : name,
				},
				success:function(data){
					$("table.table").find("tbody").empty();
					$("table.table").find("tbody").append(data);
					$("ul.pagination").remove();
				} 
			});
	});
								// -----------------chức năng add category_name------------------------------
	$("#btnAdd").click(function(){ 
			var category_name=$("#edtCName").val();
			var parent_id=$("#chkPa").val();
			This=$(this);
			$.ajax({
				url : "../html/page_product2/function2.php",
				type : "POST",
				data : {
					action: "AddCategory",
					category_name : category_name,
					parent_id : parent_id,
				},
				success:function(data){
					$(".alert_error").empty();
					$(".alert_error").append(data);
				} 
			});
	});
								//----------------- paging- category----------------------------------
	
	$("body").delegate("ul.pagination>li","click",function(){
		 var limit =$(this).text();
			 $("ul.pagination>li").removeClass("active");
			 $(this).addClass("active");
		     $.ajax({
		     	url :"../html/page_product2/function2.php",
		     	type :"POST",
		     	data : {
		     		action : "getCategoryLimit",
					limit :limit,
		     	},
		     	success:function(data){
					$("table.table").find("tbody").empty();
					$("table.table").find("tbody").append(data);
					//alert(data);
				} 
		     });
	});		

								//------------------------checkbox--------------------------
	$("#chkSelect").change(function(){
			var checkbox_all=$(this).closest("table").find("tbody input:checkbox");
			if($(this).is(":checked"))
			{
				checkbox_all.prop("checked",true);
			}else{
				checkbox_all.prop("checked",false);
			}
	});
							//---------------------delete category-----------------------------------
	$("#btnDeP").click(function(){
			var array_chkbox=[];
			$("input[name='chk-mamg[]']:checked").each(function(){
				var category_id=$(this).attr("data-id");
				array_chkbox.push(category_id);
			});
			   $.ajax({
		     	url :"../html/page_product2/function2.php",
		     	type :"POST",
		     	data : {
		     		action : "deleteCategory",
					array_chkbox :array_chkbox,
		     	},
		     	success:function(data){
		     			//load content category
						$.ajax({
				     	url :"../html/page_product2/function2.php",
				     	type :"POST",
				     	data : {
				     		action : "getCategoryLimit",
							limit :1,
				     	},
				     	success:function(data2){
							
							$("table.table").find("tbody").empty();
							$("table.table").find("tbody").append(data2);
						} 
				     });
							//load paging
						$.ajax({
				     	url :"../html/page_product2/function2.php",
				     	type :"POST",
				     	data : {
				     		action : "getPaging",
							
				     	},
				     	success:function(data3){
							
							$("ul.pagination").empty();
							$("ul.pagination").append(data3);
						} 
				     });
					
				} 
		     })
	});

		    
	
});