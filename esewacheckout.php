<?php
session_start();
require('connection.inc.php'); // Include your database connection file

// Assuming you have stored the necessary order details in session or can retrieve them again
$order_id = $_SESSION['ORDER_ID'];
$total_price = $_SESSION['TOTAL_PRICE'];

// eSewa payment integration details
$esewa_merchant_id = 'EPAYTEST';
$esewa_secret_key = '8gBm/:&EnhH.1/q';
$esewa_return_url = 'http://127.0.0.1/php/ecommerce/index.php'; // URL to redirect after payment success
$esewa_cancel_url = 'http://127.0.0.1/php/ecommerce/cart.php'; // URL to redirect after payment failure

?>

<html>
<head>
    <title>eSewa Checkout</title>
</head>
<body>
    <form action="https://esewa.com.np/epay/main" method="POST">
        <input value="<?php echo $total_price; ?>" name="tAmt" type="hidden">
        <input value="<?php echo $total_price; ?>" name="amt" type="hidden">
        <input value="0" name="txAmt" type="hidden">
        <input value="0" name="psc" type="hidden">
        <input value="0" name="pdc" type="hidden">
        <input value="<?php echo $esewa_merchant_id; ?>" name="scd" type="hidden">
        <input value="<?php echo $order_id; ?>" name="pid" type="hidden">
        <input value="<?php echo $esewa_return_url; ?>" type="hidden" name="su">
        <input value="<?php echo $esewa_cancel_url; ?>" type="hidden" name="fu">
        <input value="Pay with eSewa" type="submit">
    </form>
</body>
</html>
