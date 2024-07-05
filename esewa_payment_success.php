<?php
require('connection.php'); // Include your database connection file

$oid = $_GET['oid'];
$amt = $_GET['amt'];
$refId = $_GET['refId'];

$esewa_merchant_id = 'EPAYTEST';
$esewa_secret_key = '8gBm/:&EnhH.1/q';

// Verify the payment
$url = "https://esewa.com.np/epay/transrec";
$data = [
    'amt' => $amt,
    'scd' => $esewa_merchant_id,
    'pid' => $oid,
    'rid' => $refId,
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($curl);
curl_close($curl);

if (strpos($response, 'Success') !== false) {
    // Payment was successful, update order status
    mysqli_query($con, "UPDATE `order` SET payment_status='success', txnid='$refId' WHERE txnid='$oid'");
    unset($_SESSION['cart']);
    echo "Payment Successful. Your order ID is: " . $oid;
    // Redirect to thank you page
    header("Location: thank_you.php");
    exit();
} else {
    echo "Payment verification failed";
}
?>
