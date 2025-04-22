<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Code user Registration
if(isset($_POST['submit']))
{
$name=$_POST['fullname'];
$email=$_POST['emailid'];
$contactno=$_POST['contactno'];
$password=md5($_POST['password']);
$query=mysqli_query($con,"insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
if($query)
{
	echo "<script>alert('You are successfully register');</script>";
}
else{
echo "<script>alert('Not register something went worng');</script>";
}
}
// Code for User login
if(isset($_POST['login']))
{
   $email=$_POST['email'];
   $password=md5($_POST['password']);
$query=mysqli_query($con,"SELECT * FROM users WHERE email='$email' and password='$password'");
$num=mysqli_fetch_array($query);
if($num>0)
{
$extra="my-cart.php";
$_SESSION['login']=$_POST['email'];
$_SESSION['id']=$num['id'];
$_SESSION['username']=$num['name'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('".$_SESSION['login']."','$uip','$status')");
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$extra="login.php";
$email=$_POST['email'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=0;
$log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('$email','$uip','$status')");
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
$_SESSION['errmsg']="Invalid email id or Password";
exit();
}
}


?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <title>GEAR-UP sports | Signi-in | Signup</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<!-- Demo Purpose Only. Should be removed in production : END -->

		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">
<script type="text/javascript">
function valid()
{
 if(document.register.password.value!= document.register.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.register.confirmpassword.focus();
return false;
}
return true;
}
</script>
    	<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>



	</head>
    <body class="cnt-home">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

	<!-- ============================================== TOP MENU ============================================== -->
<?php include('includes/top-header.php');?>
<!-- ============================================== TOP MENU : END ============================================== -->
<?php include('includes/main-header.php');?>
	<!-- ============================================== NAVBAR ============================================== -->
<?php include('includes/menu-bar.php');?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>

<body>

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb"  >
	<div class="container" >
		<div class="breadcrumb-inner" >
			<ul class="list-inline list-unstyled">
				<li><a href="home.html">Home</a></li>
				<li class='active'>Authentication</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-bd" >
	<div class="container">
		<div class="sign-in-page inner-bottom-sm">
			<div class="row">
				<!-- Sign-in -->			
<div class="col-md-6 col-sm-6 sign-in" >
	<h4 class="" style=" color:black">sign in</h4>
	<div style="display: flex; flex-wrap: wrap; justify-content: space-between; max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Login Form (Left) -->
    <div class="col-md-6 col-sm-6" style="flex: 1 1 50%; min-width: 300px; padding-right: 10px;"> 


	
        <form class="register-form outer-top-xs" method="post" style="background: linear-gradient(135deg, #1a1a1a, #2b1242); padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(255, 0, 255, 0.3);" >
            <span style="color: #ff3366; font-weight: bold; text-shadow: 0 0 5px rgba(255, 51, 102, 0.7);">
<?php
echo htmlentities($_SESSION['errmsg']);
?>

<?php
echo htmlentities($_SESSION['errmsg']="");
?>
            </span>
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="info-title" for="exampleInputEmail1" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Email Address <span style="color: #ff3366;">*</span></label>
                <input type="email" name="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="info-title" for="exampleInputPassword1" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Password <span style="color: #ff3366;">*</span></label>
                <input type="password" name="password" class="form-control unicase-form-control text-input" id="exampleInputPassword1" style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">
            </div>
            <div class="radio outer-xs" style="margin-bottom: 20px;">
                <a href="forgot-password.php" class="forgot-password pull-right" style="color: #ff66cc; text-decoration: none; font-size: 14px; transition: color 0.3s ease;" onmouseover="this.style.color='#00ffff';" onmouseout="this.style.color='#ff66cc';">Forgot your Password?</a>
            </div>
            <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login" style="background: linear-gradient(45deg, #ff00ff, #00ffff); color: #fff; padding: 12px 26px; border: none; border-radius: 25px; font-size: 14px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 0 15px rgba(255, 0, 255, 0.7); text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.background='linear-gradient(45deg, #00ffff, #ff00ff)'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 255, 255, 0.9)';" onmouseout="this.style.background='linear-gradient(45deg, #ff00ff, #00ffff)'; this.style.transform='scale(1)'; this.style.boxShadow='0 0 15px rgba(255, 0, 255, 0.7)';" onmousedown="this.style.transform='scale(0.95)';" onmouseup="this.style.transform='scale(1.05)';">Login</button>
        </form>
    </div>
   <!-- Registration Form (Right) -->

<div class="col-md-6 col-sm-6 create-new-account" style="flex: 1 1 50%;   left: 700px;">
	

<div style="background: linear-gradient(135deg, #2b1242, #1a1a1a); padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);">
	<h4 class="checkout-subtitle" style="color: #ff66cc; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(255, 102, 204, 0.5);">Create a New Account</h4>
	<p class="text title-tag-line" style="color: #cc99ff; font-style: italic; font-size: 14px;">Create your own Shopping account.</p>
	<form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();" style="background: transparent;">
		<div class="form-group" style="margin-bottom: 20px;">
			<label class="info-title" for="fullname" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Full Name <span style="color: #ff3366;">*</span></label>
			<input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required="required" style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">
		</div>
		<div class="form-group" style="margin-bottom: 20px;">
			<label class="info-title" for="exampleInputEmail2" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Email Address <span style="color: #ff3366;">*</span></label>
			<input type="email" class="form-control unicase-form-control text-input" id="email" onBlur="userAvailability()" name="emailid" required style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">
			<span id="user-availability-status1" style="font-size: 12px; color: #00ffff;"></span>
		</div>
		<div class="form-group" style="margin-bottom: 20px;">
			<label class="info-title" for="contactno" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Contact No. <span style="color: #ff3366;">*</span></label>
			<input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" maxlength="10" required style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'" pattern="[0-9]{10}" inputmode="numeric" title="Enter a valid 10-digit contact number">
			</div>
		<div class="form-group" style="margin-bottom: 20px;">
			<label class="info-title" for="password" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Password <span style="color: #ff3366;">*</span></label>
			<div style="position: relative; width: 100%;">
  <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" title="Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long" style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">

  <span onclick="togglePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #fff; font-size: 24px;">👁️</span>
</div>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = event.target;

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeIcon.textContent = "🙈";
    } else {
      passwordInput.type = "password";
      eyeIcon.textContent = "👁️";
    }
  }
				
				document.getElementById('password').addEventListener('input', function(e) {
					const password = e.target.value;
					const minLength = 8;
					const hasUpperCase = /[A-Z]/.test(password);
					const hasLowerCase = /[a-z]/.test(password);
					const hasNumber = /\d/.test(password);
					if (password.length < minLength || !hasUpperCase || !hasLowerCase || !hasNumber) {
						e.target.setCustomValidity('Password must be at least 8 characters long and contain uppercase, lowercase, and numbers');
					} else {
						e.target.setCustomValidity('');
					}
				});


// 				document.getElementById('password').addEventListener('input', function(e) {
//   const password = e.target.value;
//   const minLength = 8;
//   const hasUpperCase = /[A-Z]/.test(password);
//   const hasLowerCase = /[a-z]/.test(password);
//   const hasNumber = /\d/.test(password);
//   const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password); // checks for any symbol

//   if (
//     password.length < minLength ||
//     !hasUpperCase ||
//     !hasLowerCase ||
//     !hasNumber ||
//     !hasSymbol
//   ) {
//     e.target.setCustomValidity(
//       'Password must be at least 8 characters long and contain uppercase, lowercase, number, and at least one symbol'
//     );
//   } else {
//     e.target.setCustomValidity('');
//   }
// });



			</script>

<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSeEkLcERPD0PHvIC3pVfVhbf78oJVf0km10iWvkfZ10v-akP_defbyRL29fT8ZsHUvNg&usqp=CAU" alt="" style=" height: 180px; weigth: 150px; position: relative; left: -170px; bottom: 750px;">

		</div>
		<div class="form-group" style="margin-bottom: 20px;">
			<label class="info-title" for="confirmpassword" style="color: #ffccff; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Confirm Password <span style="color: #ff3366;">*</span></label>
			<input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required style="background: rgba(255, 255, 255, 0.1); border: 1px solid #ff00ff; color: #fff; padding: 10px; border-radius: 5px; transition: all 0.3s ease; box-shadow: inset 0 0 5px rgba(255, 0, 255, 0.5); width: 100%;" onfocus="this.style.borderColor='#00ffff'; this.style.boxShadow='0 0 10px #00ffff';" onblur="this.style.borderColor='#ff00ff'; this.style.boxShadow='inset 0 0 5px rgba(255, 0, 255, 0.5);'">
		</div>
		<button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button" id="submit" style="background: linear-gradient(45deg, #ff00ff, #00ffff); color: #fff; padding: 12px 26px; border: none; border-radius: 25px; font-size: 14px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 0 15px rgba(255, 0, 255, 0.7); text-transform: uppercase; letter-spacing: 1px;" onmouseover="this.style.background='linear-gradient(45deg, #00ffff, #ff00ff)'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 255, 255, 0.9)';" onmouseout="this.style.background='linear-gradient(45deg, #ff00ff, #00ffff)'; this.style.transform='scale(1)'; this.style.boxShadow='0 0 15px rgba(255, 0, 255, 0.7)';" onmousedown="this.style.transform='scale(0.95)';" onmouseup="this.style.transform='scale(1.05)';">Sign Up</button>
	</form>
	<span class="checkout-subtitle outer-top-xs" style="color: #ff66cc; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; display: block;">Sign Up Today And You'll Be Able To:</span>
	<div class="checkbox" style="color: #cc99ff; font-size: 14px;">
		<label class="checkbox" style="margin: 5px 0; display: block;">Speed your way through the checkout.</label>
		<label class="checkbox" style="margin: 5px 0; display: block;">Track your orders easily.</label>
		<label class="checkbox" style="margin: 5px 0; display: block;">Keep a record of all your purchases.</label>
	</div>
</div>
</div>
</div >


<!-- create a new account -->			</div><!-- /.row -->
		</div>
<?php include('includes/brands-slider.php');?>
</div>
</div>
<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>
	
	<script>
		$(document).ready(function(){ 
			$(".changecolor").switchstylesheet( { seperator:"color"} );
			$('.show-theme-options').click(function(){
				$(this).parent().toggleClass('open');
				return false;
			});
		});

		$(window).bind("load", function() {
		   $('.show-theme-options').delay(2000).trigger('click');
		});
	</script>
	<!-- For demo purposes – can be removed on production : End -->

	

</body>
</html>