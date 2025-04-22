<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymethod = $_POST['paymethod'];

    if ($paymethod == "Credit Card") {
        // Get credit card details
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];

        // Just a dummy printout (never do this in real apps)
        echo "<h2>Payment Method: Credit Card</h2>";
        echo "Card Number: " . htmlspecialchars($card_number) . "<br>";
        echo "Expiry Date: " . htmlspecialchars($expiry_date) . "<br>";
        echo "CVV: " . htmlspecialchars($cvv) . "<br>";

        // Here you would integrate with a real payment gateway like Razorpay, Stripe, PayPal, etc.

    } elseif ($paymethod == "Internet Banking") {
        // Get banking details
        $bank_name = $_POST['bank_name'];
        $bank_id = $_POST['bank_id'];

        echo "<h2>Payment Method: Internet Banking</h2>";
        echo "Bank Name: " . htmlspecialchars($bank_name) . "<br>";
        echo "Bank ID: " . htmlspecialchars($bank_id) . "<br>";

        // Here also you would typically redirect to the bank's gateway or handle API call
    } else {
        echo "Invalid payment method selected.";
    }
} else {
    echo "Invalid request method.";
}
?>
