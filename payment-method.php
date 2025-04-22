<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0){   
    header('location:login.php');
} else {
	if (isset($_POST['submit'])) {
		$paymentMethod = $_POST['paymethod'];
		$userId = $_SESSION['id'];
	
		if ($paymentMethod == "Credit Card") {
			$card_number = $_POST['card_number'];
			$card_last4 = substr($card_number, -4);
			$card_expiry = $_POST['expiry_date'];
	
			mysqli_query($con, "UPDATE orders SET paymentMethod='$paymentMethod', card_last4='$card_last4', card_expiry='$card_expiry' WHERE userId='$userId' AND paymentMethod IS NULL");
		
		} elseif ($paymentMethod == "Internet Banking") {
			$bank_name = $_POST['bank_name'];
			$bank_id = $_POST['bank_id'];
	
			mysqli_query($con, "UPDATE orders SET paymentMethod='$paymentMethod', bankname='$bank_name', bank_ref='$bank_id' WHERE userId='$userId' AND paymentMethod IS NULL");
	
		} else {
			// Just COD
			mysqli_query($con, "UPDATE orders SET paymentMethod='$paymentMethod' WHERE userId='$userId' AND paymentMethod IS NULL");
		}
	
		unset($_SESSION['cart']);
		header('location:order-history.php');
	}
	
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>gear-up sports | Payment Method</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- Add all your existing CSS links here -->
</head>
<body class="cnt-home">

<header class="header-style-1">
    <?php include('includes/top-header.php');?>
    <?php include('includes/main-header.php');?>
    <?php include('includes/menu-bar.php');?>
</header>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Payment Method</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content outer-top-bd">
    <div class="container">
        <div class="checkout-box faq-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12">
                    <h2>Choose Payment Method</h2>
                    <div class="panel-group checkout-steps" id="accordion">
                        <div class="panel panel-default checkout-step-01">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        Select your Payment Method
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body" style="
                                    background: linear-gradient(135deg, rgb(32, 21, 234), #2a5298);
                                    border-radius: 20px;
                                    box-shadow: 0 5px 15px rgba(60, 117, 250, 0.5);
                                    text-align: center;
                                    max-width: 1000px;
                                    margin: auto;
                                    color: white;
                                    font-family: Arial, sans-serif;">
                                    <form name="payment" method="post" style="font-size: 20px; font-family: 'Poppins', sans-serif; font-weight: 500;">
                                        <input type="radio" name="paymethod" value="COD" onclick="showPaymentFields('cod')" checked> COD<br><br>
                                        <input type="radio" name="paymethod" value="Credit Card" onclick="showPaymentFields('card')"> Debit / Credit Card<br><br>

                                        <!-- Card Details -->
                                        <div id="card-details" style="display:none; text-align:left;">
                                            <label>Card Number:</label>
                                            <input type="text" name="card_number" placeholder="Enter Card Number" class="form-control" pattern="[0-9]{16}" maxlength="16" inputmode="numeric" title="Enter a valid 16-digit card number" required><br>
                                            <label>Expiry Date:</label>
                                            <input type="month" name="expiry_date" class="form-control"><br>
                                            <label>CVV:</label>
                                            <input type="password" name="cvv" placeholder="CVV" class="form-control" pattern="\d{3,4}" maxlength="3" inputmode="numeric" title="Enter a 3 or 4 digit CVV" required><br>
                                            </div>


                                        <input type="submit" value="SUBMIT" name="submit" class="btn btn-primary" style="
                                            background: linear-gradient(135deg, rgba(255, 255, 0, 0.93), rgb(72, 255, 0));
                                            border: none;
                                            color: white;
                                            padding: 10px 30px;
                                            font-size: 15px;
                                            font-weight: bold;
                                            border-radius: 50px;
                                            cursor: pointer;
                                            transition: all 0.3s ease-in-out;
                                            box-shadow: 0 5px 15px rgb(221, 0, 255);
                                            outline: none;"
                                            onmouseover="this.style.transform='scale(1.2)'; this.style.boxShadow='0 0 20px rgba(255, 75, 43, 0.8)';"
                                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 5px 15px rgba(255, 75, 43, 0.6)';"
                                            onmousedown="this.style.transform='scale(0.95)'; this.style.boxShadow='0 0 10px rgba(255, 75, 43, 1)';"
                                            onmouseup="this.style.transform='scale(1.2)'; this.style.boxShadow='0 0 20px rgba(255, 75, 43, 0.8)';"
                                        >
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.checkout-steps -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->

<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
function showPaymentFields(type) {
    document.getElementById('card-details').style.display = (type === 'card') ? 'block' : 'none';
    document.getElementById('bank-details').style.display = (type === 'bank') ? 'block' : 'none';

    if (type === 'cod') {
        document.getElementById('card-details').style.display = 'none';
        document.getElementById('bank-details').style.display = 'none';
    }
}
</script>

</body>
</html>

