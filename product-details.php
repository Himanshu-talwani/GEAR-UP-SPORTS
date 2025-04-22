<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
					echo "<script>alert('Product has been added to the cart')</script>";
		echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
		}else{
			$message="Product ID is invalid";
		}
	}
}
$pid=intval($_GET['pid']);
if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
	if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else
{
mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','$pid')");
echo "<script>alert('Product aaded in wishlist');</script>";
header('location:my-wishlist.php');

}
}
if(isset($_POST['submit']))
{
	$qty=$_POST['quality'];
	$price=$_POST['price'];
	$value=$_POST['value'];
	$name=$_POST['name'];
	$summary=$_POST['summary'];
	$review=$_POST['review'];
	mysqli_query($con,"insert into productreviews(productId,quality,price,value,name,summary,review) values('$pid','$qty','$price','$value','$name','$summary','$review')");
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">
	    <title>Product Details</title>
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
	</head>
    <body class="cnt-home">
	
<header class="header-style-1">

	<!-- ============================================== TOP MENU ============================================== -->
<?php include('includes/top-header.php');?>
<!-- ============================================== TOP MENU : END ============================================== -->
<?php include('includes/main-header.php');?>
	<!-- ============================================== NAVBAR ============================================== -->
<?php include('includes/menu-bar.php');?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
<?php
$ret=mysqli_query($con,"select category.categoryName as catname,subCategory.subcategory as subcatname,products.productName as pname from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory where products.id='$pid'");
while ($rw=mysqli_fetch_array($ret)) {

?>


			<ul class="list-inline list-unstyled">
				<li><a href="index.php">Home</a></li>
				<li><?php echo htmlentities($rw['catname']);?></a></li>
				<li><?php echo htmlentities($rw['subcatname']);?></li>
				<li class='active'><?php echo htmlentities($rw['pname']);?></li>
			</ul>
			<?php }?>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row single-product outer-bottom-sm '>
			<div class='col-md-3 sidebar'>
				<div class="sidebar-module-container">


					<!-- ==============================================CATEGORY============================================== -->
<div class="sidebar-widget outer-bottom-xs wow fadeInUp">
	<h3 class="section-title">Category</h3>
	<div class="sidebar-widget-body m-t-10">
		<div class="accordion">

		            <?php $sql=mysqli_query($con,"select id,categoryName  from category");
while($row=mysqli_fetch_array($sql))
{
    ?>
	    	<div class="accordion-group">
	            <div class="accordion-heading">
	                <a href="category.php?cid=<?php echo $row['id'];?>"  class="accordion-toggle collapsed">
	                   <?php echo $row['categoryName'];?>
	                </a>
	            </div>
	          
	        </div>
	        <?php } ?>
	    </div>
	</div>
</div>
	<!-- ============================================== CATEGORY : END ============================================== -->					<!-- ============================================== HOT DEALS ============================================== -->
<div class="sidebar-widget hot-deals wow fadeInUp">
	<h3 class="section-title">hot deals</h3>
	<div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-xs">
		
								   <?php
$ret=mysqli_query($con,"select * from products order by rand() limit 4 ");
while ($rws=mysqli_fetch_array($ret)) {

?>

								        
													<div class="item">
					<div class="products">
						<div class="hot-deal-wrapper">
							<div class="image">
								<img src="admin/productimages/<?php echo htmlentities($rws['id']);?>/<?php echo htmlentities($rws['productImage1']);?>"  width="200" height="334" alt="">
							</div>
							
						</div><!-- /.hot-deal-wrapper -->

						<div class="product-info text-left m-t-20">
							<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rws['id']);?>"><?php echo htmlentities($rws['productName']);?></a></h3>
							<div class="rating rateit-small"></div>

							<div class="product-price">	
								<span class="price">
									Rs. <?php echo htmlentities($rws['productPrice']);?>.00
								</span>
									
							    <span class="price-before-discount">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>					
							
							</div><!-- /.product-price -->
							
						</div><!-- /.product-info -->

						<div class="cart clearfix animate-effect">
							<div class="action">
								
								<div class="add-cart-button btn-group">
									<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<?php if($row['productAvailability']=='In Stock'){?>
										<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<i class="fa fa-shopping-cart"></i>													
							</button>
							<a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
							<button class="btn btn-primary" type="button">Add to cart</button></a>
								<?php } else {?>
							<div class="action" style="color:red">Out of Stock</div>
					<?php } ?>
															
								</div>
								
							</div><!-- /.action -->
						</div><!-- /.cart -->
					</div>	
					</div>		
					<?php } ?>        
						
	    
    </div><!-- /.sidebar-widget -->
</div>

<!-- ============================================== COLOR: END ============================================== -->
				</div>
			</div><!-- /.sidebar -->
<?php 
$ret=mysqli_query($con,"select * from products where id='$pid'");
while($row=mysqli_fetch_array($ret))
{

?>


			<div class='col-md-9'>
				<div class="row  wow fadeInUp">
					     <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
    <div class="product-item-holder size-big single-product-gallery small-gallery">

        <div id="owl-single-product">

 <div class="single-product-gallery-item" id="slide1">
                <a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']);?>" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" width="370" height="350" />
                </a>
            </div>




            <div class="single-product-gallery-item" id="slide1">
                <a data-lightbox="image-1" data-title="<?php echo htmlentities($row['productName']);?>" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" width="370" height="350" />
                </a>
            </div><!-- /.single-product-gallery-item -->

            <div class="single-product-gallery-item" id="slide2">
                <a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>" />
                </a>
            </div><!-- /.single-product-gallery-item -->

            <div class="single-product-gallery-item" id="slide3">
                <a data-lightbox="image-1" data-title="Gallery" href="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>">
                    <img class="img-responsive" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>" />
                </a>
            </div>

        </div><!-- /.single-product-slider -->


        <div class="single-product-gallery-thumbs gallery-thumbs">

            <div id="owl-single-product-thumbnails">
                <div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide1">
                        <img class="img-responsive"  alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" />
                    </a>
                </div>

            <div class="item">
                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
                        <img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage2']);?>"/>
                    </a>
                </div>
                <div class="item">

                    <a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
                        <img class="img-responsive" width="85" alt="" src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage3']);?>" height="200" />
                    </a>
                </div>

               
               
                
            </div><!-- /#owl-single-product-thumbnails -->

            

        </div>

    </div>
</div>     			




					<div class='col-sm-6 col-md-7 product-info-block'>
						<div class="product-info">
							<h1 class="name"><?php echo htmlentities($row['productName']);?></h1>
<?php $rt=mysqli_query($con,"select * from productreviews where productId='$pid'");
$num=mysqli_num_rows($rt);
{
?>		
							<div class="rating-reviews m-t-20">
								<div class="row">
									<div class="col-sm-3">
										<div class="rating rateit-small"></div>
									</div>
									<div class="col-sm-8">
										<div class="reviews">
											<a href="#" class="lnk">(<?php echo htmlentities($num);?> Reviews)</a>
										</div>
									</div>
								</div><!-- /.row -->		
							</div><!-- /.rating-reviews -->
<?php } ?>
							<div class="stock-container info-container m-t-10">
								<div class="row">
									<div class="col-sm-3">
										<div class="stock-box">
											<span class="label">Availability :</span>
										</div>	
									</div>
									<div class="col-sm-9">
										<div class="stock-box">
											<span class="value"><?php echo htmlentities($row['productAvailability']);?></span>
										</div>	
									</div>
								</div><!-- /.row -->	
							</div>



<div class="stock-container info-container m-t-10">
								<div class="row">
									<div class="col-sm-3">
										<div class="stock-box">
											<span class="label">Product Brand :</span>
										</div>	
									</div>
									<div class="col-sm-9">
										<div class="stock-box">
											<span class="value"><?php echo htmlentities($row['productCompany']);?></span>
										</div>	
									</div>
								</div><!-- /.row -->	
							</div>


<div class="stock-container info-container m-t-10">
								<div class="row">
									<div class="col-sm-3">
										<div class="stock-box">
											<span class="label">Shipping Charge :</span>
										</div>	
									</div>
									<div class="col-sm-9">
										<div class="stock-box">
											<span class="value"><?php if($row['shippingCharge']==0)
											{
												echo "Free";
											}
											else
											{
												echo htmlentities($row['shippingCharge']);
											}

											?></span>
										</div>	
									</div>
								</div><!-- /.row -->	
							</div>

							<div class="price-container info-container m-t-20">
								<div class="row">
									

									<div class="col-sm-6">
										<div class="price-box">
											<span class="price">Rs. <?php echo htmlentities($row['productPrice']);?></span>
											<span class="price-strike">Rs.<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
										</div>
									</div>




									<div class="col-sm-6">
										<div class="favorite-button m-t-10">
											<a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Wishlist" href="product-details.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist">
											    <i class="fa fa-heart"></i>
											</a>
											
											</a>
										</div>
									</div>

								</div><!-- /.row -->
							</div><!-- /.price-container -->

	




							<div class="quantity-container info-container">
								<div class="row">
									
									<div class="col-sm-2">
										<span class="label">Qty :</span>
									</div>
									
									<div class="col-sm-2">
										<div class="cart-quantity">
											<div class="quant-input">
								                <div class="arrows">
								                  <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
								                  <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
								                </div>
								                <input type="text" value="1">
							              </div>
							            </div>
									</div>

									<div class="col-sm-7">
<?php if($row['productAvailability']=='In Stock'){?>
										<a href="product-details.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</a>
													<?php } else {?>
							<div class="action" style="color:red">Out of Stock</div>
					<?php } ?>
									</div>

									
								</div><!-- /.row -->
							</div><!-- /.quantity-container -->

							<div class="product-social-link m-t-20 text-right">
								<span class="social-label">Share :</span>
								<div class="social-icons">
						            <ul class="list-inline">
						                <li><?php
// Product details
$product_id = 2;  // Change dynamically if needed
$product_name = "Awesome Product";


// Your product URL (change once your site is live)
$product_url = "http://localhost/shopping/shopping1/product-details.php?pid=" . $product_id;

// Facebook Share Link
$facebook_link = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($product_url);
?>

<!-- Facebook Share Button -->
<a href="<?php echo $facebook_link; ?>" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Share on Facebook" width="30" height="30">
</a></li>

<!-- twitter -->

						                <li><?php
// Product details
$product_id = 2;  // Change dynamically if needed
$product_name = "Awesome Product";


// Your product URL (update once live)
$product_url = "http://localhost/shopping/shopping1/product-details.php?pid=" . $product_id;

// Twitter Share Message
$twitter_message = "Check out this product: $product_name for just $product_price!";

// Twitter Share Link
$twitter_link = "https://twitter.com/intent/tweet?text=" . urlencode($twitter_message) . "&url=" . urlencode($product_url);
?>

<!-- Twitter (X) Share Button -->
<a href="<?php echo $twitter_link; ?>" target="_blank">
    <img  src="data:image/png;base64,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"  width="50" height="40">
</a></li>




<!-- whatsapp -->

										<?php
// Product details
$product_name = "Awesome Product";
$product_url = "http://localhost/shopping/shopping1/product-details.php?pid=";

// Encode the message for URL
$whatsapp_message = urlencode("Check out this product: $product_name its in discount. Click here: $product_url");

// WhatsApp share link
$whatsapp_link = "https://wa.me/?text=$whatsapp_message";

?>

<!-- WhatsApp Share Button -->
 <li>
<a href="<?php echo $whatsapp_link; ?>" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="Share on WhatsApp" width="30" height="30">
</a>
 </li>
						                <!-- <li><a  href="https://wa.me/919265803845"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="30" height="30"> </a></li> -->
						                
						            </ul><!-- /.social-icons -->
						        </div>
							</div>

							

							
						</div><!-- /.product-info -->
					</div><!-- /.col-sm-7 -->
				</div><!-- /.row -->

				
				<div class="product-tabs inner-bottom-xs  wow fadeInUp">
					<div class="row">
						<div class="col-sm-3">
							<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
								<li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
								<li><a data-toggle="tab" href="#review">REVIEW</a></li>
							</ul><!-- /.nav-tabs #product-tabs -->
						</div>
						<div class="col-sm-9">

							<div class="tab-content">
								
								<div id="description" class="tab-pane in active">
									<div class="product-tab">
										<p class="text"><?php echo $row['productDescription'];?></p>
									</div>	
								</div><!-- /.tab-pane -->

								<div id="review" class="tab-pane">
									<div class="product-tab">
																				
										<div class="product-reviews">
											<h4 class="title">Customer Reviews</h4>
<?php $qry=mysqli_query($con,"select * from productreviews where productId='$pid'");
while($rvw=mysqli_fetch_array($qry))
{
?>

											<div class="reviews" style="border: solid 1px #000; padding-left: 2% ">
												<div class="review">
													<div class="review-title"><span class="summary"><?php echo htmlentities($rvw['summary']);?></span><span class="date"><i class="fa fa-calendar"></i><span><?php echo htmlentities($rvw['reviewDate']);?></span></span></div>

													<div class="text">"<?php echo htmlentities($rvw['review']);?>"</div>
													<div class="text"><b>Quality :</b>  <?php echo htmlentities($rvw['quality']);?> Star</div>
													<div class="text"><b>Price :</b>  <?php echo htmlentities($rvw['price']);?> Star</div>
													<div class="text"><b>value :</b>  <?php echo htmlentities($rvw['value']);?> Star</div>
                                                <div class="author m-t-15"><i class="fa fa-pencil-square-o"></i> <span class="name"><?php echo htmlentities($rvw['name']);?></span></div>													</div>
											
											</div>
											<?php } ?><!-- /.reviews -->
										</div><!-- /.product-reviews -->
										<form role="form" class="cnt-form" name="review" method="post">

										
										<div class="product-add-review">
											<h4 class="title">Write your own review</h4>
											<div class="review-table">
												<div class="table-responsive">
													<table class="table table-bordered">	
														<thead>
															<tr>
																<th class="cell-label">&nbsp;</th>
																<th>1 star</th>
																<th>2 stars</th>
																<th>3 stars</th>
																<th>4 stars</th>
																<th>5 stars</th>
															</tr>
														</thead>	
														<tbody>
															<tr>
																<td class="cell-label">Quality</td>
																<td><input type="radio" name="quality" class="radio" value="1"></td>
																<td><input type="radio" name="quality" class="radio" value="2"></td>
																<td><input type="radio" name="quality" class="radio" value="3"></td>
																<td><input type="radio" name="quality" class="radio" value="4"></td>
																<td><input type="radio" name="quality" class="radio" value="5"></td>
															</tr>
															<tr>
																<td class="cell-label">Price</td>
																<td><input type="radio" name="price" class="radio" value="1"></td>
																<td><input type="radio" name="price" class="radio" value="2"></td>
																<td><input type="radio" name="price" class="radio" value="3"></td>
																<td><input type="radio" name="price" class="radio" value="4"></td>
																<td><input type="radio" name="price" class="radio" value="5"></td>
															</tr>
															<tr>
																<td class="cell-label">Value</td>
																<td><input type="radio" name="value" class="radio" value="1"></td>
																<td><input type="radio" name="value" class="radio" value="2"></td>
																<td><input type="radio" name="value" class="radio" value="3"></td>
																<td><input type="radio" name="value" class="radio" value="4"></td>
																<td><input type="radio" name="value" class="radio" value="5"></td>
															</tr>
														</tbody>
													</table><!-- /.table .table-bordered -->
												</div><!-- /.table-responsive -->
											</div><!-- /.review-table -->
											
											<div class="review-form">
												<div class="form-container">
													
														
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label for="exampleInputName">Your Name <span class="astk">*</span></label>
																<input type="text" class="form-control txt" id="exampleInputName" placeholder="" name="name" required="required">
																</div><!-- /.form-group -->
																<div class="form-group">
																	<label for="exampleInputSummary">Summary <span class="astk">*</span></label>
																	<input type="text" class="form-control txt" id="exampleInputSummary" placeholder="" name="summary" required="required">
																</div><!-- /.form-group -->
															</div>

															<div class="col-md-6">
																<div class="form-group">
																	<label for="exampleInputReview">Review <span class="astk">*</span></label>

<textarea class="form-control txt txt-review" id="exampleInputReview" rows="4" placeholder="" name="review" required="required"></textarea>
																</div><!-- /.form-group -->
															</div>
														</div><!-- /.row -->
														
														<div class="action text-right">
															<button name="submit" class="btn btn-primary btn-upper">SUBMIT REVIEW</button>
														</div><!-- /.action -->

													</form><!-- /.cnt-form -->
												</div><!-- /.form-container -->
											</div><!-- /.review-form -->

										</div><!-- /.product-add-review -->										
										
							        </div><!-- /.product-tab -->
								</div><!-- /.tab-pane -->

				

							</div><!-- /.tab-content -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.product-tabs -->

<?php $cid=$row['category'];
			$subcid=$row['subCategory']; } ?>
				<!-- ============================================== UPSELL PRODUCTS ============================================== -->
<section class="section featured-product wow fadeInUp">
	<h3 class="section-title">Realted Products </h3>
	<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
	   
		<?php 
$qry=mysqli_query($con,"select * from products where subCategory='$subcid' and category='$cid'");
while($rw=mysqli_fetch_array($qry))
{

			?>	


		<div class="item item-carousel">
			<div class="products">
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="product-details.php?pid=<?php echo htmlentities($rw['id']);?>"><img  src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($rw['id']);?>/<?php echo htmlentities($rw['productImage1']);?>" width="150" height="240" alt=""></a>
			</div><!-- /.image -->			

			                   		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($rw['id']);?>"><?php echo htmlentities($rw['productName']);?></a></h3>
			<div class="rating rateit-small"></div>
			<div class="description"></div>

			<div class="product-price">	
				<span class="price">
					Rs.<?php echo htmlentities($rw['productPrice']);?>			</span>
										     <span class="price-before-discount">Rs.
										     <?php echo htmlentities($rw['productPriceBeforeDiscount']);?></span>
									
			</div><!-- /.product-price -->
			
		</div><!-- /.product-info -->
					<div class="cart clearfix animate-effect">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
							<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<i class="fa fa-shopping-cart"></i>													
							</button>
						<a href="product-details.php?page=product&action=add&id=<?php echo $rw['id']; ?>" class="lnk btn btn-primary">Add to cart</a>
													
						</li>
	                   
		              
					</ul>
				</div><!-- /.action -->
			</div><!-- /.cart -->
			</div><!-- /.product -->
      
			</div><!-- /.products -->
		</div><!-- /.item -->
		<?php } ?>
	
		
			</div><!-- /.home-owl-carousel -->
</section><!-- /.section -->


<!-- ============================================== UPSELL PRODUCTS : END ============================================== -->
			
			</div><!-- /.col -->
			<div class="clearfix"></div>
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