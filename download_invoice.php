<?php
session_start();
include('includes/config.php');

// Check if the order ID is set
if (isset($_GET['orderid']) && !empty($_GET['orderid'])) {
    $orderid = $_GET['orderid'];

    // Fetch the order details from the database (added product ID as pid)
    $query = mysqli_query($con, "
        SELECT 
            products.id as pid, 
            products.productName as pname, 
            orders.quantity as qty, 
            products.productPrice as pprice, 
            products.shippingCharge as shippingcharge, 
            orders.paymentMethod as paym, 
            orders.orderDate as odate 
        FROM orders 
        JOIN products ON orders.productId = products.id 
        WHERE orders.id = '$orderid'
    ");

    $order = mysqli_fetch_array($query);

    if ($order) {
        // Create the invoice content
        $invoiceContent = "
            <html>
                <head>
                    <title>Invoice</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .invoice-box { width: 100%; padding: 20px; border: 1px solid #ddd; }
                        .invoice-box table { width: 100%; line-height: 30px; text-align: left; }
                        .invoice-box table th, .invoice-box table td { padding: 10px; border: 1px solid #ddd; }
                        .invoice-box .total { text-align: right; font-weight: bold; }
                    </style>
                </head>
                <body>
                    <div class='invoice-box'>
                        <h2>Invoice</h2>
                        <p>Order Date: " . $order['odate'] . "</p>
                        <table>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Shipping Charge</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td>" . $order['pid'] . "</td>
                                <td>" . $order['pname'] . "</td>
                                <td>" . $order['qty'] . "</td>
                                <td>" . $order['pprice'] . "</td>
                                <td>" . $order['shippingcharge'] . "</td>
                                <td>" . ($order['qty'] * $order['pprice'] + $order['shippingcharge']) . "</td>
                            </tr>
                        </table>
                        <div class='total'>
                            <p><strong>Payment Method: </strong>" . $order['paym'] . "</p>
                            <p><strong>Total: </strong>" . ($order['qty'] * $order['pprice'] + $order['shippingcharge']) . "</p>
                        </div>
                    </div>
                </body>
            </html>
        ";

        // Output the invoice as a downloadable file
        header('Content-Type: application/vnd.ms-word');
        header('Content-Disposition: attachment; filename="Invoice_' . $orderid . '.doc"');
        echo $invoiceContent;
    } else {
        echo "Order not found.";
    }
} else {
    echo "Invalid request.";
}
?>
