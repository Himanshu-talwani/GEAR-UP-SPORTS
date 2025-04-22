<?php
session_start();
include_once 'includes/config.php';
$oid=intval($_GET['oid']);
 ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}ser
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Order Tracking Details</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>

<div style="margin-left:50px;">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr height="50">
      <td colspan="2" class="fontkink2" style="padding-left:0px;"><div class="fontpink2"> <b>Order Tracking Details !</b></div></td>
      
    </tr>
    <tr height="30">
      <td  class="fontkink1"><b>order Id:</b></td>
      <td  class="fontkink"><?php echo $oid;?></td>
    </tr>
    <?php 
$ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
$num=mysqli_num_rows($ret);
if($num>0)
{
while($row=mysqli_fetch_array($ret))
      {
     ?>
		
    
    
      <tr height="20">
      <td class="fontkink1" ><b>At Date:</b></td>
      <td  class="fontkink"><?php echo $row['postingDate'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Status:</b></td>
      <td  class="fontkink"><?php echo $row['status'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Remark:</b></td>
      <td  class="fontkink"><?php echo $row['remark'];?></td>
    </tr>

   
    <tr>
      <td colspan="2"><hr /></td>
    </tr>
   <?php } }
else{
   ?>
   <tr>
   <td colspan="2" style="color: #FF4500;">Order Not Process Yet</td>
   </tr>
   <?php  }
$st='Delivered';
   $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
     while($num=mysqli_fetch_array($rt))
     {
     $currrentSt=$num['orderStatus'];
   }
     if($st==$currrentSt)
     { ?>
   <tr><td colspan="2" style="color: #32CD32;"><b>
      Product Delivered successfully </b></td>
   <?php } 
 
  ?>

</table>
 </form>
</div>
<style>
        /* General Button Styling */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid transparent;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* Button Animation Effect */
        .btn::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.5s ease, height 0.5s ease, top 0.5s ease, left 0.5s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .btn:hover::before {
            width: 0;
            height: 0;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        /* Return Button */
        .btn-return {
            background: linear-gradient(135deg, #32CD32, #008000);
            color: white;
            box-shadow: 0px 4px 10px rgba(50, 205, 50, 0.4);
        }

        .btn-return:hover {
            background: linear-gradient(135deg, #28a745, #006400);
            box-shadow: 0px 6px 15px rgba(50, 205, 50, 0.6);
            transform: translateY(-3px);
        }

        /* Cancel Button */
        .btn-cancel {
            background: linear-gradient(135deg, #FF4500, #B22222);
            color: white;
            box-shadow: 0px 4px 10px rgba(255, 69, 0, 0.4);
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #DC143C, #8B0000);
            box-shadow: 0px 6px 15px rgba(255, 69, 0, 0.6);
            transform: translateY(-3px);
        }

        /* Button Container */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }
    </style>
    <div class="button-container">
    <!-- Return Button -->
    <form  method="POST">
        <input type="hidden" name="order_id" value="1"> <!-- Replace with actual order ID -->
        <button type="submit" name="return" class="btn btn-return">Return</button>
    </form>

    <!-- Cancel Button -->
    <form method="POST">
        <input type="hidden" name="order_id" value="1"> <!-- Replace with actual order ID -->
        <button type="submit" name="cancel" class="btn btn-cancel">Cancel</button>
    </form>
</div>
    <?php
    if(isset($_POST['return']))
    echo "contact on this number +91 9265803845 or email us at  Gear_Up@gmail.com";
    ?>
    <?php
    if(isset($_POST['cancel']))
    echo "contact on this number +91 9265803845 or email us at  Gear_Up@gmail.com"
    ?>
    
</body>
</html>

     