<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Daily UI - Day 1 Sign In</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate1.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style1.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
	<div class="container">
		 
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
			<label for="username">Username</label>
			<br/>
			<input type="text" id="username" value=<?php echo isset($_COOKIE["email"])?  $_COOKIE["email"] : "" ?>>
			<br/>
			<p id="status"></p>
			
			<br>
			<label for="password">Password</label>
			<br/>
			<br>
			<input type="password" id="password" value=<?php echo isset($_COOKIE["pass"])?  $_COOKIE["pass"] : "" ?>>
			<br/>
			<p id="status2">ss</p>
			<button id="btn-yes" type="submit">Sign In</button>
			<br/>
			<label for="missAccount">Remember account</label>
			<input type="checkbox" id="missAccount" name="missAccount">
			<br/>
			<a href="#"><p class="small">Forgot your password?</p></a>
			<input type="hidden" id="url" value=<?php echo "http://$_SERVER[HTTP_HOST]/webpasokon/" ?>>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
		$("body").delegate("#btn-yes","click",function(){
			user=$("#username").val();
			pass=$("#password").val();
			theP=document.getElementById("status");
			theP2=document.getElementById("status2");
			missAccount=$("#missAccount").is(":checked");
			address_url=$("#url").val();
			if(user==""&&pass=="")
			{
				
				theP.style.display="block";
				theP.innerHTML="Please enter username!";
				theP2.style.display="block";
				theP2.innerHTML="Please enter password!"
			}else if(user!=""&&pass=="")
			{
				theP.style.display="none";
				theP2.style.display="block";
				theP2.innerHTML="Please enter password!"
			}
			else if(pass!=""&&user=="")
			{
				theP2.style.display="none";
				theP.style.display="block";
				theP.innerHTML="Please enter username!";
			}
			else{
				theP.style.display="none";
				theP2.style.display="none";


				 $.ajax({ 
			     url :"html/page_product2/function2.php",
			 	 type : "POST",
		
				data : {
					action : "checkLogin",
					username:user,
					password:pass,
					missAccount:missAccount
				
				},
				success:function(data){
					console.log(data);
					if(data!=0)
					{
						window.location.replace(address_url+"html/product_template.php");
					}else{
						alert("Đăng nhập thất bại!");
					}
				}
			});
			}
	
		});

    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>	

</html>